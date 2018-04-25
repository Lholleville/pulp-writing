<?php
/**
 * Created by PhpStorm.
 * User: Loic
 * Date: 25/04/2018
 * Time: 11:06
 */

namespace App\Behaviour;

use Carbon\Carbon;


trait DateTransformTime
{
    public function getCreatedatAttribute($created_at){
        return Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->format('d M Y, H:i:s');
    }

    public function getUpdatedatAttribute($updated_at){
        return Carbon::createFromFormat('Y-m-d H:i:s', $updated_at)->format('d M Y, H:i:s');
    }
}