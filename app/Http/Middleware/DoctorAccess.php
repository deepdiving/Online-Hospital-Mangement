<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Session;
class DoctorAccess
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
        if(Sentinel::getUser()->inRole('doctor') || Sentinel::getUser()->inRole('diagnostic') || Sentinel::getUser()->inRole('admin')){
            return $next($request);
        }
        Session::flash('success', 'Sorry You Are Not Authorized!');
        flash('Sorry You Are Not Authorized!')->error();
        return redirect('dashboard');
    }
}
