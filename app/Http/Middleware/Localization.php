<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $default = config('app.name');
        $accept_language = $request->header('accept-language');
        if ($accept_language) {
            list($default) = explode(',', $accept_language);
        }

        $lang = $request->route('lang', $default);

        App::setLocale($lang);

        URL::defaults([
            'lang' => $lang,
        ]);
        Route::current()->forgetParameter('lang');

        return $next($request);
    }
}
