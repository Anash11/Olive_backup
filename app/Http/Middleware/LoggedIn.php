<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoggedIn
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
        if(Session()->has('loginId') && (url('login') == $request->url()))
        {
            return back();
        }
        // elseif(Session()->has('NormalAdminId') && (url('editAdmin') == $request->url()  || url('addadmin') == $request->url() || url('deleteAdmin') == $request->url()))
        // {
        //     return back();
        // }
        return $next($request);
    }
}
