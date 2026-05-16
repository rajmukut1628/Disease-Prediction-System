<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\HealthInsight;
use App\Models\HealthRecord;
use App\Models\MedicalReport;
use App\Models\RiskPrediction;
use App\Models\SymptomCheck;
use App\Services\GeminiHealthService;
use Illuminate\Http\Request;

class HealthInsightController extends Controller
{
    public function index()
    {
        $familyMembers = FamilyMember::where('user_id', auth()->id())
            ->latest()
            ->get();

        $insights = HealthInsight::where('user_id', auth()->id())
            ->with('familyMember')
            ->latest()
            ->paginate(10);

        return view('user.health-insights.index', compact('familyMembers', 'insights'));
    }

    public function generate(Request $request, GeminiHealthService $gemini)
    {
        $validated = $request->validate([
            'family_member_id' => ['nullable', 'exists:family_members,id'],
        ]);

        $familyMemberId = $validated['family_member_id'] ?? null;

        if ($familyMemberId) {
            FamilyMember::where('user_id', auth()->id())
                ->where('id', $familyMemberId)
                ->firstOrFail();
        }

        $healthRecords = HealthRecord::where('user_id', auth()->id())
            ->when($familyMemberId, fn ($q) => $q->where('family_member_id', $familyMemberId))
            ->latest()
            ->take(8)
            ->get()
            ->map(fn ($record) => [
                'date' => $record->created_at->format('Y-m-d'),
                'bmi' => $record->bmi,
                'blood_pressure' => $record->blood_pressure,
                'sugar_level' => $record->sugar_level,
                'heart_rate' => $record->heart_rate,
                'oxygen_level' => $record->oxygen_level,
                'sleep_hours' => $record->sleep_hours,
                'water_intake_ml' => $record->water_intake_ml,
                'notes' => $record->notes,
            ])
            ->values()
            ->toArray();

        $symptomChecks = SymptomCheck::where('user_id', auth()->id())
            ->when($familyMemberId, fn ($q) => $q->where('family_member_id', $familyMemberId))
            ->latest()
            ->take(8)
            ->get()
            ->map(fn ($check) => [
                'date' => $check->created_at->format('Y-m-d'),
                'symptoms' => $check->symptoms,
                'probable_disease' => $check->probable_disease,
                'severity' => $check->severity,
                'confidence_score' => $check->confidence_score,
                'next_steps' => $check->next_steps,
            ])
            ->values()
            ->toArray();

        $riskPredictions = RiskPrediction::where('user_id', auth()->id())
            ->when($familyMemberId, fn ($q) => $q->where('family_member_id', $familyMemberId))
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($risk) => [
                'date' => $risk->created_at->format('Y-m-d'),
                'diabetes_risk' => $risk->diabetes_risk,
                'heart_disease_risk' => $risk->heart_disease_risk,
                'kidney_disease_risk' => $risk->kidney_disease_risk,
                'stroke_risk' => $risk->stroke_risk,
                'overall_risk_level' => $risk->overall_risk_level,
                'recommendation' => $risk->recommendation,
            ])
            ->values()
            ->toArray();

        $medicalReports = MedicalReport::where('user_id', auth()->id())
            ->when($familyMemberId, fn ($q) => $q->where('family_member_id', $familyMemberId))
            ->latest()
            ->take(5)
            ->get()
            ->map(fn ($report) => [
                'date' => $report->created_at->format('Y-m-d'),
                'report_type' => $report->report_type,
                'title' => $report->title,
                'ai_summary' => $report->ai_summary,
                'severity_level' => $report->severity_level,
                'warning_signs' => $report->warning_signs,
                'recommended_specialist' => $report->recommended_specialist,
                'abnormal_findings' => $report->abnormal_findings,
                'health_advice' => $report->health_advice,
            ])
            ->values()
            ->toArray();

        if (
            empty($healthRecords)
            && empty($symptomChecks)
            && empty($riskPredictions)
            && empty($medicalReports)
        ) {
            return back()->with('error', 'No health data found. Please add health records, symptoms, risk predictions, or reports first.');
        }

        try {
            $ai = $gemini->generateHealthInsight([
                'health_records' => $healthRecords,
                'symptom_checks' => $symptomChecks,
                'risk_predictions' => $riskPredictions,
                'medical_reports' => $medicalReports,
            ]);

            HealthInsight::create([
                'user_id' => auth()->id(),
                'family_member_id' => $familyMemberId,
                'title' => $ai['title'],
                'trend_status' => $ai['trend_status'],
                'confidence_score' => $ai['confidence_score'],
                'health_summary' => $ai['health_summary'],
                'risk_warning' => $ai['risk_warning'],
                'next_action_plan' => $ai['next_action_plan'],
                'key_changes' => $ai['key_changes'],
                'ai_raw_response' => $ai['raw'],
            ]);

            return redirect()
                ->route('user.health-insights.index')
                ->with('success', 'AI health insight generated successfully.');

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}