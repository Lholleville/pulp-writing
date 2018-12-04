<?php

namespace App\Http\Controllers;

use App\Configuration;
use App\Key;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ConfigurationsController extends Controller
{

    protected $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->mailer = $mailer;

    }

    public function index(){
        $config = Configuration::all();
        return view('admin.config.index', compact('config'));
    }

    public function indexkeys(){
        $config = Configuration::where('active', true)->first();
        $keys = Key::all();
        $users = User::where('accesskey', null)->get();

        return view('admin.config.keys', compact('config', 'keys', 'users'));
    }

    public function attributeKeys(Request $request){
        $data = $request->all();
        $user = User::where('id', $data["user_id"])->first();
        $key = Key::findOrFail($data["key_id"]);
        $key->update(['user_id' => $data["user_id"], 'used' => true]);
        $user->update(['accesskey' => $key->key]);
        $user->save();
        $key->save();
        $this->mailer->send(['text' => 'emails.accesskey'], compact('token', 'user', 'key'), function($message) use ($user){
            $message->to($user->email)->subject('Confirmation de votre compte');
        });
        return redirect()->back()->with('success', 'Clef bien assignée à l\'utilisateur.');
    }

    public function generateKeys($number){
        $keys = [];
        for($j = 0; $j < $number; $j++){
            $key = '';

            list($usec, $sec) = explode(' ', microtime());
            mt_srand((float) $sec + ((float) $usec * 100000));

            $inputs = array_merge(range('z','a'),range(0,9),range('A','Z'));

            for($i=0; $i < 20; $i++)
            {
                $key .= $inputs{mt_rand(0,61)};
            }
            $key = Key::create(['key' => $key, '']);
            $keys[] = $key;
        }

        return json_encode($keys);
    }

    public function deletekey($id){
        $key = Key::findOrFail($id);
        $delete = $key->key;
        $user = User::where('accesskey', $delete)->first();
        $user->accesskey = null;
        $user->save();
        $key->delete();
        return redirect()->back()->with('warning', 'La clef a bien été supprimée pour '.$user->name.'.');
    }

    public function update(Request $request, $id){
        $config = Configuration::findOrFail($id);
        if($config->keymode_enabled == 0){
            $config->update(['keymode_enabled' => true]);
        }else{
            $config->update(['keymode_enabled' => false]);
        }
        $config->save();
    }

    public function show($id){
        $config = Configuration::findOrFail($id);
        return view('admin.config.show', compact('config'));
    }
}
