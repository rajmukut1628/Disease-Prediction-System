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
                <a href="{{ route('user.health-records.index') }}"
                   class="inline-flex mb-5 px-4 py-2 rounded-2xl bg-white/10 border border-white/10 text-cyan-200 font-black text-sm">
                    ← Back to Health Records
                </a>

                <h1 class="text-4xl md:text-5xl font-black text-white">
                    Health Record Details
                </h1>

                <p class="mt-3 text-slate-300">
                    Profile:
                    <span class="text-cyan-300 font-black">
                        {{ $healthRecord->familyMember?->name ?? 'My Own Profile' }}
                    </span>
                </p>
            </div>

            <div class="grid md:grid-cols-4 gap-5 mb-8">
                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">BMI</p>
                    <p class="mt-2 text-4xl font-black text-white">{{ $healthRecord->bmi ?? '--' }}</p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Blood Pressure</p>
                    <p class="mt-2 text-4xl font-black text-white">{{ $healthRecord->blood_pressure ?? '--' }}</p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Sugar Level</p>
                    <p class="mt-2 text-4xl font-black text-white">{{ $healthRecord->sugar_level ?? '--' }}</p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Oxygen</p>
                    <p class="mt-2 text-4xl font-black text-white">
                        {{ $healthRecord->oxygen_level ?? '--' }}@if($healthRecord->oxygen_level)%@endif
                    </p>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">
                <div class="dps-card rounded-[2rem] p-6">
                    <h2 class="text-2xl font-black text-white">Vitals</h2>

                    <div class="mt-5 grid md:grid-cols-2 gap-4">
                        <div class="dps-soft rounded-2xl p-4">
                            <p class="text-xs text-slate-400 font-bold">Height</p>
                            <p class="mt-1 text-white font-black">{{ $healthRecord->height_cm ?? '--' }} cm</p>
                        </div>

                        <div class="dps-soft rounded-2xl p-4">
                            <p class="text-xs text-slate-400 font-bold">Weight</p>
                            <p class="mt-1 text-white font-black">{{ $healthRecord->weight_kg ?? '--' }} kg</p>
                        </div>

                        <div class="dps-soft rounded-2xl p-4">
                            <p class="text-xs text-slate-400 font-bold">Heart Rate</p>
                            <p class="mt-1 text-white font-black">{{ $healthRecord->heart_rate ?? '--' }} bpm</p>
                        </div>

                        <div class="dps-soft rounded-2xl p-4">
                            <p class="text-xs text-slate-400 font-bold">Sleep</p>
                            <p class="mt-1 text-white font-black">{{ $healthRecord->sleep_hours ?? '--' }} hrs</p>
                        </div>

                        <div class="dps-soft rounded-2xl p-4">
                            <p class="text-xs text-slate-400 font-bold">Water Intake</p>
                            <p class="mt-1 text-white font-black">{{ $healthRecord->water_intake_ml ?? '--' }} ml</p>
                        </div>

                        <div class="dps-soft rounded-2xl p-4">
                            <p class="text-xs text-slate-400 font-bold">Recorded</p>
                            <p class="mt-1 text-white font-black">{{ $healthRecord->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <h2 class="text-2xl font-black text-white">Health Notes</h2>

                    <div class="mt-5 dps-soft rounded-3xl p-5">
                        <p class="text-sm text-slate-300 leading-6 whitespace-pre-line">
                            {{ $healthRecord->notes ?: 'No notes added.' }}
                        </p>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('user.health-records.edit', $healthRecord) }}"
                           class="px-5 py-3 rounded-2xl bg-amber-500/15 border border-amber-300/20 text-amber-100 font-black">
                            Edit Record
                        </a>

                        <a href="{{ route('user.health-records.index') }}"
                           class="px-5 py-3 rounded-2xl bg-white/10 border border-white/10 text-white font-black">
                            Back
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>