<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'family_member_id',
        'height_cm',
        'weight_kg',
        'bmi',
        'blood_pressure',
        'sugar_level',
        'heart_rate',
        'oxygen_level',
        'sleep_hours',
        'water_intake_ml',
        'notes',
    ];

    protected $casts = [
        'height_cm' => 'decimal:2',
        'weight_kg' => 'decimal:2',
        'bmi' => 'decimal:2',
        'sugar_level' => 'decimal:2',
        'heart_rate' => 'integer',
        'oxygen_level' => 'integer',
        'sleep_hours' => 'decimal:2',
        'water_intake_ml' => 'integer',
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