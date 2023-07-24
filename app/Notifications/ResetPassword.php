<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class ResetPassword extends ResetPasswordNotification implements ShouldQueue
{
    use Queueable;

    protected function resetUrl($notifiable)
    {

        $email = $notifiable->getEmailForPasswordReset();
        $token = $this->token;
        $frontend = env('FRONTEND_URL');
        $url = "{$frontend}/conta/resetar-senha?token={$token}&email={$email}";
        return $url;
    }
}
