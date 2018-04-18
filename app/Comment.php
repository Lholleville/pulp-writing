<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $guarded = ['id'];

    public $dates = ['created_at', 'updated_at'];

    public function users(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function chapters(){
        return $this->belongsTo('App\Chapter', 'chapter_id');
    }

    public function getCollectionAttribute(){
        return $this->chapters->books->collections;
    }

    public function canEdit($user){
        if($user){
            if($user->id === $this->users->id){
                return true;
            }elseif($user->role === 'admin'){
                return true;
            }
        }
        return false;
    }

    public function isSignaled(){

    }
}
