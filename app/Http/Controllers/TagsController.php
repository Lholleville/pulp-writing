<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagsRequest;
use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['show', 'create', 'store']]);
    }

    public function getResource($slug){
        return Tag::where('slug', $slug)->first();
    }

    public function index(){

    }

    public function show($slug){

    }

    public function edit($slug){

    }

    public function create($slug){

    }

    public function update(TagsRequest $request, $slug){

    }

    public function store(TagsRequest $request){

    }

    public function destroy($slug){

    }
}
