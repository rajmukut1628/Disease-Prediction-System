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

        .dps-float {
            animation: dpsFloat 6s ease-in-out infinite;
        }

        .dps-soft {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.10);
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
                            <span class="text-sm font-black text-cyan-100">AI Symptom Checker</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            AI Symptom
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                                Analysis
                            </span>
                        </h1>

                        <p class="mt-4 text-slate-300 max-w-2xl">
                            Describe symptoms in Bangla or English. AI will suggest probable disease,
                            severity, confidence score, next steps, red flags and doctor specialist.
                        </p>
                    </div>

                    <div class="dps-float w-28 h-28 rounded-[2rem] bg-gradient-to-br from-cyan-400 via-blue-600 to-violet-700 flex items-center justify-center text-5xl shadow-2xl">
                        🤖
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="dps-border">
                        <div class="dps-card rounded-[calc(2rem-1px)] p-6 md:p-8">
                            <h2 class="text-2xl font-black text-white">Start New Symptom Check</h2>
                            <p class="mt-2 text-sm text-slate-400">
                                This analysis uses your Gemini API key through Laravel backend.
                            </p>

                            <form method="POST" action="{{ route('user.symptom-checker.store') }}" class="mt-7 space-y-6">
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

                                <div>
                                    <div class="flex items-center justify-between gap-3">
                                        <label class="dps-label" for="symptoms">SYMPTOMS</label>

                                        <div class="flex flex-wrap gap-2">
                                          <select id="voiceLang"
                                              class="rounded-2xl bg-slate-900/80 border border-cyan-300/20 text-cyan-100 text-sm font-black px-3 py-2">
                                              <option value="bn-BD">বাংলা</option>
                                              <option value="en-US">English</option>
                                               <option value="hi-IN">हिन्दी</option>
                                            </select>

                                          <button type="button" id="voiceBtn"
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-cyan-500/15 border border-cyan-300/20 text-cyan-100 font-black text-sm hover:bg-cyan-500/25 transition">
                                           🎤 Start Voice
                                          </button>

                                          <button type="button" id="clearVoiceBtn"
                                             class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-rose-500/15 border border-rose-300/20 text-rose-100 font-black text-sm hover:bg-rose-500/25 transition">
                                                     Clear
                                          </button>
                                         </div>
                                    </div>
                                    <textarea name="symptoms" id="symptoms" rows="8" required minlength="5" maxlength="5000"
                                        class="dps-input mt-2 resize-none"
                                        placeholder="Example: Amar 3 din dhore fever, headache, cough ache. Body pain hocche and weakness feel kortesi...">{{ old('symptoms') }}</textarea>

                                    <div class="mt-2 flex items-center justify-between text-xs text-slate-400">
                                        <span id="voiceStatus">Voice input supports browser speech recognition.</span>
                                        <span><span id="charCount">0</span>/5000</span>
                                    </div>

                                    <x-input-error :messages="$errors->get('symptoms')" class="mt-2" />
                                </div>

                                <div class="rounded-3xl bg-amber-400/10 border border-amber-300/20 p-5">
                                    <p class="text-amber-100 font-black">Important Medical Safety Note</p>
                                    <p class="mt-2 text-sm text-amber-100/80">
                                        This AI system gives health guidance only. It is not a final diagnosis.
                                        For chest pain, breathing difficulty, unconsciousness, stroke symptoms,
                                        severe bleeding, or very high fever, seek emergency medical help immediately.
                                    </p>
                                </div>

                                <button type="submit"
                                    class="w-full rounded-2xl py-4 text-white font-black bg-gradient-to-r from-cyan-500 via-blue-600 to-violet-600 shadow-2xl hover:scale-[1.01] transition">
                                    Analyze Symptoms with AI
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                                <div class="space-y-6">

                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-2xl font-black text-white">Recent Analyses</h3>
                        <p class="text-sm text-slate-400 mt-1">Latest AI symptom checks</p>

                        <div class="mt-5 space-y-3">
                            @forelse($latestChecks as $check)
                                @php
                                    $severityClasses = [
                                        'low' => 'bg-emerald-400/10 border-emerald-300/20 text-emerald-200',
                                        'medium' => 'bg-amber-400/10 border-amber-300/20 text-amber-200',
                                        'high' => 'bg-orange-400/10 border-orange-300/20 text-orange-200',
                                        'emergency' => 'bg-rose-500/10 border-rose-300/20 text-rose-200',
                                    ];
                                @endphp

                                <div class="dps-soft rounded-3xl p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-white font-black">
                                                {{ $check->probable_disease ?? 'AI Analysis' }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-400">
                                                {{ $check->created_at->diffForHumans() }}
                                            </p>
                                        </div>

                                        <span class="px-3 py-1 rounded-full border text-xs font-black capitalize
                                            {{ $severityClasses[$check->severity] ?? 'bg-slate-500/10 border-slate-300/20 text-slate-200' }}">
                                            {{ $check->severity }}
                                        </span>
                                    </div>

                                    <div class="mt-3 flex items-center justify-between text-sm">
                                        <span class="text-slate-400">Confidence Score</span>
                                        <span class="text-cyan-300 font-black">
                                            {{ $check->confidence_score }}%
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="dps-soft rounded-3xl p-6 text-center">
                                    <div class="text-4xl">🩺</div>
                                    <p class="mt-3 text-white font-black">No analysis yet</p>
                                    <p class="mt-1 text-sm text-slate-400">
                                        Your AI history will appear here.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @if(session('latest_check_id'))
                        @php
                            $latestResult = \App\Models\SymptomCheck::find(session('latest_check_id'));
                            $aiData = $latestResult && $latestResult->ai_response
                                ? json_decode($latestResult->ai_response, true)
                                : null;

                            $severityClasses = [
                                'low' => 'bg-emerald-400/10 border-emerald-300/20 text-emerald-200',
                                'medium' => 'bg-amber-400/10 border-amber-300/20 text-amber-200',
                                'high' => 'bg-orange-400/10 border-orange-300/20 text-orange-200',
                                'emergency' => 'bg-rose-500/10 border-rose-300/20 text-rose-200',
                            ];
                        @endphp

                        @if($latestResult)
                            <div class="dps-border">
                                <div class="dps-card rounded-[calc(2rem-1px)] p-6 md:p-8">
                                    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                        <div>
                                            <h2 class="text-3xl font-black text-white">
                                                {{ $latestResult->probable_disease }}
                                            </h2>
                                            <p class="mt-2 text-slate-400">
                                                Recommended Specialist:
                                                <span class="text-cyan-300 font-black">
                                                    {{ $aiData['doctor_specialist'] ?? 'General Physician' }}
                                                </span>
                                            </p>
                                        </div>

                                        <div class="flex flex-wrap gap-2">
                                            <span class="px-4 py-2 rounded-full border font-black text-sm
                                                {{ $severityClasses[$latestResult->severity] ?? 'bg-slate-500/10 border-slate-300/20 text-slate-200' }}">
                                                {{ ucfirst($latestResult->severity) }}
                                            </span>

                                            <span class="px-4 py-2 rounded-full bg-cyan-400/10 border border-cyan-300/20 text-cyan-200 font-black text-sm">
                                                {{ $latestResult->confidence_score }}% Confidence
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-6 grid md:grid-cols-2 gap-6">
                                        <div class="dps-soft rounded-3xl p-5">
                                            <h3 class="text-white font-black">Next Steps</h3>
                                            <p class="mt-2 text-sm text-slate-300 whitespace-pre-line">
                                                {{ $latestResult->next_steps }}
                                            </p>
                                        </div>

                                        <div class="dps-soft rounded-3xl p-5">
                                            <h3 class="text-white font-black">Medicine Note</h3>
                                            <p class="mt-2 text-sm text-slate-300 whitespace-pre-line">
                                                {{ $aiData['medicine_note'] ?? 'Do not take medicine without doctor advice.' }}
                                            </p>
                                        </div>
                                    </div>

                                    @if(!empty($aiData['red_flags']))
                                        <div class="mt-6 dps-soft rounded-3xl p-5">
                                            <h3 class="text-rose-200 font-black">Red Flags</h3>
                                            <ul class="mt-3 space-y-2">
                                                @foreach($aiData['red_flags'] as $flag)
                                                    <li class="text-sm text-slate-300">🚨 {{ $flag }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(!empty($aiData['lifestyle_tips']))
                                        <div class="mt-6 dps-soft rounded-3xl p-5">
                                            <h3 class="text-emerald-200 font-black">Lifestyle Tips</h3>
                                            <ul class="mt-3 space-y-2">
                                                @foreach($aiData['lifestyle_tips'] as $tip)
                                                    <li class="text-sm text-slate-300">✅ {{ $tip }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="mt-6 rounded-3xl bg-rose-500/10 border border-rose-300/20 p-5">
                                        <p class="text-rose-100 font-black">Medical Disclaimer</p>
                                        <p class="mt-2 text-sm text-rose-100/80">
                                            Final diagnosis and treatment decisions
                                            must be made by a licensed physician.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
    <script>
    const symptoms = document.getElementById('symptoms');
    const charCount = document.getElementById('charCount');
    const voiceBtn = document.getElementById('voiceBtn');
    const clearVoiceBtn = document.getElementById('clearVoiceBtn');
    const voiceStatus = document.getElementById('voiceStatus');
    const voiceLang = document.getElementById('voiceLang');

    function updateCharCount() {
        charCount.textContent = symptoms.value.length;
    }

    updateCharCount();
    symptoms.addEventListener('input', updateCharCount);

    const SpeechRecognition =
        window.SpeechRecognition || window.webkitSpeechRecognition;

    let isListening = false;
    let recognition = null;

    if (SpeechRecognition) {
        recognition = new SpeechRecognition();
        recognition.interimResults = true;
        recognition.continuous = false;

        voiceBtn.addEventListener('click', () => {
            if (isListening) {
                recognition.stop();
                return;
            }

            recognition.lang = voiceLang.value;
            isListening = true;

            voiceBtn.innerHTML = '⏹ Stop Voice';
            voiceBtn.classList.add('bg-rose-500/20', 'border-rose-300/30', 'text-rose-100');

            voiceStatus.textContent = 'Listening... speak clearly now.';
            recognition.start();
        });

        recognition.onresult = function (event) {
            let transcript = '';

            for (let i = event.resultIndex; i < event.results.length; i++) {
                transcript += event.results[i][0].transcript;
            }

            symptoms.value = symptoms.value
                ? symptoms.value + ' ' + transcript
                : transcript;

            updateCharCount();
            voiceStatus.textContent = 'Voice captured. You can edit before AI analysis.';
        };

        recognition.onerror = function () {
            voiceStatus.textContent = 'Voice recognition failed. Please try again or type manually.';
        };

        recognition.onend = function () {
            isListening = false;

            voiceBtn.innerHTML = '🎤 Start Voice';
            voiceBtn.classList.remove('bg-rose-500/20', 'border-rose-300/30', 'text-rose-100');

            if (!symptoms.value.trim()) {
                voiceStatus.textContent = 'Voice stopped. No text captured.';
            }
        };

        clearVoiceBtn.addEventListener('click', () => {
            symptoms.value = '';
            updateCharCount();
            voiceStatus.textContent = 'Symptoms text cleared.';
        });
    } else {
        voiceBtn.disabled = true;
        voiceBtn.classList.add('opacity-50', 'cursor-not-allowed');
        voiceStatus.textContent = 'Speech recognition is not supported in this browser.';
    }
</script>

</x-app-layout>