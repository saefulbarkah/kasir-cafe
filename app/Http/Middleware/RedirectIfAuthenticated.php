<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (auth()->user()->roles->pluck('name')->implode(' ', '') == "kasir") {
                $getRole = auth()->user()->roles->pluck('name')->implode(' ', '');
                return redirect($getRole . '/pesanan');
            }
            $getRole = auth()->user()->roles->pluck('name')->implode(' ', '');
            return redirect($getRole . '/dashboard');
        }

        return $next($request);
    }
}
