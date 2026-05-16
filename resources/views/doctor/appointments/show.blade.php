@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-950 text-white px-4 py-8">
    <div class="max-w-6xl mx-auto">

        @php
            $statusClasses = [
                'pending' => 'bg-yellow-400/15 text-yellow-200 border-yellow-400/30',
                'approved' => 'bg-emerald-400/15 text-emerald-200 border-emerald-400/30',
                'rejected' => 'bg-red-400/15 text-red-200 border-red-400/30',
                'completed' => 'bg-blue-400/15 text-blue-200 border-blue-400/30',
            ];
        @endphp

        <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <p class="text-sm text-purple-300 font-semibold uppercase tracking-[0.25em]">
                    Appointment Review
                </p>
                <h1 class="text-3xl md:text-5xl font-black mt-2">
                    Patient Appointment Details
                </h1>
                <p class="text-slate-400 mt-3">
                    Review patient information, approve or reject request, and complete appointment after consultation.
                </p>
            </div>

            <span class="w-fit rounded-full border px-5 py-2 text-sm font-black uppercase {{ $statusClasses[$appointment->status] ?? 'bg-slate-400/15 text-slate-200 border-slate-400/30' }}">
                {{ $appointment->status }}
            </span>
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

        <div class="grid lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2">
                <div class="rounded-[2rem] border border-white/10 bg-white/10 backdrop-blur-xl p-6 md:p-8 shadow-2xl">
                    <h2 class="text-2xl font-black mb-5">
                        Appointment Information
                    </h2>

                    <div class="grid md:grid-cols-2 gap-5">
                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-5">
                            <p class="text-slate-500 text-sm">Patient Name</p>
                            <p class="mt-1 font-black text-lg">
                                {{ $appointment->patient_name }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-5">
                            <p class="text-slate-500 text-sm">Phone Number</p>
                            <p class="mt-1 font-black text-lg">
                                {{ $appointment->patient_phone }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-5">
                            <p class="text-slate-500 text-sm">Date</p>
                            <p class="mt-1 font-black text-lg">
                                {{ $appointment->appointment_date?->format('d M Y') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-5">
                            <p class="text-slate-500 text-sm">Time</p>
                            <p class="mt-1 font-black text-lg">
                                {{ $appointment->formattedTime() }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 rounded-2xl bg-slate-900/70 border border-white/10 p-5">
                        <p class="text-slate-500 text-sm">Problem Description</p>
                        <p class="mt-2 text-slate-200 leading-relaxed">
                            {{ $appointment->problem_description ?: 'No problem description provided.' }}
                        </p>
                    </div>

                    @if($appointment->reject_reason)
                        <div class="mt-5 rounded-2xl border border-red-400/20 bg-red-400/10 p-5">
                            <p class="text-red-200 text-sm font-bold">Reject / Cancel Reason</p>
                            <p class="mt-2 text-red-50 leading-relaxed">
                                {{ $appointment->reject_reason }}
                            </p>
                        </div>
                    @endif

                    @if($appointment->doctor_note)
                        <div class="mt-5 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 p-5">
                            <p class="text-emerald-200 text-sm font-bold">Doctor Note</p>
                            <p class="mt-2 text-emerald-50 leading-relaxed">
                                {{ $appointment->doctor_note }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="rounded-[2rem] border border-white/10 bg-white/10 backdrop-blur-xl p-6 shadow-2xl sticky top-6">
                    <h2 class="text-2xl font-black">
                        Action Panel
                    </h2>

                    <p class="text-slate-400 mt-2 text-sm">
                        Update this appointment status safely.
                    </p>

                    <div class="mt-6 space-y-4">

                        @if($appointment->status === 'pending')
                            <form method="POST" action="{{ route('doctor.appointments.approve', $appointment) }}">
                                @csrf
                                @method('PATCH')

                                <button class="w-full rounded-2xl bg-emerald-500/20 border border-emerald-400/30 px-5 py-3 font-black text-emerald-200 hover:bg-emerald-500/30 transition">
                                    Approve Appointment
                                </button>
                            </form>

                            <form method="POST" action="{{ route('doctor.appointments.reject', $appointment) }}">
                                @csrf
                                @method('PATCH')

                                <textarea name="reject_reason"
                                          rows="4"
                                          class="w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white focus:border-red-400 focus:ring-red-400"
                                          placeholder="Write rejection reason..."
                                          required></textarea>

                                @error('reject_reason')
                                    <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                                @enderror

                                <button class="mt-3 w-full rounded-2xl bg-red-500/20 border border-red-400/30 px-5 py-3 font-black text-red-200 hover:bg-red-500/30 transition">
                                    Reject Appointment
                                </button>
                            </form>
                        @endif

                        @if($appointment->status === 'approved')
                            <form method="POST" action="{{ route('doctor.appointments.complete', $appointment) }}">
                                @csrf
                                @method('PATCH')

                                <textarea name="doctor_note"
                                          rows="5"
                                          class="w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white focus:border-blue-400 focus:ring-blue-400"
                                          placeholder="Write doctor note / consultation summary..."></textarea>

                                @error('doctor_note')
                                    <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                                @enderror

                                <button class="mt-3 w-full rounded-2xl bg-blue-500/20 border border-blue-400/30 px-5 py-3 font-black text-blue-200 hover:bg-blue-500/30 transition">
                                    Mark as Completed
                                </button>
                            </form>
                        @endif

                        @if(in_array($appointment->status, ['rejected', 'completed']))
                            <div class="rounded-2xl border border-white/10 bg-slate-900/70 p-5 text-center">
                                <p class="text-slate-300 font-bold">
                                    No further action needed.
                                </p>
                            </div>
                        @endif

                        <a href="{{ route('doctor.appointments.index') }}"
                           class="block w-full rounded-2xl border border-white/10 px-5 py-3 text-center font-bold text-slate-300 hover:bg-white/10 transition">
                            Back to List
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection