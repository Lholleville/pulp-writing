<?php

namespace App\Events;

use App\Book;
use App\Chapter;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TextCreateChapterEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $book;
    public $chapter;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Book $book, Chapter $chapter)
    {
        $this->user = $user;
        $this->chapter = $chapter;
        $this->book = $book;
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
