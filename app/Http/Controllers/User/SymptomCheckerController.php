<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\SymptomCheck;
use App\Services\GeminiHealthService;
use Illuminate\Http\Request;

class SymptomCheckerController extends Controller
{
    public function create()
    {
        $familyMembers = FamilyMember::where('user_id', auth()->id())->latest()->get();
        $latestChecks = SymptomCheck::where('user_id', auth()->id())->latest()->take(5)->get();

        return view('user.symptom-checker.create', compact('familyMembers', 'latestChecks'));
    }

    public function store(Request $request, GeminiHealthService $gemini)
    {
        $validated = $request->validate([
            'family_member_id' => ['nullable', 'exists:family_members,id'],
            'symptoms' => ['required', 'string', 'min:5', 'max:5000'],
        ]);

        $member = null;
        $memberInfo = 'Main user profile';

        if (!empty($validated['family_member_id'])) {
            $member = FamilyMember::where('user_id', auth()->id())
                ->where('id', $validated['family_member_id'])
                ->firstOrFail();

            $memberInfo = "Name: {$member->name}, Relation: {$member->relation}, Age: {$member->age}, Gender: {$member->gender}, Blood Group: {$member->blood_group}, Conditions: {$member->medical_conditions}, Allergies: {$member->allergies}";
        }

        try {
            $ai = $gemini->analyzeSymptoms($validated['symptoms'], $memberInfo);

            $check = SymptomCheck::create([
                'user_id' => auth()->id(),
                'family_member_id' => $member?->id,
                'symptoms' => $validated['symptoms'],
                'probable_disease' => $ai['probable_disease'],
                'severity' => $ai['severity'],
                'confidence_score' => $ai['confidence_score'],
                'next_steps' => $ai['next_steps'],
                'ai_response' => json_encode($ai, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            ]);

            return redirect()
                ->route('user.symptom-checker.create')
                ->with('success', 'AI symptom analysis completed successfully.')
                ->with('latest_check_id', $check->id);

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}