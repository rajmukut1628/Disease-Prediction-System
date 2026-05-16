<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\RiskPrediction;
use App\Services\GeminiHealthService;
use Illuminate\Http\Request;

class RiskPredictionController extends Controller
{
    public function create()
    {
        $familyMembers = FamilyMember::where('user_id', auth()->id())->latest()->get();

        $latestPredictions = RiskPrediction::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('user.risk-prediction.create', compact(
            'familyMembers',
            'latestPredictions'
        ));
    }

    public function store(Request $request, GeminiHealthService $gemini)
    {
        $validated = $request->validate([
            'family_member_id' => ['nullable', 'exists:family_members,id'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'gender' => ['required', 'string', 'in:male,female,other'],
            'height_cm' => ['nullable', 'numeric', 'min:50', 'max:250'],
            'weight_kg' => ['nullable', 'numeric', 'min:10', 'max:300'],
            'blood_pressure' => ['nullable', 'string', 'max:30'],
            'sugar_level' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'heart_rate' => ['nullable', 'integer', 'min:20', 'max:250'],
            'oxygen_level' => ['nullable', 'integer', 'min:40', 'max:100'],
            'smoking' => ['required', 'string', 'in:no,yes,former'],
            'diabetes_family_history' => ['required', 'string', 'in:no,yes'],
            'heart_family_history' => ['required', 'string', 'in:no,yes'],
            'kidney_problem' => ['required', 'string', 'in:no,yes'],
            'symptoms' => ['nullable', 'string', 'max:3000'],
        ]);

        $member = null;

        if (!empty($validated['family_member_id'])) {
            $member = FamilyMember::where('user_id', auth()->id())
                ->where('id', $validated['family_member_id'])
                ->firstOrFail();
        }

        try {
            $ai = $gemini->analyzeRiskFactors($validated);

            $prediction = RiskPrediction::create([
                'user_id' => auth()->id(),
                'family_member_id' => $member?->id,
                'diabetes_risk' => $ai['diabetes_risk'],
                'heart_disease_risk' => $ai['heart_disease_risk'],
                'kidney_disease_risk' => $ai['kidney_disease_risk'],
                'stroke_risk' => $ai['stroke_risk'],
                'overall_risk_level' => $ai['overall_risk_level'],
                'input_data' => $validated,
                'recommendation' => $ai['recommendation'],
            ]);

            return redirect()
                ->route('user.risk-prediction.create')
                ->with('success', 'AI risk prediction completed successfully.')
                ->with('latest_prediction_id', $prediction->id);

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}