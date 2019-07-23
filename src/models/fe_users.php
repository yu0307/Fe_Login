<?php

namespace FeIron\Fe_Login\models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use FeIron\Fe_Login\resources\PasswordResetNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class fe_users extends Authenticatable
{
    use Notifiable;
    use PasswordResetNotification;

    protected $table = 'users';
    /**
     * The attributes that not are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'remember_token','updated_at'
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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'last_login' => 'datetime',
    ];
}

?>