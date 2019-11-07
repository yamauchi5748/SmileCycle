<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AlreadyRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $member_id;
    protected $chat_room_id;
    protected $content_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($member_id, $chat_room_id, $content_id)
    {
        $this->member_id = $member_id;
        $this->chat_room_id = $chat_room_id;
        $this->content_id = $content_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('member.' . $this->member_id);
    }

    public function broadcastWith()
    {
        return [
            'room_id' => $this->chat_room_id,
            'content_id' => $this->content_id
        ];
    }
}
