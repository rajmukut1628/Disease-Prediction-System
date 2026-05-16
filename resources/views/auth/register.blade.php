<x-guest-layout>
    <style>
        @keyframes dpsFloat {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-18px) scale(1.03); }
        }

        @keyframes dpsGlow {
            0%, 100% {
                box-shadow:
                    0 0 25px rgba(34, 211, 238, .35),
                    0 0 65px rgba(79, 70, 229, .25),
                    inset 0 0 25px rgba(255,255,255,.08);
            }
            50% {
                box-shadow:
                    0 0 45px rgba(16, 185, 129, .45),
                    0 0 95px rgba(59, 130, 246, .35),
                    inset 0 0 35px rgba(255,255,255,.12);
            }
        }

        @keyframes dpsBorder {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .dps-bg {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(14,165,233,.35), transparent 34%),
                radial-gradient(circle at top right, rgba(168,85,247,.32), transparent 35%),
                radial-gradient(circle at bottom left, rgba(16,185,129,.28), transparent 34%),
                linear-gradient(135deg, #020617 0%, #0f172a 45%, #020617 100%);
            overflow: hidden;
            position: relative;
        }

        .dps-orb {
            position: absolute;
            border-radius: 9999px;
            filter: blur(2px);
            opacity: .75;
            animation: dpsFloat 8s ease-in-out infinite;
        }

        .dps-card-wrap {
            position: relative;
            padding: 2px;
            border-radius: 32px;
            background: linear-gradient(120deg, #22d3ee, #6366f1, #a855f7, #10b981, #22d3ee);
            background-size: 300% 300%;
            animation: dpsBorder 7s ease infinite;
        }

        .dps-card {
            border-radius: 30px;
            background: rgba(15, 23, 42, .82);
            backdrop-filter: blur(26px);
            border: 1px solid rgba(255,255,255,.12);
            animation: dpsGlow 5s ease-in-out infinite;
        }

        .dps-input {
            width: 100%;
            border-radius: 18px;
            border: 1px solid rgba(148,163,184,.28);
            background: rgba(15,23,42,.75);
            color: white;
            padding: 13px 16px;
            outline: none;
            transition: .25s;
        }

        .dps-input:focus {
            border-color: rgba(34,211,238,.8);
            box-shadow: 0 0 0 4px rgba(34,211,238,.15);
        }

        .dps-label {
            color: rgba(226,232,240,.92);
            font-weight: 800;
            font-size: 13px;
            letter-spacing: .04em;
        }

        .dps-btn {
            background: linear-gradient(135deg, #06b6d4, #4f46e5, #9333ea);
            box-shadow: 0 18px 40px rgba(79,70,229,.38);
            transition: .25s;
        }

        .dps-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 55px rgba(34,211,238,.42);
        }
    </style>

    <div class="dps-bg flex items-center justify-center px-5 py-10">
        <div class="dps-orb w-40 h-40 bg-cyan-400/25 top-10 left-10"></div>
        <div class="dps-orb w-52 h-52 bg-violet-500/25 bottom-10 right-10" style="animation-delay:1.5s"></div>
        <div class="dps-orb w-28 h-28 bg-emerald-400/20 top-1/2 left-1/4" style="animation-delay:3s"></div>

        <div class="w-full max-w-6xl grid lg:grid-cols-2 gap-8 items-center relative z-10">
            <div class="hidden lg:block text-white">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-sm font-bold text-cyan-100">AI Disease Prediction System</span>
                </div>

                <h1 class="text-5xl font-black leading-tight">
                    Create your
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                        Smart Health Account
                    </span>
                </h1>

                <p class="mt-5 text-slate-300 text-lg leading-8">
                    AI symptom checker, risk prediction, report analysis, encrypted medical vault,
                    doctor recommendation and premium health dashboard.
                </p>

                <div class="mt-8 grid grid-cols-2 gap-4">
                    <div class="rounded-3xl bg-white/10 border border-white/10 p-5">
                        <p class="text-3xl font-black text-cyan-300">24/7</p>
                        <p class="text-sm text-slate-300 mt-1">AI Health Assistant</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 border border-white/10 p-5">
                        <p class="text-3xl font-black text-emerald-300">Secure</p>
                        <p class="text-sm text-slate-300 mt-1">Medical History Vault</p>
                    </div>
                </div>
            </div>

            <div class="dps-card-wrap">
                <div class="dps-card p-7 md:p-9">
                    <div class="text-center mb-7">
                        <div class="mx-auto w-16 h-16 rounded-3xl bg-gradient-to-br from-cyan-400 to-violet-600 flex items-center justify-center shadow-2xl">
                            <span class="text-3xl">🧬</span>
                        </div>

                        <h2 class="mt-4 text-3xl font-black text-white">Create Account</h2>
                        <p class="mt-2 text-sm text-slate-300">
                            Choose patient or doctor account type
                        </p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="role" class="dps-label">ACCOUNT TYPE</label>
                            <select id="role" name="role" class="dps-input mt-2" required>
                                <option class="text-slate-900" value="user" @selected(old('role') === 'user')>
                                    User / Patient
                                </option>
                                <option class="text-slate-900" value="doctor" @selected(old('role') === 'doctor')>
                                    Doctor
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <div>
                            <label for="name" class="dps-label">FULL NAME</label>
                            <input id="name" class="dps-input mt-2" type="text" name="name"
                                   value="{{ old('name') }}" required autofocus autocomplete="name"
                                   placeholder="Enter your full name">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <label for="email" class="dps-label">EMAIL ADDRESS</label>
                            <input id="email" class="dps-input mt-2" type="email" name="email"
                                   value="{{ old('email') }}" required autocomplete="username"
                                   placeholder="example@email.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <label for="phone" class="dps-label">PHONE NUMBER</label>
                            <input id="phone" class="dps-input mt-2" type="text" name="phone"
                                   value="{{ old('phone') }}" placeholder="+8801XXXXXXXXX">
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="dps-label">PASSWORD</label>
                                <input id="password" class="dps-input mt-2" type="password" name="password"
                                       required autocomplete="new-password" placeholder="••••••••">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password_confirmation" class="dps-label">CONFIRM PASSWORD</label>
                                <input id="password_confirmation" class="dps-input mt-2" type="password"
                                       name="password_confirmation" required autocomplete="new-password"
                                       placeholder="••••••••">
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div id="doctorNote" class="hidden rounded-3xl border border-amber-300/20 bg-amber-400/10 p-4 text-sm text-amber-100">
                            Doctor account admin approval ছাড়া active হবে না।
                        </div>

                        <button type="submit" class="dps-btn w-full rounded-2xl py-4 text-white font-black tracking-wide">
                            Create Smart Health Account
                        </button>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-sm font-bold text-cyan-300 hover:text-cyan-200">
                                Already registered? Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const roleSelect = document.getElementById('role');
        const doctorNote = document.getElementById('doctorNote');

        function toggleDoctorNote() {
            if (roleSelect.value === 'doctor') {
                doctorNote.classList.remove('hidden');
            } else {
                doctorNote.classList.add('hidden');
            }
        }

        roleSelect.addEventListener('change', toggleDoctorNote);
        toggleDoctorNote();
    </script>
</x-guest-layout>