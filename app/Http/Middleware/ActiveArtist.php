<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ActiveArtist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('MasterUser')->user();
        // dd($user->Artist);
        if($user->Artist == null) {
            return redirect()->back()->withErrors([
                'message' => 'Your are not registered as Artist',
            ]);
        }
        if($user->Artist->IS_ACTIVE == 0) {
            return redirect()->back()->withErrors([
                'message' => 'Your Artist account is inactive, please contact admin to reactivate your account',
            ]);
        }
        return $next($request);
    }
}
