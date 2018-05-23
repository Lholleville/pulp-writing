<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regle extends Model
{
    public $guarded = ['id'];

    public $dates = ['created_at', 'updated_at'];

    public function isAllowed(){

    }
}
