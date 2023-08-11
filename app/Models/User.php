<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use HttpOz\Roles\Traits\HasRole as HasRoleTrait;
use HttpOz\Roles\Contracts\HasRole as HasRoleContract;

class User extends Authenticatable implements HasRoleContract
{
    use HasApiTokens, HasFactory, Notifiable, HasRoleTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasTeams()
    {
        return $this->hasMany(Team::class);
    }

    public function fasyankes()
    {
        return $this->hasOne(Fasyankes::class);
    }
}
