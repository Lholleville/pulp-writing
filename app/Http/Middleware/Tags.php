<?php

namespace App\Http\Middleware;

use Closure;
use ReflectionMethod;

class Tags
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $controller_name = explode('@', $request->route()->getAction()['uses'])[0];
        $controller = app($controller_name);
        $reflectionMethod = new ReflectionMethod($controller_name, 'getResource');
        $resource = $reflectionMethod->invokeArgs($controller, $request->route()->parameters());
        //$resource = $resource->first();
        if($resource->online != true){
            if($request->ajax())
            {
                return response('Unauthorized.', 401);
            }
            else
            {
                return redirect('/')->with('error', 'Ce tag n\'est plus consultable');
            }
        }
        $request->route()->setParameter($request->route()->parameterNames()[0], $resource);
        return $next($request);
    }
}
