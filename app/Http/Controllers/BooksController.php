<?php

namespace App\Http\Controllers;

use App\Annotation;
use App\Book;
use App\Collec;
use App\Genre;
use App\Http\Requests\BooksRequest;
use App\Statut;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('owner', ['except' => ['index', 'show', 'create', 'store']]);
    }

    public function getResource($slug){
        $book = Book::where('slug', $slug)->first();
        return $book;
    }

    public function index(){

    }

    public function show($slug){
        $book = Book::where('slug', $slug)->first();
        return view('books.show', compact('book'));
    }

    public function create(Guard $auth){
        $book = new Book();
        $all_genres = Genre::all()->pluck('name', 'id');
        $all_statuts = Statut::all()->pluck('name', 'id');
        $my_books = $auth->user()->books->pluck('name', 'id');
        $my_books[0] = 'Non';
        return view('books.create', compact('book', 'all_genres', 'all_statuts', 'my_books'));

    }

    public function edit($book, Guard $auth){
        $all_genres = Genre::all()->pluck('name', 'id');
        $all_statuts = Statut::all()->pluck('name', 'id');
        $my_books = $auth->user()->books->where('id', '<>', $book->id)->pluck('name', 'id');
        $my_books[0] = 'Non';
        return view('books.edit', compact('book', 'all_genres', 'all_statuts', 'my_books'));
    }

    public function store(BooksRequest $request, Guard $auth){

        $data = $request->all();
        $data['user_id'] = $auth->user()->id;
        $data['collec_id'] = Collec::where('primary', 1)->first()->id;
        Book::create($data);
        return redirect(action('AteliersController@index'))->with('success', 'Nouvelle oeuvre crée.');

    }

    public function update($book, BooksRequest $request, Guard $auth){
        $data = $request->all();
        $data['user_id'] = $auth->user()->id;
        $book->update($data);
        return redirect(action('BooksController@show', $book))->with('success', 'l\'oeuvre "'.$book->name.'" a bien été modifiée');

    }

    public function destroy($book){
        $name = $book->name;
        $book->delete();
        return redirect(action('AteliersController@index'))->with('warning', 'l\'oeuvre "'.$name.'" a bien été modifiée');
    }
}
