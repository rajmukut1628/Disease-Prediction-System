<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Disease Prediction System') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Figtree', sans-serif; }
        html { scroll-behavior: smooth; }
        body {
            overflow-x: hidden;
            background: #020617;
        }

        @keyframes dpsLiveShadow {
            0% { box-shadow: 0 0 35px rgba(34,211,238,.16), 0 0 90px rgba(59,130,246,.10); }
            25% { box-shadow: 0 0 45px rgba(168,85,247,.20), 0 0 110px rgba(34,211,238,.10); }
            50% { box-shadow: 0 0 55px rgba(16,185,129,.17), 0 0 125px rgba(99,102,241,.14); }
            75% { box-shadow: 0 0 45px rgba(14,165,233,.18), 0 0 110px rgba(244,114,182,.10); }
            100% { box-shadow: 0 0 35px rgba(34,211,238,.16), 0 0 90px rgba(59,130,246,.10); }
        }

        @keyframes dpsFloat {
            0%,100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-18px) scale(1.03); }
        }

        @keyframes dpsGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes dpsScan {
            0% { transform: translateY(-120%); opacity: 0; }
            20% { opacity: .55; }
            100% { transform: translateY(520%); opacity: 0; }
        }

        @keyframes dpsGlowLine {
            0%,100% { transform: translateX(-35%); opacity: .35; }
            50% { transform: translateX(35%); opacity: .95; }
        }

        .dps-live-shadow { animation: dpsLiveShadow 6s ease-in-out infinite; }

        .dps-floating { animation: dpsFloat 5.8s ease-in-out infinite; }

        .dps-gradient-text {
            background: linear-gradient(90deg, #67e8f9, #60a5fa, #a78bfa, #34d399);
            background-size: 280% 280%;
            animation: dpsGradient 8s ease infinite;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .dps-grid-bg {
            background-image:
                linear-gradient(rgba(255,255,255,.045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.045) 1px, transparent 1px);
            background-size: 44px 44px;
            mask-image: radial-gradient(circle at center, black, transparent 72%);
        }

        .dps-scan::after {
            content: "";
            position: absolute;
            inset: 0;
            height: 22%;
            background: linear-gradient(to bottom, transparent, rgba(34,211,238,.18), transparent);
            animation: dpsScan 4.8s ease-in-out infinite;
            pointer-events: none;
        }

        .dps-soft-card {
            background: linear-gradient(135deg, rgba(255,255,255,.12), rgba(255,255,255,.045));
            border: 1px solid rgba(255,255,255,.12);
            backdrop-filter: blur(24px);
        }

        .dps-nav-link {
            position: relative;
        }

        .dps-nav-link::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -10px;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, #67e8f9, #a78bfa);
            transform: scaleX(0);
            transform-origin: center;
            transition: .25s ease;
        }

        .dps-nav-link:hover::after {
            transform: scaleX(1);
        }

        .dps-glow-line::before {
            content: "";
            position: absolute;
            top: 0;
            left: 10%;
            width: 80%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(103,232,249,.75), rgba(167,139,250,.75), transparent);
            animation: dpsGlowLine 5s ease-in-out infinite;
        }
    </style>
</head>

<body class="min-h-screen text-white antialiased">
    <div class="fixed inset-0 -z-50 bg-slate-950"></div>
    <div class="fixed inset-0 -z-40 opacity-60 dps-grid-bg"></div>

    <div class="fixed -top-44 -left-44 h-[34rem] w-[34rem] rounded-full bg-cyan-500/20 blur-3xl dps-floating"></div>
    <div class="fixed top-32 -right-44 h-[34rem] w-[34rem] rounded-full bg-purple-500/20 blur-3xl dps-floating" style="animation-delay:1.4s;"></div>
    <div class="fixed bottom-0 left-1/3 h-[30rem] w-[30rem] rounded-full bg-emerald-500/10 blur-3xl dps-floating" style="animation-delay:2.5s;"></div>

    <header class="fixed left-0 right-0 top-0 z-50 border-b border-white/10 bg-slate-950/75 backdrop-blur-2xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">
            <a href="{{ url('/') }}" class="group flex items-center gap-3">
                <div class="relative flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-400/15 ring-1 ring-cyan-300/25 dps-live-shadow">
                    <span class="absolute inset-0 rounded-2xl bg-cyan-300/20 blur-xl"></span>
                    <span class="relative text-2xl">🧬</span>
                </div>

                <div>
                    <h1 class="text-lg font-black leading-tight tracking-tight">
                        Disease Prediction System
                    </h1>
                    <p class="text-xs font-semibold text-cyan-200/80">
                        Real AI Health Risk Analyzer
                    </p>
                </div>
            </a>

            <nav class="hidden items-center gap-7 lg:flex">
                <a href="#prediction" class="dps-nav-link text-sm font-bold text-slate-300 transition hover:text-cyan-200">Prediction</a>
                <a href="#modules" class="dps-nav-link text-sm font-bold text-slate-300 transition hover:text-cyan-200">Modules</a>
                <a href="#workflow" class="dps-nav-link text-sm font-bold text-slate-300 transition hover:text-cyan-200">Workflow</a>
                <a href="#roles" class="dps-nav-link text-sm font-bold text-slate-300 transition hover:text-cyan-200">Roles</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="rounded-2xl border border-cyan-300/20 bg-cyan-400/10 px-5 py-2.5 text-sm font-black text-cyan-100 transition hover:bg-cyan-400/20">
                        Enter System
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden rounded-2xl border border-white/10 bg-white/5 px-5 py-2.5 text-sm font-black text-slate-100 transition hover:bg-white/10 sm:inline-flex">
                        Sign in
                    </a>

                    @if(Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="rounded-2xl bg-gradient-to-r from-cyan-300 via-blue-400 to-purple-400 px-5 py-2.5 text-sm font-black text-slate-950 shadow-lg shadow-cyan-500/30 transition hover:scale-[1.03]">
                            Get Started
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="relative pt-32">
        <section id="prediction" class="mx-auto grid max-w-7xl items-center gap-12 px-5 pb-20 pt-10 lg:grid-cols-2 lg:px-8 lg:pb-28">
            <div class="relative z-10">
                <div class="mb-6 inline-flex items-center gap-3 rounded-full border border-cyan-300/20 bg-cyan-400/10 px-4 py-2 text-sm font-black text-cyan-100">
                    <span class="relative flex h-3 w-3">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-cyan-300 opacity-75"></span>
                        <span class="relative inline-flex h-3 w-3 rounded-full bg-cyan-300"></span>
                    </span>
                    Real AI Powered Disease Prediction System
                </div>

                <h1 class="max-w-4xl text-5xl font-black leading-[1.03] tracking-tight md:text-7xl">
                    Predict possible disease risk with a
                    <span class="dps-gradient-text">smart medical workflow.</span>
                </h1>

                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">
                    This system helps authenticated users check symptoms, generate AI-supported risk predictions,
                    manage medical reports, track health records, and request doctor appointments from one secure
                    role-based medical platform.
                </p>

                <div class="mt-9 flex flex-col gap-4 sm:flex-row">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="group inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-300 via-blue-400 to-purple-400 px-7 py-4 text-base font-black text-slate-950 shadow-2xl shadow-cyan-500/25 transition hover:scale-[1.03]">
                            Enter System
                            <span class="ml-2 transition group-hover:translate-x-1">→</span>
                        </a>
                    @else
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="group inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-300 via-blue-400 to-purple-400 px-7 py-4 text-base font-black text-slate-950 shadow-2xl shadow-cyan-500/25 transition hover:scale-[1.03]">
                                Get Started
                                <span class="ml-2 transition group-hover:translate-x-1">→</span>
                            </a>
                        @endif

                        <a href="{{ route('login') }}"
                           class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/10 px-7 py-4 text-base font-black text-white backdrop-blur-xl transition hover:bg-white/15">
                            Sign in
                        </a>
                    @endauth
                </div>
                                <div class="mt-10 grid max-w-xl grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl border border-white/10 bg-white/10 p-4 backdrop-blur-xl">
                        <p class="text-3xl font-black text-cyan-200">AI</p>
                        <p class="mt-1 text-xs font-bold text-slate-400">Symptom Analysis</p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/10 p-4 backdrop-blur-xl">
                        <p class="text-3xl font-black text-emerald-200">Risk</p>
                        <p class="mt-1 text-xs font-bold text-slate-400">Prediction Result</p>
                    </div>

                    <div class="rounded-3xl border border-white/10 bg-white/10 p-4 backdrop-blur-xl">
                        <p class="text-3xl font-black text-purple-200">Role</p>
                        <p class="mt-1 text-xs font-bold text-slate-400">Based Access</p>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -inset-6 rounded-[3rem] bg-gradient-to-r from-cyan-400/20 via-purple-400/20 to-emerald-400/20 blur-3xl"></div>

                <div class="relative overflow-hidden rounded-[2.5rem] border border-white/10 bg-white/10 p-5 backdrop-blur-2xl dps-live-shadow">
                    <div class="absolute right-8 top-8 h-28 w-28 rounded-full bg-cyan-300/20 blur-3xl"></div>
                    <div class="absolute bottom-8 left-8 h-28 w-28 rounded-full bg-purple-300/20 blur-3xl"></div>

                    <div class="relative overflow-hidden rounded-[2rem] border border-white/10 bg-slate-950/75 p-6 dps-scan">
                        <div class="flex items-center justify-between gap-5">
                            <div>
                                <p class="text-sm font-black uppercase tracking-[0.25em] text-cyan-200">
                                    Live AI Prediction Panel
                                </p>
                                <h2 class="mt-2 text-2xl font-black">
                                    Disease Risk Analyzer
                                </h2>
                            </div>

                            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-cyan-400/15 text-2xl ring-1 ring-cyan-300/20">
                                🧠
                            </div>
                        </div>

                        <div class="mt-7 space-y-4">
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <div class="mb-2 flex items-center justify-between">
                                    <span class="text-sm font-bold text-slate-300">Symptom Understanding</span>
                                    <span class="text-sm font-black text-cyan-200">AI</span>
                                </div>
                                <div class="h-2 rounded-full bg-slate-800">
                                    <div class="h-2 w-[86%] rounded-full bg-gradient-to-r from-cyan-300 to-blue-400"></div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <div class="mb-2 flex items-center justify-between">
                                    <span class="text-sm font-bold text-slate-300">Risk Interpretation</span>
                                    <span class="text-sm font-black text-emerald-200">Guided</span>
                                </div>
                                <div class="h-2 rounded-full bg-slate-800">
                                    <div class="h-2 w-[72%] rounded-full bg-gradient-to-r from-emerald-300 to-cyan-400"></div>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <div class="mb-2 flex items-center justify-between">
                                    <span class="text-sm font-bold text-slate-300">Medical Record Insight</span>
                                    <span class="text-sm font-black text-purple-200">Smart</span>
                                </div>
                                <div class="h-2 rounded-full bg-slate-800">
                                    <div class="h-2 w-[64%] rounded-full bg-gradient-to-r from-purple-300 to-pink-400"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="rounded-2xl border border-yellow-300/20 bg-yellow-400/10 p-4">
                                <p class="text-xs font-bold text-yellow-200">Prediction Output</p>
                                <p class="mt-1 text-sm font-black text-white">
                                    Risk Level + Guidance
                                </p>
                            </div>

                            <div class="rounded-2xl border border-cyan-300/20 bg-cyan-400/10 p-4">
                                <p class="text-xs font-bold text-cyan-200">Recommended Step</p>
                                <p class="mt-1 text-sm font-black text-white">
                                    Safe Next Action
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="absolute -right-4 -top-4 hidden rounded-3xl border border-white/10 bg-white/10 p-4 backdrop-blur-xl md:block dps-floating">
                    <p class="text-xs font-bold text-slate-300">System Focus</p>
                    <p class="mt-1 text-2xl font-black text-cyan-200">Prediction</p>
                </div>

                <div class="absolute -bottom-5 -left-5 hidden rounded-3xl border border-white/10 bg-white/10 p-4 backdrop-blur-xl md:block dps-floating" style="animation-delay:1.2s;">
                    <p class="text-xs font-bold text-slate-300">Reports</p>
                    <p class="mt-1 text-2xl font-black text-emerald-200">Secure</p>
                </div>
            </div>
        </section>

        <section id="modules" class="relative px-5 py-20 lg:px-8">
            <div class="absolute inset-x-0 top-1/2 -z-10 h-80 bg-gradient-to-r from-cyan-500/10 via-purple-500/10 to-emerald-500/10 blur-3xl"></div>

            <div class="mx-auto max-w-7xl">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="text-sm font-black uppercase tracking-[0.35em] text-cyan-300">
                        Project Modules
                    </p>

                    <h2 class="mt-4 text-4xl font-black tracking-tight md:text-6xl">
                        Everything focused on
                        <span class="dps-gradient-text">medical risk prediction.</span>
                    </h2>

                    <p class="mt-5 text-lg leading-8 text-slate-400">
                        This landing page only explains the real project flow: symptom checker, AI-supported
                        prediction, medical report management, health records, appointments, and role-based access.
                    </p>
                </div>

                <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    <div class="group relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/10 p-6 backdrop-blur-2xl transition duration-500 hover:-translate-y-2 dps-live-shadow">
                        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-cyan-400/20 blur-3xl transition group-hover:scale-150"></div>
                        <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-400/15 text-2xl ring-1 ring-cyan-300/20">
                            🩺
                        </div>
                        <h3 class="relative mt-5 text-xl font-black text-white">Symptom Checker</h3>
                        <p class="relative mt-3 text-sm leading-6 text-slate-400">
                            Users can submit symptoms and receive structured disease-related analysis from the system.
                        </p>
                    </div>

                    <div class="group relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/10 p-6 backdrop-blur-2xl transition duration-500 hover:-translate-y-2 dps-live-shadow">
                        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-purple-400/20 blur-3xl transition group-hover:scale-150"></div>
                        <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-400/15 text-2xl ring-1 ring-purple-300/20">
                            🧬
                        </div>
                        <h3 class="relative mt-5 text-xl font-black text-white">Risk Prediction</h3>
                        <p class="relative mt-3 text-sm leading-6 text-slate-400">
                            Prediction output shows possible risk level, explanation, confidence, and suggested action.
                        </p>
                    </div>
                                        <div class="group relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/10 p-6 backdrop-blur-2xl transition duration-500 hover:-translate-y-2 dps-live-shadow">
                        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-emerald-400/20 blur-3xl transition group-hover:scale-150"></div>
                        <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-400/15 text-2xl ring-1 ring-emerald-300/20">
                            📄
                        </div>
                        <h3 class="relative mt-5 text-xl font-black text-white">Medical Reports</h3>
                        <p class="relative mt-3 text-sm leading-6 text-slate-400">
                            Users can upload, organize, view, and manage medical reports from their protected account.
                        </p>
                    </div>

                    <div class="group relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/10 p-6 backdrop-blur-2xl transition duration-500 hover:-translate-y-2 dps-live-shadow">
                        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-blue-400/20 blur-3xl transition group-hover:scale-150"></div>
                        <div class="relative flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-400/15 text-2xl ring-1 ring-blue-300/20">
                            📅
                        </div>
                        <h3 class="relative mt-5 text-xl font-black text-white">Appointments</h3>
                        <p class="relative mt-3 text-sm leading-6 text-slate-400">
                            Users can request doctor appointments, and doctors can review appointment status.
                        </p>
                    </div>
                </div>

                <div class="mt-10 grid gap-6 lg:grid-cols-3">
                    <div class="relative overflow-hidden rounded-[2.3rem] border border-white/10 bg-white/10 p-7 backdrop-blur-2xl">
                        <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-cyan-400/20 blur-3xl"></div>
                        <p class="relative text-sm font-black uppercase tracking-[0.25em] text-cyan-300">User Flow</p>
                        <h3 class="relative mt-4 text-3xl font-black">Check → Predict → Act</h3>
                        <p class="relative mt-4 text-sm leading-7 text-slate-400">
                            Users start with symptoms, receive AI-supported prediction output, then follow safe guidance.
                        </p>
                    </div>

                    <div class="relative overflow-hidden rounded-[2.3rem] border border-white/10 bg-white/10 p-7 backdrop-blur-2xl">
                        <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-purple-400/20 blur-3xl"></div>
                        <p class="relative text-sm font-black uppercase tracking-[0.25em] text-purple-300">Account Flow</p>
                        <h3 class="relative mt-4 text-3xl font-black">Everything Organized</h3>
                        <p class="relative mt-4 text-sm leading-7 text-slate-400">
                            Prediction history, uploaded reports, health records, and appointment requests stay organized.
                        </p>
                    </div>

                    <div class="relative overflow-hidden rounded-[2.3rem] border border-white/10 bg-white/10 p-7 backdrop-blur-2xl">
                        <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-emerald-400/20 blur-3xl"></div>
                        <p class="relative text-sm font-black uppercase tracking-[0.25em] text-emerald-300">Doctor Flow</p>
                        <h3 class="relative mt-4 text-3xl font-black">Review Patient Requests</h3>
                        <p class="relative mt-4 text-sm leading-7 text-slate-400">
                            Doctors can review appointment requests, approve or reject them, and support patient care flow.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="workflow" class="relative px-5 py-20 lg:px-8">
            <div class="absolute left-0 top-20 -z-10 h-96 w-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
            <div class="absolute right-0 bottom-20 -z-10 h-96 w-96 rounded-full bg-purple-500/10 blur-3xl"></div>

            <div class="mx-auto max-w-7xl">
                <div class="grid gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
                    <div>
                        <p class="text-sm font-black uppercase tracking-[0.35em] text-emerald-300">
                            Disease Prediction Workflow
                        </p>

                        <h2 class="mt-4 text-4xl font-black tracking-tight md:text-6xl">
                            From symptoms to
                            <span class="dps-gradient-text">medical decision support.</span>
                        </h2>

                        <p class="mt-5 text-lg leading-8 text-slate-400">
                            The system follows a practical health workflow. Users provide symptoms, receive prediction
                            output, save health records, upload reports, and request doctor support when needed.
                        </p>

                        <div class="mt-8 grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl border border-cyan-300/15 bg-cyan-400/10 p-5">
                                <p class="text-3xl font-black text-cyan-200">5</p>
                                <p class="mt-1 text-sm font-bold text-slate-300">Main Steps</p>
                            </div>

                            <div class="rounded-3xl border border-purple-300/15 bg-purple-400/10 p-5">
                                <p class="text-3xl font-black text-purple-200">AI</p>
                                <p class="mt-1 text-sm font-bold text-slate-300">Prediction Support</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative rounded-[2.5rem] border border-white/10 bg-white/10 p-6 backdrop-blur-2xl dps-live-shadow">
                        <div class="absolute -left-8 top-12 h-32 w-32 rounded-full bg-cyan-400/20 blur-3xl"></div>
                        <div class="absolute -right-8 bottom-12 h-32 w-32 rounded-full bg-purple-400/20 blur-3xl"></div>

                        <div class="relative space-y-5">
                            <div class="group flex gap-4 rounded-3xl border border-white/10 bg-slate-950/60 p-5 transition hover:-translate-y-1 hover:bg-slate-900/70">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-cyan-400/15 text-lg font-black text-cyan-200 ring-1 ring-cyan-300/20">
                                    01
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-white">Create Account</h3>
                                    <p class="mt-1 text-sm leading-6 text-slate-400">
                                        User signs in or registers to access protected health features.
                                    </p>
                                </div>
                            </div>

                            <div class="group flex gap-4 rounded-3xl border border-white/10 bg-slate-950/60 p-5 transition hover:-translate-y-1 hover:bg-slate-900/70">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-purple-400/15 text-lg font-black text-purple-200 ring-1 ring-purple-300/20">
                                    02
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-white">Enter Symptoms</h3>
                                    <p class="mt-1 text-sm leading-6 text-slate-400">
                                        User submits symptoms through the symptom checker module.
                                    </p>
                                </div>
                            </div>

                            <div class="group flex gap-4 rounded-3xl border border-white/10 bg-slate-950/60 p-5 transition hover:-translate-y-1 hover:bg-slate-900/70">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-400/15 text-lg font-black text-emerald-200 ring-1 ring-emerald-300/20">
                                    03
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-white">Generate Prediction</h3>
                                    <p class="mt-1 text-sm leading-6 text-slate-400">
                                        System analyzes symptom input and returns risk level with medical guidance.
                                    </p>
                                </div>
                            </div>
                                                        <div class="group flex gap-4 rounded-3xl border border-white/10 bg-slate-950/60 p-5 transition hover:-translate-y-1 hover:bg-slate-900/70">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-400/15 text-lg font-black text-blue-200 ring-1 ring-blue-300/20">
                                    04
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-white">Store Health Data</h3>
                                    <p class="mt-1 text-sm leading-6 text-slate-400">
                                        User can save prediction history, reports, and health records.
                                    </p>
                                </div>
                            </div>

                            <div class="group flex gap-4 rounded-3xl border border-white/10 bg-slate-950/60 p-5 transition hover:-translate-y-1 hover:bg-slate-900/70">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-pink-400/15 text-lg font-black text-pink-200 ring-1 ring-pink-300/20">
                                    05
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-white">Request Doctor Appointment</h3>
                                    <p class="mt-1 text-sm leading-6 text-slate-400">
                                        If risk needs attention, user can request appointment with a doctor.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-20 grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                    <div class="relative order-2 lg:order-1">
                        <div class="absolute -inset-5 rounded-[3rem] bg-gradient-to-r from-cyan-400/20 via-purple-400/20 to-emerald-400/20 blur-3xl"></div>

                        <div class="relative overflow-hidden rounded-[2.7rem] border border-white/10 bg-white/10 p-5 backdrop-blur-2xl dps-live-shadow">
                            <div class="rounded-[2.1rem] border border-white/10 bg-slate-950/80 p-5">
                                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <p class="text-xs font-black uppercase tracking-[0.28em] text-cyan-300">
                                            Protected Medical Workspace
                                        </p>
                                        <h3 class="mt-2 text-2xl font-black">
                                            Disease Prediction Center
                                        </h3>
                                    </div>

                                    <div class="inline-flex w-fit items-center gap-2 rounded-full border border-emerald-300/20 bg-emerald-400/10 px-4 py-2">
                                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-300"></span>
                                        <span class="text-xs font-black text-emerald-200">Active System</span>
                                    </div>
                                </div>

                                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                                    <div class="rounded-3xl border border-cyan-300/15 bg-cyan-400/10 p-4">
                                        <p class="text-xs font-bold text-cyan-200">Symptoms</p>
                                        <p class="mt-2 text-3xl font-black">Input</p>
                                    </div>

                                    <div class="rounded-3xl border border-purple-300/15 bg-purple-400/10 p-4">
                                        <p class="text-xs font-bold text-purple-200">Prediction</p>
                                        <p class="mt-2 text-3xl font-black">AI</p>
                                    </div>

                                    <div class="rounded-3xl border border-emerald-300/15 bg-emerald-400/10 p-4">
                                        <p class="text-xs font-bold text-emerald-200">Result</p>
                                        <p class="mt-2 text-3xl font-black">Risk</p>
                                    </div>
                                </div>

                                <div class="mt-5 grid gap-4 md:grid-cols-2">
                                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-black text-white">Symptom Input</h4>
                                            <span class="rounded-full bg-cyan-400/10 px-3 py-1 text-xs font-black text-cyan-200">
                                                Analyze
                                            </span>
                                        </div>

                                        <p class="mt-3 text-sm leading-6 text-slate-400">
                                            User submits symptoms through the system form, then AI-supported logic prepares a structured medical response.
                                        </p>

                                        <div class="mt-4 h-2 rounded-full bg-slate-800">
                                            <div class="h-2 w-[68%] rounded-full bg-gradient-to-r from-cyan-300 to-blue-400"></div>
                                        </div>
                                    </div>

                                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-black text-white">Prediction Output</h4>
                                            <span class="rounded-full bg-purple-400/10 px-3 py-1 text-xs font-black text-purple-200">
                                                Result
                                            </span>
                                        </div>

                                        <p class="mt-3 text-sm leading-6 text-slate-400">
                                            System returns possible risk level, short explanation, confidence hint, and safe next-step guidance.
                                        </p>

                                        <div class="mt-4 h-2 rounded-full bg-slate-800">
                                            <div class="h-2 w-[76%] rounded-full bg-gradient-to-r from-purple-300 to-pink-400"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-5 rounded-3xl border border-white/10 bg-white/5 p-5">
                                    <div class="mb-4 flex items-center justify-between">
                                        <h4 class="font-black text-white">Disease Prediction Activity</h4>
                                        <span class="text-xs font-bold text-slate-400">Project Flow</span>
                                    </div>

                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between rounded-2xl bg-slate-950/70 px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-400/10">🩺</span>
                                                <div>
                                                    <p class="text-sm font-black text-white">Symptoms checked</p>
                                                    <p class="text-xs text-slate-500">Step 1 completed</p>
                                                </div>
                                            </div>
                                            <span class="text-xs font-black text-cyan-200">Done</span>
                                        </div>

                                        <div class="flex items-center justify-between rounded-2xl bg-slate-950/70 px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-400/10">🧬</span>
                                                <div>
                                                    <p class="text-sm font-black text-white">Risk prediction generated</p>
                                                    <p class="text-xs text-slate-500">Step 2 completed</p>
                                                </div>
                                            </div>
                                            <span class="text-xs font-black text-purple-200">Generated</span>
                                        </div>

                                        <div class="flex items-center justify-between rounded-2xl bg-slate-950/70 px-4 py-3">
                                            <div class="flex items-center gap-3">
                                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-400/10">📄</span>
                                                <div>
                                                    <p class="text-sm font-black text-white">Medical record saved</p>
                                                    <p class="text-xs text-slate-500">Step 3 completed</p>
                                                </div>
                                            </div>
                                            <span class="text-xs font-black text-emerald-200">Saved</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="order-1 lg:order-2">
                        <p class="text-sm font-black uppercase tracking-[0.35em] text-cyan-300">
                            Real Project Purpose
                        </p>

                        <h2 class="mt-4 text-4xl font-black tracking-tight md:text-6xl">
                            No fake marketing —
                            <span class="dps-gradient-text">only real project features.</span>
                        </h2>

                        <p class="mt-5 text-lg leading-8 text-slate-400">
                            Every section describes what this Disease Prediction System actually does:
                            symptom checking, AI-supported risk analysis, medical reports, health records,
                            appointments, and role-based access control.
                        </p>

                        <div class="mt-8 space-y-4">
                            <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-xl">
                                <div class="flex gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-cyan-400/15 text-xl">
                                        ✅
                                    </div>
                                    <div>
                                        <h4 class="font-black text-white">Disease Prediction Focused</h4>
                                        <p class="mt-1 text-sm leading-6 text-slate-400">
                                            Every card, title, and button stays connected to your disease prediction project.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-xl">
                                <div class="flex gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-purple-400/15 text-xl">
                                        🧠
                                    </div>
                                    <div>
                                        <h4 class="font-black text-white">Real AI Style Interface</h4>
                                        <p class="mt-1 text-sm leading-6 text-slate-400">
                                            The interface presents your AI prediction workflow in a modern medical UI.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur-xl">
                                <div class="flex gap-4">
                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-400/15 text-xl">
                                        🔐
                                    </div>
                                    <div>
                                        <h4 class="font-black text-white">Protected Entry Flow</h4>
                                        <p class="mt-1 text-sm leading-6 text-slate-400">
                                            Sign in and registration buttons connect users to the existing authentication process.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-9 flex flex-col gap-4 sm:flex-row">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                   class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-300 via-blue-400 to-purple-400 px-7 py-4 font-black text-slate-950 shadow-2xl shadow-cyan-500/25 transition hover:scale-[1.03]">
                                    Enter System
                                </a>
                            @else
                                @if(Route::has('register'))
                                    <a href="{{ route('register') }}"
                                       class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-300 via-blue-400 to-purple-400 px-7 py-4 font-black text-slate-950 shadow-2xl shadow-cyan-500/25 transition hover:scale-[1.03]">
                                        Get Started
                                    </a>
                                @endif

                                <a href="{{ route('login') }}"
                                   class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/10 px-7 py-4 font-black text-white backdrop-blur-xl transition hover:bg-white/15">
                                    Sign in
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>
                <section id="roles" class="relative px-5 py-20 lg:px-8">
            <div class="absolute inset-x-0 top-20 -z-10 h-96 bg-gradient-to-r from-cyan-500/10 via-blue-500/10 to-purple-500/10 blur-3xl"></div>

            <div class="mx-auto max-w-7xl">
                <div class="mx-auto max-w-3xl text-center">
                    <p class="text-sm font-black uppercase tracking-[0.35em] text-purple-300">
                        Role Based Access
                    </p>

                    <h2 class="mt-4 text-4xl font-black tracking-tight md:text-6xl">
                        Built for
                        <span class="dps-gradient-text">user, doctor, admin and super admin.</span>
                    </h2>

                    <p class="mt-5 text-lg leading-8 text-slate-400">
                        Disease Prediction System keeps every role separate, clean and secure.
                        Each account type has its own protected area and responsibility.
                    </p>
                </div>

                <div class="mt-14 grid gap-6 lg:grid-cols-4">
                    <div class="group relative overflow-hidden rounded-[2.5rem] border border-white/10 bg-white/10 p-7 backdrop-blur-2xl transition duration-500 hover:-translate-y-2 dps-live-shadow">
                        <div class="absolute -right-14 -top-14 h-44 w-44 rounded-full bg-cyan-400/20 blur-3xl transition group-hover:scale-150"></div>
                        <div class="relative flex h-16 w-16 items-center justify-center rounded-3xl bg-cyan-400/15 text-3xl ring-1 ring-cyan-300/20">👤</div>
                        <h3 class="relative mt-6 text-3xl font-black">User</h3>
                        <p class="relative mt-3 text-sm leading-7 text-slate-400">
                            User can check symptoms, predict disease risk, manage reports, save health records,
                            and request appointments.
                        </p>
                    </div>

                    <div class="group relative overflow-hidden rounded-[2.5rem] border border-white/10 bg-white/10 p-7 backdrop-blur-2xl transition duration-500 hover:-translate-y-2 dps-live-shadow">
                        <div class="absolute -right-14 -top-14 h-44 w-44 rounded-full bg-emerald-400/20 blur-3xl transition group-hover:scale-150"></div>
                        <div class="relative flex h-16 w-16 items-center justify-center rounded-3xl bg-emerald-400/15 text-3xl ring-1 ring-emerald-300/20">🩺</div>
                        <h3 class="relative mt-6 text-3xl font-black">Doctor</h3>
                        <p class="relative mt-3 text-sm leading-7 text-slate-400">
                            Doctor can review appointment requests, update appointment status,
                            and support consultation workflow.
                        </p>
                    </div>

                    <div class="group relative overflow-hidden rounded-[2.5rem] border border-white/10 bg-white/10 p-7 backdrop-blur-2xl transition duration-500 hover:-translate-y-2 dps-live-shadow">
                        <div class="absolute -right-14 -top-14 h-44 w-44 rounded-full bg-purple-400/20 blur-3xl transition group-hover:scale-150"></div>
                        <div class="relative flex h-16 w-16 items-center justify-center rounded-3xl bg-purple-400/15 text-3xl ring-1 ring-purple-300/20">🛡️</div>
                        <h3 class="relative mt-6 text-3xl font-black">Admin</h3>
                        <p class="relative mt-3 text-sm leading-7 text-slate-400">
                            Admin can manage users, doctors, approvals, system records,
                            and appointment-related monitoring.
                        </p>
                    </div>

                    <div class="group relative overflow-hidden rounded-[2.5rem] border border-white/10 bg-white/10 p-7 backdrop-blur-2xl transition duration-500 hover:-translate-y-2 dps-live-shadow">
                        <div class="absolute -right-14 -top-14 h-44 w-44 rounded-full bg-pink-400/20 blur-3xl transition group-hover:scale-150"></div>
                        <div class="relative flex h-16 w-16 items-center justify-center rounded-3xl bg-pink-400/15 text-3xl ring-1 ring-pink-300/20">👑</div>
                        <h3 class="relative mt-6 text-3xl font-black">Super Admin</h3>
                        <p class="relative mt-3 text-sm leading-7 text-slate-400">
                            Super Admin has full system-level control, including admin management
                            and overall project supervision.
                        </p>
                    </div>
                </div>

                <div class="mt-20 grid gap-8 lg:grid-cols-2">
                    <div class="relative overflow-hidden rounded-[2.7rem] border border-white/10 bg-white/10 p-6 backdrop-blur-2xl dps-live-shadow">
                        <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-blue-400/20 blur-3xl"></div>

                        <div class="relative">
                            <p class="text-sm font-black uppercase tracking-[0.35em] text-blue-300">
                                Appointment Module
                            </p>

                            <h2 class="mt-4 text-3xl font-black tracking-tight md:text-5xl">
                                User request and
                                <span class="dps-gradient-text">doctor approval flow.</span>
                            </h2>

                            <p class="mt-5 text-base leading-7 text-slate-400">
                                Appointment feature connects users with doctors after prediction or health concern.
                                User can request appointment and doctor can manage status.
                            </p>

                            <div class="mt-8 space-y-4">
                                <div class="rounded-3xl border border-white/10 bg-slate-950/75 p-5">
                                    <p class="font-black text-white">Appointment Request</p>
                                    <p class="mt-1 text-sm text-slate-400">
                                        User submits doctor, date, time, and problem summary.
                                    </p>
                                </div>

                                <div class="rounded-3xl border border-white/10 bg-slate-950/75 p-5">
                                    <p class="font-black text-white">Doctor Review</p>
                                    <p class="mt-1 text-sm text-slate-400">
                                        Doctor approves, rejects, or completes appointment.
                                    </p>
                                </div>

                                <div class="rounded-3xl border border-white/10 bg-slate-950/75 p-5">
                                    <p class="font-black text-white">Status History</p>
                                    <p class="mt-1 text-sm text-slate-400">
                                        User and doctor can track appointment status clearly.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative overflow-hidden rounded-[2.7rem] border border-white/10 bg-white/10 p-6 backdrop-blur-2xl dps-live-shadow">
                        <div class="absolute -left-16 -bottom-16 h-48 w-48 rounded-full bg-emerald-400/20 blur-3xl"></div>

                        <div class="relative">
                            <p class="text-sm font-black uppercase tracking-[0.35em] text-emerald-300">
                                Medical Records Module
                            </p>

                            <h2 class="mt-4 text-3xl font-black tracking-tight md:text-5xl">
                                Reports and records
                                <span class="dps-gradient-text">inside protected account.</span>
                            </h2>

                            <p class="mt-5 text-base leading-7 text-slate-400">
                                Users can upload and manage medical reports and health records.
                                These remain connected with the user’s authenticated medical workflow.
                            </p>

                            <div class="mt-8 space-y-4">
                                <div class="rounded-3xl border border-white/10 bg-slate-950/75 p-5">
                                    <p class="font-black text-white">Blood Report</p>
                                    <p class="mt-1 text-sm text-slate-400">Medical report management flow.</p>
                                </div>

                                <div class="rounded-3xl border border-white/10 bg-slate-950/75 p-5">
                                    <p class="font-black text-white">X-Ray Report</p>
                                    <p class="mt-1 text-sm text-slate-400">Medical document upload and view flow.</p>
                                </div>

                                <div class="rounded-3xl border border-white/10 bg-slate-950/75 p-5">
                                    <p class="font-black text-white">Prescription</p>
                                    <p class="mt-1 text-sm text-slate-400">Prescription file and health record flow.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative px-5 py-20 lg:px-8">
            <div class="absolute left-0 top-10 -z-10 h-96 w-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
            <div class="absolute right-0 bottom-10 -z-10 h-96 w-96 rounded-full bg-purple-500/10 blur-3xl"></div>

            <div class="mx-auto max-w-7xl">
                <div class="relative overflow-hidden rounded-[3rem] border border-white/10 bg-white/10 p-8 text-center backdrop-blur-2xl dps-live-shadow md:p-14">
                    <div class="absolute -left-20 -top-20 h-64 w-64 rounded-full bg-cyan-400/20 blur-3xl"></div>
                    <div class="absolute -right-20 -bottom-20 h-64 w-64 rounded-full bg-purple-400/20 blur-3xl"></div>

                    <div class="relative mx-auto max-w-4xl">
                        <p class="text-sm font-black uppercase tracking-[0.35em] text-cyan-300">
                            Start Disease Prediction System
                        </p>

                        <h2 class="mt-5 text-4xl font-black tracking-tight md:text-6xl">
                            Ready to use your
                            <span class="dps-gradient-text">smart health platform?</span>
                        </h2>

                        <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-slate-400">
                            Sign in to continue or create a new account to use symptom checker,
                            risk prediction, medical reports, health records, and appointment features.
                        </p>

                        <div class="mt-9 flex flex-col justify-center gap-4 sm:flex-row">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                   class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-300 via-blue-400 to-purple-400 px-8 py-4 font-black text-slate-950 shadow-2xl shadow-cyan-500/25 transition hover:scale-[1.03]">
                                    Enter System
                                </a>
                            @else
                                @if(Route::has('register'))
                                    <a href="{{ route('register') }}"
                                       class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-300 via-blue-400 to-purple-400 px-8 py-4 font-black text-slate-950 shadow-2xl shadow-cyan-500/25 transition hover:scale-[1.03]">
                                        Get Started
                                    </a>
                                @endif

                                <a href="{{ route('login') }}"
                                   class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/10 px-8 py-4 font-black text-white backdrop-blur-xl transition hover:bg-white/15">
                                    Sign in
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="relative border-t border-white/10 px-5 py-10 lg:px-8">
        <div class="mx-auto flex max-w-7xl flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <div class="relative flex h-11 w-11 items-center justify-center rounded-2xl bg-cyan-400/15 ring-1 ring-cyan-300/25">
                    <span class="text-xl">🧬</span>
                </div>

                <div>
                    <p class="font-black text-white">Disease Prediction System</p>
                    <p class="text-xs font-semibold text-slate-500">
                        AI powered health risk prediction project
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4 text-sm font-bold text-slate-400">
                <a href="#prediction" class="transition hover:text-cyan-200">Prediction</a>
                <a href="#modules" class="transition hover:text-cyan-200">Modules</a>
                <a href="#workflow" class="transition hover:text-cyan-200">Workflow</a>
                <a href="#roles" class="transition hover:text-cyan-200">Roles</a>
            </div>
        </div>
    </footer>
</body>
</html>