<?php

namespace App\Http\Controllers;

use App\Behaviour\DateTransform;
use App\Behaviour\Sluggable;
use App\Book;
use App\Chapter;
use App\Comment;
use App\Http\Requests\ChaptersRequest;
use App\Note;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChaptersController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['except' => 'show']);
        $this->middleware('owner', ['except' => ['index', 'show', 'like', 'dislike', 'read', 'unread']]);
    }

    public function getResource($slug){
        return Book::where('slug',$slug)->first();
    }

    public function index(){

    }

    public function create($book){
        $chapter = new Chapter();
        return view('chapters.create', compact('book', 'chapter'));
    }

    public function edit($book, $slug){

        $chapter = Chapter::where('slug', $slug)->first();
        return view('chapters.edit', compact('chapter', 'book'));
    }

    public function store(ChaptersRequest $request, Guard $auth, $book){
        $data = $request->all();
        $data['user_id'] = $auth->user()->id;
        $data['order'] = 0;
        $data['words'] = 0;
        Chapter::create($data);
        return redirect(action('BooksController@show', $book))->with('success', 'Nouveau chapitre enregistré');
    }

    public function update(ChaptersRequest $request,$book, $slug2, Guard $auth){
        $data = $request->all();
        if(!isset($data['online'])){
            $data['online'] = 0;
        }
        $data['user_id'] = $auth->user()->id;
        $data['words'] = 0;
        $chapter = Chapter::where('slug', $slug2)->first();
        $chapter->update($data);
        return redirect(url('ecrire/oeuvres/'.$book->slug.'/chapitre/'.$chapter->slug))->with('success', 'Les modifications ont été effectuées avec succès.');
    }

    public function show($slugbook, $slug){
        $comment = new Comment();
        $note = new Note();
        $motifs_annotation = [];
        $chapter = Chapter::where('slug', $slug)->first();
        $comments = $chapter->comments()->paginate(20);
        return view('chapters.show', compact('book', 'chapter', 'slugbook', 'comment', 'comments', 'note', 'motifs_annotation'));
    }


    public function destroy($book,$slug){
        $chapter = Chapter::where('slug', $slug)->first();
        $chapter->delete();
        return redirect(url('ecrire/oeuvres/'.$book->slug))->with('warning', 'Le chapitre a été supprimé.');
    }

    public function like($id, Guard $auth){

        $chapter = Chapter::findOrFail($id);

        if($auth->user()->hasLike($chapter)){
            return back()->with('danger','Vous avez déjà aimé le chapitre');
        }

        if($auth->user()->chapters->isEmpty() || !$auth->user()->hasInterractWith($chapter)){
            DB::table('chapter_user')->insert(['user_id' => $auth->user()->id, 'chapter_id' => $chapter->id, 'has_read' => false, 'liked' => true]);
        }else{
            DB::table('chapter_user')->where('chapter_id', $id)->where('user_id', $auth->user()->id)->update(['liked' => 1]);
        }


        return back()->with('success', 'Vous avez aimé ce chapitre ! :) ');

    }

    public function dislike($id, Guard $auth){
        $chapter = Chapter::findOrFail($id);
        if(!$auth->user()->hasLike($chapter)){
            return back()->with('danger','Vous n\'aimiez déjà pas le chapitre');
        }
        DB::table('chapter_user')->where('chapter_id', $id)->where('user_id', $auth->user()->id)->update(['liked' => 0]);
        return back()->with('warning', 'Vous n\'appréciez plus ce chapitre ... :(');
    }

    public function read($id, Guard $auth){

        $chapter = Chapter::findOrFail($id);
        if($auth->user()->hasRead($chapter)){
            return back()->with('danger','Vous avez déjà lu le chapitre!');
        }

        if($auth->user()->chapters->isEmpty() || !$auth->user()->hasInterractWith($chapter)){
            DB::table('chapter_user')->insert(['user_id' => $auth->user()->id, 'chapter_id' => $chapter->id, 'has_read' => true, 'liked' => false]);
        }else{
            DB::table('chapter_user')->where('chapter_id', $id)->where('user_id', $auth->user()->id)->update(['has_read' => 1]);
        }
        return back()->with('success', 'Vous avez lu ce chapitre ! :) ');

    }

    public function unread($id, Guard $auth){
        $chapter = Chapter::findOrFail($id);
        if(!$auth->user()->hasRead($chapter)){
            return back()->with('danger','Vous n\'aviez jamais lu le chapitre ! O.o');
        }
        DB::table('chapter_user')->where('chapter_id', $id)->where('user_id', $auth->user()->id)->update(['has_read' => 0]);
        return back()->with('warning', 'Vous n\'aviez en fait pas lu ce chapitre ... :(');
    }

}
