<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->middleware('auth');
    }

    public function index()
    {

    }

    public function edit(){
        $user = $this->auth->user();
        return view('users.edit', compact('user'));
    }

    public function show($name){
        $user = User::where('name', $name)->get()->first();
        return view('users.show', compact('user'));
    }

    public function update(UsersRequest $request){
        $user = $this->auth->user();
        $user->update($request->all());
        return redirect(action('UsersController@edit', $user))->with('success', 'Les modifications effectuées ont bien été enregistrées.');
    }
}
