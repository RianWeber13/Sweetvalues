<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorPending
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return redirect()->route('ingredients.index');
        }

        if (! $request->session()->has('auth.2fa_pending_user_id')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
