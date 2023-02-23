<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifAcess
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
              if(hasStatAccesto(Auth::id(),2))
              {

                return $next($request);
              }
                   return response()->json([
                    'code' => "Acces Interdire",], 500);

    }
}
