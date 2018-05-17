<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $guarded = ['id'];
    protected $dates = ['created_at', 'read_at'];

    public $timestamps = false;


    public function from(){
        return $this->belongsTo(User::class, 'from_id');
    }

    public function previousID(){
        $this->from;
    }
}
