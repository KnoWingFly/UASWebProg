<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckApproval
{
    public function handle(Request $request, Closure $next)
    {
        // Redirect jika user belum disetujui
        if (Auth::check() && !Auth::user()->is_approved) {
            return redirect()->route('approval.notice');
        }

        return $next($request);
    }
}
