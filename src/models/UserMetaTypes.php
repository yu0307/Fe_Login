<?php

namespace feiron\fe_login\models;

use Illuminate\Database\Eloquent\Model;

class UserMetaTypes extends Model
{
    protected $table = 'user_metatypes';
    protected $fillable = ['meta_name', 'meta_type', 'meta_defaults'];
}
