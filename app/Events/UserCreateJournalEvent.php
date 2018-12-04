<?php

namespace App\Events;

use App\Journal;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserCreateJournalEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $post;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Journal $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
