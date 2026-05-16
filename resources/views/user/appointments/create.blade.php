@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-950 text-white px-4 py-8">
    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="mb-8">
            <p class="text-sm text-cyan-300 font-semibold uppercase tracking-[0.25em]">
                Book Appointment
            </p>
            <h1 class="text-3xl md:text-5xl font-black mt-2">
                Request an appointment with
                <span class="text-cyan-300">{{ $doctor->name }}</span>
            </h1>
            <p class="text-slate-400 mt-3">
                Choose your preferred date and time. Doctor approval is required before confirmation.
            </p>
        </div>

        @if(session('error'))
            <div class="mb-6 rounded-2xl border border-red-400/30 bg-red-500/10 px-5 py-4 text-red-200">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Doctor Card --}}
            <div class="lg:col-span-1">
                <div class="rounded-[2rem] border border-white/10 bg-white/10 backdrop-blur-xl p-6 shadow-2xl">
                    <div class="h-20 w-20 rounded-3xl bg-cyan-400/20 flex items-center justify-center text-3xl font-black text-cyan-200">
                        {{ strtoupper(substr($doctor->name, 0, 1)) }}
                    </div>

                    <h2 class="text-2xl font-black mt-5">
                        {{ $doctor->name }}
                    </h2>

                    <p class="text-cyan-300 font-semibold mt-1">
                        {{ $doctor->specialization ?? $doctor->specialist ?? 'Specialist Doctor' }}
                    </p>

                    <div class="mt-6 space-y-3 text-sm text-slate-300">
                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-4">
                            <p class="text-slate-500">Consultation Fee</p>
                            <p class="text-lg font-black text-white">
                                ৳{{ $doctor->consultation_fee ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-4">
                            <p class="text-slate-500">Available Time</p>
                            <p class="font-bold text-white">
                                {{ $doctor->start_time ?? '10:00' }}
                                -
                                {{ $doctor->end_time ?? '18:00' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-900/70 border border-white/10 p-4">
                            <p class="text-slate-500">Chamber</p>
                            <p class="font-bold text-white">
                                {{ $doctor->chamber_address ?? 'Not provided' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Booking Form --}}
            <div class="lg:col-span-2">
                <form method="POST"
                      action="{{ route('user.appointments.store', $doctor) }}"
                      class="rounded-[2rem] border border-white/10 bg-white/10 backdrop-blur-xl p-6 md:p-8 shadow-2xl">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="text-sm font-bold text-slate-300">
                                Patient Name
                            </label>
                            <input type="text"
                                   name="patient_name"
                                   value="{{ old('patient_name', auth()->user()->name) }}"
                                   class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400"
                                   required>
                            @error('patient_name')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-bold text-slate-300">
                                Phone Number
                            </label>
                            <input type="text"
                                   name="patient_phone"
                                   value="{{ old('patient_phone', auth()->user()->phone ?? '') }}"
                                   class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400"
                                   required>
                            @error('patient_phone')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-bold text-slate-300">
                                Appointment Date
                            </label>
                            <input type="date"
                                   name="appointment_date"
                                   value="{{ old('appointment_date') }}"
                                   min="{{ now()->toDateString() }}"
                                   class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400"
                                   required>
                            @error('appointment_date')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm font-bold text-slate-300">
                                Appointment Time
                            </label>
                            <input type="time"
                                     name="appointment_time"
                                     value="{{ old('appointment_time') }}"
                                     step="300"
                                     min="08:00"
                                     max="22:00"
                                     class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400"
                                     required>
                            @error('appointment_time')
                                <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5">
                        <label class="text-sm font-bold text-slate-300">
                            Problem Description
                        </label>
                        <textarea name="problem_description"
                                  rows="5"
                                  class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white focus:border-cyan-400 focus:ring-cyan-400"
                                  placeholder="Write your symptoms or reason for appointment...">{{ old('problem_description') }}</textarea>
                        @error('problem_description')
                            <p class="text-red-300 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-8 flex flex-col md:flex-row gap-4 md:items-center md:justify-between">
                        <a href="{{ url()->previous() }}"
                           class="rounded-2xl border border-white/10 px-6 py-3 text-center font-bold text-slate-300 hover:bg-white/10 transition">
                            Back
                        </a>

                        <button type="submit"
                                class="rounded-2xl bg-gradient-to-r from-cyan-400 to-blue-500 px-8 py-3 font-black text-slate-950 shadow-lg shadow-cyan-500/30 hover:scale-[1.02] transition">
                            Submit Appointment Request
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection