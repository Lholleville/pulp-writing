<?php

namespace App;


use App\Behaviour\DateTransformTime;
use App\Behaviour\Sluggable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Topic extends Model
{
    public $guarded = ['id'];

    public $dates = ['updated_at', 'created_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    use Sluggable;

    use DateTransformTime;

    public function getUsernameAttribute(){
        return User::findOrFail($this->attributes['user_id'])->name;
    }

    public function comments(){
        return $this->hasMany('App\Comment', 'topic_id')->orderBy('created_at');
    }

    public function forums(){
        return $this->belongsTo('App\Forum', 'forum_id');
    }

    public function getImgAttribute(){

        $dir = url('/img/icon/forum/');
        if(!$this->isOnline()){
            return $dir.'/offline.png';
        }
        if($this->isLocked()){
            return $dir.'/locked.png';
        }
        if(!$this->isAnswerable()){
            return $dir.'/notanswerable.png';
        }
        if($this->isPinned()){
            return $dir.'/pinned.png';
        }
        if($this->isHot()){
            return $dir.'/hot.png';
        }
        return $dir.'/normal.png';
    }

    public function isLocked(){
        return ($this->attributes['locked'] == '1') ? true : false;
    }

    public function isPinned(){
        return ($this->attributes['pinned'] == '1') ? true : false;
    }

    public function isOnline(){
        return ($this->attributes['online'] == '1') ? true : false;
    }

    public function isHot(){
        if($this->comments != null){
            return ($this->comments->count() > 20) ? true : false;
        }
        return false;
    }

    public function isAnswerable(){
        return ($this->attributes['answerable'] == '1') ? true : false;
    }

    public function setMessageAttribute($message){
        self::saved(function($instance) use ($message){
            DB::table('comments')->insert(['content' => $message, 'user_id' => $instance->user_id , 'topic_id' => $instance->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            DB::table('topics')->where('id', $instance->id)->update(['last_message_time' => date('Y-m-d H:i:s')]);
        });
    }
}
