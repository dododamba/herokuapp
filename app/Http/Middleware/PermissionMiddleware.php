<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Route;
use Request;
use Session;
class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $api="")
    {   
        $routeName = $request->route()->getName();
        if (empty($routeName) || Sentinel::hasAccess($routeName)) {
            return $next($request);
        }

        if (!empty($api)) {
            return route()->redirect('need-permission');
        } else {

            Session::flash('message', 'Warning! Not enough permissions. Please contact Us for more');
            Session::flash('status', 'warning');
         return redirect()->back();
       }
        

        
    }
}
