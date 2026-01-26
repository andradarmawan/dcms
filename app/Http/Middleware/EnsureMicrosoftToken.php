<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\MicrosoftAuthService;

class EnsureMicrosoftToken
{
    public function __construct(MicrosoftAuthService $microsoftAuthService)
    {
        $this->microsoftAuthService = $microsoftAuthService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Auto-refresh token jika perlu
        if (!$this->microsoftAuthService->ensureValidToken($user)) {
            return redirect()
                ->route('auth.microsoft')
                ->with('info', 'Your Microsoft session has expired. Please reconnect.');
        }

        return $next($request);
    }
}
