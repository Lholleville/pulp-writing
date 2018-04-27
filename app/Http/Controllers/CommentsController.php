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
        $tmp = $comment;
        $comment->delete();
        if($tmp->chapter_id != 0){
            return redirect($tmp->chapters->books->collections->slug.'/'.$tmp->chapters->books->slug.'/'.$tmp->chapters->order.'/'.$tmp->chapters->slug)->with('warning', 'Votre commentaire a bien été supprimé.');
        }else{
            return redirect('forums/'.$tmp->topics->forums->slug.'/topic/'.$tmp->topics->slug)->with('warning', 'Votre commentaire a bien été supprimé.');
        }

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
        if($comment->chapter != null){
            return redirect($comment->chapters->books->collections->slug.'/'.$comment->chapters->books->slug.'/'.$comment->chapters->order.'/'.$comment->chapters->slug)->with('success', 'Votre commentaire a bien été modifié :)');
        }else{
            return redirect('forums/'.$comment->topics->forums->slug.'/topic/'.$comment->topics->slug)->with('success', 'Votre commentaire a bien été modifié :)');
        }
    }
}
