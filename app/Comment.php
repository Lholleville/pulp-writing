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

    public function topics(){
        return $this->belongsTo('App\Topic', 'topic_id');
    }

    public function journals(){
        return $this->belongsTo('App\Journal', 'journal_id');
    }

    public function engagements(){
        return $this->hasMany('App\Engagement', 'comment_id');
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

    public function getTypeAttribute(){
        if ($this->attributes['chapter_id'] != 0){
            return "chapter";
        }
        if ($this->attributes['topic_id'] != 0){
            return "topic";
        }
        if ($this->attributes['journal_id'] != 0){
            return "journal";
        }
    }

    public function getLikeAttribute(){
        $engagements = $this->engagements;
        $likes = 0;
        $names = [];
        foreach($engagements as $e){
            if($e->has_like == 1){
                $likes++;
                $names[] = $e->users->name;
            }
        }
        return [$likes, $names];
    }

    public function getDislikeAttribute(){
        $engagements = $this->engagements;
        $likes = 0;
        $names = [];
        foreach($engagements as $e){
            if($e->has_dislike == 1){
                $likes++;
                $names[] = $e->users->name;
            }
        }
        return [$likes, $names];
    }
}
