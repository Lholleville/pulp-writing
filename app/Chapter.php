<?php

namespace App;

use App\Behaviour\DateTransform;
use App\Behaviour\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic;

class Chapter extends Model
{
    # VARIABLES #

    public $guarded = ['id'];
    public $date = ['updated_at', 'created_at'];

    #BOOT#
    public static function boot(){
        parent::boot();
        static::deleted(function($instance){
            if($instance->attributes['avatar'] && $instance->avatar != "/img/chapters/defaut.jpg"){
                unlink(public_path() . $instance->avatar);
            }
            return true;
        });
    }

    # ROUTES #
    public function getRouteKeyName()
    {
        return 'slug';
    }

    #RELATIONSHIPS#
    public function books(){
        return $this->belongsTo('App\Book', 'book_id');
    }

    public function users(){
        return $this->belongsToMany('App\User')->withPivot(['has_read', 'liked']);
    }

    public function notes(){
        return $this->HasMany('App\Note', 'chapter_id');
    }

    public function comments(){
        return $this->hasMany('App\Comment','chapter_id');
    }

    #MUTATORS#
    use Sluggable;

    use DateTransform;

    public function setAvatarAttribute($avatar){
        if(is_object($avatar) && $avatar->isValid()){
            self::saved(function($instance) use ($avatar){
                $dir = public_path() . "/img/chapters/".ceil($instance->id / 1000);
                if(!file_exists($dir)){
                    mkdir($dir, '0777', true);
                }
                //ImageManagerStatic::make($avatar)->fit(400,566)->save($dir."/{$instance->id}.jpg");
                ImageManagerStatic::make($avatar)->fit(320,450)->save($dir."/{$instance->id}.jpg");
            });
        }
        $this->attributes['avatar'] = true;
    }

    public function setOrderAttribute(){
        $Story_Chapter = DB::table('chapters')->where('book_id', '=', $this->book_id)->count();
        $value = intval($Story_Chapter) + 1;
        $this->attributes['order'] = $value;
    }

    public function setWordsAttribute(){
        $char = 'èéëÉÈËàäïÖôöîûÛüÜçÇÿøæåÅØÆÀŒœ0123456789ßñÑ\'';
        $words_count = str_word_count($this->attributes['content'], 0, $char);
        $undesired_char = substr_count ( $this->attributes['content'] , '&');
        $undesired_char1 = substr_count ( $this->attributes['content'] , '<');

        $this->attributes['words'] = $words_count - $undesired_char - $undesired_char1;
    }

    #ACCESSORS#
    public function getAvatarAttribute($avatar)
    {
        return ($avatar) ? "/img/chapters/".ceil($this->id / 1000)."/".$this->id.".jpg" : "/img/chapters/defaut.jpg";
    }

    public function getNbCommentsAttribute(){
        return $this->comments()->count();
    }

    public function getViewsAttribute(){
        return ($this->attributes['views'] == null) ? '0' : $this->attributes['views'];
    }

    public function getOnlineAttribute($online){
        return ($online) ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>';
    }

    public function getNextAttribute(){
        $chapters = $this->books->chapters;

        if($chapters->last()->id === $this->id){
            return $chapters->last();
        }else{
            $i = 0;
            foreach ($chapters as $chapter){
                if($chapter->id === $this->id){
                    return $chapters->offsetGet($i + 1);
                }
                $i++;
            }
        }
    }

    public function getPreviousAttribute(){
        $chapters = $this->books->chapters;

        if($chapters->first()->id === $this->id){
            return $chapters->first();
        }else{
            $i = 0;
            foreach ($chapters as $chapter){
                if($chapter->id === $this->id){
                    return $chapters->offsetGet($i - 1);
                }
                $i++;
            }
        }
    }

    public function getLikeAttribute(){
        return $this->users()->where('liked', 1)->count();
    }

    public function getReadAttribute(){
        return $this->users()->where('has_read', 1)->count();
    }

    public function getNotetextAttribute()
    {
        $txt = $this->attributes['content'];
        $txt = explode('<p>',$txt);
        $txt = implode($txt);

        $txt = explode('</p>', $txt);
        $txt = implode($txt);

        $txt = explode('&nbsp;', $txt);
        $txt = implode($txt);
        if(!$this->notes->isEmpty())
        {

            //$this->notes->count();
            $i = 0;
            foreach($this->notes as $note)
            {
                $couic = str_split($txt, 1);

                $diff = $note->end - $note->start;

                if($this->checkSpecChar($couic, $note->start))
                {

                    $decal = 62;

                    if(intval($note->id) > 1000 ){
                        $decal = 63;
                    }

                    $couic[$note->start + $i * $decal] = '<span style="background-color: '.$note->motifs->color.'" id="notif_'.$note->id.'">'.$couic[$note->start + $i * $decal];
                    if($diff == 1)
                    {
                        $couic[$note->start] .= '</span>';
                    }
                    else
                    {
                        $couic[$note->end -1 + $i * $decal] = $couic[$note->end -1 + $i * $decal].'</span>';
                    }
                }
                $txt = implode($couic);
                $i++;
            }
            return nl2br($txt);
        }
        else
        {
            return nl2br($txt);
        }
    }

//    public function getContentAttribute($content){
//        $content = explode('<p>',$content);
//        $content = implode($content);
//
//        $content = explode('</p>', $content);
//        $content = implode($content);
//
//        $content = explode('&nbsp;', $content);
//        $content = implode($content);
//        return nl2br($content);
//    }

    private function checkSpecChar($array, $index){
        return true;
    }

}
