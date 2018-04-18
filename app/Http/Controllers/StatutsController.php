<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenresRequest;
use App\Statut;
use Illuminate\Http\Request;

class StatutsController extends Controller
{
    public function __construct(){
        $this->middleware(['admin', 'auth']);
    }

    public function index()
    {
        $statuts = Statut::all();
        return view('statuts.index', compact('statuts'));
    }

    public function show($slug)
    {
        $statut = Statut::where('slug', $slug)->first();
        return view('statuts.show', compact('statut'));
    }

    public function edit($slug)
    {
        $statut = Statut::where('slug', $slug)->first();
        return view('statuts.edit', compact('statut'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $statut = new Statut();
        return view('statuts.create', compact('statut'));
    }

    public function update(GenresRequest $request, $slug)
    {
        $statut = Statut::where('slug', $slug)->first();
        $statut->update($request->all());
        return redirect(action('StatutsController@index'))->with('success', 'Le statut a bien été modifié');

    }

    public function store(GenresRequest $request)
    {
        Statut::create($request->all());
        return redirect(action('StatutsController@index'))->with('success', 'Nouveau statut enregistré');

    }

    public function destroy($slug)
    {
        $statut = Statut::where('slug', $slug)->first();
        $statut->delete();
        return redirect(action('StatutsController@index'))->with('warning', 'Statut supprimé');
    }
}
