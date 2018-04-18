<?php

namespace App;

use App\Behaviour\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Statut extends Model
{
    public $guarded = ['id'];

    public $date = ['updated_at', 'created_at'];

    use Sluggable;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getColorAttribute($color){
        return '#'.$color;
    }
}
