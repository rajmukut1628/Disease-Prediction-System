<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DoctorApprovalController extends Controller
{
    public function index(): View
    {
        $doctors = Doctor::with('user')
            ->where('verification_status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.doctors.pending', compact('doctors'));
    }

    public function approve(Doctor $doctor): RedirectResponse
    {
        $doctor->update([
            'verification_status' => 'approved',
        ]);

        $doctor->user?->update([
            'status' => 'active',
        ]);

        return back()->with('success', 'Doctor approved successfully.');
    }

    public function reject(Doctor $doctor): RedirectResponse
    {
        $doctor->update([
            'verification_status' => 'rejected',
        ]);

        $doctor->user?->update([
            'status' => 'blocked',
        ]);

        return back()->with('success', 'Doctor rejected and blocked successfully.');
    }
}