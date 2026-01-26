<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;

class MicrosoftGraphService
{
    public function getAccessToken(User $user): string
    {
        // OPTIONAL: refresh token jika expired
        return $user->ms_access_token;
    }

    public function getMyDrive(User $user): array
    {
        return Http::withToken($this->getAccessToken($user))
            ->get('https://graph.microsoft.com/v1.0/me/drive')
            ->json();
    }

    public function getItemByPath(User $user, string $path): array
    {
        return Http::withToken($this->getAccessToken($user))
            ->get("https://graph.microsoft.com/v1.0/me/drive/root:/{$path}")
            ->json();
    }
}