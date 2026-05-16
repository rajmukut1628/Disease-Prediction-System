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

        .dps-input {
            width: 100%;
            border-radius: 1.25rem;
            border: 1px solid rgba(148,163,184,.28);
            background: rgba(15,23,42,.75);
            color: white;
            padding: 14px 16px;
            outline: none;
            transition: .25s;
        }

        .dps-input:focus {
            border-color: rgba(34,211,238,.85);
            box-shadow: 0 0 0 4px rgba(34,211,238,.14);
        }

        .dps-label {
            color: rgba(226,232,240,.95);
            font-weight: 900;
            font-size: 13px;
            letter-spacing: .04em;
        }

        .dps-float {
            animation: dpsFloat 6s ease-in-out infinite;
        }
    </style>

    <div class="dps-page px-5 py-8">
        <div class="max-w-7xl mx-auto">

            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-300/20 bg-emerald-400/10 px-5 py-4 text-emerald-100 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-3xl border border-rose-300/20 bg-rose-400/10 px-5 py-4 text-rose-100 font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="dps-card rounded-[2rem] p-7 md:p-9 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 mb-5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-sm font-black text-cyan-100">AI Health Insight</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            Disease Progress
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                                Tracking
                            </span>
                        </h1>

                        <p class="mt-4 text-slate-300 max-w-2xl">
                            AI will compare your previous health records, symptoms, risk predictions,
                            and medical reports to detect improvement, stable condition, worsening, or critical trend.
                        </p>
                    </div>

                    <div class="dps-float w-28 h-28 rounded-[2rem] bg-gradient-to-br from-cyan-400 via-blue-600 to-violet-700 flex items-center justify-center text-5xl shadow-2xl">
                        🧠
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">

                    <div class="dps-card rounded-[2rem] p-6 md:p-8">
                        <h2 class="text-2xl font-black text-white">Generate New AI Health Insight</h2>
                        <p class="mt-2 text-sm text-slate-400">
                            Select a profile. AI will analyze saved health history and generate a trend summary.
                        </p>

                        <form method="POST" action="{{ route('user.health-insights.generate') }}" class="mt-6 space-y-5">
                            @csrf

                            <div>
                                <label class="dps-label" for="family_member_id">PROFILE</label>
                                <select id="family_member_id" name="family_member_id" class="dps-input mt-2">
                                    <option class="text-slate-900" value="">My Own Profile</option>

                                    @foreach($familyMembers as $member)
                                        <option class="text-slate-900" value="{{ $member->id }}">
                                            {{ $member->name }} — {{ $member->relation ?? 'Family Member' }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('family_member_id')" class="mt-2" />
                            </div>

                            <div class="rounded-3xl bg-amber-400/10 border border-amber-300/20 p-5">
                                <p class="text-amber-100 font-black">Before Generating</p>
                                <p class="mt-2 text-sm text-amber-100/80">
                                    Better insight needs enough saved data. Add health records, symptom checks,
                                    risk predictions, or medical reports first for stronger AI analysis.
                                </p>
                            </div>

                            <button type="submit"
                                class="w-full rounded-2xl py-4 text-white font-black bg-gradient-to-r from-cyan-500 via-blue-600 to-violet-600 shadow-2xl hover:scale-[1.01] transition">
                                Generate AI Health Insight
                            </button>
                        </form>
                    </div>

                    <div class="dps-card rounded-[2rem] p-6 md:p-8">
                        <h2 class="text-2xl font-black text-white">Generated Health Insights</h2>
                        <p class="mt-2 text-sm text-slate-400">
                            Your previous AI health trend analysis history.
                        </p>

                        <div class="mt-6 space-y-5">
                            @forelse($insights as $insight)
                                @php
                                    $trendClasses = [
                                        'improving' => 'bg-emerald-400/10 border-emerald-300/20 text-emerald-200',
                                        'stable' => 'bg-cyan-400/10 border-cyan-300/20 text-cyan-200',
                                        'worsening' => 'bg-orange-400/10 border-orange-300/20 text-orange-200',
                                        'critical' => 'bg-rose-500/10 border-rose-300/20 text-rose-200',
                                        'unknown' => 'bg-slate-400/10 border-slate-300/20 text-slate-200',
                                    ];
                                @endphp

                                <div class="dps-soft rounded-3xl p-5">
                                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                        <div>
                                            <p class="text-sm text-slate-400 font-bold">
                                                {{ $insight->familyMember?->name ?? 'My Own Profile' }}
                                            </p>

                                            <h3 class="mt-2 text-2xl font-black text-white">
                                                {{ $insight->title ?? 'AI Health Insight' }}
                                            </h3>

                                            <p class="mt-1 text-xs text-slate-500">
                                                Generated {{ $insight->created_at->diffForHumans() }}
                                            </p>
                                        </div>

                                        <div class="flex flex-wrap gap-2">
                                            <span class="px-4 py-2 rounded-full border font-black text-sm capitalize
                                                {{ $trendClasses[$insight->trend_status] ?? $trendClasses['unknown'] }}">
                                                {{ $insight->trend_status }}
                                            </span>

                                            <span class="px-4 py-2 rounded-full bg-cyan-400/10 border border-cyan-300/20 text-cyan-200 font-black text-sm">
                                                {{ $insight->confidence_score }}% Confidence
                                            </span>
                                        </div>
                                    </div>
                                                                        <div class="mt-5 dps-soft rounded-3xl p-5">
                                        <h4 class="text-white font-black">Health Summary</h4>
                                        <p class="mt-2 text-sm text-slate-300 leading-6 whitespace-pre-line">
                                            {{ $insight->health_summary ?? 'No summary available.' }}
                                        </p>
                                    </div>

                                    @if($insight->risk_warning)
                                        <div class="mt-5 rounded-3xl bg-rose-500/10 border border-rose-300/20 p-5">
                                            <h4 class="text-rose-100 font-black">Risk Warning</h4>
                                            <p class="mt-2 text-sm text-rose-100/80 leading-6 whitespace-pre-line">
                                                {{ $insight->risk_warning }}
                                            </p>
                                        </div>
                                    @endif

                                    <div class="mt-5 dps-soft rounded-3xl p-5">
                                        <h4 class="text-emerald-200 font-black">Next Action Plan</h4>
                                        <p class="mt-2 text-sm text-slate-300 leading-6 whitespace-pre-line">
                                            {{ $insight->next_action_plan ?? 'Please consult a certified doctor if symptoms continue.' }}
                                        </p>
                                    </div>

                                    @if(!empty($insight->key_changes))
                                        <div class="mt-5 dps-soft rounded-3xl p-5">
                                            <h4 class="text-cyan-200 font-black">Key Changes Detected</h4>

                                            <ul class="mt-3 space-y-2">
                                                @foreach($insight->key_changes as $change)
                                                    <li class="text-sm text-slate-300">
                                                        ✅ {{ $change }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="dps-soft rounded-3xl p-10 text-center">
                                    <div class="mx-auto w-20 h-20 rounded-3xl bg-cyan-400/10 border border-cyan-300/20 flex items-center justify-center text-4xl">
                                        🧠
                                    </div>

                                    <h3 class="mt-5 text-2xl font-black text-white">No Health Insight Yet</h3>
                                    <p class="mt-2 text-slate-400">
                                        Add health records, symptom checks, risk predictions, or reports first, then generate your first AI insight.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-6">
                            {{ $insights->links() }}
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-2xl font-black text-white">Insight Engine</h3>
                        <p class="mt-2 text-sm text-slate-400">
                            This module uses AI to compare saved health history.
                        </p>

                        <div class="mt-5 space-y-3">
                            <div class="dps-soft rounded-3xl p-5">
                                <p class="text-slate-400 text-sm font-bold">AI Provider</p>
                                <p class="mt-2 text-3xl font-black text-cyan-300">Gemini</p>
                            </div>

                            <div class="dps-soft rounded-3xl p-5">
                                <p class="text-slate-400 text-sm font-bold">Total Insights</p>
                                <p class="mt-2 text-4xl font-black text-white">{{ $insights->total() }}</p>
                            </div>

                            <div class="dps-soft rounded-3xl p-5">
                                <p class="text-slate-400 text-sm font-bold">Trend Detection</p>
                                <p class="mt-2 text-2xl font-black text-emerald-300">Active</p>
                            </div>
                        </div>
                    </div>

                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-xl font-black text-white">Data Sources</h3>

                        <div class="mt-5 space-y-3">
                            @foreach([
                                'Health Records',
                                'Symptom Checks',
                                'Risk Predictions',
                                'Medical Reports',
                                'Family Profile History',
                            ] as $source)
                                <div class="dps-soft rounded-2xl px-4 py-3 text-sm text-slate-200 font-bold">
                                    ✅ {{ $source }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-xl font-black text-white">Medical Disclaimer</h3>
                        <p class="mt-3 text-sm text-rose-100/80 leading-6">
                            AI health insight is informational guidance only. It cannot replace medical diagnosis,
                            treatment, lab interpretation, or emergency care by a certified doctor.
                        </p>

                        <a href="{{ route('user.health-records.create') }}"
                           class="mt-5 inline-flex w-full justify-center rounded-2xl py-3 bg-cyan-500/15 border border-cyan-300/20 text-cyan-100 font-black">
                            Add More Health Data
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>