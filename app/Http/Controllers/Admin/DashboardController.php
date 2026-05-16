<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Core Statistics
        |--------------------------------------------------------------------------
        */
        $totalUsers = User::count();
        $totalDoctors = Doctor::count();
        $totalPatients = User::whereIn('role', ['user', 'patient'])->count();

        /*
        |--------------------------------------------------------------------------
        | Doctor Approval Statistics
        |--------------------------------------------------------------------------
        */
        $pendingDoctors = Doctor::where('verification_status', 'pending')->count();
        $approvedDoctors = Doctor::where('verification_status', 'approved')->count();
        $rejectedDoctors = Doctor::where('verification_status', 'rejected')->count();

        /*
        |--------------------------------------------------------------------------
        | Appointment Statistics
        |--------------------------------------------------------------------------
        */
        $appointmentStats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'approved' => Appointment::where('status', 'approved')->count(),
            'rejected' => Appointment::where('status', 'rejected')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | Recent Appointments
        |--------------------------------------------------------------------------
        */
        $recentAppointments = Appointment::with(['user', 'doctor'])
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Recent Pending Doctors
        |--------------------------------------------------------------------------
        */
        $recentPendingDoctors = Doctor::with('user')
            ->where('verification_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return Dashboard View
        |--------------------------------------------------------------------------
        */
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDoctors',
            'totalPatients',
            'pendingDoctors',
            'approvedDoctors',
            'rejectedDoctors',
            'appointmentStats',
            'recentAppointments',
            'recentPendingDoctors'
        ));
    }
}