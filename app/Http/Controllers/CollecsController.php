<?php

namespace App\Http\Controllers;

use App\Collec;
use App\Genre;
use App\Http\Requests\CollecsRequest;
use App\User;
use Illuminate\Http\Request;

class CollecsController extends Controller
{

    public $list_modo;

    public function __construct(){
        $this->middleware('auth' , ['except' => ['normalShow', 'indexShow']]);
        $this->middleware('admin' , ['except' => ['normalShow', 'indexShow']]);
        $this->list_modo = User::where('role_id', 2)
                           ->orWhere('role_id', 3)
                           ->pluck('name', 'id');
    }

    public function index(){
       //$user_collec = DB::table('collec_user')->where()
        $collections = Collec::all();
        return view('admin.collections.index', compact('collections'));
    }

    public function show($slug)
    {
        $collection = Collec::where('slug', $slug)->first();
        return view('admin.collections.show', compact('collection'));

    }
    public function edit($slug)
    {

        $collection = Collec::where('slug', $slug)->first();
        $modos = User::where('role_id', 2)->orWhere('role_id', 3)->pluck('name', 'id');

        //$modos_collec = $collection->users()->pluck('name', 'id');
        return view('admin.collections.edit', compact('collection', 'modos', 'modos_collec'));
    }
    public function create()
    {
        $collection = new Collec();
        $modos = $this->list_modo;
        return view('admin.collections.create', compact('collection', 'modos'));
    }
    public function store(CollecsRequest $request)
    {
        $data = $request->except(['role_id']);
        $collection = Collec::create($data);
        $collection->users()->sync($request->get('role_id'));
        return redirect(action('CollecsController@index'))->with('success', 'La collection a été crée avec succès.');
    }
    public function update(CollecsRequest $request, $slug)
    {
        $collection = Collec::where('slug', $slug)->first();
        $collection->update($request->only(['name', 'slug', 'description', 'avatar', 'online', 'updated_at', 'created_at']));
        $collection->users()->sync($request->get('role_id'));
        return redirect(action('CollecsController@index'))->with('success', 'La collection a été modifiée avec succès.');
    }

    /**
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($slug)
    {
        $collection = Collec::where('slug', $slug)->first();
        $collection->users()->detach();
        $collection->delete();
        return redirect(action('CollecsController@index'))->with('warning', 'La collection a bien été supprimée');

    }

    public function normalIndex(){

    }

    public function normalShow($slug)
    {
        $collection = Collec::where('slug', $slug)->first();
        if(!$collection->books->isEmpty()){
            foreach($collection->books as $book){
                $point = 0;
                $point += intval($book->nbComments) * 10;
                $point += intval($book->views) * 0.1;
                $point += intval($book->users->commentcount) * 30;
                if($book->datelastcomment != null){
                    $point += ( time() - date($book->datelastcomment->format('Y-m-d H:i:s'))) / 1000000;
                }
                if($book->numberchapters == 0){
                    $point -= 10000;
                }
                if($book->isSuperliked()){
                    $point += 10000;
                    $tab['superliked'] = true;
                }else{
                    $tab['superliked'] = false;
                }
                $tab['id'] = $book->id;
                $tab['name'] = $book->name;
                $tab['slug'] = $book->slug;
                $tab['collection'] = $book->collections->name;
                $tab['collection_slug'] = $book->collections->slug;
                $tab['genre'] = $book->genres->name;
                $genre = Genre::findOrFail($book->genre_id);
                $tab['genre_parent'] = $genre->name;
                $tab['avatar'] = url($book->avatar);
                $tab['words'] = $book->words;
                $tab['views'] = $book->views;
                $tab['summary'] = $book->summarytruncated;
                $tab['author'] = $book->users->name;
                $tab['authorID'] = $book->users->id;
                $tab['parent'] = (!is_null($book->parent)) ?  'Ce texte est la suite de ' . $book->parent : null;
                $tab['point'] = $point;
                $tab['link'] = url($book->collections->slug.'/'.$book->slug);


                $tabs[] = $tab;
            }

            usort($tabs, create_function('$a, $b', '
            $a = $a["point"];
            $b = $b["point"];
    
            if ($a == $b)
            {
                return 0;
            }
    
            return ($a > $b) ? -1 : 1;
            '));


            $tabs = json_encode($tabs);
        }else{
            $tabs = [];
            $tabs = json_encode($tabs);
        }

        return view('collections.show', compact('collection', 'tabs'));
    }
}
