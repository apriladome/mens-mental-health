<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'uuid',
        'email',
        'password',
        'auth_type',
        'guest_token_hash',
        'is_banned',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'guest_token_hash',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_banned' => 'boolean',
        ];
    }

    /**
     * Automatically generate a UUID when creating a new user.
     */
    protected static function booted(): void
    {
        static::creating(function ($user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) Str::uuid();
            }
        });
    }

    // Relationships
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class);
    }

    /**
     * Determine if this user can access the Filament admin portal.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->is_banned) {
            return false;
        }

        // Grant access only to staff roles
        return $this->hasAnyRole([
            'super_admin',
            'clinical_director',
            'clinician',
            'moderator',
        ]);
    }

    /**
     * Provide Filament with the display name using the profile handle or email.
     */
    public function getFilamentName(): string
    {
        return $this->profile?->public_handle ?? $this->email ?? 'Operator';
    }
}