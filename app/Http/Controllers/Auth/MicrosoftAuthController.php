<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\MicrosoftAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MicrosoftAuthController extends Controller
{
    public function redirect(MicrosoftAuthService $service)
    {
        return redirect($service->getLoginUrl());
    }

    public function callback(Request $request, MicrosoftAuthService $service)
    {
        if ($request->state !== session('ms_oauth_state')) {
            abort(403, 'Invalid OAuth state');
        }

        $user = auth()->user();
        if (!$user) {
            abort(401, 'User not authenticated');
        }

        $token = $service->getToken($request->code);

        $profile = Http::withToken($token['access_token'])
            ->get('https://graph.microsoft.com/v1.0/me')
            ->json();

        $user->update([
            'ms_email'             => $profile['mail'] ?? $profile['userPrincipalName'],
            'ms_access_token'      => $token['access_token'],
            'ms_refresh_token'     => $token['refresh_token'] ?? null,
            'ms_token_expires_at'  => now()->addSeconds($token['expires_in']),
            'ms_connected_at'      => now(),
        ]);

        return redirect('/dashboard')->with('success', 'Microsoft account connected');
    }

    public function disconnect()
    {
        auth()->user()->update([
            'ms_access_token'      => null,
            'ms_refresh_token'     => null,
            'ms_email'             => null,
            'ms_token_expires_at'  => null,
            'ms_connected_at'      => null,
        ]);

        return back()->with('status', 'Microsoft disconnected');
    }
}