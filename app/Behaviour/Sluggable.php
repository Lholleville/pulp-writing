<?php
/**
 * Created by PhpStorm.
 * User: Loic
 * Date: 12/03/2018
 * Time: 15:29
 */

namespace App\Behaviour;


use Illuminate\Support\Str;

trait Sluggable
{
    public function setSlugAttribute(){
        (isset($this->name)) ? $this->attributes['slug'] = Str::slug($this->name) : $this->attributes['slug'] = Str::slug($this->title);
    }
}