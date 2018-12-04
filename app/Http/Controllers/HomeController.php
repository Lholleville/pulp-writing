<?php

namespace App\Http\Controllers;

use App\Collec;
use App\Configuration;
use App\Book;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(){
        //$this->middleware(['guest']);
    }

    public function index(){
        $collections = Collec::where('online', true)->get();
        $config = Configuration::where("active", true)->first();
        $books = Book::orderByRaw('RAND()')->limit(3)->get();
        return view('welcome', compact('collections', 'config', 'books'));
    }
}
