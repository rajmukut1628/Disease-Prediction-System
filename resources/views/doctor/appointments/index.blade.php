@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-950 text-white px-4 py-8">
    <div class="max-w-7xl mx-auto">

        <div class="mb-8">
            <p class="text-sm text-purple-300 font-semibold uppercase tracking-[0.25em]">
                Doctor Panel
            </p>
            <h1 class="text-3xl md:text-5xl font-black mt-2">
                Appointment Management
            </h1>
            <p class="text-slate-400 mt-3">
                Manage patient requests, approve appointments, reject requests, and complete consultations.
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 px-5 py-4 text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 rounded-2xl border border-red-400/30 bg-red-500/10 px-5 py-4 text-red-200">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid md:grid-cols-4 gap-4 mb-8">
            @php
                $total = $appointments->total();
                $pending = $appointments->where('status', 'pending')->count();
                $approved = $appointments->where('status', 'approved')->count();
                $completed = $appointments->where('status', 'completed')->count();
            @endphp

            <div class="rounded-3xl border border-white/10 bg-white/10 p-5 shadow-xl">
                <p class="text-slate-400 text-sm">Total</p>
                <p class="text-3xl font-black mt-1">{{ $total }}</p>
            </div>

            <div class="rounded-3xl border border-yellow-400/20 bg-yellow-400/10 p-5 shadow-xl">
                <p class="text-yellow-200 text-sm">Pending</p>
                <p class="text-3xl font-black mt-1">{{ $pending }}</p>
            </div>

            <div class="rounded-3xl border border-emerald-400/20 bg-emerald-400/10 p-5 shadow-xl">
                <p class="text-emerald-200 text-sm">Approved</p>
                <p class="text-3xl font-black mt-1">{{ $approved }}</p>
            </div>

            <div class="rounded-3xl border border-blue-400/20 bg-blue-400/10 p-5 shadow-xl">
                <p class="text-blue-200 text-sm">Completed</p>
                <p class="text-3xl font-black mt-1">{{ $completed }}</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-5">
            @forelse($appointments as $appointment)
                @php
                    $statusClasses = [
                        'pending' => 'bg-yellow-400/15 text-yellow-200 border-yellow-400/30',
                        'approved' => 'bg-emerald-400/15 text-emerald-200 border-emerald-400/30',
                        'rejected' => 'bg-red-400/15 text-red-200 border-red-400/30',
                        'completed' => 'bg-blue-400/15 text-blue-200 border-blue-400/30',
                    ];
                @endphp

                <div class="rounded-[2rem] border border-white/10 bg-white/10 backdrop-blur-xl p-6 shadow-2xl hover:-translate-y-1 transition">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-black">
                                {{ $appointment->patient_name }}
                            </h2>
                            <p class="text-slate-400 mt-1">
                                {{ $appointment->patient_phone }}
                            </p>
                        </div>

                        <span class="rounded-full border px-4 py-1 text-xs font-black uppercase {{ $statusClasses[$appointment->status] ?? 'bg-slate-400/15 text-slate-200 border-slate-400/30' }}">
                            {{ $appointment->status }}
                        </span>
                    </div>

                    <div class="grid md:grid-cols-2 gap-3 mt-5">
                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-4">
                            <p class="text-slate-500 text-sm">Date</p>
                            <p class="font-black">
                                {{ $appointment->appointment_date?->format('d M Y') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-4">
                            <p class="text-slate-500 text-sm">Time</p>
                            <p class="font-black">
                                {{ $appointment->formattedTime() }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 rounded-2xl bg-slate-900/70 border border-white/10 p-4">
                        <p class="text-slate-500 text-sm">Problem</p>
                        <p class="mt-1 text-slate-300 line-clamp-2">
                            {{ $appointment->problem_description ?: 'No problem description provided.' }}
                        </p>
                    </div>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('doctor.appointments.show', $appointment) }}"
                           class="rounded-xl bg-cyan-400/15 px-4 py-2 text-sm font-bold text-cyan-200 hover:bg-cyan-400/25 transition">
                            View Details
                        </a>

                        @if($appointment->status === 'pending')
                            <form method="POST" action="{{ route('doctor.appointments.approve', $appointment) }}">
                                @csrf
                                @method('PATCH')

                                <button class="rounded-xl bg-emerald-400/15 px-4 py-2 text-sm font-bold text-emerald-200 hover:bg-emerald-400/25 transition">
                                    Approve
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="lg:col-span-2 rounded-[2rem] border border-white/10 bg-white/10 p-12 text-center">
                    <div class="mx-auto h-20 w-20 rounded-3xl bg-purple-400/10 flex items-center justify-center text-4xl">
                        🩺
                    </div>
                    <h3 class="mt-5 text-2xl font-black">
                        No appointment requests yet
                    </h3>
                    <p class="mt-2 text-slate-400">
                        Patient appointment requests will appear here.
                    </p>
                </div>
            @endforelse
        </div>

        @if($appointments->hasPages())
            <div class="mt-8 rounded-2xl border border-white/10 bg-white/10 px-6 py-4">
                {{ $appointments->links() }}
            </div>
        @endif

    </div>
</div>
@endsection