<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardRedirectController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\SymptomCheckerController;
use App\Http\Controllers\User\RiskPredictionController;
use App\Http\Controllers\User\MedicalReportController;
use App\Http\Controllers\User\SecureMedicalReportFileController;
use App\Http\Controllers\User\FamilyMemberController;
use App\Http\Controllers\User\HealthRecordController;
use App\Http\Controllers\User\HealthInsightController;
use App\Http\Controllers\User\EmergencyContactController;
use App\Http\Controllers\User\AiHealthChatController;
use App\Http\Controllers\User\DoctorRecommendationController;
use App\Http\Controllers\User\AppointmentController as UserAppointmentController;

use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DoctorApprovalController;

use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'check.status'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Common Auth Routes
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', DashboardRedirectController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:user')
        ->prefix('user')
        ->name('user.')
        ->group(function () {
            Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

            Route::get('/symptom-checker', [SymptomCheckerController::class, 'create'])->name('symptom-checker.create');
            Route::post('/symptom-checker', [SymptomCheckerController::class, 'store'])->name('symptom-checker.store');

            Route::get('/risk-prediction', [RiskPredictionController::class, 'create'])->name('risk-prediction.create');
            Route::post('/risk-prediction', [RiskPredictionController::class, 'store'])->name('risk-prediction.store');

            Route::get('/medical-reports', [MedicalReportController::class, 'index'])->name('medical-reports.index');
            Route::get('/medical-reports/create', [MedicalReportController::class, 'create'])->name('medical-reports.create');
            Route::post('/medical-reports', [MedicalReportController::class, 'store'])->name('medical-reports.store');
            Route::get('/medical-reports/{medicalReport}', [MedicalReportController::class, 'show'])->name('medical-reports.show');
            Route::get('/medical-reports/{medicalReport}/edit', [MedicalReportController::class, 'edit'])->name('medical-reports.edit');
            Route::patch('/medical-reports/{medicalReport}', [MedicalReportController::class, 'update'])->name('medical-reports.update');
            Route::delete('/medical-reports/{medicalReport}', [MedicalReportController::class, 'destroy'])->name('medical-reports.destroy');

            Route::get('/medical-reports/{medicalReport}/view-file', [SecureMedicalReportFileController::class, 'view'])->name('medical-reports.file.view');
            Route::get('/medical-reports/{medicalReport}/download-file', [SecureMedicalReportFileController::class, 'download'])->name('medical-reports.file.download');

            Route::resource('family-members', FamilyMemberController::class);
            Route::resource('health-records', HealthRecordController::class);

            Route::get('/health-insights', [HealthInsightController::class, 'index'])->name('health-insights.index');
            Route::post('/health-insights/generate', [HealthInsightController::class, 'generate'])->name('health-insights.generate');

            Route::resource('emergency-contacts', EmergencyContactController::class);

            Route::get('/ai-health-chat', [AiHealthChatController::class, 'index'])->name('ai-health-chat.index');
            Route::post('/ai-health-chat/send', [AiHealthChatController::class, 'send'])->name('ai-health-chat.send');

            Route::get('/doctor-recommendations', [DoctorRecommendationController::class, 'index'])->name('doctor-recommendations.index');
            Route::get('/doctor-recommendations/{symptomCheck}', [DoctorRecommendationController::class, 'fromSymptomCheck'])->name('doctor-recommendations.symptom');

            Route::get('/doctors/{doctor}/appointments/create', [UserAppointmentController::class, 'create'])->name('appointments.create');
            Route::post('/doctors/{doctor}/appointments', [UserAppointmentController::class, 'store'])->name('appointments.store');
            Route::get('/appointments', [UserAppointmentController::class, 'index'])->name('appointments.index');
            Route::get('/appointments/{appointment}', [UserAppointmentController::class, 'show'])->name('appointments.show');
            Route::patch('/appointments/{appointment}/cancel', [UserAppointmentController::class, 'cancel'])->name('appointments.cancel');
        });

    /*
    |--------------------------------------------------------------------------
    | Doctor Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:doctor')
        ->prefix('doctor')
        ->name('doctor.')
        ->group(function () {
            Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');

            Route::get('/appointments', [DoctorAppointmentController::class, 'index'])->name('appointments.index');
            Route::get('/appointments/{appointment}', [DoctorAppointmentController::class, 'show'])->name('appointments.show');
            Route::patch('/appointments/{appointment}/approve', [DoctorAppointmentController::class, 'approve'])->name('appointments.approve');
            Route::patch('/appointments/{appointment}/reject', [DoctorAppointmentController::class, 'reject'])->name('appointments.reject');
            Route::patch('/appointments/{appointment}/complete', [DoctorAppointmentController::class, 'complete'])->name('appointments.complete');
        });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            Route::get('/doctors/pending', [DoctorApprovalController::class, 'index'])->name('doctors.pending');
            Route::patch('/doctors/{doctor}/approve', [DoctorApprovalController::class, 'approve'])->name('doctors.approve');
            Route::patch('/doctors/{doctor}/reject', [DoctorApprovalController::class, 'reject'])->name('doctors.reject');
        });
            /*
    |--------------------------------------------------------------------------
    | Super Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:super_admin')
        ->prefix('superadmin')
        ->name('superadmin.')
        ->group(function () {
            Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
                ->name('dashboard');
        });
});

require __DIR__.'/auth.php';