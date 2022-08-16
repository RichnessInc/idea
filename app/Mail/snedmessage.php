<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class snedmessage extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $group_id;
    public function __construct($name, $group_id)
    {
        $this->name     = $name;
        $this->group_id = $group_id;
    }
    /**
     * Build the message.
     *
     * @return $this
     */

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->subject(config('app.name') . '-' . ' رسالة في غرفة دردشة ')->markdown('emails.snedmessage');
    }
}
