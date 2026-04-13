<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isOperator()) {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman operator!');
        }

        if (Auth::user()->status === 'nonaktif') {
            Auth::guard('web')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun operator Anda sedang dinonaktifkan.',
            ]);
        }

        return $next($request);
    }
}
