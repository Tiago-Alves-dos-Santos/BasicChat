<?php

namespace App\Events\Chat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
//evento de mensagem lida
class MessageRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_sender = 0;
    public $user_addressee = 0;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_sender, $user_addressee)
    {
        $this->user_sender = $user_sender;
        $this->user_addressee = $user_addressee;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("chat.messageRead.{$this->user_sender}");
    }

    public function boradcastWith()
    {
        return [
            'user_sender' => $this->user_sender,
            'user_adressee' => $this->user_adressee,
        ];
    }
}
