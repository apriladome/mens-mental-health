<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ConvertGuestToVerifiedAction
{
    /**
     * Convert an active guest session to a verified account (with email/password).
     *
     * @param array{
     *     email: string,
     *     password: string,
     *     public_handle?: string|null
     * } $data
     */
    public function execute(User $user, array $data): User
    {
        if ($user->auth_type === 'verified') {
            throw ValidationException::withMessages([
                'auth' => ['User account is already verified.'],
            ]);
        }

        $email = strtolower(trim($data['email']));

        $emailExists = User::where('email', $email)
            ->where('id', '!=', $user->id)
            ->exists();

        if ($emailExists) {
            throw ValidationException::withMessages([
                'email' => ['This email address is already registered to another account.'],
            ]);
        }

        return DB::transaction(function () use ($user, $data, $email) {
            $user->update([
                'email' => $email,
                'password' => Hash::make($data['password']),
                'auth_type' => 'verified',
                'guest_token_hash' => null,
            ]);

            if (!empty($data['public_handle'])) {
                $handle = trim($data['public_handle']);
                $handleExists = UserProfile::where('public_handle', $handle)
                    ->where('user_id', '!=', $user->id)
                    ->exists();

                if ($handleExists) {
                    throw ValidationException::withMessages([
                        'public_handle' => ['This tactical handle is already in use.'],
                    ]);
                }

                $user->profile()->update([
                    'public_handle' => $handle,
                ]);
            }

            // Elevate Spatie RBAC to member
            if (method_exists($user, 'removeRole') && method_exists($user, 'assignRole')) {
                $user->removeRole('guest');
                $user->assignRole('member');
            }

            return $user->fresh(['profile', 'roles']);
        });
    }
}