<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        // Microsoft
        'ms_email',
        'ms_access_token',
        'ms_refresh_token',
        'ms_token_expires_at',
        'ms_connected_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'ms_access_token',
        'ms_refresh_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'ms_access_token'     => 'encrypted',
            'ms_refresh_token'    => 'encrypted',
            'ms_token_expires_at' => 'datetime',
            'ms_connected_at'     => 'datetime',
        ];
    }

    public function hasValidMicrosoftToken(int $gracePeriodMinutes = 5): bool
    {

        if (!$this->ms_access_token || !$this->ms_token_expires_at) {
            return false;
        }
     
        // dd($this->ms_token_expires_at
        //     ->subMinutes($gracePeriodMinutes)
        //     ->isFuture());
        // Token dianggap tidak valid jika kurang dari X menit lagi expired
        return $this->ms_token_expires_at
            ->subMinutes($gracePeriodMinutes)
            ->isFuture();
    }

    public function hasMicrosoftRefreshToken(): bool
    {
        return !empty($this->ms_refresh_token);
    }
}
