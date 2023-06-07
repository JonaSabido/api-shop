<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_profile',
        'name',
        'last_name',
        'nick',
        'email',
        'password',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        $user = [
            "id" => $this->id,
            "name" => $this->name,
            "last_name" => $this->last_name,
            "nick" => $this->nick,
            "email" => $this->email,
            "id_profile" => $this->id_profile,
            "active" => $this->active
        ];

        return [
            "user" => $user
        ];
    }
    public function oProfile()
    {
        return $this->hasOne(Profile::class, 'id', 'id_profile');
    }
}
