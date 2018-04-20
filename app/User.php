<?php

namespace App;

use Badge\Badge;
use Badge\Badgeable;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic;

class User extends Authenticatable
{
    use Notifiable;
    use Badgeable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    public function roles(){
        return $this->belongsTo('App\Role','role_id');
    }

    public function collections(){
        return $this->BelongsToMany('App\Collec');
    }

    public function books(){
        return $this->hasMany('App\Book', 'user_id');
    }

    public function chapters(){
        return $this->belongsToMany('App\Chapter')->withPivot(['has_read', 'liked']);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setAvatarAttribute($avatar){
        if(is_object($avatar) && $avatar->isValid()){
            ImageManagerStatic::make($avatar)->fit(200,200)->save(public_path() . "/img/avatars/{$this->id}.jpg");
            $this->attributes['avatar'] = true;
        }
    }

    public function setCoverAttribute($cover){
        if(is_object($cover) && $cover->isValid()){
            ImageManagerStatic::make($cover)->save(public_path() . "/img/covers_users/{$this->id}.jpg");
            $this->attributes['cover'] = true;
        }
    }

    /**
     * @param $birthday
     */
    public function setBirthdayAttribute($birthday){
        if(!empty($birthday)){
            $this->attributes['birthday'] = Carbon::createFromFormat('d/m/Y', $birthday);
        }
    }

    /**
     * @param $birthday
     * @return null|string
     */
    public function GetBirthdayAttribute($birthday){
        if($birthday === "0000-00-00 00:00:00" || $birthday === null){
            return null;
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $birthday)->format('d/m/Y');
    }

    public function GetAgeAttribute(){

        if($this->attributes['birthday'] != "0000-00-00 00:00:00" && $this->attributes['birthday'] != null){
            $age = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['birthday'])->diffInYears().' ans';
        }else{
            $age = "Non renseigné";
        }
        return $age;
    }

    public function getNameAttribute(){
        return $this->attributes['name'];
    }

    public function getAvatarAttribute($avatar){
        if($this->attributes['karma'] <= 0){
            return "/img/avatars/banni.jpg";
        }else{
            if($avatar){
                return "/img/avatars/{$this->id}.jpg";
            }else{
                if($this->sex == "Homme"){
                    return "/img/avatars/defaultH.jpg";
                }elseif($this->sex == "Femme"){
                    return "/img/avatars/defaultF.jpg";
                }else{
                    return "/img/avatars/default.jpg";
                }
            }
        }
    }


    public function getSexAttribute($sex){
        switch($sex){
            case 1 :
                return 'Homme';
                break;
            case 2 :
                return 'Femme';
                break;
            case 0 :
                return 'Non renseigné';
                break;
        }
    }

    public function hasLike($chapter){
        //si le chapitre récupéré correspond à un enregistrement de la table

        if(!$this->chapters->isEmpty())
        {
            foreach($this->chapters as $c)
            {
                if($c->id == $chapter->id)
                {
                    return ($c->pivot->liked == 1) ? true : false;
                }
            }
        }
        return false;
    }

    public function hasRead($chapter){
        //si le chapitre récupéré correspond à un enregistrement de la table
        if(!$this->chapters->isEmpty())
        {
            foreach($this->chapters as $c)
            {
                if($c->id == $chapter->id)
                {
                    return ($c->pivot->has_read == 1) ? true : false;
                }
            }
        }
        return false;
    }

    public function hasInterractWith($chapter){
        $enregistrement = DB::table('chapter_user')->where('user_id', $this->id)->where('chapter_id', $chapter->id)->get();
        return ($enregistrement->isEmpty()) ? false : true;

    }

    public function getCountryAttribute(){
        if($this->attributes['country'] != null){
            return $this->attributes['country'];
        }else{
            return 'Non renseigné';
        }
    }

    public function getCommentcountAttribute(){
        $count = DB::table('comments')->select(DB::raw('COUNT(id) AS nb_comment'))->where('user_id', $this->id)->where('signal', 0)->get();
        return $count[0]->nb_comment;
    }

    public function getLikeAttribute(){
        return $this->chapters()->where('liked', 1)->count();
    }
    public function getReadAttribute(){
        return $this->chapters()->where('has_read', 1)->count();
    }

    public function isModo(){
        if($this->collections->count() > 0){
            return true;
        }
    }
}
