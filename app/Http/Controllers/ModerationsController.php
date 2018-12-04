<?php

namespace App\Http\Controllers;

use App\Book;
use App\Collec;
use App\Notification;
use App\Signal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $signals = Signal::all();
        return view('moderation.show', compact('collection', 'collections', 'signals'));
    }

    public function update($slug, Request $request){
        $book = Book::where('slug', $slug)->first();
        $book->update($request->only(['collec_id']));
        $collection = Collec::findOrFail($request->only(['collec_id']))->first();
        $content = "Votre oeuvre ".$book->name." a été déplacée dans la collection ".$collection->name;
        $link = url("collections/".$collection->slug);

        Notification::create([
            'content' => $content,
            'user_id' => $book->users->id,
            'link' => $link,
        ]);

        return redirect()->back()->with('success', 'Le texte '.$book->name.' a été déplacé avec succès.');
    }

    public function reemigrate($slug){
        $book = Book::where('slug', $slug)->first();
        $collection = $book->collections;
        $collection0 = Collec::where('primary', 1)->first();
        $book->update(['collec_id' => $collection0->id]);

        $content = "Votre oeuvre ".$book->name." a été retirée de la collection ".$collection->name;
        $link = url("collections/".$collection0->slug);

        Notification::create([
            'content' => $content,
            'user_id' => $book->users->id,
            'link' => $link,
        ]);

        return redirect()->back()->with('success', 'Le texte '.$book->name.' a été déplacé avec succès vers la collection '.$collection0->name);
    }

    public function superLiked($slug){
        $book = Book::where('slug', $slug)->first();
        if($book != null){
            DB::table('books')->where('collec_id', $book->collections->id)->update(['superliked' => false]);
            $book->superliked = 1;
            $book->save();
            return redirect()->back()->with('success', 'Le texte '.$book->name.' a été superliked');
        }
        return redirect('/')->with('danger', 'Le texte '.$slug.' est introuvable');


    }
}
