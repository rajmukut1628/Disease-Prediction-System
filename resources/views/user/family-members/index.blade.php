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
                            <span class="text-sm font-black text-cyan-100">Family Health Profile</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            Family Health
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                                Members
                            </span>
                        </h1>

                        <p class="mt-4 text-slate-300 max-w-2xl">
                            Manage multiple family profiles under one account and run AI symptom,
                            risk, and report analysis separately for each member.
                        </p>

                        <div class="mt-6">
                            <a href="{{ route('user.family-members.create') }}"
                               class="inline-flex px-5 py-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-black shadow-xl hover:scale-[1.02] transition">
                                Add Family Member
                            </a>
                        </div>
                    </div>

                    <div class="w-28 h-28 rounded-[2rem] bg-gradient-to-br from-cyan-400 via-blue-600 to-violet-700 flex items-center justify-center text-5xl shadow-2xl">
                        👨‍👩‍👧‍👦
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($familyMembers as $member)
                    <div class="dps-card rounded-[2rem] p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-cyan-400 to-violet-600 flex items-center justify-center text-white text-2xl font-black">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>

                                <div>
                                    <h2 class="text-xl font-black text-white">{{ $member->name }}</h2>
                                    <p class="text-sm text-cyan-300 font-bold">
                                        {{ $member->relation ?? 'Family Member' }}
                                    </p>
                                </div>
                            </div>

                            <span class="px-3 py-1 rounded-full bg-white/10 border border-white/10 text-slate-300 text-xs font-black">
                                {{ $member->age ? $member->age.' yrs' : 'Age N/A' }}
                            </span>
                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-3">
                            <div class="dps-soft rounded-2xl p-4">
                                <p class="text-xs text-slate-400 font-bold">Gender</p>
                                <p class="mt-1 text-white font-black capitalize">{{ $member->gender ?? 'N/A' }}</p>
                            </div>

                            <div class="dps-soft rounded-2xl p-4">
                                <p class="text-xs text-slate-400 font-bold">Blood Group</p>
                                <p class="mt-1 text-white font-black">{{ $member->blood_group ?? 'N/A' }}</p>
                            </div>

                            <div class="dps-soft rounded-2xl p-4">
                                <p class="text-xs text-slate-400 font-bold">Height</p>
                                <p class="mt-1 text-white font-black">{{ $member->height_cm ?? '--' }} cm</p>
                            </div>

                            <div class="dps-soft rounded-2xl p-4">
                                <p class="text-xs text-slate-400 font-bold">Weight</p>
                                <p class="mt-1 text-white font-black">{{ $member->weight_kg ?? '--' }} kg</p>
                            </div>
                        </div>

                        <div class="mt-5 flex flex-wrap gap-3">
                            <a href="{{ route('user.family-members.show', $member) }}"
                               class="px-4 py-2 rounded-2xl bg-cyan-500/15 border border-cyan-300/20 text-cyan-100 font-black text-sm hover:bg-cyan-500/25 transition">
                                View
                            </a>

                            <a href="{{ route('user.family-members.edit', $member) }}"
                               class="px-4 py-2 rounded-2xl bg-amber-500/15 border border-amber-300/20 text-amber-100 font-black text-sm hover:bg-amber-500/25 transition">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('user.family-members.destroy', $member) }}">
                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Delete this family member?')"
                                    class="px-4 py-2 rounded-2xl bg-rose-500/15 border border-rose-300/20 text-rose-100 font-black text-sm hover:bg-rose-500/25 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 xl:col-span-3 dps-card rounded-[2rem] p-12 text-center">
                        <div class="mx-auto w-20 h-20 rounded-3xl bg-cyan-400/10 border border-cyan-300/20 flex items-center justify-center text-4xl">
                            👨‍👩‍👧‍👦
                        </div>

                        <h2 class="mt-5 text-2xl font-black text-white">No Family Members Yet</h2>
                        <p class="mt-2 text-slate-400">
                            Add your first family profile and manage their health records separately.
                        </p>

                        <a href="{{ route('user.family-members.create') }}"
                           class="mt-6 inline-flex px-5 py-3 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-black shadow-xl hover:scale-[1.02] transition">
                            Add First Member
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $familyMembers->links() }}
            </div>

        </div>
    </div>
</x-app-layout>