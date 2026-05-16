<x-app-layout>
    @php
        $role = auth()->user()->role ?? 'user';

        $backUrl = match ($role) {
            'doctor' => route('doctor.dashboard'),
            'admin' => route('admin.dashboard'),
            'super_admin', 'superadmin' => route('superadmin.dashboard'),
            default => route('user.dashboard'),
        };

        $roleLabel = strtoupper(str_replace('_', ' ', $role));
        $initial = strtoupper(substr($user->name ?? 'U', 0, 1));
    @endphp

    <style>
        @keyframes profileFloat {
            0%,100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-14px) scale(1.03); }
        }

        @keyframes profileShadow {
            0% { box-shadow: 0 0 35px rgba(34,211,238,.18), 0 0 90px rgba(59,130,246,.12); }
            50% { box-shadow: 0 0 60px rgba(168,85,247,.22), 0 0 130px rgba(34,211,238,.14); }
            100% { box-shadow: 0 0 35px rgba(34,211,238,.18), 0 0 90px rgba(59,130,246,.12); }
        }

        @keyframes profileGradient {
            0% { background-position:0% 50%; }
            50% { background-position:100% 50%; }
            100% { background-position:0% 50%; }
        }

        .profile-float { animation: profileFloat 6s ease-in-out infinite; }
        .profile-live-shadow { animation: profileShadow 6s ease-in-out infinite; }

        .profile-gradient-text {
            background: linear-gradient(90deg, #67e8f9, #60a5fa, #a78bfa, #34d399);
            background-size: 280% 280%;
            animation: profileGradient 7s ease infinite;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>

    <div class="relative min-h-screen overflow-hidden bg-slate-950 px-5 py-8 text-white lg:px-10">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(34,211,238,.18),transparent_35%),radial-gradient(circle_at_bottom_right,rgba(168,85,247,.18),transparent_35%)]"></div>
        <div class="absolute -top-32 -left-32 h-96 w-96 rounded-full bg-cyan-400/20 blur-3xl profile-float"></div>
        <div class="absolute -bottom-32 -right-32 h-96 w-96 rounded-full bg-purple-500/20 blur-3xl profile-float"></div>

        <div class="relative mx-auto max-w-7xl">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm font-black uppercase tracking-[0.35em] text-cyan-300">
                        {{ $roleLabel }} Profile
                    </p>
                    <h1 class="mt-2 text-4xl font-black md:text-6xl">
                        View <span class="profile-gradient-text">Profile</span>
                    </h1>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ $backUrl }}"
                       class="rounded-2xl border border-white/10 bg-white/10 px-5 py-3 text-sm font-black text-white backdrop-blur-xl transition hover:bg-white/15">
                        Back
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="rounded-2xl bg-gradient-to-r from-cyan-300 via-blue-400 to-purple-400 px-5 py-3 text-sm font-black text-slate-950 shadow-lg shadow-cyan-500/25 transition hover:scale-[1.03]">
                        Edit Profile
                    </a>
                </div>
            </div>

            @if (session('status') === 'profile-updated')
                <div class="mb-6 rounded-3xl border border-emerald-300/20 bg-emerald-400/10 p-5 text-sm font-black text-emerald-200 backdrop-blur-xl">
                    Profile updated successfully.
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
                <div class="relative overflow-hidden rounded-[2.8rem] border border-white/10 bg-white/10 p-6 backdrop-blur-2xl profile-live-shadow">
                    <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-cyan-400/20 blur-3xl"></div>
                    <div class="absolute -left-20 -bottom-20 h-64 w-64 rounded-full bg-purple-400/20 blur-3xl"></div>

                    <div class="relative rounded-[2.2rem] border border-white/10 bg-slate-950/75 p-7 text-center">
                        <div class="mx-auto flex h-36 w-36 items-center justify-center overflow-hidden rounded-[2.4rem] bg-gradient-to-br from-cyan-300 via-blue-400 to-purple-500 text-6xl font-black text-white shadow-2xl shadow-cyan-500/25">
                            @if(!empty($profilePhoto))
                                <img src="{{ $profilePhoto }}" alt="Profile Photo" class="h-full w-full object-cover">
                            @else
                                {{ $initial }}
                            @endif
                        </div>

                        <h2 class="mt-6 text-3xl font-black">
                            {{ $user->name }}
                        </h2>

                        <p class="mt-2 break-all text-sm font-semibold text-slate-400">
                            {{ $user->email }}
                        </p>

                        <div class="mt-5 inline-flex rounded-full border border-cyan-300/20 bg-cyan-400/10 px-5 py-2 text-xs font-black tracking-[0.25em] text-cyan-100">
                            {{ $roleLabel }}
                        </div>

                        <a href="{{ route('profile.edit') }}"
                           class="mt-6 inline-flex w-full items-center justify-center rounded-2xl border border-cyan-300/20 bg-cyan-400/10 px-5 py-4 text-sm font-black text-cyan-100 transition hover:bg-cyan-400/20">
                            Upload / Change Picture
                        </a>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-[2.8rem] border border-white/10 bg-white/10 p-6 backdrop-blur-2xl profile-live-shadow">
                    <div class="absolute -right-16 -top-16 h-56 w-56 rounded-full bg-emerald-400/15 blur-3xl"></div>

                    <div class="relative grid gap-4 md:grid-cols-2">
                        <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-5">
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-slate-500">Name</p>
                            <p class="mt-2 text-lg font-black text-white">{{ $user->name ?? 'N/A' }}</p>
                        </div>

                        <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-5">
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-slate-500">Email</p>
                            <p class="mt-2 break-all text-lg font-black text-white">{{ $user->email ?? 'N/A' }}</p>
                        </div>

                        <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-5">
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-slate-500">Role</p>
                            <p class="mt-2 text-lg font-black text-cyan-200">{{ $roleLabel }}</p>
                        </div>

                        <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-5">
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-slate-500">Status</p>
                            <p class="mt-2 text-lg font-black text-emerald-200">{{ ucfirst($user->status ?? 'active') }}</p>
                        </div>

                        @if(isset($roleProfile) && $roleProfile)
                            @foreach(['phone','gender','blood_group','age','specialization','specialist','license_number','degree','experience','address'] as $field)
                                @if(isset($roleProfile->{$field}) && filled($roleProfile->{$field}))
                                    <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-5">
                                        <p class="text-xs font-black uppercase tracking-[0.22em] text-slate-500">
                                            {{ ucwords(str_replace('_', ' ', $field)) }}
                                        </p>
                                        <p class="mt-2 text-lg font-black text-white">
                                            {{ $roleProfile->{$field} }}
                                        </p>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>