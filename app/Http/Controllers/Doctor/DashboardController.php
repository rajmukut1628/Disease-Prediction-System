<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalReport;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $doctor = method_exists($user, 'doctor')
            ? $user->doctor
            : null;

        $doctorId = $doctor?->id;

        $stats = [
            'total_appointments' => 0,
            'pending_appointments' => 0,
            'approved_appointments' => 0,
            'completed_appointments' => 0,
            'total_patients' => 0,
            'medical_reports' => 0,
        ];

        if ($doctorId && class_exists(Appointment::class) && Schema::hasTable('appointments')) {
            $appointmentQuery = Appointment::query()->where('doctor_id', $doctorId);

            $stats['total_appointments'] = (clone $appointmentQuery)->count();

            if (Schema::hasColumn('appointments', 'status')) {
                $stats['pending_appointments'] = (clone $appointmentQuery)->where('status', 'pending')->count();
                $stats['approved_appointments'] = (clone $appointmentQuery)->whereIn('status', ['approved', 'accepted'])->count();
                $stats['completed_appointments'] = (clone $appointmentQuery)->where('status', 'completed')->count();
            }
        }

        if (class_exists(Patient::class) && Schema::hasTable('patients')) {
            $stats['total_patients'] = Patient::query()->count();
        }

        if (class_exists(MedicalReport::class) && Schema::hasTable('medical_reports')) {
            $stats['medical_reports'] = MedicalReport::query()->count();
        }

        $recentAppointments = collect();

        if ($doctorId && class_exists(Appointment::class) && Schema::hasTable('appointments')) {
            $recentAppointments = Appointment::query()
                ->where('doctor_id', $doctorId)
                ->when(method_exists(Appointment::class, 'patient'), function ($query) {
                    $query->with('patient');
                })
                ->latest()
                ->take(6)
                ->get();
        }

        return view('doctor.dashboard', compact(
            'user',
            'doctor',
            'stats',
            'recentAppointments'
        ));
    }
}