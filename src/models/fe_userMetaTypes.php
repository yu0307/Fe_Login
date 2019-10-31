<?php

namespace feiron\fe_login\models;

use Illuminate\Database\Eloquent\Model;

class fe_userMetaTypes extends Model
{
    protected $table = 'user_metatypes';
    protected $fillable = ['meta_name', 'meta_type', 'meta_defaults', 'meta_label', 'meta_options'];
    protected $casts = [
        'meta_options' => 'array',
        'meta_defaults' => 'array'
    ];
}
