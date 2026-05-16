<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->status === 'pending') {
                Auth::logout();

                return redirect()
                    ->route('login')
                    ->with('error', 'Your doctor account is pending admin approval. Please wait until admin verifies your profile.');
            }

            if ($user->status === 'blocked') {
                Auth::logout();

                return redirect()
                    ->route('login')
                    ->with('error', 'Your account has been blocked. Please contact support or admin.');
            }
        }

        return $next($request);
    }
}