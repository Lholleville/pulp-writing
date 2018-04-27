<?php

namespace App;

use App\Behaviour\DateTransformTime;
use App\Behaviour\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Forum extends Model
{
    public $guarded = ['id'];

    public $dates = ['updated_at', 'created_at'];

    use Sluggable;
    use DateTransformTime;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function collections(){
        return $this->belongsTo('App\Collec', 'collec_id');
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function topics(){
        return $this->hasMany('App\Topic', 'forum_id');
    }

    public function pinnedTopic(){
        return $this->topics()->where('pinned', true);
    }

    public function listTopicPinned(){
        return $this->topics()->where('pinned', true)->orderBy('created_at', 'desc')->get();
    }

    public function listTopic(){
        if(!Auth::guest()){
            if(Auth::user()->roles->name == "admin" || Auth::user()->isForumModo($this)){
                return $this->topics()->where('pinned', false)->orderBy('last_message_time', 'desc')->paginate(20);
            }
        }

        return $this->topics()->where('online', true)->where('pinned', false)->orderBy('last_message_time', 'desc')->paginate(20);
    }

    public function offlineTopic(){

    }

    public function getOnlineAttribute($online){
        return ($online) ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>';
    }

    public function hasCollec(){
        return $this->collections != null;
    }
}
