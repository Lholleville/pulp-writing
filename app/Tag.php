<?php

namespace App;

use App\Behaviour\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $guarded = ['id'];

    public $dates = ['updated_at', 'created_at'];

    use Sluggable;

    public function getRouteKeyName(){
        return 'slug';
    }

}
