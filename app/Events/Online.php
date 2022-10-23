<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
//evento de usuario online ou não
class Online implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id = 0;
    public $online = null;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id, $online)
    {
        $this->user_id = $user_id;
        $this->online = ($online == 'Y')?true:false;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('online.listen');
    }

    public function boradcastWith()
    {
        return [
            'user_id' => $this->user_id,
            'online' => $this->online
        ];
    }
}
