<?php

namespace Murkrow\Chat\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Murkrow\Chat\Models\Message;

class NewMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Message $message;
    public string $body;

    public function __construct($message)
    {
        $this->message = $message;
        $this->body = $message->body;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('chat.'.$this->message->chat_id);
    }

    public function broadcastAs(): string
    {
        return 'new-message';
    }
}
