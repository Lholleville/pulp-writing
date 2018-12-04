<?php

namespace App\Http\Controllers;

use App\Engagement;
use App\Events\UserCreateJournalEvent;
use App\Http\Requests\JournalsRequest;
use App\Journal;
use App\Notification;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class JournalsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'store', 'update', 'delete', 'edit']]);
        $this->middleware('owner', ['only' => [ 'update', 'destroy', 'edit']]);
    }

    public function getResource($id){
        return Journal::where('id', $id)->first();
    }

    public function index(){
        $journals = Journal::paginate(50);
        $journal = new Journal();
        return view('journals.index', compact('journals', 'journal'));
    }

    public function show(){

    }

    public function store(JournalsRequest $request, Guard $auth){
        $data = $request->all();
        $data['user_id'] = $auth->user()->id;
        $journal = Journal::create($data);
        event(new UserCreateJournalEvent($auth->user(), $journal));
        return redirect()->back()->with('success', 'Votre nouvelle publication a été créée.');
    }

    public function update(JournalsRequest $request, $journal){
        $data = $request->all();
        $journal->update($data);
        return redirect()->back()->with('success', 'Les modifications ont été sauvegardées.');
    }

    public function destroy($journal){
        $journal->delete();
        return redirect()->back()->with('warning', 'La publication a été supprimée');
    }

    private function notifcomment(User $user, Journal $post){
        $content = $user->name." a aimé votre publication <b>#".$post->id."</b> sur votre journal";
        $id = $post->users->id;
        $link = url("profil/".$post->users->slug."#".$post->id);

        Notification::create([
            'content' => $content,
            'user_id' => $id,
            'link' => $link,
        ]);
    }

    public function like($id, Guard $auth){

        $journal = Journal::findOrFail($id);

        if($journal->engagements->where('user_id', $auth->user()->id)->isEmpty()){
            $engagement = Engagement::create(
                [
                    'user_id' => $auth->user()->id,
                    'Journal_id' => $journal->id,
                    'has_like' => true
                ]
            );
            $this->notifcomment($auth->user(), $journal);
            return redirect()->back()->with('success', 'Publication likée.');
        }else{
            if($journal->engagements->where('user_id', $auth->user()->id)->first()->has_like == 0){

                $journal->engagements->where('user_id', $auth->user()->id)->first()->update(
                    [
                        'has_like' => 1,
                        'has_dislike' => 0
                    ]
                );
                $this->notifcomment($auth->user(), $journal);
                return redirect()->back()->with('success', 'Publication likée.');
            }else{
                $journal->engagements->where('user_id', $auth->user()->id)->first()->update(
                    [
                        'has_like' => 0,
                        'has_dislike' => 0
                    ]
                );
                return redirect()->back()->with('success', 'Appréciation retirée.');
            }
        }
    }

    public function dislike($id, Guard $auth){
        $journal = Journal::findOrFail($id);

        if($journal->engagements->where('user_id', $auth->user()->id)->isEmpty()){
            $engagement = Engagement::create(
                [
                    'user_id' => $auth->user()->id,
                    'Journal_id' => $journal->id,
                    'has_dislike' => true
                ]
            );
            return redirect()->back()->with('success', 'Publication dislikée.');
        }else{
            if($journal->engagements->where('user_id', $auth->user()->id)->first()->has_dislike == 0){

                $journal->engagements->where('user_id', $auth->user()->id)->first()->update(
                    [
                        'has_like' => 0,
                        'has_dislike' => 1
                    ]
                );

                return redirect()->back()->with('success', 'Publication dislikée.');
            }else{
                $journal->engagements->where('user_id', $auth->user()->id)->first()->update(
                    [
                        'has_like' => 0,
                        'has_dislike' => 0
                    ]
                );
                return redirect()->back()->with('success', 'Appréciation retirée.');
            }
        }
    }
}
