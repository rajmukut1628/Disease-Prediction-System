<x-app-layout>
    <style>
        @keyframes dpsLiveShadow {
            0%,100% {
                box-shadow: 0 25px 80px rgba(239,68,68,.18),
                            0 0 55px rgba(99,102,241,.20);
            }
            50% {
                box-shadow: 0 35px 115px rgba(34,211,238,.20),
                            0 0 90px rgba(244,63,94,.30);
            }
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

        .dps-input {
            width: 100%;
            border-radius: 1.25rem;
            border: 1px solid rgba(148,163,184,.28);
            background: rgba(15,23,42,.75);
            color: white;
            padding: 14px 16px;
            outline: none;
        }

        .dps-label {
            color: rgba(226,232,240,.95);
            font-weight: 900;
            font-size: 13px;
            letter-spacing: .04em;
        }

        .dps-soft {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.10);
        }
    </style>

    <div class="dps-page px-5 py-8">
        <div class="max-w-5xl mx-auto">
            <div class="dps-card rounded-[2rem] p-7 md:p-9">
                <div class="mb-8">
                    <h1 class="text-4xl font-black text-white">
                        Add Emergency Contact
                    </h1>

                    <p class="mt-3 text-slate-300">
                        Save trusted family members or doctors for emergency alert notifications.
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('user.emergency-contacts.store') }}"
                      class="space-y-6">
                    @csrf

                    @include('user.emergency-contacts._form')

                    <div class="flex flex-wrap gap-3">
                        <button type="submit"
                                class="px-6 py-3 rounded-2xl bg-gradient-to-r from-rose-500 to-red-600 text-white font-black shadow-xl">
                            Save Emergency Contact
                        </button>

                        <a href="{{ route('user.emergency-contacts.index') }}"
                           class="px-6 py-3 rounded-2xl bg-white/10 border border-white/10 text-white font-black">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>