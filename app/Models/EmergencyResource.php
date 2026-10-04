<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_code',
        'region_code',
        'resource_name',
        'phone_number',
        'sms_number',
        'web_url',
        'is_veteran_specific',
        'operating_hours',
    ];

    protected function casts(): array
    {
        return [
            'is_veteran_specific' => 'boolean',
        ];
    }
}