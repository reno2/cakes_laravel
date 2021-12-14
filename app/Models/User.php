<?php

namespace App\Models;

use App\Models\Room;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomEmailNotification;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * Users' roles
     * @var array
     */
    public const ROLES = [
        'admin'     => 1,
        'author'    => 2
    ];



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id', 'is_admin', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profiles(){
        return $this->hasMany('App\Models\Profile');
    }
    public function articles(){
        return $this->hasMany('App\Models\Article');
    }
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomEmailNotification);
    }


    // Проверка пользователя на статус администратора
    public function isAdmin()
    {
        return $this->is_admin === 1;
    }


}
