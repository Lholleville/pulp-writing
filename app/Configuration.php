<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    public $guarded = ['id'];

//    public function getKeymodeEnabledAttribute(){
//        return ($this->attributes['keymode_enabled']) ? "<i class=\"fas fa-check\"></i>" :"<i class=\"fas fa-times\"></i>";
//    }
//
//    public function getActiveAttribute(){
//        return ($this->attributes['active']) ? "<i class=\"fas fa-check\"></i>" :"<i class=\"fas fa-times\"></i>";
//    }

      public $dates = [];

      public function getCurrentConfig(){
          return $this->where('active', true)->first();

      }
}
