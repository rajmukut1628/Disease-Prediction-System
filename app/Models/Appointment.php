<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'user_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'patient_name',
        'patient_phone',
        'problem_description',
        'status',
        'doctor_note',
        'reject_reason',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'appointment_date' => 'date',
        // appointment_time কে datetime cast না করে raw time string হিসেবেই রাখছি
        // যাতে Carbon::parse() দিয়ে যেকোনো format সহজে করা যায়
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Status Helpers
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Professional 12-hour time format
     * Example:
     * 16:30:00 => 04:30 PM
     * 10:05:00 => 10:05 AM
     */
    public function formattedTime(): string
    {
        if (empty($this->appointment_time)) {
            return 'N/A';
        }

        return Carbon::parse($this->appointment_time)->format('h:i A');
    }

    /**
     * Professional date format
     * Example:
     * 2026-05-16 => 16 May 2026
     */
    public function formattedDate(): string
    {
        if (empty($this->appointment_date)) {
            return 'N/A';
        }

        return Carbon::parse($this->appointment_date)->format('d M Y');
    }

    /**
     * Combined date and time
     * Example:
     * 16 May 2026 at 04:30 PM
     */
    public function formattedDateTime(): string
    {
        return $this->formattedDate() . ' at ' . $this->formattedTime();
    }

    /**
     * Human readable status
     * Example:
     * pending => Pending
     */
    public function formattedStatus(): string
    {
        return ucfirst($this->status);
    }

    /**
     * Check if appointment is active
     * (Pending or Approved)
     */
    public function isActive(): bool
    {
        return in_array($this->status, [
            'pending',
            'approved',
        ]);
    }

    /**
     * Scope: only active appointments
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', [
            'pending',
            'approved',
        ]);
    }

    /**
     * Scope: by specific doctor
     */
    public function scopeForDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Scope: by specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}