<?php namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\SignalsRequest;
use App\Motifsignal;
use App\Signal;
use App\User;
use Illuminate\Support\Facades\Auth;

class SignalsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => ['store', 'show', 'approved', 'ignored', 'abused']]);
        $this->middleware('modo', ['only' => ['approved', 'ignored', 'abused']]);
    }

    public function getResourceModo($id){
        $signal = Signal::where('id',$id)->first();
        $comment = $signal->comments;
        return $comment;
    }



    public function index()
    {
        $signals = Signal::where('validated','0')->orderBy('approved', 'desc')->get();
        return view('signal.index', compact('signals'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SignalsRequest $request
     * @return Response
     */
    public function store(SignalsRequest $request)
    {

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['approved'] = 0;
        $verif = Signal::where('comment_id', $data['comment_id'])->limit(1)->get();
        if(!$verif->isEmpty()){
            $item = $verif->last();
            if($data['user_id'] != $item->user_id){
                $item->approved += 1;
                $item->save();
                return redirect()->back()->with('success', 'Quelqu\'un a déjà émis une plainte, vous avez boosté la plainte.');
            }else{
                return redirect()->back()->with('success', 'Vous avez déjà émis une plainte à ce sujet.');
            }
        }else{
            Signal::create($data);
            return redirect()->back()->with('success', 'Votre plainte a été enregistrée');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $comment
     * @return Response
     * @internal param int $id
     */
    public function show($id)
    {
        $comment = Comment::findOrFail($id);
        $motif = Motifsignal::where('parent_group', 0)->get();
        return view('signal.show', compact('comment', 'motif'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function approved($comment){
        $signal = Signal::where('comment_id', $comment->id)->first();
        $signal->validated = 1;
        $guilt = User::findOrFail($signal->guilt_id);
        $type = Motifsignal::findOrFail($signal->type);
        $comment = Comment::findOrFail($signal->comment_id);
        $comment->signal = 1;
        $guilt->karma  -= (5 * $type->importance);
        $signal->save();
        $guilt->save();
        $comment->save();
        return redirect()->back()->with('success', 'Utilisateur sanctionné.');
    }

    public function ignored($comment){
        $signal = Signal::where('comment_id', $comment->id)->first();
        $signal->validated = 2;
        $signal->save();
        return redirect()->back()->with('success', 'Plainte ignorée.');
    }

    public function abused($comment){
        $signal = Signal::where('comment_id', $comment->id)->first();
        $moaner = User::findOrFail($signal->user_id);
        $type = Motifsignal::findOrFail($signal->type);
        $signal->validated = 3;
        $moaner->karma  -= (5 * $type->importance);
        $moaner->save();
        $signal->save();
        return redirect()->back()->with('success', 'Plaignant sanctionné.');
    }

}
