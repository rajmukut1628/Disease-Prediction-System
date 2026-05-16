@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-950 text-white px-4 py-8">
    <div class="max-w-5xl mx-auto">

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
                <p class="text-sm text-cyan-300 font-semibold uppercase tracking-[0.25em]">
                    Appointment Details
                </p>
                <h1 class="text-3xl md:text-5xl font-black mt-2">
                    Appointment Request
                </h1>
                <p class="text-slate-400 mt-3">
                    Full details of your appointment request and doctor response.
                </p>
            </div>

            <span class="inline-flex w-fit rounded-full border px-5 py-2 text-sm font-black uppercase {{ $statusClasses[$appointment->status] ?? 'bg-slate-400/15 text-slate-200 border-slate-400/30' }}">
                {{ $appointment->status }}
            </span>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">

            <div class="lg:col-span-1">
                <div class="rounded-[2rem] border border-white/10 bg-white/10 backdrop-blur-xl p-6 shadow-2xl">
                    <div class="h-20 w-20 rounded-3xl bg-cyan-400/20 flex items-center justify-center text-3xl font-black text-cyan-200">
                        {{ strtoupper(substr($appointment->doctor->name ?? 'D', 0, 1)) }}
                    </div>

                    <h2 class="text-2xl font-black mt-5">
                        {{ $appointment->doctor->name ?? 'Doctor removed' }}
                    </h2>

                    <p class="text-cyan-300 font-semibold mt-1">
                        {{ $appointment->doctor->specialization ?? $appointment->doctor->specialist ?? 'Specialist Doctor' }}
                    </p>

                    <div class="mt-6 space-y-3">
                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-4">
                            <p class="text-slate-500 text-sm">Consultation Fee</p>
                            <p class="text-lg font-black">
                                ৳{{ $appointment->doctor->consultation_fee ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-4">
                            <p class="text-slate-500 text-sm">Chamber</p>
                            <p class="font-bold">
                                {{ $appointment->doctor->chamber_address ?? 'Not provided' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="rounded-[2rem] border border-white/10 bg-white/10 backdrop-blur-xl p-6 md:p-8 shadow-2xl">

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
                            {{ $appointment->problem_description ?: 'No description provided.' }}
                        </p>
                    </div>

                    @if($appointment->doctor_note)
                        <div class="mt-5 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 p-5">
                            <p class="text-emerald-200 text-sm font-bold">Doctor Note</p>
                            <p class="mt-2 text-emerald-50 leading-relaxed">
                                {{ $appointment->doctor_note }}
                            </p>
                        </div>
                    @endif

                    @if($appointment->reject_reason)
                        <div class="mt-5 rounded-2xl border border-red-400/20 bg-red-400/10 p-5">
                            <p class="text-red-200 text-sm font-bold">Reject / Cancel Reason</p>
                            <p class="mt-2 text-red-50 leading-relaxed">
                                {{ $appointment->reject_reason }}
                            </p>
                        </div>
                    @endif

                    <div class="mt-8 flex flex-col md:flex-row gap-4 md:justify-between">
                        <a href="{{ route('user.appointments.index') }}"
                           class="rounded-2xl border border-white/10 px-6 py-3 text-center font-bold text-slate-300 hover:bg-white/10 transition">
                            Back to Appointments
                        </a>

                        @if(in_array($appointment->status, ['pending', 'approved']))
                            <form method="POST"
                                  action="{{ route('user.appointments.cancel', $appointment) }}"
                                  onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="w-full md:w-auto rounded-2xl bg-red-500/20 border border-red-400/30 px-6 py-3 font-black text-red-200 hover:bg-red-500/30 transition">
                                    Cancel Appointment
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection