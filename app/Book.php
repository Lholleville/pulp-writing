<?php

namespace App;

use App\Behaviour\DateTransform;
use App\Behaviour\Sluggable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic;

class Book extends Model
{
    public $guarded = ['id'];

    public $dates = ['updated_at', 'created_at'];

    use Sluggable;

    use DateTransform;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function canEdit(Guard $auth){
        return ($this->attributes['user_id'] == $auth->user()->id)? true : false;
    }

    public function chapters(){
        return $this->hasMany('App\Chapter')->orderBy('order');
    }

    public function users(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function genres(){
        return $this->belongsTo('App\Genre', 'genre_id');
    }

    public function statuts(){
        return $this->belongsTo('App\Statut', 'statut_id');
    }

    public function collections(){
        return $this->BelongsTo('App\Collec', 'collec_id');
    }

    public function tags(){
        return $this->BelongsToMany('App\Tag');
    }
    public function getNbCommentsAttribute(){
        $count = DB::table('comments')
            ->select(DB::raw('count(comments.id) as comments_count'))
            ->join('chapters', 'chapter_id', '=', 'chapters.id')
            ->join('books', 'book_id', '=', 'books.id')
            ->where('book_id', $this->id)
            ->get();
        return $count->get(0)->comments_count;
    }

    public function getViewsAttribute(){
        $views = 0;
        foreach($this->chapters as $c){
            $views += $c->views;
        }
        return $views;
    }

    public function getWordsAttribute(){
        $words = 0;
        foreach($this->chapters as $c){
            $words += $c->words;
        }
        return $words;
    }

    public function getAvatarAttribute($avatar)
    {
        return ($avatar) ? "/img/books/".ceil($this->id / 1000)."/".$this->id.".jpg" : "/img/books/defaut.jpg";
    }

    public function getOnlineAttribute($online){
        return ($online) ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>';
    }

    public function getSummarytruncatedAttribute(){
        $text = str_replace("  ", " ", $this->attributes['summary']);
        $string = explode(" ", $text);
        if(sizeof($string) < 90){
            return $text;
        }else{
            $trimed = "";
            for ( $wordCounter = 0; $wordCounter <= 90; $wordCounter++ ){
                $trimed .= $string[$wordCounter];
                if($wordCounter < 90){
                    $trimed .= " ";
                }else{
                    $trimed .= "...";
                }
            }
            return $trimed;
        }
    }


    public function getParentAttribute(){
        if($this->attributes['parent_id'] != $this->attributes['id']){
            $name = DB::table('books')->select('name')->where('id', $this->attributes['parent_id'])->get();
            if(isset($name[0])){
                return $name[0]->name;
            }
        }
    }

    public function setAvatarAttribute($avatar){
        if(is_object($avatar) && $avatar->isValid()){
            self::saved(function($instance) use ($avatar){
                $dir = public_path() . "/img/books/".ceil($instance->id / 1000);
                if(!file_exists($dir)){
                    mkdir($dir, '0777', true);
                }
                //ImageManagerStatic::make($avatar)->fit(400,566)->save($dir."/{$instance->id}.jpg");
                ImageManagerStatic::make($avatar)->fit(320,450)->save($dir."/{$instance->id}.jpg");

            });
        }
        $this->attributes['avatar'] = true;
    }

    public function getLikeAttributes(){
        return $this->chapters()->like->count();
    }
}
