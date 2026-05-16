<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function create(Doctor $doctor)
    {
        return view('user.appointments.create', compact('doctor'));
    }

    public function store(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_phone' => ['required', 'string', 'max:30'],
            'problem_description' => ['nullable', 'string', 'max:2000'],
        ]);

        $minute = (int) date('i', strtotime($validated['appointment_time']));

        if ($minute % 5 !== 0) {
            return back()
                ->withInput()
                ->with('error', 'Please select a valid 5-minute time slot.');
        }

        $alreadyBooked = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('appointment_date', $validated['appointment_date'])
            ->whereTime('appointment_time', $validated['appointment_time'])
            ->whereIn('status', ['pending', 'approved', 'completed'])
            ->exists();

        if ($alreadyBooked) {
            return back()
                ->withInput()
                ->with('error', 'This slot is already booked. Please choose another available time.');
        }

        Appointment::create([
            'user_id' => Auth::id(),
            'doctor_id' => $doctor->id,
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'patient_name' => $validated['patient_name'],
            'patient_phone' => $validated['patient_phone'],
            'problem_description' => $validated['problem_description'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.appointments.index')
            ->with('success', 'Appointment request submitted successfully.');
    }

    public function index()
    {
        $appointments = Appointment::with('doctor')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        abort_unless($appointment->user_id === Auth::id(), 403);

        $appointment->load('doctor');

        return view('user.appointments.show', compact('appointment'));
    }

    public function cancel(Appointment $appointment)
    {
        abort_unless($appointment->user_id === Auth::id(), 403);

        if (! in_array($appointment->status, ['pending', 'approved'])) {
            return back()->with('error', 'Only pending or approved appointments can be cancelled.');
        }

        $appointment->update([
            'status' => 'rejected',
            'reject_reason' => 'Cancelled by patient.',
        ]);

        return back()->with('success', 'Appointment cancelled successfully.');
    }
}