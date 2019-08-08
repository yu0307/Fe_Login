<?php

namespace feiron\fe_login\resources;
use Illuminate\Notifications\Notifiable;

trait PasswordResetNotification
{
    use Notifiable;
    public function sendEmailPasswordResetNotification()
    {
        $this->notify(new notification\PasswordResetNotification);
    }
}
