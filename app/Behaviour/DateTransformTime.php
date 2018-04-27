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

    public function getLastMessageTimeAttribute($last_message_time){
        if($last_message_time == null){
            return null;
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $last_message_time)->format('d M Y, H:i:s');
    }
}