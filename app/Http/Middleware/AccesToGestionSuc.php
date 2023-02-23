<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AccesToGestionSuc
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
              if(hasStatAccesto(Auth::id(),3) || isAdminSuc(Auth::id()))
              {

                return $next($request);
              }
                   return response()->json([
                    'code' => "Acces Interdire",], 500);
    }
}
