<?php

namespace App\Http\Controllers;

use App\Annotation;
use App\Book;
use App\Collec;
use App\Genre;
use App\Http\Requests\BooksRequest;
use App\Statut;
use App\Tag;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $collections = Collec::all();
        return view('books.show', compact('book', 'collections'));
    }

    public function create(Guard $auth){
        $book = new Book();
        $all_genres = Genre::all()->pluck('name', 'id');
        $all_statuts = Statut::all()->pluck('name', 'id');
        $tags = Tag::where('online', true)->get();
        $my_books = $auth->user()->books->pluck('name', 'id');
        $my_books[0] = 'Non';
        return view('books.create', compact('book', 'all_genres', 'all_statuts', 'my_books', 'tags'));

    }

    public function edit($book, Guard $auth){
        $all_genres = Genre::all()->pluck('name', 'id');
        $all_statuts = Statut::all()->pluck('name', 'id');
        $my_books = $auth->user()->books->where('id', '<>', $book->id)->pluck('name', 'id');
        $my_books[0] = 'Non';
        $tags = Tag::where('online', true)->get();

        return view('books.edit', compact('book', 'all_genres', 'all_statuts', 'my_books', 'tags'));
    }

    public function store(BooksRequest $request, Guard $auth){


        $listnewids = self::addTags($request->get('tag_id'), $auth);
        $data = $request->except(['tag_id']);
        $data['user_id'] = $auth->user()->id;
        $data['collec_id'] = Collec::where('primary', 1)->first()->id;
        $book = Book::create($data);
        $book->tags()->sync($listnewids);
        return redirect(action('AteliersController@index'))->with('success', 'Nouvelle oeuvre crée.');

    }

    private function addTags($tabTag, $auth){
        $tags = Tag::all();
        //tableau des slugs des tags pour vérifier que le tag n'existe pas déjà.
        $listtags = [];
        //Liste des nouveaux id à sync avec le book
        $listnewids = [];
        foreach($tags as $t){
            $listtags[] = $t->slug;
        }
        //pour chaque tag, on vérifie que le tag n'est pas un id, donc qu'il faut le créer.
        foreach($tabTag as $tag){
            if(preg_match('#[^0-9]#', $tag) == 1){
                //si le tag n'existe pas
                if(!in_array(Str::slug($tag), $listtags)){
                    $id = DB::table('tags')->insertGetId(['name' => ucfirst($tag), 'slug' => Str::slug($tag), 'user_id' => $auth->user()->id, 'created_at' => date('Y-m-d H-i-s'), 'updated_at' => date('Y-m-d H-i-s')]);
                    $listnewids[] = $id;
                }
            }
        }
        foreach($tabTag as $tag_id){
            if(preg_match('#[^A-Za-z]#', $tag_id)){
                $listnewids[] = $tag_id;
            }
        }
        return $listnewids;
    }

    public function update($book, BooksRequest $request, Guard $auth){

        $listnewids = self::addTags($request->get('tag_id'), $auth);

        $data = $request->except(['tag_id']);
        $data['user_id'] = $auth->user()->id;
        $book->update($data);

        $book->tags()->sync($listnewids);

        return redirect(action('BooksController@show', $book))->with('success', 'l\'oeuvre "'.$book->name.'" a bien été modifiée');
    }

    public function destroy($book){
        $name = $book->name;
        $book->tags()->detach();
        $book->delete();
        return redirect(action('AteliersController@index'))->with('warning', 'l\'oeuvre "'.$name.'" a bien été modifiée');
    }
}
