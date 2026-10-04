<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'encrypted_contact_name',
        'encrypted_relationship',
        'encrypted_phone_number',
        'can_contact_in_crisis',
    ];

    /**
     * Uses Laravel's native encryption at rest (AES-256-GCM)
     */
    protected function casts(): array
    {
        return [
            'encrypted_contact_name' => 'encrypted',
            'encrypted_relationship' => 'encrypted',
            'encrypted_phone_number' => 'encrypted',
            'can_contact_in_crisis' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}