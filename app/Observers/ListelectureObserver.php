<?php
/**
 * Created by PhpStorm.
 * User: Loic
 * Date: 23/05/2018
 * Time: 22:28
 */

namespace App\Observers;


use App\Reglelecture;

class ListelectureObserver
{
    public function saved($liste){
        Reglelecture::create(['listelecture_id' => $liste->id]);
    }
}