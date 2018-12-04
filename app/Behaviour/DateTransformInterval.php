<?php
/**
 * Created by PhpStorm.
 * User: Loic
 * Date: 12/06/2018
 * Time: 10:41
 */

namespace App\Behaviour;


use Carbon\Carbon;

trait DateTransformInterval
{

    public function getCreatedatAttribute($created_at){
        Carbon::setLocale('fr');
        return Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->diffForHumans();
    }

    public function getUpdatedatAttribute($updated_at){
        Carbon::setLocale('fr');
        return Carbon::createFromFormat('Y-m-d H:i:s', $updated_at)->diffForHumans();
    }
}