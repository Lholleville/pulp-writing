<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Http\Requests\TopicsRequest;
use App\Topic;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function __construct(){
        $this->middleware('owner', ['except' => ['show', 'create', 'store']]);
    }

    public function getResource($slug){
        return Topic::where('slug', $slug)->first();
    }

    public function index(){

    }

    public function create($slugforum){
        $forum = Forum::where('slug', $slugforum)->first();
        $topic = new Topic();
        return view('topics.create', compact('topic', 'forum'));
    }

    public function store(TopicsRequest $request, Guard $auth, $slug){
        $data = $request->all();
        $data['user_id'] = $auth->user()->id;
        $data['forum_id'] = Forum::where('slug', $slug)->first()->id;
        $data['pinned'] = false;
        $data['locked'] = false;
        $data['online'] = true;
        Topic::create($data);
        return redirect(action('ForumsController@show', $slug))->with('success', 'Votre nouveau sujet a été créé');
    }

    public function show($slug){
        $topic = Topic::where('slug', $slug)->first();
        return view('topics.show', compact('show'));
    }

    public function edit($topic){

    }

    public function update($topic){

    }

    public function destroy($topic){

    }

}
