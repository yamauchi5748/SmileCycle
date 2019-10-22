<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatRecieved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $chat_room_id;
    protected $chat;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($chat_room_id, $chat)
    {
        $this->chat_room_id = $chat_room_id;
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('room.' . $this->chat_room_id);
    }

    public function broadcastWith()
    {
        return [
            'room_id' => $this->chat_room_id,
            'content' => $this->chat
        ];
    }
}
