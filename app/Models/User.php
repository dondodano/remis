<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\HasName;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasName
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
        'user_role',
        'google_id',
        'avatar',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'user_role' => UserRole::class
    ];

    const DELETED_AT = 'deleted_at';



    public function getFilamentName(): string
    {
        return $this->getAttributeValue('first_name').' '.$this->getAttributeValue('last_name');
    }


    /**
     * Override boot
     */
    public static function boot()
    {
        parent::boot();

        static::created(function($user){

        });

        static::updated(function($user){

        });

        static::deleted(function($user){

        });
    }
}
