<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenresRequest;
use App\Motif;
use Illuminate\Http\Request;

class MotifsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin', 'auth']);
    }

    public function index()
    {
        $motifs = Motif::all();
        return view('motifs.index', compact('motifs'));
    }

    public function show($slug)
    {
        $motif = Motif::where('slug', $slug)->first();
        return view('motifs.show', compact('motif'));
    }

    public function create(){
        $motif = new Motif();
        return view('motifs.create', compact('motif'));
    }

    public function edit($slug){
        $motif = Motif::where('slug', $slug)->first();
        return view('motifs.edit', compact('motif'));
    }

    public function store(GenresRequest $request){
        Motif::create($request->all());
        return redirect(action('MotifsController@index'))->with('success', 'Motif crée avec succès');
    }

    public function update(GenresRequest $request, $slug){
        $motif = Motif::where('slug', $slug)->first();
        $motif->update($request->all());
        return redirect(action('MotifsController@index'))->with('warning', 'Motif modifié');
    }

    public function destroy($slug){
        $motif = Motif::where('slug', $slug)->first();
        $motif->delete();
        return redirect(action('MotifsController@index'))->with('success', 'Motif supprimé');

    }
}
