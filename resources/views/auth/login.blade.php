<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'Disease Prediction System') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Figtree', sans-serif;
        }

        html,
        body {
            min-height: 100%;
            margin: 0;
            background: #020617;
            overflow-x: hidden;
        }

        @keyframes dpsFloat {
            0%, 100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-18px) scale(1.035);
            }
        }

        @keyframes dpsLiveShadow {
            0% {
                box-shadow:
                    0 0 35px rgba(34, 211, 238, .22),
                    0 0 90px rgba(59, 130, 246, .14);
            }

            25% {
                box-shadow:
                    0 0 48px rgba(168, 85, 247, .26),
                    0 0 110px rgba(34, 211, 238, .12);
            }

            50% {
                box-shadow:
                    0 0 60px rgba(16, 185, 129, .20),
                    0 0 130px rgba(99, 102, 241, .16);
            }

            75% {
                box-shadow:
                    0 0 48px rgba(236, 72, 153, .22),
                    0 0 110px rgba(14, 165, 233, .13);
            }

            100% {
                box-shadow:
                    0 0 35px rgba(34, 211, 238, .22),
                    0 0 90px rgba(59, 130, 246, .14);
            }
        }

        @keyframes dpsGradientText {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes dpsShine {
            0% {
                transform: translateX(-140%);
            }

            100% {
                transform: translateX(140%);
            }
        }

        @keyframes dpsScan {
            0% {
                transform: translateY(-130%);
                opacity: 0;
            }

            25% {
                opacity: .55;
            }

            100% {
                transform: translateY(520%);
                opacity: 0;
            }
        }

        @keyframes dpsBorderSpin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .dps-float {
            animation: dpsFloat 6s ease-in-out infinite;
        }

        .dps-float-delay {
            animation: dpsFloat 7s ease-in-out infinite;
            animation-delay: 1.2s;
        }

        .dps-float-slow {
            animation: dpsFloat 8s ease-in-out infinite;
            animation-delay: 2.2s;
        }

        .dps-live-shadow {
            animation: dpsLiveShadow 6s ease-in-out infinite;
        }

        .dps-gradient-text {
            background: linear-gradient(90deg, #67e8f9, #60a5fa, #a78bfa, #34d399);
            background-size: 280% 280%;
            animation: dpsGradientText 7s ease infinite;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .dps-login-grid {
            background-image:
                linear-gradient(rgba(255,255,255,.055) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.055) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: radial-gradient(circle at center, black, transparent 74%);
        }

        .dps-glass {
            background: linear-gradient(135deg, rgba(255,255,255,.12), rgba(255,255,255,.045));
            border: 1px solid rgba(255,255,255,.12);
            backdrop-filter: blur(26px);
        }

        .dps-scan::after {
            content: "";
            position: absolute;
            inset: 0;
            height: 22%;
            background: linear-gradient(to bottom, transparent, rgba(103,232,249,.16), transparent);
            animation: dpsScan 5s ease-in-out infinite;
            pointer-events: none;
        }

        .dps-btn-shine::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.45), transparent);
            transform: translateX(-140%);
        }

        .dps-btn-shine:hover::before {
            animation: dpsShine .8s ease;
        }

        .dps-premium-border::before {
            content: "";
            position: absolute;
            width: 180%;
            height: 180%;
            left: -40%;
            top: -40%;
            background: conic-gradient(
                from 90deg,
                transparent,
                rgba(103,232,249,.45),
                rgba(167,139,250,.40),
                rgba(52,211,153,.35),
                transparent
            );
            animation: dpsBorderSpin 8s linear infinite;
        }
    </style>
</head>

<body class="min-h-screen text-white antialiased">
    <div class="fixed inset-0 -z-50 bg-slate-950"></div>

    <div class="fixed inset-0 -z-40 bg-[radial-gradient(circle_at_top_left,rgba(34,211,238,0.20),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(168,85,247,0.20),transparent_35%),radial-gradient(circle_at_center,rgba(59,130,246,0.10),transparent_45%)]"></div>

    <div class="fixed inset-0 -z-30 opacity-45 dps-login-grid"></div>

    <div class="fixed -top-32 -left-32 h-96 w-96 rounded-full bg-cyan-400/20 blur-3xl dps-float"></div>
    <div class="fixed -bottom-32 -right-32 h-96 w-96 rounded-full bg-purple-500/20 blur-3xl dps-float-delay"></div>
    <div class="fixed left-1/2 top-1/3 h-80 w-80 rounded-full bg-emerald-400/10 blur-3xl dps-float-slow"></div>

    <main class="relative z-10 flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid w-full max-w-7xl items-center gap-8 xl:grid-cols-[1.15fr_.85fr]">

            {{-- Left Premium Branding --}}
            <section class="hidden xl:block">
                <div class="relative overflow-hidden rounded-[3.2rem] dps-glass p-10 2xl:p-12 dps-live-shadow">
                    <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-cyan-400/20 blur-3xl"></div>
                    <div class="absolute -left-24 -bottom-24 h-72 w-72 rounded-full bg-purple-400/20 blur-3xl"></div>

                    <div class="relative z-10">
                        <a href="{{ url('/') }}"
                           class="inline-flex items-center gap-3 rounded-full border border-cyan-300/20 bg-cyan-400/10 px-5 py-3 text-sm font-black text-cyan-100 transition hover:bg-cyan-400/20">
                            <span class="relative flex h-3 w-3">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-300 opacity-75"></span>
                                <span class="relative inline-flex h-3 w-3 rounded-full bg-cyan-300"></span>
                            </span>
                            Disease Prediction System Login
                        </a>

                        <h1 class="mt-7 text-6xl font-black leading-[1.03] tracking-tight text-white 2xl:text-7xl">
                            Welcome to your
                            <span class="block dps-gradient-text">smart health command center.</span>
                        </h1>
                                                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                            Login securely to access symptom checking, AI-supported disease risk prediction,
                            medical reports, health records, and doctor appointment workflows.
                        </p>

                        <div class="mt-9 grid max-w-2xl grid-cols-3 gap-4">
                            <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-xl transition hover:-translate-y-1">
                                <p class="text-3xl font-black text-cyan-200">AI</p>
                                <p class="mt-1 text-xs font-bold text-slate-400">Prediction</p>
                            </div>

                            <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-xl transition hover:-translate-y-1">
                                <p class="text-3xl font-black text-emerald-200">Secure</p>
                                <p class="mt-1 text-xs font-bold text-slate-400">Reports</p>
                            </div>

                            <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-xl transition hover:-translate-y-1">
                                <p class="text-3xl font-black text-purple-200">Live</p>
                                <p class="mt-1 text-xs font-bold text-slate-400">Booking</p>
                            </div>
                        </div>

                        <div class="mt-8 rounded-[2rem] border border-white/10 bg-slate-950/60 p-5">
                            <div class="flex items-start gap-4">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-cyan-400/15 text-xl ring-1 ring-cyan-300/20">
                                    🔐
                                </div>

                                <div>
                                    <h3 class="text-lg font-black text-white">
                                        Protected Role-Based Access
                                    </h3>

                                    <p class="mt-1 text-sm leading-6 text-slate-400">
                                        After login, your existing Laravel authentication process redirects
                                        users according to their role: user, doctor, admin, or super admin.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="rounded-[2rem] border border-cyan-300/15 bg-cyan-400/10 p-5">
                                <p class="text-sm font-black uppercase tracking-[0.22em] text-cyan-200">
                                    Secure Login
                                </p>
                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Uses your current route login process without changing backend logic.
                                </p>
                            </div>

                            <div class="rounded-[2rem] border border-purple-300/15 bg-purple-400/10 p-5">
                                <p class="text-sm font-black uppercase tracking-[0.22em] text-purple-200">
                                    Premium UI
                                </p>
                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Full screen layout, glass effect, animated glow, and live shadow design.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Login Card --}}
            <section class="mx-auto w-full max-w-md">
                <div class="relative">
                    <div class="absolute -inset-5 rounded-[3rem] bg-gradient-to-r from-cyan-400/25 via-blue-500/20 to-purple-500/25 blur-2xl"></div>

                    <div class="dps-premium-border relative overflow-hidden rounded-[2.7rem] p-[1px]">
                        <div class="relative overflow-hidden rounded-[2.65rem] border border-white/10 bg-white/10 p-2 backdrop-blur-2xl dps-live-shadow">
                            <div class="relative overflow-hidden rounded-[2.1rem] border border-white/10 bg-slate-950/90 px-6 py-7 sm:px-8 sm:py-8 dps-scan">
                                <div class="absolute -right-20 -top-20 h-44 w-44 rounded-full bg-cyan-400/20 blur-3xl"></div>
                                <div class="absolute -left-20 -bottom-20 h-44 w-44 rounded-full bg-purple-400/20 blur-3xl"></div>

                                <div class="relative text-center">
                                    <a href="{{ url('/') }}"
                                       class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-cyan-300 via-blue-400 to-purple-500 text-2xl shadow-2xl shadow-cyan-500/30 transition hover:scale-105">
                                        🧠
                                    </a>

                                    <h2 class="mt-5 text-3xl font-black tracking-tight text-white sm:text-4xl">
                                        Welcome Back
                                    </h2>

                                    <p class="mt-2 text-sm font-semibold leading-6 text-slate-400">
                                        Login to continue your AI health workflow
                                    </p>
                                </div>

                                @if (session('status'))
                                    <div class="relative mt-6 rounded-2xl border border-emerald-300/20 bg-emerald-400/10 p-4 text-sm font-semibold text-emerald-200">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="relative mt-6 rounded-2xl border border-red-300/20 bg-red-400/10 p-4 text-sm font-semibold text-red-200">
                                        <p class="font-black">Please check the information below.</p>
                                        <ul class="mt-2 list-inside list-disc space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" class="relative mt-7 space-y-5">
                                    @csrf

                                    {{-- Email --}}
                                    <div>
                                        <label for="email" class="text-xs font-black uppercase tracking-[0.18em] text-slate-300">
                                            Email Address
                                        </label>

                                        <div class="relative mt-2">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-cyan-200">
                                                ✉️
                                            </div>

                                            <input
                                                id="email"
                                                type="email"
                                                name="email"
                                                value="{{ old('email') }}"
                                                required
                                                autofocus
                                                autocomplete="username"
                                                class="block w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3.5 pl-12 text-sm font-bold text-white placeholder:text-slate-500 outline-none transition focus:border-cyan-300/50 focus:bg-white/10 focus:ring-4 focus:ring-cyan-400/10"
                                                placeholder="Enter your email"
                                            >
                                        </div>
                                    </div>
                                                                        {{-- Password --}}
                                    <div>
                                        <label for="password" class="text-xs font-black uppercase tracking-[0.18em] text-slate-300">
                                            Password
                                        </label>

                                        <div class="relative mt-2">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-purple-200">
                                                🔒
                                            </div>

                                            <input
                                                id="password"
                                                type="password"
                                                name="password"
                                                required
                                                autocomplete="current-password"
                                                class="block w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3.5 pl-12 text-sm font-bold text-white placeholder:text-slate-500 outline-none transition focus:border-purple-300/50 focus:bg-white/10 focus:ring-4 focus:ring-purple-400/10"
                                                placeholder="Enter your password"
                                            >
                                        </div>
                                    </div>

                                    {{-- Remember + Forgot --}}
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <label for="remember_me" class="inline-flex items-center gap-2">
                                            <input
                                                id="remember_me"
                                                type="checkbox"
                                                name="remember"
                                                class="h-4 w-4 rounded border-white/20 bg-white/10 text-cyan-400 shadow-sm focus:ring-cyan-400"
                                            >

                                            <span class="text-xs font-bold text-slate-400">
                                                Remember me
                                            </span>
                                        </label>

                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}"
                                               class="text-xs font-black text-cyan-300 transition hover:text-cyan-100">
                                                Forgot password?
                                            </a>
                                        @endif
                                    </div>

                                    {{-- Submit --}}
                                    <button
                                        type="submit"
                                        class="dps-btn-shine group relative w-full overflow-hidden rounded-2xl bg-gradient-to-r from-cyan-300 via-blue-400 to-purple-500 px-6 py-4 text-sm font-black text-slate-950 shadow-2xl shadow-cyan-500/25 transition hover:scale-[1.02] active:scale-[0.99]"
                                    >
                                        <span class="relative z-10 inline-flex items-center justify-center gap-2">
                                            Login Securely
                                            <span class="transition group-hover:translate-x-1">→</span>
                                        </span>
                                    </button>

                                    {{-- Register Link --}}
                                    @if (Route::has('register'))
                                        <div class="rounded-3xl border border-white/10 bg-white/5 p-4 text-center">
                                            <p class="text-xs font-bold text-slate-400">
                                                Don’t have an account?
                                            </p>

                                            <a href="{{ route('register') }}"
                                               class="mt-3 inline-flex w-full items-center justify-center rounded-2xl border border-cyan-300/20 bg-cyan-400/10 px-5 py-3 text-sm font-black text-cyan-100 transition hover:bg-cyan-400/20">
                                                Create New Account
                                            </a>
                                        </div>
                                    @endif
                                </form>

                                <div class="relative mt-6 grid grid-cols-3 gap-3">
                                    <div class="rounded-2xl border border-cyan-300/15 bg-cyan-400/10 p-3 text-center">
                                        <p class="text-lg font-black text-cyan-200">01</p>
                                        <p class="mt-1 text-[11px] font-bold text-slate-400">Login</p>
                                    </div>

                                    <div class="rounded-2xl border border-purple-300/15 bg-purple-400/10 p-3 text-center">
                                        <p class="text-lg font-black text-purple-200">02</p>
                                        <p class="mt-1 text-[11px] font-bold text-slate-400">Analyze</p>
                                    </div>

                                    <div class="rounded-2xl border border-emerald-300/15 bg-emerald-400/10 p-3 text-center">
                                        <p class="text-lg font-black text-emerald-200">03</p>
                                        <p class="mt-1 text-[11px] font-bold text-slate-400">Track</p>
                                    </div>
                                </div>

                                <div class="relative mt-6 rounded-3xl border border-white/10 bg-white/5 p-4 xl:hidden">
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-cyan-400/15 text-lg ring-1 ring-cyan-300/20">
                                            🔐
                                        </div>

                                        <div>
                                            <p class="text-sm font-black text-white">
                                                Protected Role-Based Access
                                            </p>

                                            <p class="mt-1 text-xs leading-5 text-slate-400">
                                                Login redirects users according to their account role.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                                            </div>
                        </div>
                    </div>

                    <p class="mt-6 text-center text-xs font-semibold text-slate-500">
                        Disease Prediction System • AI Health Risk Analyzer
                    </p>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
                    