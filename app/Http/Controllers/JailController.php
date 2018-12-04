<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;

class JailController extends Controller
{
    public $mailer;

    public function __construct(Mailer $mailer){
        $this->mailer = $mailer;
    }

    public function redirect(){
        return view('banni');
    }

    public function earlyaccess(){
        return view('keymode');
    }

    public function nonconfirmed(){
        return view('nonconfirmed');
    }

    public function confirmationmail(Guard $auth){
        $token = str_random(60);
        $user = $auth->user();
        $user->update(['confirmation_token' => $token]);
        $user->save();
        $this->mailer->send(['text' => 'emails.register'], compact('token', 'user'), function($message) use ($user){
            $message->to($user->email)->subject('Confirmation de votre compte');
        });
        return redirect("mailconfirmsent");
    }

    public function mailconfirmsent(){
        return view('mailconfirmsent');
    }
}
