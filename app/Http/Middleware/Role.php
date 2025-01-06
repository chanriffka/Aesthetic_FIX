<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $raw;

        if ($role == "ADMIN") {
            $raw = 3;
        } else if ($role == "ARTIST") {
            $raw = 2;
        } else {
            $raw = 1;
        }

        if (Auth::guard('MasterUser')->user()->USER_LEVEL == $raw) {
            return $next($request);
        }
        return redirect()->back();
    }
}
