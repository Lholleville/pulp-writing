<?php

namespace App\Listeners;

use App\Events\UserCreateTextEvent;
use App\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreateTextListener
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
     * @param  UserCreateTextEvent  $event
     * @return void
     */
    public function handle(UserCreateTextEvent $event)
    {
        $user = $event->user;
        $book = $event->book;

        $content = $user->name." a publié un nouveau texte, intitulé ".$book->name;
        $summary = $book->summarytruncatedmini;
        $content .= '<br>'.$summary;
        $link = url($book->collections->name."/".$book->name);

        foreach($user->subscribeliste->users as $subscriber){
            if($subscriber->abonnementsliste->regles->user_text_created){
                Notification::create([
                    'content' => $content,
                    'user_id' => $subscriber->id,
                    'link' => $link,
                ]);
            }

        }
    }
}
