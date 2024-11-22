<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class UserStatusUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return new Channel('user-status'); // Nama channel
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'is_active' => $this->user->is_active,
        ];
    }
    
}
