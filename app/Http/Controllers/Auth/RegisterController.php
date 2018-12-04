<?php

namespace App\Http\Controllers\Auth;

use App\Regle;
use App\Reglelecture;
use App\User;
use App\Liste;
use App\Listelecture;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';
    private $mailer;

    /**
     * Create a new controller instance.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->middleware('guest')->except(['getConfirm']);
        $this->mailer = $mailer;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->setLists($user);

        $this->guard()->login($user);


        return $this->registered($request, $user)
            ?: redirect('/')->with('success', 'Votre compte a bien été créé. Pensez à le valider.');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $token = str_random(60);
        $user = User::create([
            'name' => $data['name'],
            'slug' => null,
            'email' => $data['email'],
            'confirmation_token' => $token,
            'password' => bcrypt($data['password']),
            'role_id' => 1
        ]);
        $this->mailer->send(['text' => 'emails.register'], compact('token', 'user'), function($message) use ($user){
            $message->to($user->email)->subject('Confirmation de votre compte');
        });
        return $user;
    }

    protected function setLists($user){
        $list = new Liste();
        $listlecture = new Listelecture();
        $rule = new Regle();

        $list->create(
            [
                'name' => Liste::BLACKLIST_NAME,
                'description' => Liste::BLACKLIST_DESCRIPTION,
                'type' => Liste::BLACKLIST_ID,
                'user_id' => $user->id,
            ]);

        $list = Liste::orderBy('id', 'DESC')->first();

        $rule->create([
            'liste_id' => $list->id
        ]);
        $rule = Regle::orderBy('id', 'DESC')->first();



        $list->create(
            [
                'name' => Liste::SUBSCRIBERS_NAME,
                'description' => Liste::SUBSCRIBERS_DESCRIPTION,
                'type' => Liste::SUBSCRIBERS_ID,
                'user_id' => $user->id,
            ]);

        $list = Liste::orderBy('id', 'DESC')->first();

        $rule->create([
            'liste_id' => $list->id
        ]);
        $rule = Regle::orderBy('id', 'DESC')->first();




        $list->create(
            [
                'name' => Liste::ABONNEMENTS_NAME,
                'description' => Liste::ABONNEMENTS_DESCRIPTION,
                'type' => Liste::ABONNEMENTS_ID,
                'user_id' => $user->id,
            ]);
        $list = Liste::orderBy('id', 'DESC')->first();

        $rule->create([
            'liste_id' => $list->id
        ]);
        $rule = Regle::orderBy('id', 'DESC')->first();




        $listlecture->create(
            [
                'name' => Listelecture::LECTURE_NAME,
                'description' => Listelecture::LECTURE_DESCRIPTION,
                'type' => Listelecture::LECTURE_ID,
                'user_id' => $user->id,
            ]);
        $listlecture = Listelecture::orderBy('id', 'DESC')->first();

        $rule->create([
            'liste_id' => $listlecture->id
        ]);
        $rule = Reglelecture::orderBy('id', 'DESC')->first();


    }

    public function getConfirm(Request $request, $user_id, $token){
        $user = User::findOrFail($user_id);
        if($user->confirmation_token == $token && $user->confirmed == false){
            $user->confirmation_token = null;
            $user->confirmed = true;
            $user->save();
        }else{
            return abort(500);
        }
        $this->guard()->login($user);
        return redirect('/')->with('success', 'Votre compte a bien été confirmé');
    }

}
