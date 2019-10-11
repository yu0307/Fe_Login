<?php

namespace feiron\fe_login\lib;
use Auth;
use \feiron\fe_login\models\fe_userMeta;
use \feiron\fe_login\models\fe_users;
use \feiron\fe_login\models\fe_userMetaTypes;
use \feiron\fe_login\lib\outlet\feOutletManager;
use \feiron\fe_login\lib\outlet\defaultOutlets\userManagement as management;
class UserManagement extends feOutletManager
{
    private $UID;

    public function __construct($UID=null){
        $this->UID=($UID??(Auth::user()->getKey()??Auth::user()->id))??null;        
        app()->UserManagementOutlet->bindOutlet('UserManageOutlet', new management());
    }
    
    public function getUsers($meta=[],$withMyself=false){
        $where=[];
        foreach($meta as $key=>$val){
            array_push($where, ['meta_name',$key] );
            array_push($where, ['meta_value',$val]);
        }
        $userQuery=fe_users::query();
        if($withMyself===false){
            $userQuery->where('id','<>',$this->UID);
        }
        return (empty($where)?$userQuery->get():$userQuery->whereIn('id',fe_userMeta::where($where)->pluck('id')->toArray())->get());
    }

    public function setMeta($metaKey,$metaValue,$UID=null){
        fe_userMeta::updateOrCreate(
            ['user_id' => ($UID??$this->UID),'meta_name' => $metaKey],
            ['meta_value' => $metaValue]
        );
    }

    public function getMeta($metaKey,$UID=null){
        return fe_userMeta::where('meta_name', $metaKey)->where('user_id', ($UID??$this->UID))->first();
    }

    public function removeMeta($metaKey,$UID=null){
        fe_userMeta::where([['meta_name', $metaKey],['user_id', ($UID??$this->UID)]])->delete();
    }

    public function getMetaFields(){
        return fe_userMetaTypes::all()??[];
    }

}
