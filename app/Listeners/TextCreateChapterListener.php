<?php

namespace App\Listeners;

use App\Events\TextCreateChapterEvent;
use App\Notification;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TextCreateChapterListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TextCreateChapterEvent  $event
     * @return void
     */
    public function handle(TextCreateChapterEvent $event)
    {
        $user = $event->user;
        $book = $event->book;
        $chapter = $event->chapter;

        $content = "L'oeuvre ".$book->name." contient un nouveau chapitre.";
        $link = url($book->collections->slug."/".$book->slug."/".$chapter->order."/".$chapter->slug);

        $users = User::All();


        foreach($users as $user){
            if($book->isInList($user->textsliste)){
                if($user->textsliste->reglelectures->text_chapter_created){
                    Notification::create([
                        'content' => $content,
                        'user_id' => $user->id,
                        'link' => $link,
                    ]);
                }
            }
        }
    }
}
