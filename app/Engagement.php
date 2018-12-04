<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Engagement extends Model
{
    public $guarded = ['id'];

    public $dates = ['created_at', 'uploaded_at'];

    public function users(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getLikeAttribute(){
        return $this->attributes['has_like'];
    }




}
