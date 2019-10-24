<?php

namespace feiron\fe_login\models;

use Illuminate\Database\Eloquent\Model;
use \feiron\fe_login\models\fe_users;
class fe_userMeta extends Model
{
    protected $table = 'user_meta';
    protected $fillable = ['meta_name', 'meta_value', 'user_id'];
    protected $visible = ['meta_name', 'meta_value'];
    public function User(){
        return $this->belongsTo('\feiron\fe_login\models\fe_users','user_id', 'id');
    }
    
    public function MetaInfo(){
        return $this->belongsTo('\feiron\fe_login\models\fe_userMetaTypes', 'meta_name', 'meta_name');
    }
}
