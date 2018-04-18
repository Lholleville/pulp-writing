<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\CommentsRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct(){
        $this->middleware('owner', ['except' => ['index', 'store', 'create', 'signal']]);
    }

    public function getResource($id){
        return Comment::findOrFail($id);
    }

    public function index(){

    }

    public function show(){

    }

    public function edit($comment){
        return view('comments.edit', compact('comment'));
    }

    public function create(){


    }

    public function destroy($comment){
        $comment->delete();
        return redirect($comment->chapters->books->collections->slug.'/'.$comment->chapters->books->slug.'/'.$comment->chapters->order.'/'.$comment->chapters->slug)->with('warning', 'Votre commentaire a bien été supprimé.');

    }

    public function store(CommentsRequest $request, Guard $auth){
        $data = $request->all();
        $data["signal"] = 0;
        $data["user_id"] = $auth->user()->id;
        Comment::create($data);
        return back()->with('success', 'Merci pour votre commentaire ! :)');
    }

    public function update(CommentsRequest $request, $comment){
        $comment->update($request->all());
        return redirect($comment->chapters->books->collections->slug.'/'.$comment->chapters->books->slug.'/'.$comment->chapters->order.'/'.$comment->chapters->slug)->with('success', 'Votre commentaire a bien été modifié :)');
    }
}
