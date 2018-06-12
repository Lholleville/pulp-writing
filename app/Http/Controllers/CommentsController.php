<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Comment;
use App\Engagement;
use App\Http\Requests\CommentsRequest;
use App\Journal;
use App\Notification;
use App\Topic;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct(){
        $this->middleware('owner', ['except' => ['index', 'store', 'create', 'signal', 'like', 'dislike']]);
        $this->middleware('auth', ['only' => ['like', 'dislike']]);
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
        $comment = Comment::create($data);

        if(isset($data['chapter_id'])){
            $chapter = Chapter::findOrFail($data['chapter_id']);
            $content = $auth->user()->name." a commenté votre chapitre : ".$chapter->name." de l'oeuvre ".$chapter->books->name;
            $link = url($chapter->books->collections->slug."/".$chapter->books->slug."/".$chapter->order."/".$chapter->slug."#".$comment->id);
            $id = $chapter->books->users->id;
        }
        if(isset($data['topic_id'])){
            $topic = Topic::findOrFail($data['topic_id']);
            $content = $auth->user()->name." a commenté votre topic : ".$topic->name." sur le forum ".$topic->forums->name;
            $link = url("forums/".$topic->forums->slug."/topic/".$topic->slug."#".$comment->id);
            $id = $topic->users->id;
        }
        if(isset($data['journal_id'])){
            $post = Journal::findOrFail($data['journal_id']);
            $content = $auth->user()->name." a commenté votre publication : ".$post->name." sur votre journal.";
            $link = url("profil/".$post->users->slug."#".$comment->id);
            $id = $post->users->id;
        }
        Notification::create([
            'content' => $content,
            'user_id' => $id,
            'link' => $link,
        ]);
        return redirect()->back()->with('success', 'Merci pour votre commentaire ! :)');
    }

    public function update(CommentsRequest $request, $comment){
        $comment->update($request->all());


        if($comment->chapters != null){
            return redirect($comment->chapters->books->collections->slug.'/'.$comment->chapters->books->slug.'/'.$comment->chapters->order.'/'.$comment->chapters->slug)->with('success', 'Votre commentaire a bien été modifié :)');
        }elseif($comment->journals != null){
            return redirect('profil/'.$comment->journals->users->slug);
        }
        else{
            return redirect('forums/'.$comment->topics->forums->slug.'/topic/'.$comment->topics->slug)->with('success', 'Votre commentaire a bien été modifié :)');
        }
    }


    private function notifcomment(User $user, Comment $comment){
        $content = $user->name." a aimé votre commentaire ";

        switch($comment->type){
            case "chapter" :
                $id = $comment->chapters->books->users->id;
                $content .= "sur le chapitre ".$comment->chapters->name;
                $link = url($comment->chapters->books->collections->slug."/".$comment->chapters->books->slug."/".$comment->chapters->order."/".$comment->chapters->slug."#".$comment->id);
            break;
            case "topic" :
                $topic = $comment->topics;
                dd($topic);
                $id = $topic->users->id;
                $content .= "sur le topic ".$topic->name;
                $link = url("forums/".$topic->forums->slug."/topic/".$topic->slug."#$comment->id");
            break;
            case "journal" :
                $post = $comment->journals;
                $id = $post->users->id;
                $content .= "sur la publication <b>#".$post->id."</b>";
                $link = url("profil/".$post->users->slug."#".$post->id);
            break;
        }


        Notification::create([
            'content' => $content,
            'user_id' => $id,
            'link' => $link,
        ]);
    }

    public function like($id, Guard $auth){

        $comment = Comment::findOrFail($id);

        if($comment->engagements->where('user_id', $auth->user()->id)->isEmpty()){
            $engagement = Engagement::create(
                [
                    'user_id' => $auth->user()->id,
                    'comment_id' => $comment->id,
                    'has_like' => true
                ]
            );
            $this->notifcomment($auth->user(), $comment);
            return redirect()->back()->with('success', 'Commentaire liké.');
        }else{
            if($comment->engagements->where('user_id', $auth->user()->id)->first()->has_like == 0){

                $comment->engagements->where('user_id', $auth->user()->id)->first()->update(
                    [
                        'has_like' => 1,
                        'has_dislike' => 0
                    ]
                );
                $this->notifcomment($auth->user(), $comment);
                return redirect()->back()->with('success', 'Commentaire liké.');
            }else{
                $comment->engagements->where('user_id', $auth->user()->id)->first()->update(
                    [
                        'has_like' => 0,
                        'has_dislike' => 0
                    ]
                );
                return redirect()->back()->with('error', 'Appréciation retirée.');
            }
        }
    }

    public function dislike($id, Guard $auth){
        $comment = Comment::findOrFail($id);

        if($comment->engagements->where('user_id', $auth->user()->id)->isEmpty()){
            $engagement = Engagement::create(
                [
                    'user_id' => $auth->user()->id,
                    'comment_id' => $comment->id,
                    'has_dislike' => true
                ]
            );
            return redirect()->back()->with('success', 'Commentaire disliké.');
        }else{
            if($comment->engagements->where('user_id', $auth->user()->id)->first()->has_dislike == 0){

                $comment->engagements->where('user_id', $auth->user()->id)->first()->update(
                    [
                        'has_like' => 0,
                        'has_dislike' => 1
                    ]
                );

                return redirect()->back()->with('success', 'Commentaire disliké.');
            }else{
                $comment->engagements->where('user_id', $auth->user()->id)->first()->update(
                    [
                        'has_like' => 0,
                        'has_dislike' => 0
                    ]
                );
                return redirect()->back()->with('error', 'Appréciation retirée.');
            }
        }
    }
}
