<?php

namespace FeIron\Fe_Login\resources;
use Illuminate\Notifications\Notifiable;

trait PasswordResetNotification
{
    use Notifiable;
    public function sendEmailPasswordResetNotification()
    {
        $this->notify(new notification\PasswordResetNotification);
    }
}
