<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\UsersRequest;
use App\Liste;
use App\Listelecture;
use App\Role;
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
        $this->middleware('admin', ['only' => ['index']]);
    }

    public function index()
    {
        $users = User::All();
        if(!$users->isEmpty()){
            foreach($users as $user){
                $tab['id'] = $user->id;
                $tab['name'] = $user->name;
                $tab['slug'] = $user->slug;
                $tab['email'] = $user->email;
                $tab['avatar'] = url($user->avatar);
                $tab['birthday'] = $user->birthday;
                $tab['age'] = $user->age;
                $tab['country'] = $user->country;
                $tab['karma'] = $user->karma;
                $tab['alias'] = $user->alias;
                $tab['role'] = $user->roles->name;
                $tab['role_color'] = $user->roles->color;
                $tab['action'] = "users/".$user->slug."/update";
                $tab['link'] = url("/profil/".$user->slug);
                $tabs[] = $tab;
            }
        }else{
            $tabs = [];
        }
        $roles = Role::all();
        foreach($roles as $role){
            $tab1['id'] = $role->id;
            $tab1['name'] = $role->name;
            $tab1['color'] = $role->color;
            $tab1['description'] = $role->description;
            $tabs1[] = $tab1;
        }
        $tabs = json_encode($tabs);
        $tabs1 = json_encode($tabs1);
        $users = $tabs;
        $roles = $tabs1;
        return view('users.index', compact('users', 'roles'));
    }


    public function edit(){
        $user = $this->auth->user();
        return view('users.edit', compact('user'));
    }

    public function show($slug){
        $user = User::where('slug', $slug)->get()->first();
        $users = User::where('id', '!=', $this->auth->user()->id);
        $books = Book::where('online', true)->get();
        $listcontact = new Liste();
        $newlistlecture = new Listelecture();
        return view('users.show', compact('user', 'users', 'books', 'listcontact', 'newlistlecture'));
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

    public function updateadmin(Request $request, $slug){
        $user = User::where('slug', $slug)->first();
        $this->validate($request, [
            'karma'   =>  "numeric|max:20",
            'role' =>  array('Regex:/admin|modo|user/')
        ]);
        $user->update($request->all());
        return redirect()->back()->with('success', 'Informations de l\'utilisateur modifiées');

    }
}
