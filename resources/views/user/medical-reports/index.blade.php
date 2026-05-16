<x-app-layout>
    <style>
        @keyframes dpsLiveShadow {
            0%,100% { box-shadow: 0 25px 80px rgba(34,211,238,.18), 0 0 55px rgba(99,102,241,.22); }
            50% { box-shadow: 0 35px 115px rgba(16,185,129,.24), 0 0 90px rgba(168,85,247,.32); }
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

            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-300/20 bg-emerald-400/10 px-5 py-4 text-emerald-100 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="dps-card rounded-[2rem] p-7 md:p-9 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 mb-5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-sm font-black text-cyan-100">Secure Medical Report Vault</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            My Medical
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                                Reports
                            </span>
                        </h1>

                        <p class="mt-4 text-slate-300 max-w-2xl">
                            View uploaded reports, AI summaries, abnormal findings, severity level,
                            specialist suggestions and health advice.
                        </p>

                        <div class="mt-6">
                            <a href="{{ route('user.medical-reports.create') }}"
                               class="inline-flex px-5 py-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-black shadow-xl hover:scale-[1.02] transition">
                                Analyze New Report
                            </a>
                        </div>
                    </div>

                    <div class="dps-float w-28 h-28 rounded-[2rem] bg-gradient-to-br from-cyan-400 via-blue-600 to-violet-700 flex items-center justify-center text-5xl shadow-2xl">
                        🧾
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-5">
                    @forelse($reports as $report)
                        @php
                            $severityClasses = [
                                'low' => 'bg-emerald-400/10 border-emerald-300/20 text-emerald-200',
                                'medium' => 'bg-amber-400/10 border-amber-300/20 text-amber-200',
                                'high' => 'bg-orange-400/10 border-orange-300/20 text-orange-200',
                                'emergency' => 'bg-rose-500/10 border-rose-300/20 text-rose-200',
                            ];
                        @endphp

                        <div class="dps-card rounded-[2rem] p-6">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                <div>
                                    <p class="text-sm text-slate-400 font-bold uppercase">
                                        {{ str_replace('_', ' ', $report->report_type) }}
                                    </p>

                                    <h2 class="mt-2 text-2xl font-black text-white">
                                        {{ $report->title }}
                                    </h2>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Uploaded {{ $report->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <span class="px-4 py-2 rounded-full border font-black text-sm capitalize {{ $severityClasses[$report->severity_level] ?? 'bg-slate-500/10 border-slate-300/20 text-slate-200' }}">
                                        {{ $report->severity_level }}
                                    </span>

                                    <span class="px-4 py-2 rounded-full bg-cyan-400/10 border border-cyan-300/20 text-cyan-200 font-black text-sm">
                                        {{ $report->ai_confidence_score }}% AI Confidence
                                    </span>
                                    <span class="px-4 py-2 rounded-full {{ $report->is_encrypted ? 'bg-emerald-400/10 border border-emerald-300/20 text-emerald-200' : 'bg-slate-400/10 border border-slate-300/20 text-slate-200' }} font-black text-sm">
                                        🔐 {{ $report->encryption_label }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6 dps-soft rounded-3xl p-5">
                                <h3 class="text-white font-black">AI Summary</h3>
                                <p class="mt-2 text-sm text-slate-300 leading-6 whitespace-pre-line">
                                    {{ $report->ai_summary ?? 'No AI summary available.' }}
                                </p>
                            </div>

                            @if(!empty($report->abnormal_findings))
                                <div class="mt-5 dps-soft rounded-3xl p-5">
                                    <h3 class="text-orange-200 font-black">Abnormal Findings</h3>
                                    <ul class="mt-3 space-y-2">
                                        @foreach($report->abnormal_findings as $finding)
                                            <li class="text-sm text-slate-300">⚠️ {{ $finding }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mt-5 grid md:grid-cols-2 gap-4">
                                <div class="dps-soft rounded-3xl p-5">
                                    <h3 class="text-cyan-200 font-black">Recommended Specialist</h3>
                                    <p class="mt-2 text-sm text-slate-300">
                                        {{ $report->recommended_specialist ?? 'General Physician' }}
                                    </p>
                                </div>

                                <div class="dps-soft rounded-3xl p-5">
                                    <h3 class="text-rose-200 font-black">Warning Signs</h3>
                                    <p class="mt-2 text-sm text-slate-300 whitespace-pre-line">
                                        {{ $report->warning_signs ?: 'No major warning signs mentioned by AI.' }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 dps-soft rounded-3xl p-5">
                                <h3 class="text-emerald-200 font-black">Health Advice</h3>
                                <p class="mt-2 text-sm text-slate-300 leading-6 whitespace-pre-line">
                                    {{ $report->health_advice ?? 'Please consult a certified doctor for proper guidance.' }}
                                </p>
                            </div>

                            <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                                <div class="text-xs text-slate-500">
                                    File:
                                    <span class="text-slate-300 font-bold">
                                        {{ $report->original_name ?? 'Text-only report' }}
                                             @if($report->is_encrypted)
                                               <span class="ml-2 text-emerald-300 font-black">Encrypted</span>
                                             @endif
                                    </span>
                                </div>

                                <span class="px-4 py-2 rounded-2xl bg-white/10 border border-white/10 text-slate-200 text-xs font-black">
                                    {{ $report->file_size_human }}
                                </span>
                            </div>

                            @if($report->file_path && $report->file_path !== 'text-only-report')
                                <div class="mt-5 flex flex-wrap gap-3">
                                    <a href="{{ route('user.medical-reports.file.view', $report) }}"
                                       target="_blank"
                                       class="px-4 py-2 rounded-2xl bg-cyan-500/15 border border-cyan-300/20 text-cyan-100 font-black text-sm hover:bg-cyan-500/25 transition">
                                        View File
                                    </a>

                                    <a href="{{ route('user.medical-reports.file.download', $report) }}"
                                       class="px-4 py-2 rounded-2xl bg-emerald-500/15 border border-emerald-300/20 text-emerald-100 font-black text-sm hover:bg-emerald-500/25 transition">
                                        Download File
                                    </a>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="dps-card rounded-[2rem] p-12 text-center">
                            <div class="mx-auto w-20 h-20 rounded-3xl bg-cyan-400/10 border border-cyan-300/20 flex items-center justify-center text-4xl">
                                📄
                            </div>

                            <h2 class="mt-5 text-2xl font-black text-white">No Reports Yet</h2>
                            <p class="mt-2 text-slate-400">
                                Upload or paste your first medical report and analyze it using AI.
                            </p>

                            <a href="{{ route('user.medical-reports.create') }}"
                               class="mt-6 inline-flex px-5 py-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-black shadow-xl hover:scale-[1.02] transition">
                                Analyze First Report
                            </a>
                        </div>
                    @endforelse

                    <div class="mt-6">
                        {{ $reports->links() }}
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-2xl font-black text-white">Report Vault Stats</h3>
                        <p class="mt-2 text-sm text-slate-400">Your AI report analysis overview.</p>

                        <div class="mt-5 space-y-3">
                            <div class="dps-soft rounded-3xl p-5">
                                <p class="text-slate-400 text-sm font-bold">Total Reports</p>
                                <p class="mt-2 text-4xl font-black text-white">{{ $reports->total() }}</p>
                            </div>

                            <div class="dps-soft rounded-3xl p-5">
                                <p class="text-slate-400 text-sm font-bold">AI Engine</p>
                                <p class="mt-2 text-2xl font-black text-cyan-300">Gemini</p>
                            </div>

                            <div class="dps-soft rounded-3xl p-5">
                                <p class="text-slate-400 text-sm font-bold">Storage</p>
                                <p class="mt-2 text-2xl font-black text-emerald-300">Private Local</p>
                            </div>
                        </div>
                    </div>

                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-xl font-black text-white">Privacy & Security Note</h3>
                        <p class="mt-3 text-sm text-slate-300 leading-6">
                            Your report files are stored outside the public folder using Laravel local storage.
                            Direct public URL access is not used.
                        </p>
                    </div>

                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-xl font-black text-white">Medical Disclaimer</h3>
                        <p class="mt-3 text-sm text-rose-100/80 leading-6">
                            AI report analysis is informational guidance only. It cannot replace certified
                            doctors, radiologists, or lab specialists.
                        </p>

                        <a href="{{ route('user.medical-reports.create') }}"
                           class="mt-5 inline-flex w-full justify-center rounded-2xl py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-black hover:scale-[1.01] transition">
                            Analyze Another Report
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>