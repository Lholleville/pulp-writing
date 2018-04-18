<?php

namespace App\Http\Middleware;

use Closure;
use ReflectionMethod;

class Owner2
{
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        $controller_name = explode('@', $request->route()->getAction()['uses'])[0];
        dd($controller_name);
        $controller = app($controller_name);
        $reflectionMethod = new ReflectionMethod($controller_name, 'getResource');
        $resource = $reflectionMethod->invokeArgs($controller, $request->route()->parameters());
        //$resource = $resource->first();
        if($resource->user_id != $this->auth->user()->id){
            if($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                return redirect('/')->with('error', 'Vous ne pouvez pas éditer ce contenu');
            }
        }
        $request->route()->setParameter($request->route()->parameterNames()[0], $resource);
        return $next($request);
    }
}
