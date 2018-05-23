<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listelecture extends Liste
{
    public function books(){
        return $this->belongsToMany('App\Book');
    }

    public function reglelectures(){
        return $this->HasOne('App\Reglelecture');
    }



}
