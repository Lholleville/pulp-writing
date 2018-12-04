<?php

namespace App\Http\Middleware;

use App\Configuration;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class Key
{
    public $auth;

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
        $config = Configuration::where('active', true)->first();

        if($config->keymode_enabled){
            if($this->auth->guest()){
                return redirect('/earlyaccess');
            }

            if($this->auth->user() != null && $this->auth->user()->accesskey != null){
                return $next($request);
            }else{
                return redirect('/earlyaccess');
            }
        }else{
            return $next($request);
        }
    }
}
