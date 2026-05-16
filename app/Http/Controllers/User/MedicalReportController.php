<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\MedicalReport;
use App\Services\GeminiHealthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MedicalReportController extends Controller
{
    public function index()
    {
        $reports = MedicalReport::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.medical-reports.index', compact('reports'));
    }

    public function create()
    {
        $familyMembers = FamilyMember::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.medical-reports.create', compact('familyMembers'));
    }

    public function store(Request $request, GeminiHealthService $gemini)
    {
        $validated = $request->validate([
            'family_member_id' => ['nullable', 'exists:family_members,id'],
            'report_type' => ['required', 'in:blood_test,ecg,xray,urine_test,prescription,other'],
            'title' => ['required', 'string', 'max:255'],
            'report_text' => ['required', 'string', 'min:10', 'max:12000'],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,txt', 'max:10240'],
        ]);

        $member = null;

        if (!empty($validated['family_member_id'])) {
            $member = FamilyMember::where('user_id', auth()->id())
                ->where('id', $validated['family_member_id'])
                ->firstOrFail();
        }

        $filePath = 'text-only-report';
        $originalName = null;
        $mimeType = null;
        $fileSize = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getMimeType();
            $fileSize = $file->getSize();

            $rawFileContent = file_get_contents($file->getRealPath());

            $encryptedPayload = Crypt::encryptString(base64_encode($rawFileContent));

            $safeName = Str::uuid()->toString() . '.dps';

            $filePath = 'medical-reports/encrypted/' . auth()->id() . '/' . $safeName;

            Storage::disk('local')->put($filePath, $encryptedPayload);
        }

        try {
            $ai = $gemini->analyzeMedicalReport(
                $validated['report_text'],
                $validated['report_type']
            );

            MedicalReport::create([
                'user_id' => auth()->id(),
                'family_member_id' => $member?->id,
                'report_type' => $validated['report_type'],
                'title' => $validated['title'],

                'file_path' => $filePath,
                'original_name' => $originalName,
                'mime_type' => $mimeType,
                'file_size' => $fileSize,

                'ai_summary' => $ai['summary'],
                'warning_signs' => $ai['warning_signs'],
                'ai_confidence_score' => $ai['ai_confidence_score'],
                'recommended_specialist' => $ai['recommended_specialist'],
                'severity_level' => $ai['severity_level'],
                'abnormal_findings' => $ai['abnormal_findings'],
                'health_advice' => $ai['health_advice'],
                'ai_raw_response' => json_encode($ai, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),

                'is_encrypted' => $request->hasFile('file'),
            ]);

            return redirect()
                ->route('user.medical-reports.index')
                ->with('success', 'Medical report encrypted, uploaded, and analyzed by AI successfully.');

        } catch (\Throwable $e) {
            if ($filePath && $filePath !== 'text-only-report') {
                Storage::disk('local')->delete($filePath);
            }

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}