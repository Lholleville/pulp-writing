<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Forum;
use App\Http\Requests\TopicsRequest;
use App\Topic;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function __construct(){
        $this->middleware('modo', ['only' => ['archived', 'pinned']]);
        $this->middleware('owner', ['except' => ['show', 'create', 'store']]);
    }

    public function getResource($slug, $slugtopic = null){
        if(!isset($slugtopic)){
            $slugtopic = $slug;
        }
        $topic = Topic::where('slug', $slugtopic)->first();
        return $topic;
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

    public function show($slugforum, $slug){
        $forum = Forum::where('slug', $slugforum)->first();
        $topic = Topic::where('slug', $slug)->first();
        $comment = new Comment();
        $comments = $topic->comments()->paginate(20);
        return view('topics.show', compact('topic', 'forum', 'comment', 'comments'));
    }

    public function edit($topic){

        $forum = $topic->forums;
        return view('topics.edit', compact('topic', 'forum'));
    }

    public function update(TopicsRequest $request, $topic){
        $topic->update($request->only(['name', 'slug', 'online']));
        return redirect('forums/'.$topic->forums->slug.'/topic/'.$topic->slug)->with('success', 'Le sujet a bien été modifié.');
    }

    public function destroy($topic){
        $forum = $topic->forums;
        foreach($topic->comments as $comment){
            $comment->delete();
        }
        $topic->delete();
        return redirect(action('ForumsController@show', $forum))->with('sucess', 'Le sujet a bien été supprimé, ainsi que tous les commentaires associés.');
    }

    public function archive($topic){

    }

    public function pin($topic){
        $topic->pinned = !$topic->pinned;
        $topic->save();
        return redirect(action('ForumsController@show', $topic->forums))->with('success', $topic->pinned ? 'Le topic a bien été épinglé.' : 'Le topic a bien été désépinglé');
    }

    public function lock($topic){
        $topic->locked = !$topic->locked;
        if($topic->locked == false){
            $topic->answerable = true;
        }
        $topic->save();
        return redirect(action('ForumsController@show', $topic->forums))->with('success', $topic->locked ? 'Le topic a bien été vérouillé.' : 'Le topic a bien été dévérouillé');
    }

    public function answerable($topic){
        if($topic->isPinned()){
            $topic->answerable = !$topic->answerable;
            $topic->save();
            return redirect(action('ForumsController@show', $topic->forums))->with('success', $topic->answerable ? 'Les réponses ont bien été désactivées.' : 'Les réponses ont été activées');
        }
        else{
            return redirect(action('ForumsController@show', $topic->forums))->with('danger', 'Le sujet doit d\'abord être épinglé');
        }
    }

}
