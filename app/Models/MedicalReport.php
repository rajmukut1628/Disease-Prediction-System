<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'family_member_id',
        'report_type',
        'title',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
        'ai_summary',
        'warning_signs',
        'is_encrypted',

        'ai_confidence_score',
        'recommended_specialist',
        'severity_level',
        'abnormal_findings',
        'health_advice',
        'ai_raw_response',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'is_encrypted' => 'boolean',
        'abnormal_findings' => 'array',
        'ai_confidence_score' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function getFileSizeHumanAttribute(): string
    {
        if (!$this->file_size) {
            return 'Text Only';
        }

        $bytes = $this->file_size;

        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' B';
    }

    public function getEncryptionLabelAttribute(): string
    {
        return $this->is_encrypted ? 'Encrypted' : 'Text Only';
    }
}