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
                            <span class="text-sm font-black text-cyan-100">Personal Health Dashboard</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            Health Records
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                                Tracker
                            </span>
                        </h1>

                        <p class="mt-4 text-slate-300 max-w-2xl">
                            Track BMI, blood pressure, sugar level, heart rate, oxygen level, sleep,
                            hydration, and daily health notes for yourself or family members.
                        </p>

                        <div class="mt-6">
                            <a href="{{ route('user.health-records.create') }}"
                               class="inline-flex px-5 py-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-black shadow-xl hover:scale-[1.02] transition">
                                Add Health Record
                            </a>
                        </div>
                    </div>

                    <div class="dps-float w-28 h-28 rounded-[2rem] bg-gradient-to-br from-cyan-400 via-blue-600 to-violet-700 flex items-center justify-center text-5xl shadow-2xl">
                        💓
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Latest BMI</p>
                    <h2 class="mt-2 text-4xl font-black text-white">
                        {{ $latestRecord?->bmi ?? '--' }}
                    </h2>
                    <p class="mt-2 text-cyan-300 text-sm font-bold">Body Mass Index</p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Blood Pressure</p>
                    <h2 class="mt-2 text-4xl font-black text-white">
                        {{ $latestRecord?->blood_pressure ?? '--' }}
                    </h2>
                    <p class="mt-2 text-emerald-300 text-sm font-bold">Latest BP</p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Sugar Level</p>
                    <h2 class="mt-2 text-4xl font-black text-white">
                        {{ $latestRecord?->sugar_level ?? '--' }}
                    </h2>
                    <p class="mt-2 text-amber-300 text-sm font-bold">mg/dL</p>
                </div>

                <div class="dps-card rounded-[2rem] p-6">
                    <p class="text-slate-400 text-sm font-bold">Oxygen Level</p>
                    <h2 class="mt-2 text-4xl font-black text-white">
                        {{ $latestRecord?->oxygen_level ?? '--' }}@if($latestRecord?->oxygen_level)%@endif
                    </h2>
                    <p class="mt-2 text-violet-300 text-sm font-bold">SpO₂</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                                <div class="lg:col-span-2 space-y-5">
                    @forelse($records as $record)
                        <div class="dps-card rounded-[2rem] p-6">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                <div>
                                    <p class="text-sm text-slate-400 font-bold">
                                        {{ $record->familyMember?->name ?? 'My Own Profile' }}
                                    </p>

                                    <h2 class="mt-2 text-2xl font-black text-white">
                                        Health Record
                                    </h2>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Added {{ $record->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('user.health-records.show', $record) }}"
                                       class="px-4 py-2 rounded-2xl bg-cyan-500/15 border border-cyan-300/20 text-cyan-100 font-black text-sm">
                                        View
                                    </a>

                                    <a href="{{ route('user.health-records.edit', $record) }}"
                                       class="px-4 py-2 rounded-2xl bg-amber-500/15 border border-amber-300/20 text-amber-100 font-black text-sm">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('user.health-records.destroy', $record) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Delete this health record?')"
                                            class="px-4 py-2 rounded-2xl bg-rose-500/15 border border-rose-300/20 text-rose-100 font-black text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="mt-5 grid md:grid-cols-4 gap-3">
                                <div class="dps-soft rounded-2xl p-4">
                                    <p class="text-xs text-slate-400 font-bold">BMI</p>
                                    <p class="mt-1 text-white font-black">{{ $record->bmi ?? '--' }}</p>
                                </div>

                                <div class="dps-soft rounded-2xl p-4">
                                    <p class="text-xs text-slate-400 font-bold">BP</p>
                                    <p class="mt-1 text-white font-black">{{ $record->blood_pressure ?? '--' }}</p>
                                </div>

                                <div class="dps-soft rounded-2xl p-4">
                                    <p class="text-xs text-slate-400 font-bold">Heart Rate</p>
                                    <p class="mt-1 text-white font-black">
                                        {{ $record->heart_rate ?? '--' }}@if($record->heart_rate) bpm @endif
                                    </p>
                                </div>

                                <div class="dps-soft rounded-2xl p-4">
                                    <p class="text-xs text-slate-400 font-bold">Sleep</p>
                                    <p class="mt-1 text-white font-black">
                                        {{ $record->sleep_hours ?? '--' }}@if($record->sleep_hours) hrs @endif
                                    </p>
                                </div>
                            </div>

                            @if($record->notes)
                                <div class="mt-5 dps-soft rounded-3xl p-5">
                                    <h3 class="text-white font-black">Notes</h3>
                                    <p class="mt-2 text-sm text-slate-300 whitespace-pre-line">
                                        {{ $record->notes }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="dps-card rounded-[2rem] p-12 text-center">
                            <div class="mx-auto w-20 h-20 rounded-3xl bg-cyan-400/10 border border-cyan-300/20 flex items-center justify-center text-4xl">
                                💓
                            </div>

                            <h2 class="mt-5 text-2xl font-black text-white">No Health Records Yet</h2>
                            <p class="mt-2 text-slate-400">
                                Add your first BMI, BP, sugar, oxygen, sleep, and hydration record.
                            </p>

                            <a href="{{ route('user.health-records.create') }}"
                               class="mt-6 inline-flex px-5 py-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-black shadow-xl">
                                Add First Record
                            </a>
                        </div>
                    @endforelse

                    <div class="mt-6">
                        {{ $records->links() }}
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-2xl font-black text-white">Health Summary</h3>

                        <div class="mt-5 space-y-3">
                            <div class="dps-soft rounded-3xl p-5">
                                <p class="text-slate-400 text-sm font-bold">Total Records</p>
                                <p class="mt-2 text-4xl font-black text-white">{{ $records->total() }}</p>
                            </div>

                            <div class="dps-soft rounded-3xl p-5">
                                <p class="text-slate-400 text-sm font-bold">Latest Heart Rate</p>
                                <p class="mt-2 text-3xl font-black text-rose-300">
                                    {{ $latestRecord?->heart_rate ?? '--' }}
                                    @if($latestRecord?->heart_rate) bpm @endif
                                </p>
                            </div>

                            <div class="dps-soft rounded-3xl p-5">
                                <p class="text-slate-400 text-sm font-bold">Water Intake</p>
                                <p class="mt-2 text-3xl font-black text-cyan-300">
                                    {{ $latestRecord?->water_intake_ml ?? '--' }}
                                    @if($latestRecord?->water_intake_ml) ml @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-xl font-black text-white">Next Premium Upgrade</h3>
                        <p class="mt-3 text-sm text-slate-300 leading-6">
                            এই data দিয়ে পরে AI health insight, progress tracking,
                            worsening/improvement detection, and graph analysis add করা যাবে।
                        </p>

                        <a href="{{ route('user.health-records.create') }}"
                           class="mt-5 inline-flex w-full justify-center rounded-2xl py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-black">
                            Add New Health Record
                        </a>
                    </div>

                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-xl font-black text-white">Medical Disclaimer</h3>
                        <p class="mt-3 text-sm text-rose-100/80 leading-6">
                            Health record tracking is for personal monitoring only.
                            Abnormal BP, sugar, oxygen, or heart rate should be reviewed by a certified doctor.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>