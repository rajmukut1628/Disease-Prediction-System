<x-app-layout>
    <style>
        @keyframes dpsLiveShadow {
            0%,100% { box-shadow: 0 25px 80px rgba(34,211,238,.18), 0 0 55px rgba(99,102,241,.22); }
            50% { box-shadow: 0 35px 115px rgba(16,185,129,.24), 0 0 90px rgba(168,85,247,.32); }
        }

        .dps-page {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(34,211,238,.18), transparent 28%),
                radial-gradient(circle at top right, rgba(168,85,247,.18), transparent 30%),
                linear-gradient(135deg, #020617, #0f172a 55%, #020617);
        }

        .dps-card {
            background: rgba(15,23,42,.78);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.12);
            animation: dpsLiveShadow 5s ease-in-out infinite;
        }

        .dps-soft {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.10);
        }
    </style>

    <div class="dps-page px-5 py-8">
        <div class="max-w-7xl mx-auto">

            <div class="dps-card rounded-[2rem] p-7 md:p-9 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <a href="{{ route('user.family-members.index') }}"
                           class="inline-flex mb-5 px-4 py-2 rounded-2xl bg-white/10 border border-white/10 text-cyan-200 font-black text-sm">
                            ← Back to Family Members
                        </a>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            {{ $familyMember->name }}
                        </h1>

                        <p class="mt-3 text-slate-300">
                            {{ $familyMember->relation ?? 'Family Member' }} health profile and AI analysis history.
                        </p>
                    </div>

                    <div class="w-28 h-28 rounded-[2rem] bg-gradient-to-br from-cyan-400 via-blue-600 to-violet-700 flex items-center justify-center text-white text-5xl font-black shadow-2xl">
                        {{ strtoupper(substr($familyMember->name, 0, 1)) }}
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-4 gap-5 mb-8">
                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Age</p>
                    <p class="mt-2 text-3xl font-black text-white">{{ $familyMember->age ?? '--' }}</p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Gender</p>
                    <p class="mt-2 text-3xl font-black text-white capitalize">{{ $familyMember->gender ?? '--' }}</p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Blood Group</p>
                    <p class="mt-2 text-3xl font-black text-white">{{ $familyMember->blood_group ?? '--' }}</p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">BMI Data</p>
                    <p class="mt-2 text-xl font-black text-white">
                        {{ $familyMember->height_cm ?? '--' }} cm / {{ $familyMember->weight_kg ?? '--' }} kg
                    </p>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <div class="dps-card rounded-[2rem] p-6">
                    <h2 class="text-xl font-black text-white">Medical Conditions</h2>
                    <p class="mt-3 text-sm text-slate-300 whitespace-pre-line">
                        {{ $familyMember->medical_conditions ?: 'No medical conditions added.' }}
                    </p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <h2 class="text-xl font-black text-white">Allergies</h2>
                    <p class="mt-3 text-sm text-slate-300 whitespace-pre-line">
                        {{ $familyMember->allergies ?: 'No allergies added.' }}
                    </p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <h2 class="text-xl font-black text-white">Quick Actions</h2>

                    <div class="mt-4 space-y-3">
                        <a href="{{ route('user.symptom-checker.create') }}"
                           class="block rounded-2xl bg-cyan-500/15 border border-cyan-300/20 px-4 py-3 text-cyan-100 font-black">
                            AI Symptom Check
                        </a>

                        <a href="{{ route('user.risk-prediction.create') }}"
                           class="block rounded-2xl bg-violet-500/15 border border-violet-300/20 px-4 py-3 text-violet-100 font-black">
                            Risk Prediction
                        </a>

                        <a href="{{ route('user.medical-reports.create') }}"
                           class="block rounded-2xl bg-emerald-500/15 border border-emerald-300/20 px-4 py-3 text-emerald-100 font-black">
                            Analyze Medical Report
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid lg:grid-cols-3 gap-6">
                <div class="dps-card rounded-[2rem] p-6">
                    <h2 class="text-xl font-black text-white">Recent Symptom Checks</h2>

                    <div class="mt-4 space-y-3">
                        @forelse($familyMember->symptomChecks as $check)
                            <div class="dps-soft rounded-2xl p-4">
                                <p class="text-white font-black">{{ $check->probable_disease ?? 'AI Analysis' }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $check->created_at->diffForHumans() }}</p>
                                <p class="mt-2 text-sm text-cyan-300 font-black">{{ $check->confidence_score }}% Confidence</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">No symptom checks yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <h2 class="text-xl font-black text-white">Recent Risk Predictions</h2>

                    <div class="mt-4 space-y-3">
                        @forelse($familyMember->riskPredictions as $prediction)
                            <div class="dps-soft rounded-2xl p-4">
                                <p class="text-white font-black capitalize">
                                    Overall: {{ $prediction->overall_risk_level }}
                                </p>
                                <p class="mt-1 text-xs text-slate-400">{{ $prediction->created_at->diffForHumans() }}</p>
                                <p class="mt-2 text-sm text-cyan-300 font-black">
                                    Diabetes {{ $prediction->diabetes_risk }}% · Heart {{ $prediction->heart_disease_risk }}%
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">No risk predictions yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <h2 class="text-xl font-black text-white">Recent Reports</h2>

                    <div class="mt-4 space-y-3">
                        @forelse($familyMember->medicalReports as $report)
                            <div class="dps-soft rounded-2xl p-4">
                                <p class="text-white font-black">{{ $report->title }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $report->created_at->diffForHumans() }}</p>
                                <p class="mt-2 text-sm text-cyan-300 font-black">
                                    {{ $report->ai_confidence_score }}% AI Confidence
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-400">No reports yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>