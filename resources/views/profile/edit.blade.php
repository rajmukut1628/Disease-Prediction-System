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
                        Edit <span class="profile-gradient-text">Profile</span>
                    </h1>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('profile.show') }}"
                       class="rounded-2xl border border-cyan-300/20 bg-cyan-400/10 px-5 py-3 text-sm font-black text-cyan-100 backdrop-blur-xl transition hover:bg-cyan-400/20">
                        View Profile
                    </a>

                    <a href="{{ $backUrl }}"
                       class="rounded-2xl border border-white/10 bg-white/10 px-5 py-3 text-sm font-black text-white backdrop-blur-xl transition hover:bg-white/15">
                        Back
                    </a>
                </div>
            </div>

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

                        <p class="mt-6 text-sm leading-6 text-slate-400">
                            Upload a new profile picture from the form. JPG, PNG, JPEG, WEBP supported.
                        </p>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-[2.8rem] border border-white/10 bg-white/10 p-6 backdrop-blur-2xl profile-live-shadow">
                    <div class="absolute -right-16 -top-16 h-56 w-56 rounded-full bg-emerald-400/15 blur-3xl"></div>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="relative space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="mb-2 block text-xs font-black uppercase tracking-[0.22em] text-slate-400">
                                Profile Picture
                            </label>

                            <input
                                type="file"
                                name="profile_photo"
                                accept="image/png,image/jpeg,image/jpg,image/webp"
                                class="w-full cursor-pointer rounded-2xl border border-white/10 bg-slate-950/70 px-5 py-4 text-sm font-bold text-slate-300 file:mr-4 file:rounded-xl file:border-0 file:bg-cyan-400/20 file:px-4 file:py-2 file:text-sm file:font-black file:text-cyan-100 hover:bg-slate-900/80"
                            >

                            @error('profile_photo')
                                <p class="mt-2 text-sm font-bold text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="name" class="mb-2 block text-xs font-black uppercase tracking-[0.22em] text-slate-400">
                                Name
                            </label>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full rounded-2xl border border-white/10 bg-slate-950/70 px-5 py-4 font-bold text-white outline-none transition focus:border-cyan-300/50 focus:ring-4 focus:ring-cyan-400/10"
                            >

                            @error('name')
                                <p class="mt-2 text-sm font-bold text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="mb-2 block text-xs font-black uppercase tracking-[0.22em] text-slate-400">
                                Email
                            </label>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full rounded-2xl border border-white/10 bg-slate-950/70 px-5 py-4 font-bold text-white outline-none transition focus:border-cyan-300/50 focus:ring-4 focus:ring-cyan-400/10"
                            >

                            @error('email')
                                <p class="mt-2 text-sm font-bold text-red-300">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row">
                            <button type="submit"
                                    class="rounded-2xl bg-gradient-to-r from-cyan-300 via-blue-400 to-purple-400 px-8 py-4 font-black text-slate-950 shadow-lg shadow-cyan-500/25 transition hover:scale-[1.03]">
                                Save Changes
                            </button>

                            <a href="{{ route('profile.show') }}"
                               class="rounded-2xl border border-white/10 bg-white/10 px-8 py-4 text-center font-black text-white transition hover:bg-white/15">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>