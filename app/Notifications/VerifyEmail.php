<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
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

        $frontend = env('FRONTEND_URL');
        $query = "id={$id}&hash={$hash}&expires={$expires}&signature={$signature}";
        $frontendUrl = "{$frontend}/conta/resetar-senha?{$query}";

        return $frontendUrl;
    }
}
