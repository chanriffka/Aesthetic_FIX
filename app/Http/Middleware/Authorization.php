<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $login): Response
    {
        if ($login == "true") {
            if(Auth::check()) {
                return $next($request);
            }
            return redirect('/login')->withErrors([
                'message' => 'Your have to login before go to the website page',
            ]);
        } else {
            if(!Auth::check()) {
                return $next($request);
            }
            return redirect('/landing')->withErrors([
                'message' => 'You are loged in, no need to login again',
            ]);
        }
    }
}
