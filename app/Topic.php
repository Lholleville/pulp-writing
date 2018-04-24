<?php

namespace App;

use App\Behaviour\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public $guarded = ['id'];

    public $dates = ['updated_at', 'created_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    use Sluggable;
}
