<?php
/**
 * Created by PhpStorm.
 * User: Loic
 * Date: 17/03/2017
 * Time: 16:52
 */

namespace App\Behaviour;


use Carbon\Carbon;

trait DateTransform
{
    public function getCreatedatAttribute($created_at){
        return Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->format('d M Y');
    }

    public function getUpdatedatAttribute($updated_at){
        return Carbon::createFromFormat('Y-m-d H:i:s', $updated_at)->format('d M Y');
    }
}