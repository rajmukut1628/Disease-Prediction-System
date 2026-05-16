<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardRedirectController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return match ($user->role) {
            'doctor' => redirect()->route('doctor.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            'super_admin' => redirect()->route('superadmin.dashboard'),
            default => redirect()->route('user.dashboard'),
        };
    }
}