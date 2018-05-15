<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JailController extends Controller
{
    public function redirect(){
        return view('banni');
    }
}
