<x-app-layout>
    <style>
        @keyframes dpsLiveShadow {
            0%,100% {
                box-shadow: 0 25px 80px rgba(34,211,238,.18),
                            0 0 50px rgba(99,102,241,.22);
            }
            50% {
                box-shadow: 0 35px 110px rgba(16,185,129,.22),
                            0 0 80px rgba(168,85,247,.30);
            }
        }

        @keyframes dpsFloat {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .dps-admin-page {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(34,211,238,.18), transparent 28%),
                radial-gradient(circle at top right, rgba(168,85,247,.18), transparent 30%),
                radial-gradient(circle at bottom left, rgba(16,185,129,.16), transparent 30%),
                linear-gradient(135deg, #020617, #0f172a 55%, #020617);
        }

        .dps-card {
            background: rgba(15,23,42,.78);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.12);
            animation: dpsLiveShadow 5s ease-in-out infinite;
        }

        .dps-float {
            animation: dpsFloat 6s ease-in-out infinite;
        }
    </style>

    <div class="dps-admin-page px-5 py-8">
        <div class="max-w-7xl mx-auto">

            <div class="dps-card rounded-[2rem] p-7 md:p-9 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 mb-5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-sm font-black text-cyan-100">Admin Control Center</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            Disease Prediction
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                                Admin Dashboard
                            </span>
                        </h1>

                        <p class="mt-4 text-slate-300 max-w-2xl">
                            Manage doctors, monitor user activity, review health system modules,
                            and control AI healthcare operations from one premium dashboard.
                        </p>
                    </div>

                    <div class="dps-float w-28 h-28 rounded-[2rem] bg-gradient-to-br from-cyan-400 via-blue-600 to-violet-700 flex items-center justify-center text-5xl shadow-2xl">
                        🏥
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-5 mb-8">
                <a href="{{ route('admin.doctors.pending') }}"
                   class="dps-card rounded-[2rem] p-6 hover:scale-[1.02] transition block">
                    <div class="w-14 h-14 rounded-2xl bg-amber-400/15 border border-amber-300/20 flex items-center justify-center text-3xl">
                        🩺
                    </div>
                    <p class="mt-5 text-slate-400 text-sm font-bold">Doctor Verification</p>
                    <h2 class="mt-2 text-2xl font-black text-white">Pending Approvals</h2>
                    <p class="mt-3 text-sm text-slate-300">
                        Review newly registered doctors and approve or reject accounts.
                    </p>
                    <span class="mt-5 inline-flex px-4 py-2 rounded-2xl bg-amber-400/10 border border-amber-300/20 text-amber-200 font-black text-sm">
                        Open Requests →
                    </span>
                </a>

                <div class="dps-card rounded-[2rem] p-6">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-400/15 border border-cyan-300/20 flex items-center justify-center text-3xl">
                        👥
                    </div>
                    <p class="mt-5 text-slate-400 text-sm font-bold">Users</p>
                    <h2 class="mt-2 text-2xl font-black text-white">Patient Management</h2>
                    <p class="mt-3 text-sm text-slate-300">
                        Manage patient users, account status and medical access control.
                    </p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <div class="w-14 h-14 rounded-2xl bg-violet-400/15 border border-violet-300/20 flex items-center justify-center text-3xl">
                        🤖
                    </div>
                    <p class="mt-5 text-slate-400 text-sm font-bold">AI System</p>
                    <h2 class="mt-2 text-2xl font-black text-white">Prediction Monitor</h2>
                    <p class="mt-3 text-sm text-slate-300">
                        Track AI symptom checker, risk score and report analysis activity.
                    </p>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-5">
                <div class="dps-card rounded-[2rem] p-6">
                    <h3 class="text-xl font-black text-white">Premium Health Modules</h3>

                    <div class="mt-5 space-y-3">
                        @foreach([
                            'AI Symptom Checker',
                            'Risk Score Prediction',
                            'Smart Report Analysis',
                            'Emergency Alert System',
                            'Doctor Recommendation',
                            'Secure Medical Vault'
                        ] as $module)
                            <div class="flex items-center justify-between rounded-2xl bg-white/5 border border-white/10 px-4 py-3">
                                <span class="text-slate-200 font-bold">{{ $module }}</span>
                                <span class="text-emerald-300 font-black text-sm">Ready</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <h3 class="text-xl font-black text-white">Admin Quick Actions</h3>

                    <div class="mt-5 grid sm:grid-cols-2 gap-3">
                        <a href="{{ route('admin.doctors.pending') }}"
                           class="rounded-2xl bg-cyan-500/15 border border-cyan-300/20 p-4 text-cyan-100 font-black hover:bg-cyan-500/25 transition">
                            Doctor Approvals
                        </a>

                        <div class="rounded-2xl bg-emerald-500/15 border border-emerald-300/20 p-4 text-emerald-100 font-black">
                            User Management
                        </div>

                        <div class="rounded-2xl bg-violet-500/15 border border-violet-300/20 p-4 text-violet-100 font-black">
                            AI Settings
                        </div>

                        <div class="rounded-2xl bg-amber-500/15 border border-amber-300/20 p-4 text-amber-100 font-black">
                            Subscription Plans
                        </div>
                    </div>

                    <div class="mt-6 rounded-3xl bg-rose-500/10 border border-rose-300/20 p-5">
                        <p class="text-rose-100 font-black">Medical Disclaimer</p>
                        <p class="mt-2 text-sm text-rose-100/80">
                            AI predictions are guidance only. Final medical decisions must be made by certified doctors.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>