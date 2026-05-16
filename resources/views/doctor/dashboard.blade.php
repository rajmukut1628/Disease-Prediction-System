<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doctor Panel - {{ config('app.name', 'Disease Prediction System') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Figtree', sans-serif; }
        body { background:#020617; overflow-x:hidden; }

        @keyframes dpsFloat {
            0%,100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-18px) scale(1.03); }
        }

        @keyframes dpsShadow {
            0% { box-shadow: 0 0 35px rgba(34,211,238,.18), 0 0 100px rgba(59,130,246,.12); }
            25% { box-shadow: 0 0 45px rgba(168,85,247,.20), 0 0 120px rgba(34,211,238,.10); }
            50% { box-shadow: 0 0 55px rgba(16,185,129,.18), 0 0 130px rgba(99,102,241,.15); }
            75% { box-shadow: 0 0 45px rgba(14,165,233,.18), 0 0 120px rgba(244,114,182,.12); }
            100% { box-shadow: 0 0 35px rgba(34,211,238,.18), 0 0 100px rgba(59,130,246,.12); }
        }

        @keyframes dpsGradient {
            0% { background-position:0% 50%; }
            50% { background-position:100% 50%; }
            100% { background-position:0% 50%; }
        }

        .dps-shadow { animation:dpsShadow 6s ease-in-out infinite; }
        .dps-float { animation:dpsFloat 6s ease-in-out infinite; }

        .dps-gradient-text {
            background: linear-gradient(90deg,#67e8f9,#60a5fa,#a78bfa,#34d399);
            background-size:280% 280%;
            animation:dpsGradient 8s ease infinite;
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }

        .dps-grid {
            background-image:
                linear-gradient(rgba(255,255,255,.045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.045) 1px, transparent 1px);
            background-size:44px 44px;
            mask-image:radial-gradient(circle at center, black, transparent 75%);
        }

        .dps-glass {
            background:linear-gradient(135deg,rgba(255,255,255,.12),rgba(255,255,255,.045));
            border:1px solid rgba(255,255,255,.12);
            backdrop-filter:blur(24px);
        }
    </style>
</head>

<body class="min-h-screen text-white antialiased">
    <div class="fixed inset-0 -z-50 bg-slate-950"></div>
    <div class="fixed inset-0 -z-40 opacity-60 dps-grid"></div>
    <div class="fixed -top-44 -left-44 h-[34rem] w-[34rem] rounded-full bg-cyan-500/20 blur-3xl dps-float"></div>
    <div class="fixed top-20 -right-44 h-[34rem] w-[34rem] rounded-full bg-purple-500/20 blur-3xl dps-float" style="animation-delay:1.2s;"></div>
    <div class="fixed bottom-0 left-1/3 h-[30rem] w-[30rem] rounded-full bg-emerald-500/10 blur-3xl dps-float" style="animation-delay:2.4s;"></div>

    @php
        $doctorName = auth()->user()->name ?? 'Doctor';

        $appointmentsUrl = Route::has('doctor.appointments.index')
            ? route('doctor.appointments.index')
            : url('/doctor/appointments');

        $reportsUrl = Route::has('doctor.medical-reports.index')
            ? route('doctor.medical-reports.index')
            : url('/doctor/medical-reports');

        $patientsUrl = Route::has('doctor.patients.index')
            ? route('doctor.patients.index')
            : url('/doctor/patients');

        $profileUrl = Route::has('profile.edit')
            ? route('profile.edit')
            : url('/profile');
    @endphp

    <header class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/75 backdrop-blur-2xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <div class="relative flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-400/15 ring-1 ring-cyan-300/25 dps-shadow">
                    <span class="absolute inset-0 rounded-2xl bg-cyan-300/20 blur-xl"></span>
                    <span class="relative text-2xl">🩺</span>
                </div>

                <div>
                    <h1 class="text-lg font-black leading-tight">Doctor Control Center</h1>
                    <p class="text-xs font-semibold text-cyan-200/80">Disease Prediction System</p>
                </div>
            </a>

            <nav class="hidden items-center gap-3 lg:flex">
                <a href="{{ $appointmentsUrl }}" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-black text-slate-200 transition hover:bg-white/10">
                    Appointments
                </a>
                <a href="{{ $patientsUrl }}" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-black text-slate-200 transition hover:bg-white/10">
                    Patients
                </a>
                <a href="{{ $reportsUrl }}" class="rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-black text-slate-200 transition hover:bg-white/10">
                    Medical Reports
                </a>
                <a href="{{ $profileUrl }}" class="rounded-2xl border border-cyan-300/20 bg-cyan-400/10 px-4 py-2 text-sm font-black text-cyan-100 transition hover:bg-cyan-400/20">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="rounded-2xl border border-red-300/20 bg-red-400/10 px-4 py-2 text-sm font-black text-red-100 transition hover:bg-red-400/20">
                        Logout
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-5 py-8 lg:px-8">
        <section class="relative overflow-hidden rounded-[2.5rem] dps-glass p-6 dps-shadow md:p-10">
            <div class="absolute -right-20 -top-20 h-72 w-72 rounded-full bg-cyan-400/20 blur-3xl"></div>
            <div class="absolute -left-20 -bottom-20 h-72 w-72 rounded-full bg-purple-400/20 blur-3xl"></div>

            <div class="relative grid gap-8 lg:grid-cols-[1.1fr_.9fr] lg:items-center">
                <div>
                    <div class="inline-flex items-center gap-3 rounded-full border border-cyan-300/20 bg-cyan-400/10 px-4 py-2 text-sm font-black text-cyan-100">
                        <span class="relative flex h-3 w-3">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-300 opacity-75"></span>
                            <span class="relative inline-flex h-3 w-3 rounded-full bg-cyan-300"></span>
                        </span>
                        Doctor Workspace Active
                    </div>

                    <h2 class="mt-6 text-4xl font-black leading-tight tracking-tight md:text-6xl">
                        Welcome back,
                        <span class="dps-gradient-text">{{ $doctorName }}</span>
                    </h2>

                    <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-300">
                        Review patient appointment requests, support medical consultation flow,
                        and manage doctor-side actions from one premium workspace.
                    </p>

                    <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                        <a href="{{ $appointmentsUrl }}"
                           class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-300 via-blue-400 to-purple-400 px-7 py-4 font-black text-slate-950 shadow-2xl shadow-cyan-500/25 transition hover:scale-[1.03]">
                            View Appointments →
                        </a>

                        <a href="{{ $patientsUrl }}"
                           class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/10 px-7 py-4 font-black text-white backdrop-blur-xl transition hover:bg-white/15">
                            Patient Requests
                        </a>
                    </div>
                </div>

                <div class="relative rounded-[2rem] border border-white/10 bg-slate-950/70 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.28em] text-cyan-300">Live Medical Panel</p>
                            <h3 class="mt-2 text-2xl font-black">Doctor Activity</h3>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-400/15 text-2xl ring-1 ring-cyan-300/20">
                            🧠
                        </div>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-slate-300">Appointment Review</span>
                                <span class="text-sm font-black text-cyan-200">Ready</span>
                            </div>
                            <div class="mt-3 h-2 rounded-full bg-slate-800">
                                <div class="h-2 w-[82%] rounded-full bg-gradient-to-r from-cyan-300 to-blue-400"></div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-slate-300">Patient Support</span>
                                <span class="text-sm font-black text-emerald-200">Active</span>
                            </div>
                            <div class="mt-3 h-2 rounded-full bg-slate-800">
                                <div class="h-2 w-[74%] rounded-full bg-gradient-to-r from-emerald-300 to-cyan-400"></div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-bold text-slate-300">Medical Workflow</span>
                                <span class="text-sm font-black text-purple-200">Secure</span>
                            </div>
                            <div class="mt-3 h-2 rounded-full bg-slate-800">
                                <div class="h-2 w-[68%] rounded-full bg-gradient-to-r from-purple-300 to-pink-400"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mt-8 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
            <a href="{{ $appointmentsUrl }}" class="group relative overflow-hidden rounded-[2rem] dps-glass p-6 transition hover:-translate-y-2">
                <div class="absolute -right-12 -top-12 h-36 w-36 rounded-full bg-cyan-400/20 blur-3xl transition group-hover:scale-150"></div>
                <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-400/15 text-2xl ring-1 ring-cyan-300/20">📅</div>
                <h3 class="relative mt-5 text-xl font-black">Appointments</h3>
                <p class="relative mt-2 text-sm leading-6 text-slate-400">Review and manage patient appointment requests.</p>
            </a>

            <a href="{{ $patientsUrl }}" class="group relative overflow-hidden rounded-[2rem] dps-glass p-6 transition hover:-translate-y-2">
                <div class="absolute -right-12 -top-12 h-36 w-36 rounded-full bg-emerald-400/20 blur-3xl transition group-hover:scale-150"></div>
                <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-400/15 text-2xl ring-1 ring-emerald-300/20">👥</div>
                <h3 class="relative mt-5 text-xl font-black">Patients</h3>
                <p class="relative mt-2 text-sm leading-6 text-slate-400">Access patient-related requests and support flow.</p>
            </a>
                        <a href="{{ $reportsUrl }}" class="group relative overflow-hidden rounded-[2rem] dps-glass p-6 transition hover:-translate-y-2">
                <div class="absolute -right-12 -top-12 h-36 w-36 rounded-full bg-purple-400/20 blur-3xl transition group-hover:scale-150"></div>
                <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-400/15 text-2xl ring-1 ring-purple-300/20">📄</div>
                <h3 class="relative mt-5 text-xl font-black">Medical Reports</h3>
                <p class="relative mt-2 text-sm leading-6 text-slate-400">Review report-related workflow where your routes support it.</p>
            </a>

            <a href="{{ $profileUrl }}" class="group relative overflow-hidden rounded-[2rem] dps-glass p-6 transition hover:-translate-y-2">
                <div class="absolute -right-12 -top-12 h-36 w-36 rounded-full bg-pink-400/20 blur-3xl transition group-hover:scale-150"></div>
                <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-400/15 text-2xl ring-1 ring-pink-300/20">⚙️</div>
                <h3 class="relative mt-5 text-xl font-black">Profile</h3>
                <p class="relative mt-2 text-sm leading-6 text-slate-400">Update your account information and doctor profile details.</p>
            </a>
        </section>

        <section class="mt-8 grid gap-6 lg:grid-cols-[1.15fr_.85fr]">
            <div class="relative overflow-hidden rounded-[2.4rem] dps-glass p-6 dps-shadow">
                <div class="absolute -right-20 -top-20 h-60 w-60 rounded-full bg-cyan-400/20 blur-3xl"></div>

                <div class="relative flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.28em] text-cyan-300">Doctor Actions</p>
                        <h3 class="mt-2 text-3xl font-black">Quick Medical Workflow</h3>
                    </div>
                    <span class="w-fit rounded-full border border-emerald-300/20 bg-emerald-400/10 px-4 py-2 text-xs font-black text-emerald-200">
                        Secure Access
                    </span>
                </div>

                <div class="relative mt-6 grid gap-4 md:grid-cols-2">
                    <a href="{{ $appointmentsUrl }}" class="rounded-3xl border border-white/10 bg-slate-950/65 p-5 transition hover:bg-slate-900/80">
                        <div class="flex items-start gap-4">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-cyan-400/15 text-xl">📅</span>
                            <div>
                                <h4 class="font-black text-white">Review Appointment Requests</h4>
                                <p class="mt-1 text-sm leading-6 text-slate-400">
                                    Check requested appointments and continue your approval/review process.
                                </p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ $patientsUrl }}" class="rounded-3xl border border-white/10 bg-slate-950/65 p-5 transition hover:bg-slate-900/80">
                        <div class="flex items-start gap-4">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-400/15 text-xl">👥</span>
                            <div>
                                <h4 class="font-black text-white">Patient Support</h4>
                                <p class="mt-1 text-sm leading-6 text-slate-400">
                                    Continue patient-related support through your existing project routes.
                                </p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ $reportsUrl }}" class="rounded-3xl border border-white/10 bg-slate-950/65 p-5 transition hover:bg-slate-900/80">
                        <div class="flex items-start gap-4">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-purple-400/15 text-xl">📄</span>
                            <div>
                                <h4 class="font-black text-white">Medical Report Flow</h4>
                                <p class="mt-1 text-sm leading-6 text-slate-400">
                                    Open report-related area only if that route exists in your application.
                                </p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ $profileUrl }}" class="rounded-3xl border border-white/10 bg-slate-950/65 p-5 transition hover:bg-slate-900/80">
                        <div class="flex items-start gap-4">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-pink-400/15 text-xl">⚙️</span>
                            <div>
                                <h4 class="font-black text-white">Profile Settings</h4>
                                <p class="mt-1 text-sm leading-6 text-slate-400">
                                    Manage your profile and account information from the profile page.
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-[2.4rem] dps-glass p-6 dps-shadow">
                <div class="absolute -left-16 -bottom-16 h-56 w-56 rounded-full bg-purple-400/20 blur-3xl"></div>

                <div class="relative">
                    <p class="text-sm font-black uppercase tracking-[0.28em] text-purple-300">Account Status</p>
                    <h3 class="mt-2 text-3xl font-black">Doctor Access Ready</h3>
                    <p class="mt-4 text-sm leading-7 text-slate-400">
                        You are signed in as a doctor. This page keeps the interface clean and avoids blank white screen issues.
                        Menu links use existing route names when available and fallback URLs when needed.
                    </p>

                    <div class="mt-6 space-y-4">
                        <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="font-black text-white">Authenticated User</p>
                                    <p class="mt-1 text-sm text-slate-400">{{ auth()->user()->email ?? 'Signed in account' }}</p>
                                </div>
                                <span class="rounded-full border border-cyan-300/20 bg-cyan-400/10 px-3 py-1 text-xs font-black text-cyan-200">
                                    Active
                                </span>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-white/10 bg-slate-950/70 p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="font-black text-white">Role</p>
                                    <p class="mt-1 text-sm text-slate-400">Doctor</p>
                                </div>
                                <span class="rounded-full border border-emerald-300/20 bg-emerald-400/10 px-3 py-1 text-xs font-black text-emerald-200">
                                    Verified Access
                                </span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full rounded-2xl border border-red-300/20 bg-red-400/10 px-5 py-4 text-sm font-black text-red-100 transition hover:bg-red-400/20">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <nav class="mt-8 grid gap-4 lg:hidden">
            <a href="{{ $appointmentsUrl }}" class="rounded-2xl border border-white/10 bg-white/10 px-5 py-4 font-black text-slate-100 backdrop-blur-xl">
                Appointments
            </a>
            <a href="{{ $patientsUrl }}" class="rounded-2xl border border-white/10 bg-white/10 px-5 py-4 font-black text-slate-100 backdrop-blur-xl">
                Patients
            </a>
            <a href="{{ $reportsUrl }}" class="rounded-2xl border border-white/10 bg-white/10 px-5 py-4 font-black text-slate-100 backdrop-blur-xl">
                Medical Reports
            </a>
            <a href="{{ $profileUrl }}" class="rounded-2xl border border-white/10 bg-white/10 px-5 py-4 font-black text-slate-100 backdrop-blur-xl">
                Profile
            </a>
        </nav>
    </main>
</body>
</html>