<?php

namespace App;

use App\Behaviour\DateTransform;
use App\Behaviour\DateTransformTime;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    public $guarded = ['id'];

    public $dates = ['created_at', 'updated_at'];

    use DateTransformTime;

    public function comments(){
        return $this->hasMany('App\Comment', 'journal_id')->orderBy('created_at', 'Asc');
    }

    public function users(){
        return $this->belongsTo('App\User', 'user_id');
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

    public function getNbMessagesAttribute(){
        return $this->comments->count();
    }

    public function has_message(){
        return $this->comments->count() > 0;
    }

    public function engagements(){
        return $this->hasMany('App\Engagement', 'journal_id');
    }

    public function getSummarytruncatedMiniAttribute(){
        $text = str_replace("  ", " ", $this->content);
        $string = explode(" ", $text);
        if(sizeof($string) < 30){
            return $text;
        }else{
            $trimed = "";
            for ( $wordCounter = 0; $wordCounter <= 30; $wordCounter++ ){
                $trimed .= $string[$wordCounter];
                if($wordCounter < 30){
                    $trimed .= " ";
                }else{
                    $trimed .= "...";
                }
            }
            return $trimed;
        }
    }
}
