<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $roomId;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message,$roomId)
    {
        $this->message = $message;
        $this->roomId = $roomId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel('privatechat.'.$this->roomId);
    }
    public function broadcastAs()
    {
        return 'ChatSent';
    }
    public function broadcastWith()
    {
        return ['message' => $this->message->message];
    }
}
