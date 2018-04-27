<?php
/**
 * Created by PhpStorm.
 * User: Loic
 * Date: 25/04/2018
 * Time: 20:59
 */

namespace App\Observers;
use App\Comment;
use App\Topic;

class CommentsObserver
{
    public function saved($comment){
        if($comment->topic_id != 0){
            $topic = Topic::where('id', $comment->topic_id)->first();
            $topic->last_message_time = $comment->created_at;
            $topic->save();
        }
    }

//    public function deleted($comment){
//        if($comment->topic_id != 0){
//            $topic = Topic::where('id', $comment->topic_id)->first();
//            $index = $topic->comments->count() - 1;
//            if($topic->comments->last()->id == $comment->id){
//                $topic->last_message_time = $topic->comments->get($index)->created_at;
//                dd($topic->comments->get($index)->created_at);
//                $topic->save();
//            }
//        }
//    }
}