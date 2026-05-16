<x-app-layout>
    <style>
        @keyframes dpsLiveShadow {
            0%,100% { box-shadow: 0 25px 80px rgba(239,68,68,.18), 0 0 55px rgba(99,102,241,.20); }
            50% { box-shadow: 0 35px 115px rgba(34,211,238,.20), 0 0 90px rgba(244,63,94,.30); }
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
        <div class="max-w-7xl mx-auto">

            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-300/20 bg-emerald-400/10 px-5 py-4 text-emerald-100 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="dps-card rounded-[2rem] p-7 md:p-9 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-rose-500/10 border border-rose-300/20 mb-5">
                            <span class="w-2 h-2 rounded-full bg-rose-400 animate-pulse"></span>
                            <span class="text-sm font-black text-rose-100">Emergency Alert System</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            Emergency
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-300 via-cyan-300 to-violet-300">
                                Contacts
                            </span>
                        </h1>

                        <p class="mt-4 text-slate-300 max-w-2xl">
                            Save trusted family or doctor contacts for high-risk predictions, emergency warning,
                            critical report findings, and urgent health alerts.
                        </p>

                        <div class="mt-6">
                            <a href="{{ route('user.emergency-contacts.create') }}"
                               class="inline-flex px-5 py-3 rounded-2xl bg-gradient-to-r from-rose-500 to-red-600 text-white font-black shadow-xl hover:scale-[1.02] transition">
                                Add Emergency Contact
                            </a>
                        </div>
                    </div>

                    <div class="w-28 h-28 rounded-[2rem] bg-gradient-to-br from-rose-500 via-red-600 to-violet-700 flex items-center justify-center text-5xl shadow-2xl">
                        🚨
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($contacts as $contact)
                    <div class="dps-card rounded-[2rem] p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-rose-500 to-violet-600 flex items-center justify-center text-white text-2xl font-black">
                                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                                </div>

                                <div>
                                    <h2 class="text-xl font-black text-white">{{ $contact->name }}</h2>
                                    <p class="text-sm text-rose-300 font-bold">
                                        {{ $contact->relation ?? 'Emergency Contact' }}
                                    </p>
                                </div>
                            </div>

                            @if($contact->is_primary)
                                <span class="px-3 py-1 rounded-full bg-emerald-400/10 border border-emerald-300/20 text-emerald-200 text-xs font-black">
                                    Primary
                                </span>
                            @endif
                        </div>

                        <div class="mt-5 space-y-3">
                            <div class="dps-soft rounded-2xl p-4">
                                <p class="text-xs text-slate-400 font-bold">Phone</p>
                                <p class="mt-1 text-white font-black">{{ $contact->phone }}</p>
                            </div>

                            <div class="dps-soft rounded-2xl p-4">
                                <p class="text-xs text-slate-400 font-bold">Email</p>
                                <p class="mt-1 text-white font-black">{{ $contact->email ?? 'N/A' }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="dps-soft rounded-2xl p-4">
                                    <p class="text-xs text-slate-400 font-bold">SMS Alert</p>
                                    <p class="mt-1 font-black {{ $contact->notify_by_sms ? 'text-emerald-300' : 'text-slate-400' }}">
                                        {{ $contact->notify_by_sms ? 'Enabled' : 'Disabled' }}
                                    </p>
                                </div>

                                <div class="dps-soft rounded-2xl p-4">
                                    <p class="text-xs text-slate-400 font-bold">Email Alert</p>
                                    <p class="mt-1 font-black {{ $contact->notify_by_email ? 'text-emerald-300' : 'text-slate-400' }}">
                                        {{ $contact->notify_by_email ? 'Enabled' : 'Disabled' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 flex flex-wrap gap-3">
                            <a href="{{ route('user.emergency-contacts.show', $contact) }}"
                               class="px-4 py-2 rounded-2xl bg-cyan-500/15 border border-cyan-300/20 text-cyan-100 font-black text-sm">
                                View
                            </a>

                            <a href="{{ route('user.emergency-contacts.edit', $contact) }}"
                               class="px-4 py-2 rounded-2xl bg-amber-500/15 border border-amber-300/20 text-amber-100 font-black text-sm">
                                Edit
                            </a>

                            <form method="POST" action="{{ route('user.emergency-contacts.destroy', $contact) }}">
                                @csrf
                                @method('DELETE')

                                <button onclick="return confirm('Delete this emergency contact?')"
                                    class="px-4 py-2 rounded-2xl bg-rose-500/15 border border-rose-300/20 text-rose-100 font-black text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 xl:col-span-3 dps-card rounded-[2rem] p-12 text-center">
                        <div class="mx-auto w-20 h-20 rounded-3xl bg-rose-500/10 border border-rose-300/20 flex items-center justify-center text-4xl">
                            🚨
                        </div>

                        <h2 class="mt-5 text-2xl font-black text-white">No Emergency Contacts Yet</h2>
                        <p class="mt-2 text-slate-400">
                            Add a trusted family member or doctor contact for high-risk alert readiness.
                        </p>

                        <a href="{{ route('user.emergency-contacts.create') }}"
                           class="mt-6 inline-flex px-5 py-3 rounded-2xl bg-gradient-to-r from-rose-500 to-red-600 text-white font-black shadow-xl">
                            Add First Contact
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $contacts->links() }}
            </div>

        </div>
    </div>
</x-app-layout>