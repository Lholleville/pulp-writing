<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reglelecture extends Model
{
    public $guarded = ['id'];

    public $dates = ['created_at', 'updated_at'];


}
