<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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

        if (!$request->user()->hasRole('admin')){
//            Session::flash('message_danger', 'No tiene privilegios suficientes !!');
            abort(403);
            return redirect()->route('events.index');
        }


        return $next($request);
    }
}
