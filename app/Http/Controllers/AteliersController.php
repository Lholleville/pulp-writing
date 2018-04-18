<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class AteliersController extends Controller
{

    public $auth;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Guard $auth){
        $user = $auth->user();
        return view('atelier', compact('user'));
    }
}
