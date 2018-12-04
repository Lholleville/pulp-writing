<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Mailconfirm
{

    public $auth;

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->auth->guest()){
            return redirect("/");
        }
        if($this->auth->user()->confirmed == true){
            return redirect("/");
        }
        return $next($request);
    }
}
