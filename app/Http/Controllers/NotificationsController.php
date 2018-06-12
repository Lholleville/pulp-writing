<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{

    public function read($id){
        DB::table('notifications')->where('id', $id)->update(['read' => true]);
    }

}
