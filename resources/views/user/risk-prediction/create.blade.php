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

        @keyframes dpsGradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
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

        .dps-border {
            padding: 1px;
            border-radius: 2rem;
            background: linear-gradient(120deg, #22d3ee, #6366f1, #a855f7, #10b981, #22d3ee);
            background-size: 300% 300%;
            animation: dpsGradientMove 8s ease infinite;
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
                            <span class="text-sm font-black text-cyan-100">AI Risk Prediction</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            Disease Risk
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                                Score Prediction
                            </span>
                        </h1>

                        <p class="mt-4 text-slate-300 max-w-2xl">
                            Enter health data and AI will estimate diabetes, heart disease,
                            kidney disease and stroke risk percentages with personalized guidance.
                        </p>
                    </div>

                    <div class="dps-float w-28 h-28 rounded-[2rem] bg-gradient-to-br from-cyan-400 via-blue-600 to-violet-700 flex items-center justify-center text-5xl shadow-2xl">
                        📊
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="dps-border">
                        <div class="dps-card rounded-[calc(2rem-1px)] p-6 md:p-8">
                            <h2 class="text-2xl font-black text-white">Start New Risk Prediction</h2>
                            <p class="mt-2 text-sm text-slate-400">
                                This risk score is generated by AI.
                            </p>

                            <form method="POST" action="{{ route('user.risk-prediction.store') }}" class="mt-7 space-y-6">
                                @csrf

                                <div>
                                    <label class="dps-label" for="family_member_id">PROFILE</label>
                                    <select name="family_member_id" id="family_member_id" class="dps-input mt-2">
                                        <option class="text-slate-900" value="">My Own Profile</option>
                                        @foreach($familyMembers as $member)
                                            <option class="text-slate-900" value="{{ $member->id }}" @selected(old('family_member_id') == $member->id)>
                                                {{ $member->name }} — {{ $member->relation ?? 'Family Member' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('family_member_id')" class="mt-2" />
                                </div>

                                <div class="grid md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="dps-label" for="age">AGE</label>
                                        <input id="age" name="age" type="number" min="1" max="120"
                                               value="{{ old('age') }}"
                                               class="dps-input mt-2" required placeholder="25">
                                        <x-input-error :messages="$errors->get('age')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="dps-label" for="gender">GENDER</label>
                                        <select id="gender" name="gender" class="dps-input mt-2" required>
                                            <option class="text-slate-900" value="">Select</option>
                                            <option class="text-slate-900" value="male" @selected(old('gender') === 'male')>Male</option>
                                            <option class="text-slate-900" value="female" @selected(old('gender') === 'female')>Female</option>
                                            <option class="text-slate-900" value="other" @selected(old('gender') === 'other')>Other</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="dps-label" for="blood_pressure">BLOOD PRESSURE</label>
                                        <input id="blood_pressure" name="blood_pressure" type="text"
                                               value="{{ old('blood_pressure') }}"
                                               class="dps-input mt-2" placeholder="120/80">
                                        <x-input-error :messages="$errors->get('blood_pressure')" class="mt-2" />
                                    </div>
                                </div>
                                                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="dps-label" for="height_cm">HEIGHT CM</label>
                                        <input id="height_cm" name="height_cm" type="number" step="0.01"
                                               value="{{ old('height_cm') }}"
                                               class="dps-input mt-2" placeholder="170">
                                        <x-input-error :messages="$errors->get('height_cm')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="dps-label" for="weight_kg">WEIGHT KG</label>
                                        <input id="weight_kg" name="weight_kg" type="number" step="0.01"
                                               value="{{ old('weight_kg') }}"
                                               class="dps-input mt-2" placeholder="65">
                                        <x-input-error :messages="$errors->get('weight_kg')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="dps-label" for="sugar_level">SUGAR LEVEL</label>
                                        <input id="sugar_level" name="sugar_level" type="number" step="0.01"
                                               value="{{ old('sugar_level') }}"
                                               class="dps-input mt-2" placeholder="Example: 110">
                                        <x-input-error :messages="$errors->get('sugar_level')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="dps-label" for="heart_rate">HEART RATE</label>
                                        <input id="heart_rate" name="heart_rate" type="number"
                                               value="{{ old('heart_rate') }}"
                                               class="dps-input mt-2" placeholder="Example: 78">
                                        <x-input-error :messages="$errors->get('heart_rate')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="dps-label" for="oxygen_level">OXYGEN LEVEL</label>
                                        <input id="oxygen_level" name="oxygen_level" type="number"
                                               value="{{ old('oxygen_level') }}"
                                               class="dps-input mt-2" placeholder="Example: 98">
                                        <x-input-error :messages="$errors->get('oxygen_level')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="dps-label" for="smoking">SMOKING STATUS</label>
                                        <select id="smoking" name="smoking" class="dps-input mt-2" required>
                                            <option class="text-slate-900" value="">Select</option>
                                            <option class="text-slate-900" value="no" @selected(old('smoking') === 'no')>No</option>
                                            <option class="text-slate-900" value="yes" @selected(old('smoking') === 'yes')>Yes</option>
                                            <option class="text-slate-900" value="former" @selected(old('smoking') === 'former')>Former</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('smoking')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="dps-label" for="diabetes_family_history">DIABETES FAMILY HISTORY</label>
                                        <select id="diabetes_family_history" name="diabetes_family_history" class="dps-input mt-2" required>
                                            <option class="text-slate-900" value="">Select</option>
                                            <option class="text-slate-900" value="no" @selected(old('diabetes_family_history') === 'no')>No</option>
                                            <option class="text-slate-900" value="yes" @selected(old('diabetes_family_history') === 'yes')>Yes</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('diabetes_family_history')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="dps-label" for="heart_family_history">HEART FAMILY HISTORY</label>
                                        <select id="heart_family_history" name="heart_family_history" class="dps-input mt-2" required>
                                            <option class="text-slate-900" value="">Select</option>
                                            <option class="text-slate-900" value="no" @selected(old('heart_family_history') === 'no')>No</option>
                                            <option class="text-slate-900" value="yes" @selected(old('heart_family_history') === 'yes')>Yes</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('heart_family_history')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="dps-label" for="kidney_problem">KIDNEY PROBLEM</label>
                                        <select id="kidney_problem" name="kidney_problem" class="dps-input mt-2" required>
                                            <option class="text-slate-900" value="">Select</option>
                                            <option class="text-slate-900" value="no" @selected(old('kidney_problem') === 'no')>No</option>
                                            <option class="text-slate-900" value="yes" @selected(old('kidney_problem') === 'yes')>Yes</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('kidney_problem')" class="mt-2" />
                                    </div>
                                </div>

                                <div>
                                    <label class="dps-label" for="symptoms">CURRENT SYMPTOMS / EXTRA DETAILS</label>
                                    <textarea id="symptoms" name="symptoms" rows="5"
                                              class="dps-input mt-2 resize-none"
                                              placeholder="Example: chest pain, frequent urination, weakness, headache, swelling, family history etc...">{{ old('symptoms') }}</textarea>
                                    <x-input-error :messages="$errors->get('symptoms')" class="mt-2" />
                                </div>

                                <div class="rounded-3xl bg-amber-400/10 border border-amber-300/20 p-5">
                                    <p class="text-amber-100 font-black">Important Medical Safety Note</p>
                                    <p class="mt-2 text-sm text-amber-100/80">
                                        This AI risk score is not a final diagnosis. It only gives health guidance.
                                        For emergency symptoms, contact a hospital or certified doctor immediately.
                                    </p>
                                </div>

                                <button type="submit"
                                    class="w-full rounded-2xl py-4 text-white font-black bg-gradient-to-r from-cyan-500 via-blue-600 to-violet-600 shadow-2xl hover:scale-[1.01] transition">
                                    Generate AI Risk Score
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-2xl font-black text-white">Recent Risk Predictions</h3>
                        <p class="text-sm text-slate-400 mt-1">Latest AI risk history</p>

                        <div class="mt-5 space-y-3">
                            @forelse($latestPredictions as $prediction)
                                @php
                                    $levelClasses = [
                                        'low' => 'bg-emerald-400/10 border-emerald-300/20 text-emerald-200',
                                        'medium' => 'bg-amber-400/10 border-amber-300/20 text-amber-200',
                                        'high' => 'bg-orange-400/10 border-orange-300/20 text-orange-200',
                                        'critical' => 'bg-rose-500/10 border-rose-300/20 text-rose-200',
                                    ];
                                @endphp

                                <div class="dps-soft rounded-3xl p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-white font-black">
                                                Overall Risk: {{ ucfirst($prediction->overall_risk_level) }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-400">
                                                {{ $prediction->created_at->diffForHumans() }}
                                            </p>
                                        </div>

                                        <span class="px-3 py-1 rounded-full border text-xs font-black capitalize
                                            {{ $levelClasses[$prediction->overall_risk_level] ?? 'bg-slate-500/10 border-slate-300/20 text-slate-200' }}">
                                            {{ $prediction->overall_risk_level }}
                                        </span>
                                    </div>

                                    <div class="mt-4 grid grid-cols-2 gap-2 text-xs">
                                        <div class="rounded-2xl bg-white/5 border border-white/10 p-3">
                                            <p class="text-slate-400">Diabetes</p>
                                            <p class="text-cyan-300 font-black">{{ $prediction->diabetes_risk }}%</p>
                                        </div>
                                        <div class="rounded-2xl bg-white/5 border border-white/10 p-3">
                                            <p class="text-slate-400">Heart</p>
                                            <p class="text-cyan-300 font-black">{{ $prediction->heart_disease_risk }}%</p>
                                        </div>
                                        <div class="rounded-2xl bg-white/5 border border-white/10 p-3">
                                            <p class="text-slate-400">Kidney</p>
                                            <p class="text-cyan-300 font-black">{{ $prediction->kidney_disease_risk }}%</p>
                                        </div>
                                        <div class="rounded-2xl bg-white/5 border border-white/10 p-3">
                                            <p class="text-slate-400">Stroke</p>
                                            <p class="text-cyan-300 font-black">{{ $prediction->stroke_risk }}%</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="dps-soft rounded-3xl p-6 text-center">
                                    <div class="text-4xl">📊</div>
                                    <p class="mt-3 text-white font-black">No prediction yet</p>
                                    <p class="mt-1 text-sm text-slate-400">
                                        Your AI risk history will appear here.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                                        @if(session('latest_prediction_id'))
                        @php
                            $latestResult = \App\Models\RiskPrediction::find(session('latest_prediction_id'));

                            $levelClasses = [
                                'low' => 'bg-emerald-400/10 border-emerald-300/20 text-emerald-200',
                                'medium' => 'bg-amber-400/10 border-amber-300/20 text-amber-200',
                                'high' => 'bg-orange-400/10 border-orange-300/20 text-orange-200',
                                'critical' => 'bg-rose-500/10 border-rose-300/20 text-rose-200',
                            ];

                            $riskBars = $latestResult ? [
                                'Diabetes Risk' => $latestResult->diabetes_risk,
                                'Heart Disease Risk' => $latestResult->heart_disease_risk,
                                'Kidney Disease Risk' => $latestResult->kidney_disease_risk,
                                'Stroke Risk' => $latestResult->stroke_risk,
                            ] : [];
                        @endphp

                        @if($latestResult)
                            <div class="dps-border">
                                <div class="dps-card rounded-[calc(2rem-1px)] p-6 md:p-8">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-sm text-slate-400 font-bold">AI Result</p>
                                            <h2 class="mt-2 text-3xl font-black text-white">
                                                Overall Risk:
                                                <span class="capitalize text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-violet-300">
                                                    {{ $latestResult->overall_risk_level }}
                                                </span>
                                            </h2>
                                        </div>

                                        <span class="px-4 py-2 rounded-full border font-black text-sm capitalize
                                            {{ $levelClasses[$latestResult->overall_risk_level] ?? 'bg-slate-500/10 border-slate-300/20 text-slate-200' }}">
                                            {{ $latestResult->overall_risk_level }}
                                        </span>
                                    </div>

                                    <div class="mt-6 space-y-5">
                                        @foreach($riskBars as $label => $value)
                                            <div>
                                                <div class="flex justify-between text-sm font-bold mb-2">
                                                    <span class="text-slate-300">{{ $label }}</span>
                                                    <span class="text-cyan-300">{{ $value }}%</span>
                                                </div>

                                                <div class="h-4 rounded-full bg-white/10 overflow-hidden">
                                                    <div class="h-full rounded-full bg-gradient-to-r from-cyan-400 via-blue-500 to-violet-500 transition-all duration-700"
                                                         style="width: {{ min(100, max(0, $value)) }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-6 dps-soft rounded-3xl p-5">
                                        <h3 class="text-white font-black">Personalized Recommendation</h3>
                                        <p class="mt-2 text-sm text-slate-300 whitespace-pre-line">
                                            {{ $latestResult->recommendation }}
                                        </p>
                                    </div>

                                    <div class="mt-6 rounded-3xl bg-rose-500/10 border border-rose-300/20 p-5">
                                        <p class="text-rose-100 font-black">Medical Disclaimer</p>
                                        <p class="mt-2 text-sm text-rose-100/80">
                                            It is not a final medical diagnosis.
                                            Please consult a certified doctor for diagnosis and treatment.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-xl font-black text-white">AI Accuracy Note</h3>
                        <p class="mt-3 text-sm text-slate-300 leading-6">
                            Risk percentage depends on the information you provide. More accurate health data,
                            recent reports, BP, sugar level, age, family history and symptoms can improve the AI analysis.
                        </p>

                        <div class="mt-5 grid grid-cols-2 gap-3">
                            <div class="rounded-2xl bg-cyan-400/10 border border-cyan-300/20 p-4">
                                <p class="text-cyan-200 font-black">AI</p>
                                <p class="mt-1 text-xs text-slate-400">Analysis</p>
                            </div>

                            <div class="rounded-2xl bg-emerald-400/10 border border-emerald-300/20 p-4">
                                <p class="text-emerald-200 font-black">Secure Save</p>
                                <p class="mt-1 text-xs text-slate-400">History stored</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>