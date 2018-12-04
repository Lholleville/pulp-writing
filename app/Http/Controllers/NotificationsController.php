<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function __construct(Guard $auth){
        $this->auth = $auth;
    }

    public function read($id){
        DB::table('notifications')->where('id', $id)->update(['read' => true]);
    }

    public function allRead() {
        DB::table('notifications')->where('user_id', $this->auth->user()->id)->where('read', false)->update(['read' => true]);

    }

}
