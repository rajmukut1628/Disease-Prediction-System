<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{
    public function index()
    {
        $familyMembers = FamilyMember::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.family-members.index', compact('familyMembers'));
    }

    public function create()
    {
        return view('user.family-members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'relation' => ['nullable', 'string', 'max:100'],
            'age' => ['nullable', 'integer', 'min:0', 'max:120'],
            'gender' => ['nullable', 'in:male,female,other'],
            'blood_group' => ['nullable', 'string', 'max:10'],
            'height_cm' => ['nullable', 'numeric', 'min:30', 'max:250'],
            'weight_kg' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'medical_conditions' => ['nullable', 'string', 'max:3000'],
            'allergies' => ['nullable', 'string', 'max:3000'],
        ]);

        $validated['user_id'] = auth()->id();

        FamilyMember::create($validated);

        return redirect()
            ->route('user.family-members.index')
            ->with('success', 'Family member added successfully.');
    }

    public function show(FamilyMember $familyMember)
    {
        $this->authorizeOwner($familyMember);

        $familyMember->load([
            'symptomChecks' => fn ($query) => $query->latest()->take(5),
            'riskPredictions' => fn ($query) => $query->latest()->take(5),
            'medicalReports' => fn ($query) => $query->latest()->take(5),
            'healthRecords' => fn ($query) => $query->latest()->take(5),
        ]);

        return view('user.family-members.show', compact('familyMember'));
    }

    public function edit(FamilyMember $familyMember)
    {
        $this->authorizeOwner($familyMember);

        return view('user.family-members.edit', compact('familyMember'));
    }

    public function update(Request $request, FamilyMember $familyMember)
    {
        $this->authorizeOwner($familyMember);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'relation' => ['nullable', 'string', 'max:100'],
            'age' => ['nullable', 'integer', 'min:0', 'max:120'],
            'gender' => ['nullable', 'in:male,female,other'],
            'blood_group' => ['nullable', 'string', 'max:10'],
            'height_cm' => ['nullable', 'numeric', 'min:30', 'max:250'],
            'weight_kg' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'medical_conditions' => ['nullable', 'string', 'max:3000'],
            'allergies' => ['nullable', 'string', 'max:3000'],
        ]);

        $familyMember->update($validated);

        return redirect()
            ->route('user.family-members.index')
            ->with('success', 'Family member updated successfully.');
    }

    public function destroy(FamilyMember $familyMember)
    {
        $this->authorizeOwner($familyMember);

        $familyMember->delete();

        return redirect()
            ->route('user.family-members.index')
            ->with('success', 'Family member deleted successfully.');
    }

    private function authorizeOwner(FamilyMember $familyMember): void
    {
        if ((int) $familyMember->user_id !== (int) auth()->id()) {
            abort(403, 'Unauthorized access.');
        }
    }
}