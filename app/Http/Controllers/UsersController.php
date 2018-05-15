<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function deletealias(){
        $user = $this->auth->user();
        DB::table('users')->where('id', $user->id)->update(['alias' => null, 'alias_use' => 0]);
        return redirect(action('UsersController@edit', $user))->with('success', 'L\'Alias a bien été supprimé');
    }

    public function setalias(Request $request){
        $user = $this->auth->user();
        $user->update($request->all());
        $user->alias_conf = 1;
        $user->alias_use = 1;
        $user->save();
        return redirect()->back()->with('success', 'Alias défini avec succès.');
    }

    public function deleteavatar(){
        $user = $this->auth->user();
        if($user->avatar && $user->avatar != "/img/chapters/defaut.jpg"){
            unlink(public_path() . $user->avatar);
        }
        DB::table('users')->where('id', $user->id)->update(['avatar' => false]);

        return redirect(action('UsersController@edit', $user))->with('success', 'L\'Alias a bien été supprimé');
    }

    public function aliasignored(){
        $user = $this->auth->user();
        DB::table('users')->where('id', $user->id)->update(['alias_conf' => 1]);
        return redirect()->back();
    }
}
