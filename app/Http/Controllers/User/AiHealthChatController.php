<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AiChatHistory;
use App\Models\FamilyMember;
use App\Services\GeminiHealthService;
use Illuminate\Http\Request;

class AiHealthChatController extends Controller
{
    public function index()
    {
        $familyMembers = FamilyMember::where('user_id', auth()->id())
            ->latest()
            ->get();

        $chats = AiChatHistory::where('user_id', auth()->id())
            ->with('familyMember')
            ->latest()
            ->take(30)
            ->get()
            ->reverse();

        return view('user.ai-health-chat.index', compact('familyMembers', 'chats'));
    }

    public function send(Request $request, GeminiHealthService $gemini)
    {
        $validated = $request->validate([
            'family_member_id' => ['nullable', 'exists:family_members,id'],
            'language' => ['required', 'in:auto,bangla,english,hindi'],
            'message' => ['required', 'string', 'min:2', 'max:5000'],
        ]);

        $member = null;
        $memberInfo = 'Main user profile';

        if (!empty($validated['family_member_id'])) {
            $member = FamilyMember::where('user_id', auth()->id())
                ->where('id', $validated['family_member_id'])
                ->firstOrFail();

            $memberInfo = "Name: {$member->name}, Relation: {$member->relation}, Age: {$member->age}, Gender: {$member->gender}, Blood Group: {$member->blood_group}, Conditions: {$member->medical_conditions}, Allergies: {$member->allergies}";
        }

        $recentHistory = AiChatHistory::where('user_id', auth()->id())
            ->when($member, fn ($q) => $q->where('family_member_id', $member->id))
            ->latest()
            ->take(8)
            ->get()
            ->map(fn ($chat) => [
                'user_message' => $chat->user_message,
                'ai_response' => $chat->ai_response,
                'language' => $chat->language,
            ])
            ->values()
            ->toArray();

        try {
            $ai = $gemini->healthChatbotReply(
                $validated['message'],
                $validated['language'],
                $memberInfo,
                $recentHistory
            );

            AiChatHistory::create([
                'user_id' => auth()->id(),
                'family_member_id' => $member?->id,
                'user_message' => $validated['message'],
                'ai_response' => $ai['reply'],
                'language' => $ai['language'],
                'confidence_score' => $ai['confidence_score'],
                'meta' => [
                    'safety_level' => $ai['safety_level'],
                    'recommended_next_step' => $ai['recommended_next_step'],
                    'raw' => $ai['raw'],
                ],
            ]);

            return redirect()
                ->route('user.ai-health-chat.index')
                ->with('success', 'AI replied successfully.');

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}