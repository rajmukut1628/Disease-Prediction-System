<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
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

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
    public function healthInsights()
{
    return $this->hasMany(HealthInsight::class);
}
public function emergencyContacts()
{
    return $this->hasMany(EmergencyContact::class);
}
public function aiChatHistories()
{
    return $this->hasMany(AiChatHistory::class);
}
public function appointments()
{
    return $this->hasMany(\App\Models\Appointment::class);
}
}