<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagsRequest;
use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('tags', ['only' => ['show']]);
        $this->middleware('admin', ['except' => ['show', 'create', 'store']]);
    }

    public function getResource($slug){
        return Tag::where('slug', $slug)->first();
    }

    public function index(){
        $tags = Tag::where('online', true)->orderBy('created_at')->get();
        $tags_not_online = Tag::where('online', false)->get();
        return view('tags.index', compact('tags', 'tags_not_online'));
    }

    public function edit($slug){

    }

    public function create($slug){

    }

    public function show($tag){

        return view('tags.show', compact('tag'));
    }

    public function update(TagsRequest $request, $slug){

    }

    public function store(TagsRequest $request){

    }

    public function destroy($tag){

    }

    public function restore($slug){
        $tag = Tag::where('slug', $slug)->first();
        $tag->online = !$tag->online;
        if(!$tag->online){
            $tag->books()->detach();
        }
        $tag->save();
        return redirect()->back()->with('success', 'Le statut du tag a été modifié');
    }
}
