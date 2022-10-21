<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

class Permission
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
        $permission = Route::currentRouteName();
        
        $user = Sentinel::getUser();
        if (!$user->hasAccess($permission)){
            Session::flash('message', 'You Does not have Permission');
            Session::flash('alert-class','alert-danger');
            return back();
        }
        return $next($request);
    }
}
