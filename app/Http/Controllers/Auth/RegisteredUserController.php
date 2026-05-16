<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', 'in:user,doctor'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $role = $request->role;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $role,
            'status' => $role === 'doctor' ? 'pending' : 'active',
            'password' => Hash::make($request->password),
        ]);

        if ($role === 'doctor') {
            Doctor::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'specialist' => 'General Physician',
                'verification_status' => 'pending',
            ]);
        }

        event(new Registered($user));

        if ($role === 'doctor') {
            return redirect()
                ->route('login')
                ->with('status', 'Doctor account created successfully. Please wait for admin approval.');
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}