<?php
namespace feiron\fe_login\lib\events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use feiron\fe_login\models\fe_users;

class UserCreated
{
    use Dispatchable, SerializesModels;

    public $User;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(fe_users $CurrentUser)
    {
        $this->User=$CurrentUser;
    }
}
