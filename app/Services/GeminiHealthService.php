<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GeminiHealthService
{
    public function analyzeSymptoms(string $symptoms, ?string $memberInfo = null): array
    {
        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model', 'gemini-2.5-flash');

        if (!$apiKey) {
            throw new \Exception('Gemini API key is missing. Please set GEMINI_API_KEY in .env');
        }

        $prompt = $this->buildPrompt($symptoms, $memberInfo);

        $response = Http::timeout(60)
            ->withHeaders([
                'x-goog-api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature' => 0.35,
                    'responseMimeType' => 'application/json',
                ],
            ]);

        if (!$response->successful()) {
            throw new \Exception('Gemini API error: '.$response->body());
        }

        $text = data_get($response->json(), 'candidates.0.content.parts.0.text');

        if (!$text) {
            throw new \Exception('Gemini returned empty response.');
        }

        $clean = Str::of($text)
            ->replace('```json', '')
            ->replace('```', '')
            ->trim()
            ->toString();

        $data = json_decode($clean, true);

        if (!is_array($data)) {
            throw new \Exception('Gemini response JSON parse failed.');
        }

        return [
            'probable_disease' => $data['probable_disease'] ?? 'Needs medical review',
            'severity' => $this->normalizeSeverity($data['severity'] ?? 'medium'),
            'confidence_score' => min(100, max(0, (int)($data['confidence_score'] ?? 60))),
            'next_steps' => $data['next_steps'] ?? 'Please consult a certified doctor.',
            'doctor_specialist' => $data['doctor_specialist'] ?? 'General Physician',
            'red_flags' => $data['red_flags'] ?? [],
            'lifestyle_tips' => $data['lifestyle_tips'] ?? [],
            'medicine_note' => $data['medicine_note'] ?? 'Do not take medicine without doctor advice.',
            'raw' => $data,
        ];
    }

    private function buildPrompt(string $symptoms, ?string $memberInfo): string
    {
        return <<<PROMPT
You are an AI health assistant for a Disease Prediction System.

IMPORTANT:
- You are not a doctor.
- Do not give final diagnosis.
- Do not prescribe exact medicine dosage.
- Always recommend doctor consultation when needed.
- Emergency symptoms must be marked as emergency.

User/family info:
{$memberInfo}

Symptoms:
{$symptoms}

Return ONLY valid JSON with this exact structure:
{
  "probable_disease": "string",
  "severity": "low | medium | high | emergency",
  "confidence_score": 0,
  "next_steps": "string",
  "doctor_specialist": "string",
  "red_flags": ["string"],
  "lifestyle_tips": ["string"],
  "medicine_note": "string"
}
PROMPT;
    }


    private function normalizeSeverity(string $severity): string
    {
        $severity = strtolower(trim($severity));

        return in_array($severity, ['low', 'medium', 'high', 'emergency'])
            ? $severity
            : 'medium';
    }

    public function analyzeRiskFactors(array $data): array
{
    $apiKey = config('services.gemini.api_key');
    $model = config('services.gemini.model', 'gemini-2.5-flash');

    if (!$apiKey) {
        throw new \Exception('Gemini API key is missing.');
    }

    $prompt = <<<PROMPT
You are an advanced AI health risk assessment system.

Analyze the following health data and estimate risk percentages.

Input Data:
{$this->arrayToText($data)}

Return ONLY valid JSON in this format:
{
  "diabetes_risk": 0,
  "heart_disease_risk": 0,
  "kidney_disease_risk": 0,
  "stroke_risk": 0,
  "overall_risk_level": "low | medium | high | critical",
  "recommendation": "string"
}
PROMPT;

    $response = Http::timeout(60)
        ->withHeaders([
            'x-goog-api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])
        ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.2,
                'responseMimeType' => 'application/json',
            ],
        ]);

    if (!$response->successful()) {
        throw new \Exception('Gemini API Error: '.$response->body());
    }

    $text = data_get($response->json(), 'candidates.0.content.parts.0.text');

    $json = json_decode(
        trim(str_replace(['```json', '```'], '', $text)),
        true
    );

    if (!is_array($json)) {
        throw new \Exception('Invalid AI response.');
    }

    return [
        'diabetes_risk' => min(100, max(0, (int)($json['diabetes_risk'] ?? 0))),
        'heart_disease_risk' => min(100, max(0, (int)($json['heart_disease_risk'] ?? 0))),
        'kidney_disease_risk' => min(100, max(0, (int)($json['kidney_disease_risk'] ?? 0))),
        'stroke_risk' => min(100, max(0, (int)($json['stroke_risk'] ?? 0))),
        'overall_risk_level' => $json['overall_risk_level'] ?? 'medium',
        'recommendation' => $json['recommendation'] ?? 'Consult a physician.',
    ];
}


private function arrayToText(array $data): string
{
    $lines = [];

    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $value = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }

        $lines[] = $key . ': ' . $value;
    }

    return implode("\n", $lines);
}

public function analyzeMedicalReport(
    string $reportText,
    string $reportType = 'General Medical Report'
): array {
    $apiKey = config('services.gemini.api_key');
    $model = config('services.gemini.model', 'gemini-2.5-flash');

    if (!$apiKey) {
        throw new \Exception('Gemini API key is missing.');
    }

    $prompt = <<<PROMPT
You are an advanced AI medical report analysis assistant.

Analyze the following medical report and provide a structured summary.

Report Type:
{$reportType}

Report Content:
{$reportText}

IMPORTANT:
- Do not claim to be a doctor.
- Do not provide a final diagnosis.
- Highlight abnormal findings.
- Mention emergency red flags if present.
- Recommend the most appropriate specialist.

Return ONLY valid JSON in this exact format:
{
  "summary": "string",
  "abnormal_findings": ["string"],
  "severity_level": "low | medium | high | emergency",
  "ai_confidence_score": 0,
  "warning_signs": "string",
  "recommended_specialist": "string",
  "health_advice": "string"
}
PROMPT;

    $response = Http::timeout(90)
        ->withHeaders([
            'x-goog-api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])
        ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.25,
                'responseMimeType' => 'application/json',
                'maxOutputTokens' => 4096,
            ],
        ]);

    if (!$response->successful()) {
        throw new \Exception('Gemini API Error: ' . $response->body());
    }

    $text = data_get($response->json(), 'candidates.0.content.parts.0.text');

    if (!$text) {
        throw new \Exception('Gemini returned an empty response.');
    }

    $clean = trim(str_replace(['```json', '```'], '', $text));

    $json = json_decode($clean, true);

    if (!is_array($json)) {
        throw new \Exception('Invalid AI response format.');
    }

    return [
        'summary' => $json['summary'] ?? 'No summary available.',
        'abnormal_findings' => $json['abnormal_findings'] ?? [],
        'severity_level' => $this->normalizeSeverity(
            $json['severity_level'] ?? 'low'
        ),
        'ai_confidence_score' => min(
            100,
            max(0, (int) ($json['ai_confidence_score'] ?? 70))
        ),
        'warning_signs' => $json['warning_signs'] ?? '',
        'recommended_specialist' => $json['recommended_specialist'] ?? 'General Physician',
        'health_advice' => $json['health_advice'] ?? 'Please consult a certified doctor.',
        'raw' => $json,
    ];
}
public function generateHealthInsight(array $healthData): array
{
    $apiKey = config('services.gemini.api_key');
    $model = config('services.gemini.model', 'gemini-2.5-flash');

    if (!$apiKey) {
        throw new \Exception('Gemini API key is missing.');
    }

    $prompt = <<<PROMPT
You are an AI health trend analysis assistant.

Analyze the user's previous health records, symptom checks, risk predictions, and medical reports.

IMPORTANT:
- Do not give final diagnosis.
- Do not prescribe medicine dosage.
- Detect improvement, stable condition, worsening, or critical trend.
- Mention emergency warning if needed.
- Give practical next action plan.
- Use simple patient-friendly language.

Health Data:
{$this->arrayToText($healthData)}

Return ONLY valid JSON in this exact format:
{
  "title": "string",
  "trend_status": "improving | stable | worsening | critical | unknown",
  "confidence_score": 0,
  "health_summary": "string",
  "risk_warning": "string",
  "next_action_plan": "string",
  "key_changes": ["string"]
}
PROMPT;

    $response = \Illuminate\Support\Facades\Http::timeout(90)
        ->withHeaders([
            'x-goog-api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])
        ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.25,
                'responseMimeType' => 'application/json',
                'maxOutputTokens' => 4096,
            ],
        ]);

    if (!$response->successful()) {
        throw new \Exception('Gemini API Error: ' . $response->body());
    }

    $text = data_get($response->json(), 'candidates.0.content.parts.0.text');

    if (!$text) {
        throw new \Exception('Gemini returned empty response.');
    }

    $clean = trim(str_replace(['```json', '```'], '', $text));
    $json = json_decode($clean, true);

    if (!is_array($json)) {
        throw new \Exception('Invalid AI response format.');
    }

    $trend = strtolower($json['trend_status'] ?? 'unknown');

    if (!in_array($trend, ['improving', 'stable', 'worsening', 'critical', 'unknown'])) {
        $trend = 'unknown';
    }

    return [
        'title' => $json['title'] ?? 'AI Health Insight',
        'trend_status' => $trend,
        'confidence_score' => min(100, max(0, (int) ($json['confidence_score'] ?? 70))),
        'health_summary' => $json['health_summary'] ?? 'No summary available.',
        'risk_warning' => $json['risk_warning'] ?? '',
        'next_action_plan' => $json['next_action_plan'] ?? 'Please consult a certified doctor if symptoms continue.',
        'key_changes' => $json['key_changes'] ?? [],
        'raw' => $json,
    ];
}
public function healthChatbotReply(
    string $message,
    string $language = 'auto',
    ?string $memberInfo = null,
    array $recentHistory = []
): array {
    $apiKey = config('services.gemini.api_key');
    $model = config('services.gemini.model', 'gemini-2.5-flash');

    if (!$apiKey) {
        throw new \Exception('Gemini API key is missing.');
    }

    $historyText = $this->arrayToText($recentHistory);

    $prompt = <<<PROMPT
You are a 24/7 AI Health Chatbot for a Disease Prediction System.

User language preference:
{$language}

Family/User profile:
{$memberInfo}

Recent chat history:
{$historyText}

User message:
{$message}

IMPORTANT SAFETY RULES:
- You are not a doctor.
- Do not give final diagnosis.
- Do not prescribe exact medicine dosage.
- Explain in patient-friendly language.
- Support Bangla, English, and Hindi.
- If user writes Bangla, reply in Bangla.
- If user writes English, reply in English.
- If user writes Hindi, reply in Hindi.
- For emergency symptoms such as chest pain, severe breathing problem, unconsciousness, stroke signs, severe bleeding, or severe allergic reaction, tell user to seek emergency medical care immediately.

Return ONLY valid JSON in this exact format:
{
  "reply": "string",
  "confidence_score": 0,
  "language": "bangla | english | hindi | auto",
  "safety_level": "normal | caution | urgent | emergency",
  "recommended_next_step": "string"
}
PROMPT;

    $response = \Illuminate\Support\Facades\Http::timeout(90)
        ->withHeaders([
            'x-goog-api-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])
        ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.35,
                'responseMimeType' => 'application/json',
                'maxOutputTokens' => 4096,
            ],
        ]);

    if (!$response->successful()) {
        throw new \Exception('Gemini API Error: ' . $response->body());
    }

    $text = data_get($response->json(), 'candidates.0.content.parts.0.text');

    if (!$text) {
        throw new \Exception('Gemini returned empty response.');
    }

    $clean = trim(str_replace(['```json', '```'], '', $text));
    $json = json_decode($clean, true);

    if (!is_array($json)) {
        throw new \Exception('Invalid AI response format.');
    }

    $safetyLevel = strtolower($json['safety_level'] ?? 'normal');

    if (!in_array($safetyLevel, ['normal', 'caution', 'urgent', 'emergency'])) {
        $safetyLevel = 'normal';
    }

    return [
        'reply' => $json['reply'] ?? 'Please consult a certified doctor for proper medical advice.',
        'confidence_score' => min(100, max(0, (int) ($json['confidence_score'] ?? 70))),
        'language' => $json['language'] ?? $language,
        'safety_level' => $safetyLevel,
        'recommended_next_step' => $json['recommended_next_step'] ?? 'Consult a certified doctor if symptoms continue.',
        'raw' => $json,
    ];
}
}