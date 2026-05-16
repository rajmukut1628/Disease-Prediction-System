<nav
    x-data="{ open: false, profileOpen: false }"
    class="mhb-navbar-wrap sticky top-0 z-50"
>
    <style>
        .mhb-navbar-wrap {
            font-family: 'Figtree', system-ui, sans-serif;
        }

        .mhb-premium-nav {
            position: relative;
            overflow: visible;
            border-bottom: 1px solid rgba(255,255,255,.16);
            background:
                radial-gradient(circle at 8% 20%, rgba(34,211,238,.22), transparent 28%),
                radial-gradient(circle at 88% 12%, rgba(139,92,246,.25), transparent 32%),
                linear-gradient(135deg, rgba(2,6,23,.96), rgba(15,23,42,.94));
            backdrop-filter: blur(24px);
            box-shadow: 0 18px 55px rgba(15,23,42,.28);
        }

        .mhb-premium-nav::before {
            content: "";
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            background:
                linear-gradient(90deg, transparent, rgba(34,211,238,.18), transparent),
                radial-gradient(circle at var(--x, 50%) var(--y, 50%), rgba(99,102,241,.22), transparent 28%);
            animation: mhbLiveMove 7s ease-in-out infinite alternate;
        }

        @keyframes mhbLiveMove {
            0% { --x: 8%; --y: 20%; opacity: .75; }
            50% { --x: 75%; --y: 30%; opacity: 1; }
            100% { --x: 95%; --y: 70%; opacity: .78; }
        }

        .mhb-nav-inner {
            position: relative;
            z-index: 2;
        }

        .mhb-brand-card {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            padding: .55rem .85rem;
            border-radius: 1.35rem;
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.14);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.18), 0 14px 34px rgba(0,0,0,.22);
            transition: .35s ease;
        }

        .mhb-brand-card:hover {
            transform: translateY(-2px);
            background: rgba(255,255,255,.14);
        }

        .mhb-logo-orb {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 1.15rem;
            background: linear-gradient(135deg, #22d3ee, #6366f1, #a855f7);
            box-shadow: 0 14px 30px rgba(99,102,241,.42);
            animation: mhbFloat 3.4s ease-in-out infinite;
        }

        @keyframes mhbFloat {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        .mhb-brand-title {
            color: white;
            font-size: .95rem;
            font-weight: 900;
            letter-spacing: -.03em;
            line-height: 1;
        }

        .mhb-brand-subtitle {
            color: rgba(226,232,240,.75);
            font-size: .68rem;
            font-weight: 700;
            margin-top: .2rem;
        }

        .mhb-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .7rem .95rem;
            border-radius: 999px;
            color: rgba(226,232,240,.80);
            font-size: .86rem;
            font-weight: 800;
            transition: .25s ease;
        }

        .mhb-link:hover,
        .mhb-link-active {
            color: white;
            background: rgba(255,255,255,.12);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.14), 0 12px 28px rgba(0,0,0,.18);
        }

        .mhb-link-active::after {
            content: "";
            position: absolute;
            left: 20%;
            right: 20%;
            bottom: .35rem;
            height: 2px;
            border-radius: 999px;
            background: linear-gradient(90deg, #22d3ee, #818cf8, #c084fc);
            box-shadow: 0 0 18px rgba(34,211,238,.75);
        }

        .mhb-role-pill {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .55rem .75rem;
            border-radius: 999px;
            color: rgba(255,255,255,.88);
            font-size: .72rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .08em;
            background: rgba(34,211,238,.12);
            border: 1px solid rgba(34,211,238,.22);
        }

        .mhb-user-trigger {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            padding: .45rem .55rem .45rem .45rem;
            border-radius: 999px;
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.15);
            color: white;
            transition: .25s ease;
        }

        .mhb-user-trigger:hover {
            transform: translateY(-1px);
            background: rgba(255,255,255,.15);
            box-shadow: 0 16px 38px rgba(0,0,0,.24);
        }

        .mhb-avatar {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            color: white;
            font-weight: 950;
            background: linear-gradient(135deg, #06b6d4, #6366f1, #9333ea);
            box-shadow: 0 10px 24px rgba(99,102,241,.35);
        }

        .mhb-logout-direct {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .72rem 1rem;
            border-radius: 999px;
            color: #fecdd3;
            font-size: .82rem;
            font-weight: 900;
            background: rgba(244,63,94,.12);
            border: 1px solid rgba(251,113,133,.24);
            transition: .25s ease;
        }

        .mhb-logout-direct:hover {
            color: white;
            background: rgba(244,63,94,.22);
            transform: translateY(-1px);
            box-shadow: 0 16px 34px rgba(244,63,94,.18);
        }
    </style>

    @php
        $roleLabel = str_replace('_', ' ', Auth::user()->role ?? 'user');
        $initial = strtoupper(substr(Auth::user()->name ?? 'U', 0, 1));
    @endphp

    <div class="mhb-premium-nav">
        <div class="mhb-nav-inner max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center min-h-[76px]">

                {{-- Left Side --}}
                <div class="flex items-center gap-6">
                    <a href="{{ route('dashboard') }}" class="mhb-brand-card">
                        <div class="mhb-logo-orb">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/>
                            </svg>
                        </div>

                        <div>
                            <div class="mhb-brand-title">{{ config('app.name', 'Disease Prediction System') }}</div>
                            <div class="mhb-brand-subtitle">Smart Healthcare Portal</div>
                        </div>
                    </a>

                    <div class="hidden lg:flex items-center gap-2">
                        <a
                            href="{{ route('dashboard') }}"
                            class="mhb-link {{ request()->routeIs('dashboard') ? 'mhb-link-active' : '' }}"
                        >
                            Dashboard
                        </a>

                        @if(in_array(Auth::user()->role, ['user', 'patient']))
                            <a
                                href="{{ route('user.appointments.index') }}"
                                class="mhb-link {{ request()->routeIs('user.appointments.*') ? 'mhb-link-active' : '' }}"
                            >
                                My Appointments
                            </a>
                        @endif

                        @if(Auth::user()->role === 'doctor')
                            <a
                                href="{{ route('doctor.appointments.index') }}"
                                class="mhb-link {{ request()->routeIs('doctor.appointments.*') ? 'mhb-link-active' : '' }}"
                            >
                                Appointments
                            </a>
                        @endif
                    </div>
                </div>
                                {{-- Right Side --}}
                <div class="hidden lg:flex items-center gap-3">
                    <div class="mhb-role-pill">
                        <span class="w-2 h-2 rounded-full bg-cyan-300 shadow-[0_0_14px_rgba(103,232,249,.9)]"></span>
                        {{ $roleLabel }}
                    </div>

                    <div class="relative" @click.outside="profileOpen = false">
                        <button
                            type="button"
                            @click="profileOpen = !profileOpen"
                            class="mhb-user-trigger"
                        >
                            <span class="mhb-avatar">{{ $initial }}</span>

                            <span class="text-left leading-tight hidden xl:block">
                                <span class="block text-sm font-black text-white">
                                    {{ Auth::user()->name }}
                                </span>
                                <span class="block text-[11px] font-bold text-slate-300 max-w-[160px] truncate">
                                    {{ Auth::user()->email }}
                                </span>
                            </span>

                            <svg
                                class="w-4 h-4 text-slate-200 transition"
                                :class="{ 'rotate-180': profileOpen }"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2.4"
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7"/>
                            </svg>
                        </button>

                        <div
                            x-show="profileOpen"
                            x-transition
                            class="absolute right-0 mt-4 w-72 rounded-[1.5rem] overflow-hidden border border-white/15 bg-slate-950/95 backdrop-blur-2xl shadow-2xl shadow-slate-950/50"
                            style="display: none;"
                        >
                            <div class="p-4 border-b border-white/10 bg-white/[.04]">
                                <div class="flex items-center gap-3">
                                    <div class="mhb-avatar">{{ $initial }}</div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-black text-white truncate">
                                            {{ Auth::user()->name }}
                                        </div>
                                        <div class="text-xs font-semibold text-slate-400 truncate">
                                            {{ Auth::user()->email }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <div class="p-2">
    {{-- View Profile --}}
    <a href="{{ route('profile.show') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold text-slate-200 hover:text-white hover:bg-white/10 transition">
        View Profile
    </a>

    {{-- Edit Profile --}}
    <a href="{{ route('profile.edit') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold text-slate-200 hover:text-white hover:bg-white/10 transition">
        Edit Profile
    </a>

                                @if(in_array(Auth::user()->role, ['user', 'patient']))
                                    <a href="{{ url('/user/appointments') }}"
                                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold text-slate-200 hover:text-white hover:bg-white/10 transition">
                                        My Appointments
                                    </a>
                                @endif

                                @if(Auth::user()->role === 'doctor')
                                    <a href="{{ url('/doctor/appointments') }}"
                                       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold text-slate-200 hover:text-white hover:bg-white/10 transition">
                                        Appointments
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold text-rose-200 hover:text-white hover:bg-rose-500/15 transition"
                                    >
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mobile Toggle --}}
                <div class="flex lg:hidden items-center">
                    <button
                        type="button"
                        @click="open = !open"
                        class="w-12 h-12 rounded-2xl grid place-items-center border border-white/15 bg-white/10 text-white shadow-xl transition hover:bg-white/15"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 12h16M4 17h16"/>
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" style="display:none;"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div
            x-show="open"
            x-transition
            class="lg:hidden relative z-20 px-4 pb-5"
            style="display:none;"
        >
            <div class="max-w-7xl mx-auto rounded-[1.6rem] border border-white/15 bg-slate-950/90 backdrop-blur-2xl shadow-2xl shadow-slate-950/40 overflow-hidden">
                <div class="p-4 border-b border-white/10 bg-white/[.04]">
                    <div class="flex items-center gap-3">
                        <div class="mhb-avatar">{{ $initial }}</div>
                        <div class="min-w-0">
                            <div class="text-sm font-black text-white truncate">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="text-xs font-semibold text-slate-400 truncate">
                                {{ Auth::user()->email }}
                            </div>
                            <div class="mt-2 inline-flex px-3 py-1 rounded-full bg-cyan-400/10 border border-cyan-300/20 text-[10px] font-black uppercase tracking-[.16em] text-cyan-100">
                                {{ $roleLabel }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-3 space-y-2">
                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center justify-between px-4 py-3 rounded-2xl text-sm font-black transition
                        {{ request()->routeIs('dashboard') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
                    >
                        <span>Dashboard</span>
                    </a>

                    @if(in_array(Auth::user()->role, ['user', 'patient']))
                        <a
                            href="{{ url('/user/appointments') }}"
                            class="flex items-center justify-between px-4 py-3 rounded-2xl text-sm font-black transition
                            {{ request()->routeIs('user.appointments.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
                        >
                            <span>My Appointments</span>
                        </a>
                    @endif

                    @if(Auth::user()->role === 'doctor')
                        <a
                            href="{{ url('/doctor/appointments') }}"
                            class="flex items-center justify-between px-4 py-3 rounded-2xl text-sm font-black transition
                            {{ request()->routeIs('doctor.appointments.*') ? 'bg-white/15 text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
                        >
                            <span>Appointments</span>
                        </a>
                    @endif

                   {{-- View Profile --}}
    <a href="{{ route('profile.show') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold text-slate-200 hover:text-white hover:bg-white/10 transition">
        View Profile
    </a>

    {{-- Edit Profile --}}
    <a href="{{ route('profile.edit') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-extrabold text-slate-200 hover:text-white hover:bg-white/10 transition">
        Edit Profile
    </a>

                    <form method="POST" action="{{ route('logout') }}" class="pt-2">
                        @csrf
                        <button
                            type="submit"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-2xl text-sm font-black text-rose-200 hover:bg-rose-500/15 hover:text-white transition"
                        >
                            <span>Log Out</span>
                            <span>↗</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>