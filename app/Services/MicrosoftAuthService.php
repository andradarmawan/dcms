<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class MicrosoftAuthService
{
    protected string $tenant;
    protected string $clientId;
    protected string $clientSecret;
    protected string $redirectUri;

    public function __construct()
    {
        $this->tenant = config('services.microsoft.tenant');
        $this->clientId = config('services.microsoft.client_id');
        $this->clientSecret = config('services.microsoft.client_secret');
        $this->redirectUri = config('services.microsoft.redirect');
    }

    /**
     * Generate Microsoft OAuth login URL
     */
    public function getLoginUrl(): string
    {
        $state = bin2hex(random_bytes(16));
        session(['ms_oauth_state' => $state]);

        $query = http_build_query([
            'client_id'     => $this->clientId,
            'response_type' => 'code',
            'redirect_uri'  => $this->redirectUri,
            'response_mode' => 'query',
            'scope'         => implode(' ', [
                'openid',
                'profile',
                'offline_access',
                'User.Read',
                'Files.ReadWrite.All',
                'Sites.ReadWrite.All',
            ]),
            'state'         => $state,
            'prompt'        => 'select_account'
        ]);

        return "https://login.microsoftonline.com/{$this->tenant}/oauth2/v2.0/authorize?{$query}";
    }


    /**
     * Exchange auth code to access token
     */
    public function getToken(string $code): array
    {
        $response = Http::asForm()->post(
            "https://login.microsoftonline.com/{$this->tenant}/oauth2/v2.0/token",
            [
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type'    => 'authorization_code',
                'code'          => $code,
                'redirect_uri'  => $this->redirectUri,
                'scope'         => 'https://graph.microsoft.com/.default'
            ]
        );

        if ($response->failed()) {
            throw new \Exception('Failed to get Microsoft token: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Get Microsoft user profile
     */
    public function getUserProfile(string $accessToken): array
    {
        $response = Http::withToken($accessToken)
            ->get('https://graph.microsoft.com/v1.0/me');

        if ($response->failed()) {
            throw new \Exception('Failed to fetch Microsoft profile');
        }

        return $response->json();
    }

    public function ensureValidToken(User $user): bool
    {
        // Jika token masih valid, tidak perlu refresh
        if ($user->hasValidMicrosoftToken()) {
            return true;
        }

        // Token expired atau akan expired, coba refresh
        if ($user->hasMicrosoftRefreshToken()) {
            return $this->refreshAccessToken($user);
        }

        // Tidak ada refresh token, perlu login ulang
        return false;
    }


        /**
     * Refresh access token menggunakan refresh token
     */
    public function refreshAccessToken(User $user): bool
    {
        if (!$user->hasMicrosoftRefreshToken()) {
            Log::warning("User {$user->id} has no refresh token");
            return false;
        }

        try {
            $response = Http::asForm()->post("https://login.microsoftonline.com/{$this->tenant}/oauth2/v2.0/token", [
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
                'refresh_token' => $user->ms_refresh_token,
                'grant_type'    => 'refresh_token',
                'scope'         => implode(' ', [
                    'openid',
                    'profile',
                    'offline_access',
                    'User.Read',
                    'Files.ReadWrite.All',
                    'Sites.ReadWrite.All',
                ])
            ]);


            if ($response->failed()) {
                Log::error("Failed to refresh token for user {$user->id}", [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                // Jika refresh token invalid (401, 400), clear tokens
                if (in_array($response->status(), [400, 401])) {
                    $user->update([
                        'ms_access_token' => null,
                        'ms_email' => null,
                        'ms_refresh_token' => null,
                        'ms_token_expires_at' => null,
                        'ms_connected_at' => null,
                    ]);
                }
                
                return false;
            }

            $tokens = $response->json();
            $profile = Http::withToken($tokens['access_token'])
                ->get('https://graph.microsoft.com/v1.0/me')
                ->json();
        
            // Update dengan token baru
            $user->update([
                'ms_access_token'       => $tokens['access_token'],
                'ms_refresh_token'      => $tokens['refresh_token'] ?? $user->ms_refresh_token,
                'ms_token_expires_at'   => now()->addSeconds($tokens['expires_in']),
                'ms_email'              => $profile['mail'] ?? $profile['userPrincipalName'],
                'ms_connected_at'       => now(),
            ]);

            Log::info("Successfully refreshed token for user {$user->id}");
            return true;

        } catch (\Exception $e) {
            Log::error("Exception refreshing token for user {$user->id}: " . $e->getMessage());
            return false;
        }
    }
}
