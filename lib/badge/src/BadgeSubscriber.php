<?php

namespace Badge;


use App\Collec;
use App\Role;
use Illuminate\Support\Facades\DB;

class BadgeSubscriber {

    private $badge;

    public function __construct(Badge $badge){
        $this->badge = $badge;
    }
        public function subscribe($events){
            $events->listen('eloquent.created: App\User', [$this, 'onRegister']);
            $events->listen('eloquent.saved: App\Book', [$this, 'onFirstPublish']);
            $events->listen('eloquent.updated: App\Book', [$this,'collectionsManager']);
            $events->listen('eloquent.updated: App\User', [$this, 'roleUpdate']);
        }

        /*Badge inscription*/

        public function onRegister(\App\User $user){
            $this->badge->unlockActionFor($user, 'onRegister', 1);
        }

        /*Badge premier texte*/

        public function onFirstPublish(\App\Book $book){
            $user = $book->users;
            $book_count = $user->books()->count();
            $this->badge->unlockActionFor($user, 'onFirstPublish', $book_count);
        }

        /*Badge collection*/

        public function collectionsManager(\App\Book $book){

            $user = $book->users;

            $original_collection = Collec::where('id', $book->getOriginal('collec_id'))->first();

            $new_collection = Collec::where('id', $book->collec_id)->first();

            $original_collections_books = $original_collection->books;

            $user_has_book_in_collection = false;

            foreach($original_collections_books as $ob){
                if($ob->users->id == $user->id){
                    $user_has_book_in_collection = true;
                }else{
                    $user_has_book_in_collection = false;
                }
            }
            if(!$user_has_book_in_collection){
                $this->badge->lockActionFor($user, "on".$original_collection->name."Publish");
            }


            $nb_collection = DB::table('books')
                ->select(DB::raw('count(*) as collec_count, collec_id'))
                ->where('user_id', $user->id)
                ->groupBy('collec_id')
                ->get();

            $this->badge->unlockActionFor($user, 'allCollec', sizeof($nb_collection));

            switch($new_collection->name){
                case "Mandragore" :
                    $this->badge->unlockActionFor($user, 'onMandragorePublish', 1);
                break;
                case "Hellébore" :
                    $this->badge->unlockActionFor($user, 'onHelleborePublish', 1);
                break;
                case "Absinthe" :
                    $this->badge->unlockActionFor($user, 'onAbsinthePublish', 1);
                break;
                case "Aconit" :
                    $this->badge->unlockActionFor($user, 'onAconitPublish', 1);
                break;
                case "Nepenthes" :
                    $this->badge->unlockActionFor($user, 'onNepenthesPublish', 1);
                break;
                case "Belladone" :
                    $this->badge->unlockActionFor($user, 'onBelladone$Publish', 1);
                break;
            }
        }

        /*Badge role*/

        public function roleUpdate(\App\User $user){

            $newrole = Role::findOrFail($user->role_id);
            $oldrole = Role::findOrFail($user->getOriginal("role_id"));

            $this->badge->unlockActionFor($user, 'on'.$newrole->name.'Promoted', 1);

            if($newrole->name == "user"){
                $this->badge->lockActionFor($user, 'on'.$oldrole->name.'Promoted', 1);
                $this->badge->unlockActionFor($user, 'on'.$oldrole->name.'Unpromoted', 1);
            }
            if($newrole->name != "admin" && $oldrole->name == "admin"){
                $this->badge->lockActionFor($user, 'onadminPromoted', 1);
                $this->badge->unlockActionFor($user, 'onadminUnpromoted', 1);
            }

        }
    }