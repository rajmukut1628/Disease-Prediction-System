<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\SymptomCheck;

class DoctorRecommendationController extends Controller
{
    public function index()
    {
        $latestChecks = SymptomCheck::where('user_id', auth()->id())
            ->latest()
            ->take(10)
            ->get();

        $doctors = Doctor::with('user')
            ->where('verification_status', 'approved')
            ->latest()
            ->paginate(12);

        return view('user.doctor-recommendations.index', compact(
            'latestChecks',
            'doctors'
        ));
    }

    public function fromSymptomCheck(SymptomCheck $symptomCheck)
    {
        if ((int) $symptomCheck->user_id !== (int) auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $aiData = $symptomCheck->ai_response
            ? json_decode($symptomCheck->ai_response, true)
            : [];

        $specialist = $aiData['doctor_specialist']
            ?? $this->mapDiseaseToSpecialist($symptomCheck->probable_disease);

        $doctors = Doctor::with('user')
            ->where('verification_status', 'approved')
            ->where(function ($query) use ($specialist) {
                $query->where('specialist', 'like', "%{$specialist}%")
                    ->orWhere('specialist', 'like', "%General Physician%");
            })
            ->latest()
            ->paginate(12);

        return view('user.doctor-recommendations.index', [
            'latestChecks' => SymptomCheck::where('user_id', auth()->id())
                ->latest()
                ->take(10)
                ->get(),
            'doctors' => $doctors,
            'selectedCheck' => $symptomCheck,
            'recommendedSpecialist' => $specialist,
        ]);
    }

    private function mapDiseaseToSpecialist(?string $disease): string
    {
        $text = strtolower($disease ?? '');

        return match (true) {
            str_contains($text, 'heart'),
            str_contains($text, 'chest'),
            str_contains($text, 'cardiac') => 'Cardiologist',

            str_contains($text, 'diabetes'),
            str_contains($text, 'thyroid'),
            str_contains($text, 'hormone') => 'Endocrinologist',

            str_contains($text, 'kidney'),
            str_contains($text, 'urine'),
            str_contains($text, 'renal') => 'Nephrologist',

            str_contains($text, 'brain'),
            str_contains($text, 'stroke'),
            str_contains($text, 'headache'),
            str_contains($text, 'nerve') => 'Neurologist',

            str_contains($text, 'skin'),
            str_contains($text, 'rash'),
            str_contains($text, 'allergy') => 'Dermatologist',

            str_contains($text, 'child'),
            str_contains($text, 'pediatric') => 'Pediatrician',

            str_contains($text, 'bone'),
            str_contains($text, 'joint'),
            str_contains($text, 'fracture') => 'Orthopedic',

            str_contains($text, 'pregnancy'),
            str_contains($text, 'women'),
            str_contains($text, 'gyne') => 'Gynecologist',

            default => 'General Physician',
        };
    }
}