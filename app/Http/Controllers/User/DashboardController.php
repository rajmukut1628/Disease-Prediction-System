<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\HealthRecord;
use App\Models\MedicalReport;
use App\Models\RiskPrediction;
use App\Models\SymptomCheck;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $latestSymptomCheck = SymptomCheck::where('user_id', $user->id)->latest()->first();
        $latestRiskPrediction = RiskPrediction::where('user_id', $user->id)->latest()->first();
        $latestHealthRecord = HealthRecord::where('user_id', $user->id)->latest()->first();

        $totalReports = MedicalReport::where('user_id', $user->id)->count();
        $totalSymptomChecks = SymptomCheck::where('user_id', $user->id)->count();

        $appointmentStats = [
            'total' => Appointment::where('user_id', $user->id)->count(),
            'pending' => Appointment::where('user_id', $user->id)->where('status', 'pending')->count(),
            'approved' => Appointment::where('user_id', $user->id)->where('status', 'approved')->count(),
            'rejected' => Appointment::where('user_id', $user->id)->where('status', 'rejected')->count(),
            'completed' => Appointment::where('user_id', $user->id)->where('status', 'completed')->count(),
        ];

        $recentAppointments = Appointment::with('doctor')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recentSymptomChecks = SymptomCheck::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'latestSymptomCheck',
            'latestRiskPrediction',
            'latestHealthRecord',
            'totalReports',
            'totalSymptomChecks',
            'appointmentStats',
            'recentAppointments',
            'recentSymptomChecks'
        ));
    }
}