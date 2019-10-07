<?php

namespace feiron\fe_login\models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \feiron\fe_login\models\fe_userMeta;

class fe_users extends Authenticatable
{
    use Notifiable;

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

    public function metainfo(){
        return $this->hasMany('\feiron\fe_login\models\fe_userMeta','user_id', 'id');
    }
}

?>