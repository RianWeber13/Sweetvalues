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
        'two_factor_code',
        'two_factor_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'     => 'datetime',
            'password'              => 'hashed',
            'two_factor_expires_at' => 'datetime',
        ];
    }

    public function generateTwoFactorCode(): void
    {
        $this->timestamps = false;
        $this->forceFill([
            'two_factor_code'       => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),
            'two_factor_expires_at' => now()->addMinutes(10),
        ])->save();
        $this->timestamps = true;
    }

    public function clearTwoFactorCode(): void
    {
        $this->timestamps = false;
        $this->forceFill([
            'two_factor_code'       => null,
            'two_factor_expires_at' => null,
        ])->save();
        $this->timestamps = true;
    }
}
