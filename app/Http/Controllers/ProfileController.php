<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
            'roleProfile' => $this->roleProfile($request->user()),
            'profilePhoto' => $this->profilePhotoUrl($request->user()),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'roleProfile' => $this->roleProfile($request->user()),
            'profilePhoto' => $this->profilePhotoUrl($request->user()),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');

            foreach (['profile_photo', 'avatar'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    if (!empty($user->{$column}) && Storage::disk('public')->exists($user->{$column})) {
                        Storage::disk('public')->delete($user->{$column});
                    }

                    $user->{$column} = $path;
                    break;
                }
            }
        }

        $user->save();

        $roleProfile = $this->roleProfile($user);

        if ($roleProfile) {
            if (Schema::hasColumn($roleProfile->getTable(), 'name')) {
                $roleProfile->name = $user->name;
            }

            if (Schema::hasColumn($roleProfile->getTable(), 'email')) {
                $roleProfile->email = $user->email;
            }

            if ($request->hasFile('profile_photo')) {
                foreach (['profile_photo', 'avatar', 'photo'] as $column) {
                    if (Schema::hasColumn($roleProfile->getTable(), $column)) {
                        $roleProfile->{$column} = $path;
                        break;
                    }
                }
            }

            if ($roleProfile->isDirty()) {
                $roleProfile->save();
            }
        }

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    private function roleProfile($user)
    {
        if (!$user) {
            return null;
        }

        if (in_array($user->role, ['user', 'patient'], true) && method_exists($user, 'patient')) {
            return $user->patient;
        }

        if ($user->role === 'doctor' && method_exists($user, 'doctor')) {
            return $user->doctor;
        }

        if ($user->role === 'admin' && method_exists($user, 'admin')) {
            return $user->admin;
        }

        if (in_array($user->role, ['super_admin', 'superadmin'], true) && method_exists($user, 'superAdmin')) {
            return $user->superAdmin;
        }

        return null;
    }

    private function profilePhotoUrl($user): ?string
    {
        foreach (['profile_photo', 'avatar'] as $column) {
            if (Schema::hasColumn('users', $column) && !empty($user->{$column})) {
                if (str_starts_with($user->{$column}, 'http')) {
                    return $user->{$column};
                }

                return Storage::url($user->{$column});
            }
        }

        return null;
    }
}