<?php

namespace App\Listeners;

use App\Events\UserCreateJournalEvent;
use App\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreateJournalListener
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
     * @param  UserCreateJournalEvent  $event
     * @return void
     */
    public function handle(UserCreateJournalEvent $event)
    {
        $user = $event->user;

        $content = $user->name." a publié dans son journal";
        $content .= '<br>'.$event->post->summarytruncatedmini;
        $link = url("profil/".$user->slug.'#'.$event->post->id);


        foreach($user->subscribeliste->users as $subscriber){
            if($subscriber->abonnementsliste->regles->user_diary_created){
                Notification::create([
                    'content' => $content,
                    'user_id' => $subscriber->id,
                    'link' => $link,
                ]);
            }
        }
    }
}
