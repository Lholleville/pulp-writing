<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Http\Requests\NotesRequest;
use App\Note;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotesController extends Controller
{

    public function index()
    {
        //$this->middleware('auth');
    }

    function create()
    {
        //
    }

    public function store(NotesRequest $request, Guard $auth)
    {
        $data= $request->all();
        $data['user_id'] = $auth->user()->id;
        $chapter = Chapter::where('slug', $data['chapter_id'])->first();
        $data['chapter_id'] = $chapter->id;
        $txt = $chapter->content;


        $data['selected'] = str_replace(['«','»','’', '—'],['&laquo;', '&raquo;', '&rsquo;', '&mdash;'], $data['selected']);
        $needle = $data['selected'];

        $txt = explode('<p>',$txt);
        $txt = implode($txt);

        $txt = explode('</p>', $txt);
        $txt = implode($txt);

        $txt = explode('&nbsp;', $txt);
        $txt = implode($txt);

        $pos = mb_strrpos($txt, $needle);

        if(!$chapter->notes->isEmpty()){
            foreach($chapter->notes  as $note){
                if($note->start == $pos){
                    $pos = strpos($txt, $needle, $note->end);
                }
            }
        }



        $data['start'] = $pos;
        $data['end'] = $data['start'] + mb_strlen($data['selected']);

        Note::create($data);

        return back();
    }

    public function show()
    {
        //
    }

    public function edit()
    {
        //
    }

    public function update()
    {
        //
    }

    public function destroy()
    {
        //
    }
}
