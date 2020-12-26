<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class CheckAuthorized
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
        if (!Sentinel::check()) {
            flash('Sorry You Are Not Authorized!')->error();
            return redirect('login');
        }
        $timezone = (session()->has('settings')) ? session()->get('settings')[0]['timezone'] : 'UTC';
        config(['app.timezone' => $timezone]);
        date_default_timezone_set($timezone);

        if(\Session::has('locale')){
            \App::setLocale(\Session::get('locale'));
        }
        return $next($request);
    }
}
