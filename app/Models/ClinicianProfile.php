<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicianProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'legal_name',
        'professional_title',
        'bio_summary',
        'license_number',
        'licensing_state_or_jurisdiction',
        'license_verified_at',
        'hourly_rate_cents',
        'max_weekly_caseload',
        'is_accepting_clients',
    ];

    protected function casts(): array
    {
        return [
            'legal_name' => 'encrypted',
            'license_number' => 'encrypted',
            'license_verified_at' => 'datetime',
            'is_accepting_clients' => 'boolean',
            'hourly_rate_cents' => 'integer',
            'max_weekly_caseload' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialties()
    {
        return $this->belongsToMany(Specialty::class, 'clinician_specialty');
    }

    public function availabilities()
    {
        return $this->hasMany(ClinicianAvailability::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}