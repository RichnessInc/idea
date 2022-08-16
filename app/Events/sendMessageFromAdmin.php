<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class sendMessageFromAdmin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $client_id;
    public $fileName;

    public function __construct($message, $client_id, $fileName = null)
    {
        $this->message      = $message;
        $this->client_id    = $client_id;
        $this->fileName     = $fileName;
    }

    public function broadcastOn()
    {
        return new Channel('my-channel.'.$this->client_id);
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
