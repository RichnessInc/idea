<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class standardEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $content;
    public $emailSubject;
    public $buttonText;
    public $buttonUrl;
    public function __construct($content, $emailSubject, $buttonText, $buttonUrl)
    {
        $this->content      = $content;
        $this->emailSubject = $emailSubject;
        $this->buttonText   = $buttonText;
        $this->buttonUrl    = $buttonUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.standard-email')->subject($this->emailSubject);
    }
}
