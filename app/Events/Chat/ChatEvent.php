<?php

namespace App\Events\Chat;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message = '';
    public $status = '';
    public $user_sender = 0;
    public $user_adressee = 0;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_sender, $user_adressee, $message, $status = '')
    {
        $this->user_sender = $user_sender;
        $this->user_adressee = $user_adressee;
        $this->message = $message;
        $this->status = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.user.'.$this->user_adressee);
    }

    public function boradcastWith()
    {
        return [
            'user_sender' => $this->user_sender,
            'user_adressee' => $this->user_adressee,
            'message' => $this->message,
            'status' => $this->status
        ];
    }

    // public function boradcastAs()
    // {
    //     return 'chat.event';
    // }
}
