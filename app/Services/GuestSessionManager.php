<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;

class GuestSessionManager
{
    public const COOKIE_NAME = 'mmh_guest_token';
    public const COOKIE_LIFETIME_MINUTES = 60 * 24 * 30; // 30 days retention

    /**
     * Resolve the current user: authenticated, existing guest via cookie, or newly provisioned guest.
     */
    public function ensureSession(Request $request): User
    {
        // 1. If user is already authenticated via Laravel session guard
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            return $user;
        }

        // 2. Inspect request for guest token cookie
        $rawToken = $request->cookie(self::COOKIE_NAME);

        if ($rawToken && is_string($rawToken)) {
            $tokenHash = hash('sha256', $rawToken);
            $existingGuest = User::where('guest_token_hash', $tokenHash)
                ->where('auth_type', 'guest')
                ->where('is_banned', false)
                ->first();

            if ($existingGuest) {
                Auth::login($existingGuest, remember: true);
                return $existingGuest;
            }
        }

        // 3. Provision a brand new zero-knowledge guest
        return $this->createGuest();
    }

    /**
     * Atomically create an anonymous guest user, generate a secure token, and log them in.
     */
    public function createGuest(): User
    {
        return DB::transaction(function () {
            $plainToken = Str::random(64);
            $tokenHash = hash('sha256', $plainToken);

            /** @var User $guestUser */
            $guestUser = User::create([
                'auth_type' => 'guest',
                'guest_token_hash' => $tokenHash,
                'email' => null,
                'password' => null,
                'is_banned' => false,
            ]);

            // Assign Spatie guest role
            if (method_exists($guestUser, 'assignRole')) {
                $guestUser->assignRole('guest');
            }

            // Create default anonymous profile
            UserProfile::create([
                'user_id' => $guestUser->id,
                'public_handle' => $this->generateUniqueGuestHandle(),
                'avatar_preset_id' => 'default_monochrome',
                'timezone' => 'UTC',
                'locale' => 'en',
                'stealth_mode_enabled' => false,
                'retention_preference' => 'full',
            ]);

            // Set encrypted HTTP-only cookie queue for the upcoming response
            Cookie::queue(
                self::COOKIE_NAME,
                $plainToken,
                self::COOKIE_LIFETIME_MINUTES,
                path: '/',
                domain: null,
                secure: config('session.secure', false),
                httpOnly: true,
                raw: false,
                sameSite: SymfonyCookie::SAMESITE_LAX
            );

            Auth::login($guestUser, remember: false);

            return $guestUser;
        });
    }

    /**
     * Generate a non-identifying, collisions-resistant guest handle (e.g. Guest_8492).
     */
    public function generateUniqueGuestHandle(): string
    {
        do {
            $handle = 'Guest_' . random_int(1000, 99999);
        } while (UserProfile::where('public_handle', $handle)->exists());

        return $handle;
    }
}