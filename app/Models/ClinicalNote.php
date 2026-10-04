<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'clinician_profile_id',
        'encrypted_soap_notes',
        'signed_at',
    ];

    protected function casts(): array
    {
        return [
            'encrypted_soap_notes' => 'encrypted',
            'signed_at' => 'datetime',
        ];
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function clinician()
    {
        return $this->belongsTo(ClinicianProfile::class, 'clinician_profile_id');
    }
}