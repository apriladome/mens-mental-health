<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'public_handle',
        'avatar_preset_id',
        'timezone',
        'locale',
        'stealth_mode_enabled',
        'retention_preference',
    ];

    protected function casts(): array
    {
        return [
            'stealth_mode_enabled' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}