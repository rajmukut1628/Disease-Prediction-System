<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'specialist',
        'degree',
        'experience',
        'license_number',
        'chamber_address',
        'consultation_fee',
        'verification_status',
        'profile_photo',
        'bio',
    ];

    protected $casts = [
        'consultation_fee' => 'decimal:2',
        'experience' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isApproved(): bool
    {
        return $this->verification_status === 'approved';
    }
    public function appointments()
{
    return $this->hasMany(\App\Models\Appointment::class);
}
}