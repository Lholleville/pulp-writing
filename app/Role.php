<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $guarded = ['id'];

    public function users(){
        return $this->HasMany('App\User', 'role_id');
    }
}
