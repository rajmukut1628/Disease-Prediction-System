<x-app-layout>
    <style>
        @keyframes dpsLiveShadow {
            0%, 100% {
                box-shadow:
                    0 25px 80px rgba(34, 211, 238, .16),
                    0 0 40px rgba(99, 102, 241, .22);
            }
            50% {
                box-shadow:
                    0 35px 100px rgba(16, 185, 129, .20),
                    0 0 70px rgba(168, 85, 247, .28);
            }
        }

        @keyframes dpsMoveGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .dps-page {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(34,211,238,.18), transparent 28%),
                radial-gradient(circle at top right, rgba(168,85,247,.18), transparent 28%),
                linear-gradient(135deg, #020617, #0f172a 55%, #020617);
        }

        .dps-panel {
            background: rgba(15, 23, 42, .78);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.12);
            animation: dpsLiveShadow 5s ease-in-out infinite;
        }

        .dps-premium-border {
            background: linear-gradient(120deg, #22d3ee, #6366f1, #a855f7, #10b981, #22d3ee);
            background-size: 300% 300%;
            animation: dpsMoveGradient 8s ease infinite;
            padding: 1px;
            border-radius: 28px;
        }
    </style>

    <div class="dps-page px-5 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-sm font-black text-cyan-100">Admin Control Center</span>
                </div>

                <h1 class="mt-5 text-4xl md:text-5xl font-black text-white">
                    Pending Doctor
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                        Approvals
                    </span>
                </h1>

                <p class="mt-3 text-slate-300 max-w-2xl">
                    Review doctor registration requests and approve verified medical professionals.
                </p>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-300/20 bg-emerald-400/10 px-5 py-4 text-emerald-100 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid md:grid-cols-3 gap-5 mb-8">
                <div class="dps-panel rounded-3xl p-6">
                    <p class="text-slate-400 text-sm font-bold">Pending Requests</p>
                    <p class="mt-2 text-4xl font-black text-white">{{ $doctors->total() }}</p>
                </div>

                <div class="dps-panel rounded-3xl p-6">
                    <p class="text-slate-400 text-sm font-bold">Approval Mode</p>
                    <p class="mt-2 text-2xl font-black text-cyan-300">Manual Review</p>
                </div>

                <div class="dps-panel rounded-3xl p-6">
                    <p class="text-slate-400 text-sm font-bold">Security Layer</p>
                    <p class="mt-2 text-2xl font-black text-emerald-300">Role Protected</p>
                </div>
            </div>

            <div class="dps-premium-border">
                <div class="dps-panel rounded-[27px] overflow-hidden">
                    @if($doctors->count())
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-white/10 bg-white/5">
                                        <th class="px-6 py-4 text-left text-xs font-black text-slate-300 uppercase">Doctor</th>
                                        <th class="px-6 py-4 text-left text-xs font-black text-slate-300 uppercase">Specialist</th>
                                        <th class="px-6 py-4 text-left text-xs font-black text-slate-300 uppercase">Contact</th>
                                        <th class="px-6 py-4 text-left text-xs font-black text-slate-300 uppercase">Status</th>
                                        <th class="px-6 py-4 text-right text-xs font-black text-slate-300 uppercase">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-white/10">
                                    @foreach($doctors as $doctor)
                                        <tr class="hover:bg-white/5 transition">
                                            <td class="px-6 py-5">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-cyan-400 to-violet-600 flex items-center justify-center text-white font-black">
                                                        {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-white font-black">{{ $doctor->name }}</p>
                                                        <p class="text-slate-400 text-sm">{{ $doctor->email }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-6 py-5">
                                                <span class="inline-flex px-3 py-1 rounded-full bg-cyan-400/10 border border-cyan-300/20 text-cyan-200 text-sm font-bold">
                                                    {{ $doctor->specialist }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-5">
                                                <p class="text-slate-200 text-sm">{{ $doctor->phone ?? 'Not provided' }}</p>
                                            </td>

                                            <td class="px-6 py-5">
                                                <span class="inline-flex px-3 py-1 rounded-full bg-amber-400/10 border border-amber-300/20 text-amber-200 text-sm font-bold">
                                                    Pending
                                                </span>
                                            </td>

                                            <td class="px-6 py-5">
                                                <div class="flex justify-end gap-3">
                                                    <form method="POST" action="{{ route('admin.doctors.approve', $doctor) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="px-4 py-2 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-white font-black transition">
                                                            Approve
                                                        </button>
                                                    </form>

                                                    <form method="POST" action="{{ route('admin.doctors.reject', $doctor) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button onclick="return confirm('Reject this doctor?')"
                                                            class="px-4 py-2 rounded-2xl bg-rose-500 hover:bg-rose-400 text-white font-black transition">
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="px-6 py-5 border-t border-white/10">
                            {{ $doctors->links() }}
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <div class="mx-auto w-20 h-20 rounded-3xl bg-emerald-400/10 border border-emerald-300/20 flex items-center justify-center text-4xl">
                                ✅
                            </div>
                            <h2 class="mt-5 text-2xl font-black text-white">No Pending Doctors</h2>
                            <p class="mt-2 text-slate-400">All doctor requests are already reviewed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>