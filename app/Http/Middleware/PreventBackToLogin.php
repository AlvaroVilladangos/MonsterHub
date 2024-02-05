<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventBackToLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       if ($request->is(['login', 'register']) && auth()->check()) {
            if (auth()->user()->admin) {
                return redirect('/indexAdmin');
            }
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
