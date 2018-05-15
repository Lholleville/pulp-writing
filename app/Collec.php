<?php

namespace App;

use App\Behaviour\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic;

class Collec extends Model
{
    public $guarded = ['id'];

    public $dates = ['created_at', 'updated_at'];

    use Sluggable;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function users(){
        return $this->BelongsToMany('App\User');
    }

    public function books(){
        return $this->HasMany('App\Book', "collec_id")->where('online', true);
    }

    public function forums(){
        return $this->hasOne('App\Forum');
    }

    public function getNbTxtAttribute(){
        return $this->HasMany('App\Book', "collec_id")->where('online', true)->count();
    }

    public function setAvatarAttribute($avatar){
        if(is_object($avatar) && $avatar->isValid()){
            self::saved(function($instance) use ($avatar){
                ImageManagerStatic::make($avatar)->fit(800,350)->save(public_path() . "/img/collections/{$instance->id}.{$avatar->extension()}");
            });
            $this->attributes['avatar'] = true;
            $this->attributes['extension'] = $avatar->extension();
        }
    }

    public function getAvatarAttribute($avatar)
    {
        return ($avatar) ? "/img/collections/{$this->id}{$this->extension}" : "/img/collections/default-collection.jpg";
    }

    public function getPrimaryAttribute($primary){
        return ($primary == "1") ? true : false;
    }

    //Collection de base.
    public function isPrimary(){
        return ($this->attributes['primary'] == "1") ? true : false;
    }

}
