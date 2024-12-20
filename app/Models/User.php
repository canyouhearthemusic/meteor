<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Table: users
 *
 * === Columns ===
 * @property int $id
 * @property string|null $name
 * @property string $email
 * @property string|null $avatar
 * @property string $password
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * === Relationships ===
 * @property-read \Laravel\Sanctum\PersonalAccessToken|null $tokens
 * @property-read \Illuminate\Notifications\DatabaseNotification|null $notifications
 *
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $hidden = [
        'password',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected function password(): Attribute
    {
        return Attribute::set(
            fn(string $value) => bcrypt($value)
        );
    }

    protected function avatar(): Attribute
    {
        return Attribute::get(
            fn(?string $avatar) => !is_null($avatar) ? url('/') . Storage::url($avatar) : null,
        );
    }
}
