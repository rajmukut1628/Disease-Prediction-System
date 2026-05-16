<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;

class EmergencyContactController extends Controller
{
    public function index()
    {
        $contacts = EmergencyContact::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.emergency-contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('user.emergency-contacts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'relation' => ['nullable', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'is_primary' => ['nullable', 'boolean'],
            'notify_by_sms' => ['nullable', 'boolean'],
            'notify_by_email' => ['nullable', 'boolean'],
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_primary'] = $request->boolean('is_primary');
        $validated['notify_by_sms'] = $request->boolean('notify_by_sms');
        $validated['notify_by_email'] = $request->boolean('notify_by_email');

        if ($validated['is_primary']) {
            EmergencyContact::where('user_id', auth()->id())
                ->update(['is_primary' => false]);
        }

        EmergencyContact::create($validated);

        return redirect()
            ->route('user.emergency-contacts.index')
            ->with('success', 'Emergency contact added successfully.');
    }

    public function show(EmergencyContact $emergencyContact)
    {
        $this->authorizeOwner($emergencyContact);

        return view('user.emergency-contacts.show', compact('emergencyContact'));
    }

    public function edit(EmergencyContact $emergencyContact)
    {
        $this->authorizeOwner($emergencyContact);

        return view('user.emergency-contacts.edit', compact('emergencyContact'));
    }

    public function update(Request $request, EmergencyContact $emergencyContact)
    {
        $this->authorizeOwner($emergencyContact);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'relation' => ['nullable', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'is_primary' => ['nullable', 'boolean'],
            'notify_by_sms' => ['nullable', 'boolean'],
            'notify_by_email' => ['nullable', 'boolean'],
        ]);

        $validated['is_primary'] = $request->boolean('is_primary');
        $validated['notify_by_sms'] = $request->boolean('notify_by_sms');
        $validated['notify_by_email'] = $request->boolean('notify_by_email');

        if ($validated['is_primary']) {
            EmergencyContact::where('user_id', auth()->id())
                ->where('id', '!=', $emergencyContact->id)
                ->update(['is_primary' => false]);
        }

        $emergencyContact->update($validated);

        return redirect()
            ->route('user.emergency-contacts.index')
            ->with('success', 'Emergency contact updated successfully.');
    }

    public function destroy(EmergencyContact $emergencyContact)
    {
        $this->authorizeOwner($emergencyContact);

        $emergencyContact->delete();

        return redirect()
            ->route('user.emergency-contacts.index')
            ->with('success', 'Emergency contact deleted successfully.');
    }

    private function authorizeOwner(EmergencyContact $emergencyContact): void
    {
        if ((int) $emergencyContact->user_id !== (int) auth()->id()) {
            abort(403, 'Unauthorized access.');
        }
    }
}