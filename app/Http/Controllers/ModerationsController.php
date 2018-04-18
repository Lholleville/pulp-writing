<?php

namespace App\Http\Controllers;

use App\Collec;
use Illuminate\Http\Request;

class ModerationsController extends Controller
{
    public function __construct()
    {
    }

    public function index(){
        return view('moderation.index');
    }

    public function show($slug){
        $collection = Collec::where('slug', $slug)->first();
        return view('moderation.show', compact('collection'));
    }
}
