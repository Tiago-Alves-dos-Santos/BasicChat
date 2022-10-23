<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
//evento ao mandar mensagem para grupo
class GroupGlobal implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message = '';
    public $sender = null;
    public $user_name = '';
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $sender)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->user_name = User::find($sender)->name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('grupo.global');
    }

    public function boradcastWith()
    {
        return [
            'message' => $this->message,
            'sender' => $this->sender,
            'name' => $this->user_name
        ];
    }

}
