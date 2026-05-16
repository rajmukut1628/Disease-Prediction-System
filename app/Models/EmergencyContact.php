<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'relation',
        'phone',
        'email',
        'is_primary',
        'notify_by_sms',
        'notify_by_email',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'notify_by_sms' => 'boolean',
        'notify_by_email' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}