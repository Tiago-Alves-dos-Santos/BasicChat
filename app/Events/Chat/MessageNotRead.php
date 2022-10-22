<?php

namespace App\Events\Chat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageNotRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user_addressee = 0;
    public $messages_count = 0;
    public $user_sender = 0;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_addressee, $messages_count, $user_sender)
    {
        $this->user_addressee = $user_addressee;
        $this->messages_count = $messages_count;
        $this->user_sender = $user_sender;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("message.notRead.user.{$this->user_addressee}");
    }

    public function boradcastWith()
    {
        return [

            'user_adressee' => $this->user_adressee,
            'messages_count' => $this->messages_count,
            'user_sender' => $this->user_sender,
        ];
    }
}
