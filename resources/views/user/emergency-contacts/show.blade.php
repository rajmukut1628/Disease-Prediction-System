<x-app-layout>
    <style>
        @keyframes dpsLiveShadow {
            0%,100% {
                box-shadow: 0 25px 80px rgba(239,68,68,.18),
                            0 0 55px rgba(99,102,241,.20);
            }
            50% {
                box-shadow: 0 35px 115px rgba(34,211,238,.20),
                            0 0 90px rgba(244,63,94,.30);
            }
        }

        .dps-page {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(239,68,68,.20), transparent 28%),
                radial-gradient(circle at top right, rgba(34,211,238,.16), transparent 30%),
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
        <div class="max-w-6xl mx-auto">

            <div class="dps-card rounded-[2rem] p-7 md:p-9 mb-8">
                <a href="{{ route('user.emergency-contacts.index') }}"
                   class="inline-flex mb-5 px-4 py-2 rounded-2xl bg-white/10 border border-white/10 text-rose-200 font-black text-sm">
                    ← Back to Emergency Contacts
                </a>

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            {{ $emergencyContact->name }}
                        </h1>

                        <p class="mt-3 text-slate-300">
                            {{ $emergencyContact->relation ?? 'Emergency Contact' }}
                        </p>
                    </div>

                    <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-br from-rose-500 via-red-600 to-violet-700 flex items-center justify-center text-white text-4xl font-black shadow-2xl">
                        {{ strtoupper(substr($emergencyContact->name, 0, 1)) }}
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Phone</p>
                    <p class="mt-2 text-xl font-black text-white">
                        {{ $emergencyContact->phone }}
                    </p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Email</p>
                    <p class="mt-2 text-lg font-black text-white break-all">
                        {{ $emergencyContact->email ?? 'N/A' }}
                    </p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Primary</p>
                    <p class="mt-2 text-2xl font-black {{ $emergencyContact->is_primary ? 'text-emerald-300' : 'text-slate-400' }}">
                        {{ $emergencyContact->is_primary ? 'Yes' : 'No' }}
                    </p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Created</p>
                    <p class="mt-2 text-lg font-black text-white">
                        {{ $emergencyContact->created_at->format('d M Y') }}
                    </p>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">
                <div class="dps-card rounded-[2rem] p-6">
                    <h2 class="text-2xl font-black text-white">Alert Preferences</h2>

                    <div class="mt-5 grid md:grid-cols-2 gap-4">
                        <div class="dps-soft rounded-2xl p-5">
                            <p class="text-slate-400 text-sm font-bold">SMS Alerts</p>
                            <p class="mt-2 text-2xl font-black {{ $emergencyContact->notify_by_sms ? 'text-emerald-300' : 'text-slate-400' }}">
                                {{ $emergencyContact->notify_by_sms ? 'Enabled' : 'Disabled' }}
                            </p>
                        </div>

                        <div class="dps-soft rounded-2xl p-5">
                            <p class="text-slate-400 text-sm font-bold">Email Alerts</p>
                            <p class="mt-2 text-2xl font-black {{ $emergencyContact->notify_by_email ? 'text-emerald-300' : 'text-slate-400' }}">
                                {{ $emergencyContact->notify_by_email ? 'Enabled' : 'Disabled' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <h2 class="text-2xl font-black text-white">Emergency Alert System</h2>

                    <div class="mt-5 dps-soft rounded-3xl p-5">
                        <p class="text-sm text-slate-300 leading-6">
                            This contact is prepared for future automated notifications when:
                        </p>

                        <ul class="mt-4 space-y-2 text-sm text-slate-300">
                            <li>🚨 Critical health insight detected</li>
                            <li>🩺 High-risk disease prediction</li>
                            <li>📄 Dangerous medical report findings</li>
                            <li>❤️ Severe symptom analysis result</li>
                        </ul>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('user.emergency-contacts.edit', $emergencyContact) }}"
                           class="px-5 py-3 rounded-2xl bg-amber-500/15 border border-amber-300/20 text-amber-100 font-black">
                            Edit Contact
                        </a>

                        <a href="{{ route('user.emergency-contacts.index') }}"
                           class="px-5 py-3 rounded-2xl bg-white/10 border border-white/10 text-white font-black">
                            Back
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>