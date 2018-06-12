<?php

namespace App;

use App\Behaviour\DateTransformInterval;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $guarded = ['id'];

    public $dates = ['updated_at', 'created_at'];

    public function isRead(){
        return $this->attributes['read'] ? true : false;
    }

    use DateTransformInterval;



}
