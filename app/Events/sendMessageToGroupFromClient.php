<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class sendMessageToGroupFromClient implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $client_id;
    public $group_id;
    public $fileName;
    public $name;
    public $from;

    public function __construct($message, $client_id, $group_id, $name, $fileName = null, $from = 0)
    {
        $this->message      = $message;
        $this->client_id    = $client_id;
        $this->fileName     = $fileName;
        $this->group_id     = $group_id;
        $this->name         = $name;
        $this->from         = $from;
    }

    public function broadcastOn()
    {
        return new Channel('send-message-to-group-from-client.'.$this->group_id);
    }

    public function broadcastAs()
    {
        return 'send-message-to-group';
    }
}
