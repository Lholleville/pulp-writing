<?php

namespace App;

use App\Behaviour\DateTransform;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    public $guarded = ['id'];

    public $dates = ['created_at', 'updated_at'];

    use DateTransform;

    public function comments(){
        return $this->hasMany('App\Comment', 'journal_id');
    }

    public function users(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
