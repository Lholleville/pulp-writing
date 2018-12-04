<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    public $guarded = ['id'];

    public $dates = ['updated_at', 'created_at'];

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
