<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerifyEmail extends VerifyEmailNotification implements ShouldQueue
{
    use Queueable;

   /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        $apiUrl = parent::verificationUrl($notifiable);

        $id = Str::between($apiUrl, 'verify/', '/');
        $hash = Str::between($apiUrl, "verify/{$id}/", '?');
        $expires = Str::between($apiUrl, 'expires=', '&');
        $signature = Str::after($apiUrl, 'signature=');

        $base_url = config('mail.url.verify');
        $query = "id={$id}&hash={$hash}&expires={$expires}&signature={$signature}";
        $frontendUrl = "{$base_url}?{$query}";

        return $frontendUrl;
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
            ->subject('Verificar conta')
            ->markdown('emails.verify', ['url' => $url]);
    }
}
