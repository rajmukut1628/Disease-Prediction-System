<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Models\HealthRecord;
use Illuminate\Http\Request;

class HealthRecordController extends Controller
{
    public function index()
    {
        $records = HealthRecord::where('user_id', auth()->id())
            ->with('familyMember')
            ->latest()
            ->paginate(12);

        $latestRecord = HealthRecord::where('user_id', auth()->id())
            ->latest()
            ->first();

        return view('user.health-records.index', compact('records', 'latestRecord'));
    }

    public function create()
    {
        $familyMembers = FamilyMember::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.health-records.create', compact('familyMembers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'family_member_id' => ['nullable', 'exists:family_members,id'],
            'height_cm' => ['nullable', 'numeric', 'min:30', 'max:250'],
            'weight_kg' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'blood_pressure' => ['nullable', 'string', 'max:30'],
            'sugar_level' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'heart_rate' => ['nullable', 'integer', 'min:20', 'max:250'],
            'oxygen_level' => ['nullable', 'integer', 'min:40', 'max:100'],
            'sleep_hours' => ['nullable', 'numeric', 'min:0', 'max:24'],
            'water_intake_ml' => ['nullable', 'integer', 'min:0', 'max:10000'],
            'notes' => ['nullable', 'string', 'max:3000'],
        ]);

        if (!empty($validated['family_member_id'])) {
            FamilyMember::where('user_id', auth()->id())
                ->where('id', $validated['family_member_id'])
                ->firstOrFail();
        }

        $validated['user_id'] = auth()->id();
        $validated['bmi'] = $this->calculateBmi(
            $validated['height_cm'] ?? null,
            $validated['weight_kg'] ?? null
        );

        HealthRecord::create($validated);

        return redirect()
            ->route('user.health-records.index')
            ->with('success', 'Health record saved successfully.');
    }

    public function show(HealthRecord $healthRecord)
    {
        $this->authorizeOwner($healthRecord);

        return view('user.health-records.show', compact('healthRecord'));
    }

    public function edit(HealthRecord $healthRecord)
    {
        $this->authorizeOwner($healthRecord);

        $familyMembers = FamilyMember::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.health-records.edit', compact('healthRecord', 'familyMembers'));
    }

    public function update(Request $request, HealthRecord $healthRecord)
    {
        $this->authorizeOwner($healthRecord);

        $validated = $request->validate([
            'family_member_id' => ['nullable', 'exists:family_members,id'],
            'height_cm' => ['nullable', 'numeric', 'min:30', 'max:250'],
            'weight_kg' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'blood_pressure' => ['nullable', 'string', 'max:30'],
            'sugar_level' => ['nullable', 'numeric', 'min:0', 'max:1000'],
            'heart_rate' => ['nullable', 'integer', 'min:20', 'max:250'],
            'oxygen_level' => ['nullable', 'integer', 'min:40', 'max:100'],
            'sleep_hours' => ['nullable', 'numeric', 'min:0', 'max:24'],
            'water_intake_ml' => ['nullable', 'integer', 'min:0', 'max:10000'],
            'notes' => ['nullable', 'string', 'max:3000'],
        ]);

        if (!empty($validated['family_member_id'])) {
            FamilyMember::where('user_id', auth()->id())
                ->where('id', $validated['family_member_id'])
                ->firstOrFail();
        }

        $validated['bmi'] = $this->calculateBmi(
            $validated['height_cm'] ?? null,
            $validated['weight_kg'] ?? null
        );

        $healthRecord->update($validated);

        return redirect()
            ->route('user.health-records.index')
            ->with('success', 'Health record updated successfully.');
    }

    public function destroy(HealthRecord $healthRecord)
    {
        $this->authorizeOwner($healthRecord);

        $healthRecord->delete();

        return redirect()
            ->route('user.health-records.index')
            ->with('success', 'Health record deleted successfully.');
    }

    private function calculateBmi($heightCm, $weightKg): ?float
    {
        if (!$heightCm || !$weightKg) {
            return null;
        }

        $heightM = $heightCm / 100;

        if ($heightM <= 0) {
            return null;
        }

        return round($weightKg / ($heightM * $heightM), 2);
    }

    private function authorizeOwner(HealthRecord $healthRecord): void
    {
        if ((int) $healthRecord->user_id !== (int) auth()->id()) {
            abort(403, 'Unauthorized access.');
        }
    }
}