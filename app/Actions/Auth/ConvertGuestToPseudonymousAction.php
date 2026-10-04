<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ConvertGuestToPseudonymousAction
{
    /**
     * Convert an active guest session to a pseudonymous account without losing historical records.
     *
     * @param array{
     *     public_handle: string,
     *     password: string
     * } $data
     */
    public function execute(User $user, array $data): User
    {
        if ($user->auth_type !== 'guest') {
            throw ValidationException::withMessages([
                'auth' => ['User account has already been upgraded.'],
            ]);
        }

        // Validate handle uniqueness if modified
        $handle = trim($data['public_handle']);
        $existingProfile = UserProfile::where('public_handle', $handle)
            ->where('user_id', '!=', $user->id)
            ->exists();

        if ($existingProfile) {
            throw ValidationException::withMessages([
                'public_handle' => ['This tactical handle is already in use.'],
            ]);
        }

        return DB::transaction(function () use ($user, $data, $handle) {
            // 1. Upgrade user credentials
            $user->update([
                'password' => Hash::make($data['password']),
                'auth_type' => 'pseudonymous',
                'guest_token_hash' => null, // Invalidate guest cookie lookup
            ]);

            // 2. Update profile handle
            $user->profile()->update([
                'public_handle' => $handle,
            ]);

            // 3. Elevate Spatie RBAC from guest to member
            if (method_exists($user, 'removeRole') && method_exists($user, 'assignRole')) {
                $user->removeRole('guest');
                $user->assignRole('member');
            }

            return $user->fresh(['profile', 'roles']);
        });
    }
}