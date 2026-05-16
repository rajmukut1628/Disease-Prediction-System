<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskPrediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'family_member_id',
        'diabetes_risk',
        'heart_disease_risk',
        'kidney_disease_risk',
        'stroke_risk',
        'overall_risk_level',
        'input_data',
        'recommendation',
    ];

    protected $casts = [
        'diabetes_risk' => 'integer',
        'heart_disease_risk' => 'integer',
        'kidney_disease_risk' => 'integer',
        'stroke_risk' => 'integer',
        'input_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }
}