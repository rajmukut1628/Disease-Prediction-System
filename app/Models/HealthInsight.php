<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthInsight extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'family_member_id',
        'title',
        'trend_status',
        'confidence_score',
        'health_summary',
        'risk_warning',
        'next_action_plan',
        'key_changes',
        'ai_raw_response',
    ];

    protected $casts = [
        'confidence_score' => 'integer',
        'key_changes' => 'array',
        'ai_raw_response' => 'array',
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