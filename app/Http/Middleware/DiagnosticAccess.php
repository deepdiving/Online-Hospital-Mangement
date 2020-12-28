<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Session;
class DiagnosticAccess
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
        if(Sentinel::getUser()->inRole('diagnostic') || Sentinel::getUser()->inRole('admin') || Sentinel::getUser()->inRole('receptionist') || Sentinel::getUser()->inRole('manager')){
            return $next($request);
        }
        Session::flash('success', 'Sorry You Are Not Authorized!');
        flash('Sorry You Are Not Authorized!')->error();
        return redirect('dashboard');
    }
}
