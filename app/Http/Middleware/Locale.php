<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Config;
use Session;

class Locale
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
        $locale_segment = $request->segment(1);
        $raw_locale = session('locale');
        $locale = $raw_locale ? $raw_locale : config('app.locale');

        if($locale_segment==config('lia.route.prefix') || $locale_segment=='_debugbar') {
            App::setLocale(config('app.locale'));
            return $next($request);
        }
        if (!in_array($locale_segment, Config::get('app.locales'))) {
            $segments = implode('/' ,array_merge([$locale], $request->segments())).(count($request->all()) ? '?'.http_build_query($request->all()) : '');
            $segments = str_replace('index.php/', '', $segments);
            return redirect($segments);
        }
        if(session('locale')!=$locale_segment) session(['locale' => $locale_segment]);

        App::setLocale($locale_segment);
        return $next($request);
    }
}
