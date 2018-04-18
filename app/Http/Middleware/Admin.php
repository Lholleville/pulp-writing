<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Admin
{
    public function __construct(Guard $auth)
    {
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
        if($this->auth->user()->roles->name == "admin")
        {
            return $next($request);
        }
        else
        {
            return redirect('/')->with('danger', 'Vous ne pouvez pas accéder à ce contenu.');
        }

    }
}
