<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;

class MicrosoftTokenService
{
    public function getValidAccessToken(User $user): string
    {
        if ($user->ms_token_expires_at && now()->lt($user->ms_token_expires_at)) {
            return $user->ms_access_token;
        }

        return $this->refreshToken($user);
    }

    protected function refreshToken(User $user): string
    {
        if (!$user->ms_refresh_token) {
            abort(401, 'Microsoft refresh token missing');
        }

        $response = Http::asForm()->post(
            'https://login.microsoftonline.com/'
            . config('services.microsoft.tenant_id')
            . '/oauth2/v2.0/token',
            [
                'client_id'     => config('services.microsoft.client_id'),
                'client_secret' => config('services.microsoft.client_secret'),
                'grant_type'    => 'refresh_token',
                'refresh_token' => $user->ms_refresh_token,
                'scope'         => 'offline_access Files.ReadWrite.All Sites.ReadWrite.All',
            ]
        )->throw()->json();

        $user->update([
            'ms_access_token'     => $response['access_token'],
            'ms_refresh_token'    => $response['refresh_token'] ?? $user->ms_refresh_token,
            'ms_token_expires_at' => now()->addSeconds($response['expires_in']),
        ]);

        return $response['access_token'];
    }
}
