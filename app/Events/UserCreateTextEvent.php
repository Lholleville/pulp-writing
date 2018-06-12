<?php

namespace App\Events;

use App\Book;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserCreateTextEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $book;
    public $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Book $book)
    {
        $this->user = $user;
        $this->book = $book;
    }

}
