<x-app-layout>
    <style>
        @keyframes dpsLiveShadow {
            0%,100% {
                box-shadow: 0 25px 80px rgba(34,211,238,.18),
                            0 0 55px rgba(99,102,241,.22);
            }
            50% {
                box-shadow: 0 35px 115px rgba(16,185,129,.24),
                            0 0 90px rgba(168,85,247,.32);
            }
        }

        @keyframes dpsFloat {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .dps-page {
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(34,211,238,.18), transparent 28%),
                radial-gradient(circle at top right, rgba(168,85,247,.18), transparent 30%),
                radial-gradient(circle at bottom left, rgba(16,185,129,.16), transparent 30%),
                linear-gradient(135deg, #020617, #0f172a 55%, #020617);
        }

        .dps-card {
            background: rgba(15,23,42,.78);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.12);
            animation: dpsLiveShadow 5s ease-in-out infinite;
        }

        .dps-soft {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.10);
        }

        .dps-input {
            width: 100%;
            border-radius: 1.25rem;
            border: 1px solid rgba(148,163,184,.28);
            background: rgba(15,23,42,.75);
            color: white;
            padding: 14px 16px;
            outline: none;
            transition: .25s;
        }

        .dps-input:focus {
            border-color: rgba(34,211,238,.85);
            box-shadow: 0 0 0 4px rgba(34,211,238,.14);
        }

        .dps-label {
            color: rgba(226,232,240,.95);
            font-weight: 900;
            font-size: 13px;
            letter-spacing: .04em;
        }

        .dps-float {
            animation: dpsFloat 6s ease-in-out infinite;
        }

        .dps-chat-box {
            max-height: 620px;
            overflow-y: auto;
            scroll-behavior: smooth;
        }

        .dps-chat-box::-webkit-scrollbar {
            width: 8px;
        }

        .dps-chat-box::-webkit-scrollbar-thumb {
            background: rgba(34,211,238,.35);
            border-radius: 999px;
        }
    </style>

    <div class="dps-page px-5 py-8">
        <div class="max-w-7xl mx-auto">

            @if(session('success'))
                <div class="mb-6 rounded-3xl border border-emerald-300/20 bg-emerald-400/10 px-5 py-4 text-emerald-100 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-3xl border border-rose-300/20 bg-rose-400/10 px-5 py-4 text-rose-100 font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="dps-card rounded-[2rem] p-7 md:p-9 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 mb-5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span class="text-sm font-black text-cyan-100">24/7 AI Health Assistant</span>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-black text-white">
                            AI Health
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-300 to-violet-300">
                                Chatbot
                            </span>
                        </h1>

                        <p class="mt-4 text-slate-300 max-w-2xl">
                            Ask health-related questions in Bangla, English or Hindi.
                            AI will reply with safe guidance, next steps and emergency warnings when needed.
                        </p>
                    </div>

                    <div class="dps-float w-28 h-28 rounded-[2rem] bg-gradient-to-br from-cyan-400 via-blue-600 to-violet-700 flex items-center justify-center text-5xl shadow-2xl">
                        💬
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 dps-card rounded-[2rem] p-5 md:p-6">
                    <div class="flex items-center justify-between gap-4 mb-5">
                        <div>
                            <h2 class="text-2xl font-black text-white">Chat Conversation</h2>
                            <p class="mt-1 text-sm text-slate-400">
                                Your recent AI health chat history.
                            </p>
                        </div>

                        <span class="px-4 py-2 rounded-full bg-emerald-400/10 border border-emerald-300/20 text-emerald-200 font-black text-sm">
                            Online
                        </span>
                    </div>

                    <div id="chatBox" class="dps-chat-box space-y-5 pr-2">
                                                @forelse($chats as $chat)
                            <div class="space-y-4">
                                <div class="ml-auto max-w-3xl rounded-[2rem] bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-6 py-4 shadow-2xl">
                                    <p class="text-sm font-black mb-2">You</p>
                                    <p class="leading-7 whitespace-pre-line">{{ $chat->user_message }}</p>
                                </div>

                                <div class="max-w-3xl rounded-[2rem] bg-white/8 border border-white/10 text-slate-100 px-6 py-5 shadow-xl">
                                    <div class="flex flex-wrap items-center gap-2 mb-3">
                                        <span class="px-3 py-1 rounded-full bg-violet-500/15 border border-violet-300/20 text-violet-200 text-xs font-black">
                                            AI
                                        </span>

                                        <span class="px-3 py-1 rounded-full bg-cyan-500/15 border border-cyan-300/20 text-cyan-200 text-xs font-black">
                                            {{ $chat->confidence_score }}% Confidence
                                        </span>

                                        @php
                                            $safety = data_get($chat->meta, 'safety_level', 'normal');
                                            $safetyColors = [
                                                'normal' => 'bg-emerald-400/10 border-emerald-300/20 text-emerald-200',
                                                'caution' => 'bg-amber-400/10 border-amber-300/20 text-amber-200',
                                                'urgent' => 'bg-orange-400/10 border-orange-300/20 text-orange-200',
                                                'emergency' => 'bg-rose-500/10 border-rose-300/20 text-rose-200',
                                            ];
                                        @endphp

                                        <span class="px-3 py-1 rounded-full border text-xs font-black capitalize {{ $safetyColors[$safety] ?? $safetyColors['normal'] }}">
                                            {{ $safety }}
                                        </span>
                                    </div>

                                    <p class="leading-7 whitespace-pre-line text-slate-200">
                                        {{ $chat->ai_response }}
                                    </p>

                                    @if(data_get($chat->meta, 'recommended_next_step'))
                                        <div class="mt-4 rounded-2xl bg-cyan-500/10 border border-cyan-300/20 p-4">
                                            <p class="text-cyan-100 font-black text-sm">Recommended Next Step</p>
                                            <p class="mt-1 text-sm text-cyan-100/80 leading-6">
                                                {{ data_get($chat->meta, 'recommended_next_step') }}
                                            </p>
                                        </div>
                                    @endif

                                    <p class="mt-4 text-xs text-slate-500">
                                        {{ $chat->created_at->format('d M Y, h:i A') }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-[2rem] border border-dashed border-white/10 p-12 text-center">
                                <div class="mx-auto w-20 h-20 rounded-3xl bg-cyan-400/10 border border-cyan-300/20 flex items-center justify-center text-4xl">
                                    💬
                                </div>

                                <h3 class="mt-5 text-2xl font-black text-white">
                                    Start Your First Health Conversation
                                </h3>

                                <p class="mt-2 text-slate-400 max-w-2xl mx-auto">
                                    Ask any health question in Bangla, English, or Hindi and receive AI guidance.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <form method="POST"
                          action="{{ route('user.ai-health-chat.send') }}"
                          class="mt-6 space-y-4">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="dps-label" for="family_member_id">PROFILE</label>
                                <select id="family_member_id" name="family_member_id" class="dps-input mt-2">
                                    <option class="text-slate-900" value="">My Own Profile</option>

                                    @foreach($familyMembers as $member)
                                        <option class="text-slate-900"
                                                value="{{ $member->id }}"
                                                @selected(old('family_member_id') == $member->id)>
                                            {{ $member->name }} — {{ $member->relation ?? 'Family Member' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="dps-label" for="language">LANGUAGE</label>
                                <select id="language" name="language" class="dps-input mt-2">
                                    <option class="text-slate-900" value="auto" @selected(old('language', 'auto') === 'auto')>Auto Detect</option>
                                    <option class="text-slate-900" value="bangla" @selected(old('language') === 'bangla')>বাংলা</option>
                                    <option class="text-slate-900" value="english" @selected(old('language') === 'english')>English</option>
                                    <option class="text-slate-900" value="hindi" @selected(old('language') === 'hindi')>हिन्दी</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="dps-label" for="message">YOUR QUESTION</label>
                            <textarea id="message"
                                      name="message"
                                      rows="5"
                                      class="dps-input mt-2 resize-none"
                                      placeholder="Describe your symptoms or ask a health question...">{{ old('message') }}</textarea>
                            <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        </div>

                        <button type="submit"
                                class="w-full rounded-2xl py-4 bg-gradient-to-r from-cyan-500 via-blue-600 to-violet-600 text-white font-black shadow-2xl hover:scale-[1.01] transition">
                            Send to AI
                        </button>
                    </form>
                </div>

                <div class="space-y-6">
                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-2xl font-black text-white">AI Assistant Status</h3>

                        <div class="mt-5 space-y-3">
                            <div class="dps-soft rounded-3xl p-5">
                                <p class="text-slate-400 text-sm font-bold">Provider</p>
                                <p class="mt-2 text-3xl font-black text-cyan-300">Gemini</p>
                            </div>

                            <div class="dps-soft rounded-3xl p-5">
                                <p class="text-slate-400 text-sm font-bold">Languages</p>
                                <p class="mt-2 text-lg font-black text-white">
                                    বাংলা · English · हिन्दी
                                </p>
                            </div>

                            <div class="dps-soft rounded-3xl p-5">
                                <p class="text-slate-400 text-sm font-bold">Saved Chats</p>
                                <p class="mt-2 text-4xl font-black text-white">
                                    {{ $chats->count() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-xl font-black text-white">Safety Notice</h3>
                        <p class="mt-3 text-sm text-slate-300 leading-6">
                            This AI assistant provides educational guidance only and cannot replace medical diagnosis,
                            prescriptions, laboratory interpretation, or emergency treatment.
                        </p>
                    </div>

                    <div class="dps-card rounded-[2rem] p-6">
                        <h3 class="text-xl font-black text-white">Emergency Symptoms</h3>
                        <ul class="mt-4 space-y-2 text-sm text-rose-100/80">
                            <li>🚨 Severe chest pain</li>
                            <li>🚨 Difficulty breathing</li>
                            <li>🚨 Stroke warning signs</li>
                            <li>🚨 Unconsciousness</li>
                            <li>🚨 Severe bleeding</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatBox = document.getElementById('chatBox');
            if (chatBox) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
    </script>
</x-app-layout>