<?php
namespace feiron\fe_login\lib\events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use feiron\fe_login\models\fe_users;

class UserCreated
{
    use Dispatchable, SerializesModels;

    public $User;
    private $extraMeta;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(fe_users $CurrentUser,$extra=[])
    {
        $this->User=$CurrentUser;
        $this->extraMeta=$extra;
    }

    public function __get($key){
        return array_key_exists($key,$this->extraMeta)?$this->extraMeta[$key]:null;
    }
}
