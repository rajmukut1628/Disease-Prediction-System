<x-app-layout>
    <style>
        @keyframes dpsLiveShadow {
            0%,100% {
                box-shadow: 0 25px 80px rgba(34,211,238,.18),
                            0 0 55px rgba(99,102,241,.22);
            }
            50% {
                box-shadow: 0 35px 110px rgba(16,185,129,.22),
                            0 0 90px rgba(168,85,247,.30);
            }
        }

        @keyframes dpsFloat {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .dps-user-page {
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

        .dps-soft-card {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.10);
        }

        .dps-float {
            animation: dpsFloat 6s ease-in-out infinite;
        }
    </style>

    <div class="dps-user-page px-5 py-8">
        <div class="max-w-7xl mx-auto">

            <div class="dps-card rounded-[2rem] p-7 md:p-9 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 mb-5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-sm font-black text-cyan-100">AI Health Intelligence</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            Welcome,
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                                {{ auth()->user()->name }}
                            </span>
                        </h1>

                        <p class="mt-4 text-slate-300 max-w-2xl">
                            Track your symptoms, health records, disease risks, medical reports and AI health guidance from one premium dashboard.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('user.symptom-checker.create') }}"
                               class="px-5 py-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-black shadow-xl hover:scale-[1.02] transition">
                                Start AI Symptom Check
                            </a>
                            <a href="{{ route('user.medical-reports.index') }}"
   class="px-5 py-3 rounded-2xl bg-white/10 border border-white/10 text-white font-black hover:bg-white/15 transition">
    Medical Reports
</a>
                               <a   href="{{ route('user.risk-prediction.create') }}"
                                    class="px-5 py-3 rounded-2xl bg-white/10 border border-white/10 text-white font-black hover:bg-white/15 transition">
                                    Disease Risk Prediction
                               </a>

                            <a href="{{ Route::has('user.medical-reports.create') ? route('user.medical-reports.create') : url('/user/medical-reports/create') }}"
                               class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/10 px-6 py-3 text-sm font-black text-white transition-all duration-300 hover:scale-105 hover:bg-white/15">
                               Upload Medical Report
                             </a>
                        </div>
                    </div>

                    <div class="dps-float w-28 h-28 rounded-[2rem] bg-gradient-to-br from-cyan-400 via-blue-600 to-violet-700 flex items-center justify-center text-5xl shadow-2xl">
                        🧬
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-4 gap-5 mb-8">
                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Symptom Checks</p>
                    <h2 class="mt-2 text-4xl font-black text-white">{{ $totalSymptomChecks }}</h2>
                    <p class="mt-2 text-cyan-300 text-sm font-bold">AI powered</p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Medical Reports</p>
                    <h2 class="mt-2 text-4xl font-black text-white">{{ $totalReports }}</h2>
                    <p class="mt-2 text-emerald-300 text-sm font-bold">Secure vault</p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Latest Severity</p>
                    <h2 class="mt-2 text-2xl font-black text-white capitalize">
                        {{ $latestSymptomCheck?->severity ?? 'No Data' }}
                    </h2>
                    <p class="mt-2 text-amber-300 text-sm font-bold">Health alert</p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">BMI</p>
                    <h2 class="mt-2 text-4xl font-black text-white">
                        {{ $latestHealthRecord?->bmi ?? '--' }}
                    </h2>
                    <p class="mt-2 text-violet-300 text-sm font-bold">Body index</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-5">
                <div class="lg:col-span-2 dps-card rounded-[2rem] p-6">
                    <div class="flex items-center justify-between gap-4 mb-5">
                        <div>
                            <h3 class="text-2xl font-black text-white">Recent AI Symptom Checks</h3>
                            <p class="text-sm text-slate-400 mt-1">Your latest disease prediction history</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @forelse($recentSymptomChecks as $check)
                            <div class="dps-soft-card rounded-3xl p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div>
                                    <p class="text-white font-black">{{ $check->probable_disease ?? 'AI Analysis' }}</p>
                                    <p class="mt-1 text-sm text-slate-400 line-clamp-1">{{ $check->symptoms }}</p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 rounded-full bg-cyan-400/10 border border-cyan-300/20 text-cyan-200 text-sm font-black">
                                        {{ $check->confidence_score }}%
                                    </span>
                                    <span class="px-3 py-1 rounded-full bg-amber-400/10 border border-amber-300/20 text-amber-200 text-sm font-black capitalize">
                                        {{ $check->severity }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="dps-soft-card rounded-3xl p-8 text-center">
                                <div class="text-5xl">🩺</div>
                                <h3 class="mt-4 text-xl font-black text-white">No symptom check yet</h3>
                                <p class="mt-2 text-slate-400">Start your first AI symptom check now.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <h3 class="text-2xl font-black text-white">Health Risk Snapshot</h3>
                    <p class="text-sm text-slate-400 mt-1">Latest risk prediction summary</p>

                    <div class="mt-6 space-y-4">
                        @php
                            $riskItems = [
                                'Diabetes' => $latestRiskPrediction?->diabetes_risk ?? 0,
                                'Heart Disease' => $latestRiskPrediction?->heart_disease_risk ?? 0,
                                'Kidney Disease' => $latestRiskPrediction?->kidney_disease_risk ?? 0,
                                'Stroke' => $latestRiskPrediction?->stroke_risk ?? 0,
                            ];
                        @endphp

                        @foreach($riskItems as $label => $value)
                            <div>
                                <div class="flex justify-between text-sm font-bold mb-2">
                                    <span class="text-slate-300">{{ $label }}</span>
                                    <span class="text-cyan-300">{{ $value }}%</span>
                                </div>
                                <div class="h-3 rounded-full bg-white/10 overflow-hidden">
                                    <div class="h-full rounded-full bg-gradient-to-r from-cyan-400 to-violet-500"
                                         style="width: {{ min(100, max(0, $value)) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 rounded-3xl bg-rose-500/10 border border-rose-300/20 p-5">
                        <p class="text-rose-100 font-black">Medical Disclaimer</p>
                        <p class="mt-2 text-sm text-rose-100/80">
                            AI prediction is guidance only. Consult a certified doctor for final diagnosis.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>