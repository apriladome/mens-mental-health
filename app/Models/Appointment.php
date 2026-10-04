<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'clinician_profile_id',
        'scheduled_start_time',
        'scheduled_end_time',
        'status',
        'telehealth_room_name',
        'cancellation_reason',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_start_time' => 'datetime',
            'scheduled_end_time' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($appointment) {
            if (empty($appointment->uuid)) {
                $appointment->uuid = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinician()
    {
        return $this->belongsTo(ClinicianProfile::class, 'clinician_profile_id');
    }

    public function clinicalNote()
    {
        return $this->hasOne(ClinicalNote::class);
    }
}