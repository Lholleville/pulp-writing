<?php

namespace App\Http\Controllers;

use App\Collec;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(){
        //$this->middleware(['guest']);
    }

    public function index(){
        $collections = Collec::where('online', true)->get();
        return view('welcome', compact('collections'));
    }
}
