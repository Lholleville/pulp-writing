<?php

namespace App\Http\Controllers;

use App\Collec;
use App\Forum;
use App\Http\Requests\ForumsRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumsController extends Controller
{

    public function __construct(){
        $this->middleware('admin', ['only' => ['indexadmin', 'destroy', 'store', 'update', 'edit', 'create']]);
    }

    public function index(){
        $forums = Forum::where('online', true)->get();
        return view('forums.index', compact('forums'));
    }

    public function indexadmin(){
        $forums = Forum::All();
        return view('forums.indexadmin', compact('forums'));
    }

    public function show($slug){
        $forum = Forum::where('slug', $slug)->first();
        return view('forums.show', compact('forum'));
    }

    public function create(){
        $forum = new Forum();
        $collecs = Collec::all()->pluck('name', 'id');
        $collecs[0] = 'Non';
        $modos = User::where('role_id', '2')->orWhere('role_id', '3')->pluck('name', 'id');
        return view('forums.create', compact('forum', 'collecs', 'modos'));
    }

    public function store(ForumsRequest $request){
        $data = $request->all();
        if($data['collec_id'] != '0')
        {
            if(isset($data['user_id'])){
                $data = $request->except(['user_id']);
            }

            $forum = Forum::create($data);
            $user_id = DB::table('collec_user')
                ->select('user_id')
                ->where('collec_id', $data['collec_id'])
                ->get();
            $user_id->collapse();
            foreach($user_id as $id){
                $ids[] = $id->user_id;
            }
            $forum->users()->sync($ids);
        }
        else
        {
            $data = $request->except(['user_id']);
            $forum = Forum::create($data);
            $forum->users()->sync($request->get('user_id'));
        }
        return redirect(action('ForumsController@indexadmin'))->with('success', 'Nouveau forum créé avec succès !');
    }

    public function edit($slug){
        $forum = Forum::where('slug', $slug)->first();
        $collecs = Collec::all()->pluck('name', 'id');
        $collecs[0] = 'Non';
        $modos = User::where('role_id', '2')->orWhere('role_id', '3')->pluck('name', 'id');
        return view('forums.edit', compact('forum', 'collecs', 'modos'));
    }

    public function update(ForumsRequest $request, $slug){
        $data = $request->all();
        $forum = Forum::where('slug', $slug)->first();

        if($data['collec_id'] != '0' && $forum->collec_id == '0')
        {

            if(isset($data['user_id'])){
                $data = $request->except(['user_id']);
            }

            $forum->update($data);
            $user_id = DB::table('collec_user')
                ->select('user_id')
                ->where('collec_id', $data['collec_id'])
                ->get();
            $user_id->collapse();
            foreach($user_id as $id){
                $ids[] = $id->user_id;
            }
            $forum->users()->sync($ids);
        }
        else
        {
            $data = $request->except(['user_id']);
            $forum->update($data);
            $forum->users()->sync($request->get('user_id'));
        }
        return redirect(action('ForumsController@indexadmin'))->with('success', 'Le forum '.$forum->name.' a bien été modifié.');
    }

    public function destroy($slug){
        $forum = Forum::where('slug', $slug)->first();
        $name = $forum->name;
        $forum->users()->detach();
        $forum->delete();
        return redirect()->back()->with('success', 'Le forum '.$name.' a été supprimé avec succès.');
    }
}
