<?php namespace App;

use App\Behaviour\DateTransform;
use Illuminate\Database\Eloquent\Model;

class Signal extends Model {

    public $guarded = ['id'];

    use DateTransform;

    public function motifsignals(){
        return $this->belongsTo('App\Motifsignal', 'type');
    }

    public function comments(){
        return $this->belongsTo('App\Comment', 'comment_id');
    }

    //get the name of those who signaled the message
    public function getMoanerAttribute(){
        $moaner = User::findOrFail($this->attributes['user_id']);
        return $moaner->name;
    }

    public function getGuiltyAttribute(){
        $guilty = User::findOrFail($this->attributes['guilt_id']);
        return $guilty->name;
    }

    public function getCommentdenouncedAttribute(){
        $comment = Comment::findOrFail($this->attributes['comment_id']);
        return $comment->content;
    }

    public function getTypenameAttribute(){
        $type = Motifsignal::findOrFail($this->attributes['type']);
        return $type->name;
    }

    public function getImportanceAttribute(){
        $type = Motifsignal::findOrFail($this->attributes['type']);
        if($type->importance == 0){
            $type = Motifsignal::findOrFail($type->parent);
            dd($type);

        }else{
            return $type->importance;
        }
    }

    public function belongsToCollection($collection){
        return $this->comments->chapters->books->collections->id == $collection->id;
    }
}