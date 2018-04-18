<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\MotifsignalsRequest;
use App\Http\Requests\MotifsRequest;
use App\Motifsignal;
use Illuminate\Http\Request;

class MotifsignalsController extends Controller {

    public function __construct(){
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $motifs = Motifsignal::get();
        return view('admin.motifsignals.index', compact('motifs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $motif = new Motifsignal();
        $motif_categorie = Motifsignal::where('parent_group', 0)->pluck('name','id');
        $motif_categorie[0] = '/';
        return view('admin.motifsignals.create', compact('motif', 'motif_categorie'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MotifsRequest $request
     * @return Response
     */
    public function store(MotifsignalsRequest $request)
    {
        Motifsignal::create($request->only('name', 'description', 'parent_group', 'slug'));
        return redirect(action('MotifsignalsController@index'))->with('success', 'Nouveau motif enregistré');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $motif = Motifsignal::where('slug', $id)->first();
        $motif_categorie = Motifsignal::where('parent_group', 0)->pluck('name','id');
        $motif_categorie[0] = '/';
        return view('admin.motifsignals.edit', compact('motif', 'motif_categorie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param ModifsRequest $request
     * @return Response
     */
    public function update($id, MotifsignalsRequest $request)
    {
        $data = $request->all();
        if($request->parameters['parent_group']){
            $data['parent_group'] = 0;
        }
        $motif = Motifsignal::where('slug', $id)->first();
        $motif->update($data);
        return redirect(action('MotifsignalsController@index'))->with('success', 'Le motif a bien été modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $motif = Motifsignal::where('slug',$id)->first();
        $motif->delete();
        return redirect(action('MotifsignalsController@index'))->with('success', 'Le motif a bien été supprimé');
    }

}
