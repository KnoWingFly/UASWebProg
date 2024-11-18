<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth; 

class CheckApproval
{
    public function handle(Request $request, Closure $next)
    {

        if (Auth::check() && !Auth::user()->is_approved) {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Your account is not approved yet.');
        }

        return $next($request); 
    }
}
