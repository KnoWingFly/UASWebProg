<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in and not approved
        if (Auth::check() && !Auth::user()->is_approved) {
            Auth::logout(); // Log out unapproved user
            return redirect()->route('not-approved');
        }

        return $next($request);
    }
}
