<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SymptomCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'family_member_id',
        'symptoms',
        'probable_disease',
        'severity',
        'confidence_score',
        'next_steps',
        'ai_response',
    ];

    protected $casts = [
        'confidence_score' => 'integer',
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