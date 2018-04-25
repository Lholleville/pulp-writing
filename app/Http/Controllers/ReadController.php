<?php

namespace App\Http\Controllers;

use App\Annotation;
use App\Book;
use App\Chapter;
use App\Collec;
use App\Comment;
use App\Motif;
use App\Note;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class ReadController extends Controller
{

    public function show($slugcollection, $slug){
        $readmode = true;
        $collections = Collec::all();
        $book = Book::where('slug', $slug)->first();
        return view('books.show', compact('book', 'readmode', 'collections'));
    }

    public function showChapter($slugcollection, $slugbook, $order, $slug, Guard $auth){
        $readmode = true;
        $chapter = Chapter::where('slug', $slug)->first();
        $motifs_annotation = Motif::all()->pluck('name', 'id');
        $note = new Note();
        if($auth->guest() || $chapter->user_id != $auth->user()->id ){

            //COOKIE VUE
            $cookie_name = 'view_'.$chapter->id;
            if(!isset($_COOKIE[$cookie_name])){
                $chapter->views = intval($chapter->views) + 1;
                $chapter->save();
                setcookie($cookie_name, $chapter->id, time() + 300, '/');
            }

            //COOKIE ORDRE
            $cookie_name = 'order_'.$chapter->books->id;
            setcookie($cookie_name, $chapter->order, time() + 365*24*3600, '/');
        }
        $comment = new Comment();
        $comments = $chapter->comments;
        return view('chapters.show', compact('readmode', 'chapter', 'slugbook', 'comment', 'comments', 'motifs_annotation', 'note'));
    }
}
