<?php

namespace Badge;


class BadgeSubscriber {

    private $badge;

    public function __construct(Badge $badge){
        $this->badge = $badge;
    }
        public function subscribe($events){
            $events->listen('eloquent.saved: App\Girl', [$this, 'onNewZouz']);
            $events->listen('eloquent.saved: App\Girl', [$this, 'onFiveZouz']);
            $events->listen('eloquent.saved: App\Girl', [$this, 'getX']);
        }

        public function onNewZouz(\App\Girl $girl){
            $user = $girl->user;

            $girl_count = $user->girls()->count();

            $this->badge->unlockActionFor($user, 'addzouz', $girl_count);
        }

        public function onFiveZouz(\App\Girl $girl){
            $user = $girl->user;
            $girl_count = sizeof($user->letters);
            $this->badge->unlockActionFor($user, 'fivezouz', $girl_count);
        }

        public function getX(\App\Girl $girl){
            $user = $girl->user;
            $girl_count = $user->girls()->where('name', 'LIKE', "X%")->count();
            $this->badge->unlockActionFor($user, 'getX', $girl_count);
        }
    }