<?php

namespace App;

use App\Behaviour\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public $guarded = ['id'];

    public $dates = ['updated_at', 'created_at'];

    use Sluggable;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getParentAttribute(){
        if($this->attributes['parent_id'] != 0){
            $genre = Genre::findOrFail($this->attributes['parent_id']);
            return $genre->name;
        }else{
            return '/';
        }
    }
}
