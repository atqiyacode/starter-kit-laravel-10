<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiMultiLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $local = ($request->hasHeader('x-language')) ? $request->header('x-language') : config('app.locale');
        app()->setLocale($local);
        return $next($request);
    }
}
