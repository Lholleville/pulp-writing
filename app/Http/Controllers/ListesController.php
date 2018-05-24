<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListesRequest;
use App\Liste;
use App\User;
use DateTime;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class ListesController extends Controller
{
    public $auth;

    public function __construct(Guard $auth)
    {
        $this->middleware('auth');
        $this->middleware('owner', ['only' => 'update', 'destroy']);
        $this->auth = $auth;
    }

    public function getResource($id){
        return Liste::findOrFail($id);
    }

    public function update(Request $request, $list){
        $list->users()->sync($request->get('user_id'));
        return redirect()->back()->with('success', $list->name.' a bien été mise à jour.');
    }

    public function store(ListesRequest $request){
        $data = $request->all();
        $data['type'] = Liste::CUSTOM_USER_ID;
        $data['user_id'] = $this->auth->user()->id;
        if(!isset($data['description'])){
            $data['description'] = Liste::CUSTOM_USER_DESCRIPTION;
        }
        if(!isset($data['name'])){
            $data['name'] = Liste::CUSTOM_USER_NAME;
        }
        Liste::create($data);

        return redirect()->back()->with('sucess', 'Votre liste "'.$data['name'].'" a bien été créée.');
    }

    public function friends($id){
        $user = User::findOrFail($id);
        $list = $this->auth->user()->friendsliste;
        if($user->isInlist($list)){
            $list->users()->detach($user->id);
        }else{
            $list->users()->attach($user->id);
        }
        return redirect()->back();
    }

    public function subscribe($id){
        $user = User::findOrFail($id);
        $list = $this->auth->user()->abonnementsliste;
        $listsubscribe = $user->subscribeliste;

        if($this->auth->user()->isInList($listsubscribe)){
            $listsubscribe->users()->detach($this->auth->user()->id);
        }else{
            $listsubscribe->users()->attach($this->auth->user()->id);
        }

        if($user->isInlist($list)){
            $list->users()->detach($user->id);
        }else{
            $list->users()->attach($user->id);
        }
        return redirect()->back();
    }

    public function blacklist($id){
        $user = User::findOrFail($id);
        $list = $this->auth->user()->blackliste;
        if($user->isInlist($list)){
            $list->users()->detach($user->id);
        }else{
            $list->users()->attach($user->id);
        }
        return redirect()->back();
    }

    public function destroy($liste){
        $liste = Liste::findOrFail($liste);
        $liste->delete();
        return redirect()->back()->with('warning', 'La liste a bien été supprimée.');
    }

    public function setrules(Request $request, $id){
        $list = Liste::findOrFail($id);
        $regle = $list->regles->first();



        $data = $request->all();

        if(!isset($data['user_article_created'])){
            $data['user_article_created'] = 0;
        }
        if(!isset($data['user_text_created'])){
            $data['user_text_created'] = 0;
        }
        if(!isset($data['user_diary_created'])){
            $data['user_diary_created'] = 0;
        }
        if(!isset($data['user_topic_created'])){
            $data['user_topic_created'] = 0;
        }

        $regle->update($data);
        return redirect()->back()->with('success', 'Les règles de validation ont bien été validées');

    }

}
