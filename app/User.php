<?php

namespace App;

use App\Behaviour\Sluggable;
use Badge\Badge;
use Badge\Badgeable;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic;
use Kim\Activity\Activity;

class User extends Authenticatable
{

    use Notifiable;
    use Badgeable;
    use Sluggable;
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

    public function forums(){
        return $this->belongsToMany('App\Forum');
    }

    public function listes(){
        return $this->hasMany('App\Liste', 'user_id');
    }

    public function listelectures(){
        return $this->hasMany('App\Listelecture', 'user_id');
    }

    public function comments(){
        return $this->hasMany('App\Comment', 'user_id');
    }

    public function journals(){
        return $this->hasMany('App\Journal');
    }

    public function notifications(){
        return $this->hasMany('App\Notification');
    }

    public function getNbUnreadNotificationsAttribute(){
        return $this->notifications()->where('read', false)->count();
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

    public function isModoCollection($collection){
        if($this->collections->contains($collection)){
            return true;
        }
    }

    public function isForumModo($forum){
        if($this->forums->count() > 0){
            if($this->forums->contains($forum->id)){
                return true;
            }
        }
    }

    public function isOP($resource){
        if($resource->user_id == $this->id){
            return true;
        }
    }

    public function hasAvatar(){
        return $this->attributes['avatar'] == 1 ? true : false;
    }

    public function hasConfAlias(){
        return $this->attributes['alias_conf'] == 1 ? true : false;
    }

    public function hasAlias(){
        if($this->attributes['alias'] != null){
            return $this->attributes['alias_use'] == 1 ? true : false;
        }
        return false;
    }

    public function isActive(){
        $activities = Activity::users(5)->get();
        foreach($activities as $activity){
            if($this->id  == $activity->user->id){
                return true;
            }
        }
        return false;
    }

    public function getActivitiesAttribute(){
        return DB::table('sessions')->where('user_id', $this->id)->get();
    }

    public function getActivityAttribute(){

        foreach($this->activities as $activity){
            if(!$this->isActive()){
                $seconds = time() - $activity->last_activity;
                $delay = $this->secondsToTime($seconds);
                return [false, $delay];
            }
        }
        if(!$this->isActive()) {
            return [false, 'Hors ligne.'];
        }else{
            return [true, ''];
        }
    }

    public function getFriendslisteAttribute(){
        return $this->listes()->where('type', Liste::AMIS_ID)->first();
    }

    public function getAbonnementslisteAttribute(){
        return $this->listes()->where('type', Liste::ABONNEMENTS_ID)->first();
    }

    public function getSubscribelisteAttribute(){
        return $this->listes()->where('type', Liste::SUBSCRIBERS_ID)->first();
    }

    public function getBlacklisteAttribute(){
        return $this->listes()->where('type', Liste::BLACKLIST_ID)->first();
    }

    public function getTextslisteAttribute(){
        return $this->listelectures()->where('type', Liste::LECTURE_ID)->first();
    }



    public function isInList($list){
        return ($list->users->contains($this)) ? true : false;

    }

    public function isBlacklisted(){
        $myblacklist = Auth::user()->getBlacklisteAttribute();
        if($this->isInList($myblacklist)){
            return true;
        }
    }

    public function AmIBlacklisted(User $user){
        $blacklist = $user->getBlacklisteAttribute();
        if(Auth::user()->isInList($blacklist)){
            return true;
        }
    }



    private function secondsToTime($seconds) {

        if(!isset($seconds)){
            return 'Hors ligne.';
        }

        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        $d = $dtF->diff($dtT);
        $string = 'En ligne il y a ';

        if($d->y > 0)
        {
            if($d->y > 1){
                $string .= " %y ans";
            }else{
                $string .= " %y an";
            }
        }
        if($d->m > 0){
            $string .= " %m mois";
        }
        if($d->d > 0){
            if($d->d > 1){
                $string .= " %a jours";
            }else{
                $string .= " %a jour";
            }
        }
        if($d->h > 0){
            if($d->h > 1){
                $string .= " %h heures";
            }else{
                $string .= " %h heure";
            }
        }
        if($d->i > 0){
            if($d->i > 1){
                $string .= " %i minutes";
            }else{
                $string .= " %i minutes";
            }
        }
        $string .= ".";
        return $dtF->diff($dtT)->format($string);
    }

    public function hasLikeComment($comment){
        foreach($comment->engagements as $e){
            if($e->users->id == Auth::user()->id && $e->has_like == 1){
                return true;
            }
        }
        return false;
    }

    public function hasDislikeComment($comment){
        foreach($comment->engagements as $e){
            if($e->users->id == Auth::user()->id && $e->has_dislike == 1){
                return true;
            }
        }
        return false;
    }
}
