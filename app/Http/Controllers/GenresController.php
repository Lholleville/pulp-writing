<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Http\Requests\GenresRequest;
use Illuminate\Http\Request;

class GenresController extends Controller
{

    public $all_genres;

    public function __construct()
    {
        $this->all_genres = Genre::all();
        $this->middleware(['admin', 'auth']);
    }

    public function index()
    {
        $genres = $this->all_genres;
        return view('genres.index', compact('genres'));
    }

    public function create()
    {
        $all_genres = $this->all_genres->pluck('name', 'id');
        $genre = new Genre();
        return view('genres.create', compact('genre', 'all_genres'));
    }

    public function edit($slug)
    {
        $all_genres = $this->all_genres->pluck('name', 'id');
        $genre = Genre::where('slug', $slug)->first();
        return view('genres.edit', compact('genre', 'all_genres'));
    }

    /**
     * @param GenresRequest $request
     */
    public function store(GenresRequest $request)
    {
        Genre::create($request->only('name', 'slug', 'parent_id'));
        return redirect(action('GenresController@index'))->with('success', 'Nouveau genre enregistré');
    }

    /**
     * @param GenresRequest $request
     */
    public function update(GenresRequest $request, $slug)
    {
        $genres = Genre::where('slug', $slug)->first();
        $genres->update($request->all());
        return redirect(action('GenresController@index'))->with('success', 'Le genre a bien été modifié');
    }

    public function show($slug)
    {
        $genre = Genre::where('slug', $slug)->first();
        return view('genres.show', compact('genre'));
    }

    public function destroy($slug){
        $genre = Genre::where('slug', $slug)->first();
        $genre->delete();
        return redirect(action('GenresController@index'))->with('warning', 'Le genre a bien été supprimé');
    }
}
