<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'relation',
        'age',
        'gender',
        'blood_group',
        'height_cm',
        'weight_kg',
        'medical_conditions',
        'allergies',
    ];

    protected $casts = [
        'age' => 'integer',
        'height_cm' => 'decimal:2',
        'weight_kg' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function symptomChecks()
    {
        return $this->hasMany(SymptomCheck::class);
    }

    public function riskPredictions()
    {
        return $this->hasMany(RiskPrediction::class);
    }

    public function medicalReports()
    {
        return $this->hasMany(MedicalReport::class);
    }

    public function healthRecords()
    {
        return $this->hasMany(HealthRecord::class);
    }
    public function healthInsights()
{
    return $this->hasMany(HealthInsight::class);
}
public function aiChatHistories()
{
    return $this->hasMany(AiChatHistory::class);
}
}