<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$allowedTypes
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$allowedTypes)
    {
        $user = Auth::user();

        if (!$user || !in_array($user->type_id, $allowedTypes)) {
            
            return redirect('/home/access-denied');
        }

        return $next($request);
    }
}
