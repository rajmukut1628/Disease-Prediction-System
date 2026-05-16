<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    private function doctorId()
    {
        return Auth::user()->doctor?->id;
    }

    public function index()
    {
        $doctorId = $this->doctorId();

        abort_if(! $doctorId, 403, 'Doctor profile not found.');

        $appointments = Appointment::with('user')
            ->where('doctor_id', $doctorId)
            ->latest()
            ->paginate(12);

        return view('doctor.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        abort_unless($appointment->doctor_id === $this->doctorId(), 403);

        $appointment->load('user');

        return view('doctor.appointments.show', compact('appointment'));
    }

    public function approve(Appointment $appointment)
    {
        abort_unless($appointment->doctor_id === $this->doctorId(), 403);

        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Only pending appointments can be approved.');
        }

        $appointment->update([
            'status' => 'approved',
            'reject_reason' => null,
        ]);

        return back()->with('success', 'Appointment approved successfully.');
    }

    public function reject(Request $request, Appointment $appointment)
    {
        abort_unless($appointment->doctor_id === $this->doctorId(), 403);

        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Only pending appointments can be rejected.');
        }

        $validated = $request->validate([
            'reject_reason' => ['required', 'string', 'max:1000'],
        ]);

        $appointment->update([
            'status' => 'rejected',
            'reject_reason' => $validated['reject_reason'],
        ]);

        return back()->with('success', 'Appointment rejected successfully.');
    }

    public function complete(Request $request, Appointment $appointment)
    {
        abort_unless($appointment->doctor_id === $this->doctorId(), 403);

        if ($appointment->status !== 'approved') {
            return back()->with('error', 'Only approved appointments can be completed.');
        }

        $validated = $request->validate([
            'doctor_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $appointment->update([
            'status' => 'completed',
            'doctor_note' => $validated['doctor_note'] ?? null,
        ]);

        return back()->with('success', 'Appointment marked as completed.');
    }
}