<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicianAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinician_profile_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_recurring',
    ];

    protected function casts(): array
    {
        return [
            'is_recurring' => 'boolean',
            'day_of_week' => 'integer',
        ];
    }

    public function clinician()
    {
        return $this->belongsTo(ClinicianProfile::class, 'clinician_profile_id');
    }
}