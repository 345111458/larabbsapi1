<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Cache;


class ChangeLocale
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
        if ($request->header('accept-language')){
            $language = $request->header('accept-language');
            Cache::put('language'.$request->getClientIp() , $language);
            \App::setLocale($language);
        }else{
            \App::setLocale(Cache::get('language'.$request->getClientIp()));
        }
        $response = $next($request);
        return $response;
    }
}
