@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-950 text-white px-4 py-8">
    <div class="max-w-7xl mx-auto">

        <div class="mb-8">
            <p class="text-sm text-cyan-300 font-semibold uppercase tracking-[0.25em]">
                My Appointments
            </p>
            <h1 class="text-3xl md:text-5xl font-black mt-2">
                Appointment History
            </h1>
            <p class="text-slate-400 mt-3">
                Track your doctor appointment requests, approval status, and medical notes.
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

        <div class="rounded-[2rem] border border-white/10 bg-white/10 backdrop-blur-xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white/10 text-slate-300 text-sm uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Doctor</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Time</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10">
                        @forelse($appointments as $appointment)
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-400/15 text-yellow-200 border-yellow-400/30',
                                    'approved' => 'bg-emerald-400/15 text-emerald-200 border-emerald-400/30',
                                    'rejected' => 'bg-red-400/15 text-red-200 border-red-400/30',
                                    'completed' => 'bg-blue-400/15 text-blue-200 border-blue-400/30',
                                ];
                            @endphp

                            <tr class="hover:bg-white/5 transition">
                                <td class="px-6 py-5">
                                    <p class="font-black text-white">
                                        {{ $appointment->doctor->name ?? 'Doctor removed' }}
                                    </p>
                                    <p class="text-sm text-cyan-300">
                                        {{ $appointment->doctor->specialization ?? $appointment->doctor->specialist ?? 'Specialist' }}
                                    </p>
                                </td>

                                <td class="px-6 py-5 text-slate-300">
                                    {{ $appointment->appointment_date?->format('d M Y') }}
                                </td>

                                <td class="px-6 py-5 text-slate-300">
                                    {{ $appointment->formattedTime() }}
                                </td>

                                <td class="px-6 py-5">
                                    <span class="inline-flex rounded-full border px-4 py-1 text-xs font-black uppercase {{ $statusClasses[$appointment->status] ?? 'bg-slate-400/15 text-slate-200 border-slate-400/30' }}">
                                        {{ $appointment->status }}
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('user.appointments.show', $appointment) }}"
                                           class="rounded-xl bg-cyan-400/15 px-4 py-2 text-sm font-bold text-cyan-200 hover:bg-cyan-400/25 transition">
                                            View
                                        </a>

                                        @if(in_array($appointment->status, ['pending', 'approved']))
                                            <form method="POST"
                                                  action="{{ route('user.appointments.cancel', $appointment) }}"
                                                  onsubmit="return confirm('Are you sure you want to cancel this appointment?')">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                        class="rounded-xl bg-red-400/15 px-4 py-2 text-sm font-bold text-red-200 hover:bg-red-400/25 transition">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="mx-auto max-w-md">
                                        <div class="mx-auto h-20 w-20 rounded-3xl bg-cyan-400/10 flex items-center justify-center text-4xl">
                                            📅
                                        </div>
                                        <h3 class="mt-5 text-2xl font-black">
                                            No appointments yet
                                        </h3>
                                        <p class="mt-2 text-slate-400">
                                            Start by finding a doctor and submitting your first appointment request.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($appointments->hasPages())
                <div class="border-t border-white/10 px-6 py-4">
                    {{ $appointments->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection