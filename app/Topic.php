<?php

namespace App;


use App\Behaviour\DateTransformTime;
use App\Behaviour\Sluggable;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany('App\Comment', 'topic_id');
    }

    public function getImgAttribute(){

        $dir = url('/img/icon/forum/');

        if($this->isLocked()){
            return $dir.'/locked.png';
        }
        if(!$this->isOnline()){
            return $dir.'/offline.png';
        }
        if($this->isPinned()){
            return $dir.'/pinned.png';
        }
        if($this->isHot()){
            return $dir.'/hot.png';
        }
        if(!$this->isAnswerable()){
            return $dir.'/notanswerable';
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
}
