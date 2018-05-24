<?php
/**
 * Created by PhpStorm.
 * User: Loic
 * Date: 23/05/2018
 * Time: 22:11
 */

namespace App\Observers;

use App\Regle;

class ListesObserver
{
    public function saved($liste){
        Regle::create(['liste_id' => $liste->id]);
    }
}