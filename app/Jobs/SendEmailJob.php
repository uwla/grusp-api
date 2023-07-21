<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The mail to be sent.
     *
     * @var Mailable
     */
    protected $mail;

    /**
     * The destination mail address.
     *
     * @var string
     */
    protected $to;

    /**
     * Create a new job instance.
     */
    public function __construct(Mailable $mail, string $to)
    {
        $this->mail = $mail;
        $this->to = $to;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->to)->send($this->mail);
    }
}
