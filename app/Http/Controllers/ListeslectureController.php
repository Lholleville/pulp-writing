<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\ListesRequest;
use App\Liste;
use App\Listelecture;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class ListeslectureController extends Controller
{
    public $auth;

    public function __construct(Guard $auth)
    {
        $this->middleware('auth');
        $this->middleware('owner', ['only' => 'update']);
        $this->auth = $auth;
    }

    public function getResource($id){
        return Listelecture::findOrFail($id);
    }

    public function update(ListesRequest $request, $list){
        $list->books()->sync($request->get('book_id'));
        return redirect()->back()->with('success', $list->name.' a bien été mise à jour.');
    }

    public function store(ListesRequest $request){
        $data = $request->all();
        $data['type'] = Liste::CUSTOM_LECTURE_ID;
        $data['user_id'] = $this->auth->user()->id;
        if(!isset($data['description'])){
            $data['description'] = Liste::CUSTOM_LECTURE_DESCRIPTION;
        }
        if(!isset($data['name'])){
            $data['name'] = Liste::CUSTOM_LECTURE_NAME;
        }
        Listelecture::create($data);
        return redirect()->back()->with('sucess', 'Votre liste "'.$data['name'].'" a bien été créée.');
    }

    public function destroy($liste){
        $list = Listelecture::findOrFail($liste);
        $list->delete();
        return redirect()->back()->with('warning', 'La liste de lecture a bien été supprimée.');
    }

    public function subscribe($id){
        $book = Book::findOrFail($id);
        $list = $this->auth->user()->textsliste;

        if($book->isInlist($list)){
            $list->books()->detach($book->id);
        }else{
            $list->books()->attach($book->id);
        }
        return redirect()->back();

    }

    public function setruleslecture(Request $request, $id){
        $list = Listelecture::findOrFail($id);
        $regle = $list->reglelectures;

        $data = $request->all();

        if(!isset($data['text_chapter_created'])){
            $data['text_chapter_created'] = 0;
        }
        if(!isset($data['text_statut_changed'])){
            $data['text_statut_changed'] = 0;
        }

        $regle->update($data);
        return redirect()->back()->with('success', 'Les règles de validation ont bien été validées');
    }
}
