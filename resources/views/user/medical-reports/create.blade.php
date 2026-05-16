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
                            <span class="text-sm font-black text-cyan-100">AI Report Analyzer</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            Smart Medical Report
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                                Analysis
                            </span>
                        </h1>

                        <p class="mt-4 text-slate-300 max-w-2xl">
                            Upload or paste your blood test, ECG, X-ray, urine test, prescription, or other report text.
                            AI will generate summary, abnormal findings, severity, warning signs, and specialist suggestion.
                        </p>
                    </div>

                    <div class="dps-float w-28 h-28 rounded-[2rem] bg-gradient-to-br from-cyan-400 via-blue-600 to-violet-700 flex items-center justify-center text-5xl shadow-2xl">
                        📄
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="dps-border">
                        <div class="dps-card rounded-[calc(2rem-1px)] p-6 md:p-8">
                            <h2 class="text-2xl font-black text-white">Analyze New Report</h2>
                            <p class="mt-2 text-sm text-slate-400">
                                For best AI result, paste the important report values/text below.
                            </p>

                            <form method="POST"
                                  action="{{ route('user.medical-reports.store') }}"
                                  enctype="multipart/form-data"
                                  class="mt-7 space-y-6">
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

                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="dps-label" for="report_type">REPORT TYPE</label>
                                        <select id="report_type" name="report_type" class="dps-input mt-2" required>
                                            <option class="text-slate-900" value="">Select report type</option>
                                            <option class="text-slate-900" value="blood_test" @selected(old('report_type') === 'blood_test')>Blood Test</option>
                                            <option class="text-slate-900" value="ecg" @selected(old('report_type') === 'ecg')>ECG</option>
                                            <option class="text-slate-900" value="xray" @selected(old('report_type') === 'xray')>X-ray</option>
                                            <option class="text-slate-900" value="urine_test" @selected(old('report_type') === 'urine_test')>Urine Test</option>
                                            <option class="text-slate-900" value="prescription" @selected(old('report_type') === 'prescription')>Prescription</option>
                                            <option class="text-slate-900" value="other" @selected(old('report_type') === 'other')>Other</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('report_type')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="dps-label" for="title">REPORT TITLE</label>
                                        <input id="title"
                                               name="title"
                                               type="text"
                                               value="{{ old('title') }}"
                                               class="dps-input mt-2"
                                               required
                                               placeholder="Example: CBC Blood Test - May 2026">
                                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                    </div>
                                </div>

                                <div>
                                    <label class="dps-label" for="report_text">REPORT TEXT / VALUES</label>
                                    <textarea id="report_text"
                                              name="report_text"
                                              rows="10"
                                              required
                                              minlength="10"
                                              maxlength="12000"
                                              class="dps-input mt-2 resize-none"
                                              placeholder="Paste report text here. Example: Hemoglobin 12.5 g/dL, WBC 11000, Platelet 250000, Fasting Blood Sugar 130 mg/dL...">{{ old('report_text') }}</textarea>

                                    <div class="mt-2 flex items-center justify-between text-xs text-slate-400">
                                        <span>AI will analyze this report text.</span>
                                        <span><span id="reportCharCount">0</span>/12000</span>
                                    </div>

                                    <x-input-error :messages="$errors->get('report_text')" class="mt-2" />
                                </div>
                                                                <div>
                                    <label class="dps-label" for="file">OPTIONAL REPORT FILE</label>

                                    <input id="file"
                                           name="file"
                                           type="file"
                                           accept=".pdf,.jpg,.jpeg,.png,.txt"
                                           class="dps-input mt-2">

                                    <p class="mt-2 text-xs text-slate-400">
                                        Supported: PDF, JPG, PNG, TXT. Max size: 10MB.
                                        AI analysis will use the pasted text above.
                                    </p>

                                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                                </div>

                                <div class="rounded-3xl bg-amber-400/10 border border-amber-300/20 p-5">
                                    <p class="text-amber-100 font-black">Important Note</p>
                                    <p class="mt-2 text-sm text-amber-100/80">
                                        AI report analysis is health guidance only. It cannot replace a certified doctor,
                                        lab specialist, or radiologist. For serious abnormal findings, consult a doctor quickly.
                                    </p>
                                </div>

                                <button type="submit"
                                    class="w-full rounded-2xl py-4 text-white font-black bg-gradient-to-r from-cyan-500 via-blue-600 to-violet-600 shadow-2xl hover:scale-[1.01] transition">
                                    Analyze Report with AI
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-2xl font-black text-white">AI Report Tips</h3>
                        <p class="mt-2 text-sm text-slate-400">
                            For best analysis, paste clear report values with units and reference ranges.
                        </p>

                        <div class="mt-5 space-y-3">
                            @foreach([
                                'Blood test values with units',
                                'ECG summary or machine interpretation',
                                'X-ray findings text',
                                'Urine test parameters',
                                'Doctor prescription details',
                                'Any symptoms related to the report'
                            ] as $tip)
                                <div class="dps-soft rounded-2xl px-4 py-3 text-sm text-slate-200 font-bold">
                                    ✅ {{ $tip }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-xl font-black text-white">Privacy Note</h3>
                        <p class="mt-3 text-sm text-slate-300 leading-6">
                            Report file is stored in Laravel private local storage.
                            In the next security upgrade, we will add encrypted file storage and secure download controller.
                        </p>

                        <a href="{{ route('user.medical-reports.index') }}"
                           class="mt-5 inline-flex w-full justify-center rounded-2xl py-3 bg-white/10 border border-white/10 text-white font-black hover:bg-white/15 transition">
                            View My Reports
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        const reportText = document.getElementById('report_text');
        const reportCharCount = document.getElementById('reportCharCount');

        function updateReportCount() {
            reportCharCount.textContent = reportText.value.length;
        }

        updateReportCount();
        reportText.addEventListener('input', updateReportCount);
    </script>
</x-app-layout>