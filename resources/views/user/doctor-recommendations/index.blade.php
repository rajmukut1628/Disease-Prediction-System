<x-app-layout>
    <style>
        @keyframes dpsLiveShadow {
            0%,100% {
                box-shadow: 0 25px 80px rgba(34,211,238,.18),
                            0 0 55px rgba(99,102,241,.22);
            }
            50% {
                box-shadow: 0 35px 115px rgba(16,185,129,.24),
                            0 0 90px rgba(168,85,247,.32);
            }
        }

        @keyframes dpsFloat {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .dps-page {
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

        .dps-soft {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.10);
        }

        .dps-float {
            animation: dpsFloat 6s ease-in-out infinite;
        }
    </style>

    <div class="dps-page px-5 py-8">
        <div class="max-w-7xl mx-auto">

            <div class="dps-card rounded-[2rem] p-7 md:p-9 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 mb-5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-sm font-black text-cyan-100">AI Doctor Recommendation</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            Recommended
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                                Doctors
                            </span>
                        </h1>

                        <p class="mt-4 text-slate-300 max-w-2xl">
                            AI symptom analysis থেকে recommended specialist অনুযায়ী approved doctors দেখানো হবে।
                        </p>
                    </div>

                    <div class="dps-float w-28 h-28 rounded-[2rem] bg-gradient-to-br from-cyan-400 via-blue-600 to-violet-700 flex items-center justify-center text-5xl shadow-2xl">
                        🩺
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 space-y-6">
                    <div class="dps-card rounded-[2rem] p-6">
                        <h2 class="text-2xl font-black text-white">AI Symptom Results</h2>
                        <p class="mt-2 text-sm text-slate-400">
                            যেকোনো symptom analysis select করলে matching specialist doctor দেখাবে।
                        </p>

                        <div class="mt-5 space-y-3">
                            @forelse($latestChecks as $check)
                                <a href="{{ route('user.doctor-recommendations.symptom', $check) }}"
                                   class="block dps-soft rounded-3xl p-4 hover:bg-white/10 transition">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-white font-black">
                                                {{ $check->probable_disease ?? 'AI Analysis' }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-400">
                                                {{ $check->created_at->diffForHumans() }}
                                            </p>
                                        </div>

                                        <span class="px-3 py-1 rounded-full bg-cyan-400/10 border border-cyan-300/20 text-cyan-200 text-xs font-black">
                                            {{ $check->confidence_score }}%
                                        </span>
                                    </div>

                                    <p class="mt-3 text-xs text-slate-400 line-clamp-2">
                                        {{ $check->symptoms }}
                                    </p>
                                </a>
                            @empty
                                <div class="dps-soft rounded-3xl p-6 text-center">
                                    <div class="text-4xl">🤖</div>
                                    <p class="mt-3 text-white font-black">No Symptom Check Yet</p>
                                    <p class="mt-1 text-sm text-slate-400">
                                        First run AI symptom checker.
                                    </p>

                                    <a href="{{ route('user.symptom-checker.create') }}"
                                       class="mt-4 inline-flex px-4 py-2 rounded-2xl bg-cyan-500/15 border border-cyan-300/20 text-cyan-100 font-black text-sm">
                                        Start Symptom Check
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @isset($recommendedSpecialist)
                        <div class="dps-card rounded-[2rem] p-6">
                            <h3 class="text-xl font-black text-white">Recommended Specialist</h3>
                            <p class="mt-3 text-3xl font-black text-cyan-300">
                                {{ $recommendedSpecialist }}
                            </p>

                            @isset($selectedCheck)
                                <p class="mt-3 text-sm text-slate-400">
                                    Based on: {{ $selectedCheck->probable_disease ?? 'AI symptom analysis' }}
                                </p>
                            @endisset
                        </div>
                    @endisset
                </div>
                                <div class="lg:col-span-2">
                    <div class="grid md:grid-cols-2 gap-6">
                        @forelse($doctors as $doctor)
                            <div class="dps-card rounded-[2rem] p-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-cyan-400 to-violet-600 flex items-center justify-center text-white text-2xl font-black">
                                        {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                    </div>

                                    <div class="flex-1">
                                        <h2 class="text-xl font-black text-white">
                                            Dr. {{ $doctor->name }}
                                        </h2>

                                        <p class="mt-1 text-cyan-300 font-bold">
                                            {{ $doctor->specialist }}
                                        </p>

                                        <p class="mt-2 text-sm text-slate-400">
                                            {{ $doctor->degree ?? 'Medical Professional' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-5 grid grid-cols-2 gap-3">
                                    <div class="dps-soft rounded-2xl p-4">
                                        <p class="text-xs text-slate-400 font-bold">Experience</p>
                                        <p class="mt-1 text-white font-black">
                                            {{ $doctor->experience ?? 0 }} years
                                        </p>
                                    </div>

                                    <div class="dps-soft rounded-2xl p-4">
                                        <p class="text-xs text-slate-400 font-bold">Fee</p>
                                        <p class="mt-1 text-white font-black">
                                            ৳{{ number_format($doctor->consultation_fee ?? 0) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-5 dps-soft rounded-3xl p-5">
                                    <p class="text-xs text-slate-400 font-bold">Chamber</p>
                                    <p class="mt-2 text-sm text-slate-300 leading-6">
                                        {{ $doctor->chamber_address ?? 'Chamber information not available.' }}
                                    </p>
                                </div>

                                <div class="mt-5 flex flex-wrap gap-3">
                                    <span class="px-4 py-2 rounded-2xl bg-emerald-400/10 border border-emerald-300/20 text-emerald-200 font-black text-sm">
                                        Approved Doctor
                                    </span>

                                    <span class="px-4 py-2 rounded-2xl bg-cyan-400/10 border border-cyan-300/20 text-cyan-200 font-black text-sm">
                                        AI Matched
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="md:col-span-2 dps-card rounded-[2rem] p-12 text-center">
                                <div class="mx-auto w-20 h-20 rounded-3xl bg-cyan-400/10 border border-cyan-300/20 flex items-center justify-center text-4xl">
                                    🩺
                                </div>

                                <h2 class="mt-5 text-2xl font-black text-white">
                                    No Matching Doctors Found
                                </h2>

                                <p class="mt-2 text-slate-400">
                                    No approved doctor found for this specialist yet.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $doctors->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>