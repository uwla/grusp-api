<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

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

    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('Resetar senha')
            ->markdown('emails.reset', ['url' => $url]);
    }
}
