<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsValid
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        if (is_impersonating()) {
            return $response;
        }

        $user = getLogInUser();
        if (Auth::check() && (! $user->is_active || ! $user->hasVerifiedEmail())) {
            $isActive = $user->is_active;
            Auth::logout();

            return redirect(route('login'))->withErrors(! $isActive ? 'Your account is not active. Please contact to administrator.' : 'Your account is not verified.');
        }

        return $response;
    }
}
