<?php

namespace App\Http\Middleware;

use Closure;

class InstallMiddleware
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
        if( !config('setup') ){
            return redirect('/install');
        }
        return $next($request);
    }
}
