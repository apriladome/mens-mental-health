<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\GuestSessionManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureGuestOrAuthenticated
{
    public function __construct(
        protected GuestSessionManager $guestSessionManager
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Intercept and ensure a persistent guest or authenticated user exists
        $user = $this->guestSessionManager->ensureSession($request);

        // Bind user explicitly to request instance
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}