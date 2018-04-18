<?php

namespace App\Http\Controllers;

use App\Book;
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
        $collections = Collec::All();
        $collection = Collec::where('slug', $slug)->first();
        return view('moderation.show', compact('collection', 'collections'));
    }

    public function update($slug, Request $request){
        $book = Book::where('slug', $slug)->first();
        $book->update($request->only(['collec_id']));
        return redirect()->back()->with('success', 'Le texte '.$book->name.' a été déplacé avec succès.');
    }

    public function reemigrate($slug){
        $book = Book::where('slug', $slug)->first();
        $collection0 = Collec::where('primary', 1)->first();
        $book->update(['collec_id' => $collection0->id]);
        return redirect()->back()->with('success', 'Le texte'.$book->name.' a été déplacé avec succès vers la collection '.$collection0->name);
    }
}
