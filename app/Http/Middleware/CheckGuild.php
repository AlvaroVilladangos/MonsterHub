<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckGuild
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();
        $hunter = $user->hunter;

        if ($hunter->guild_id != null) {
           
            $guild = $hunter->guild_id;
            return redirect()->route('guild.show', compact('guild'));
        }

        return $next($request);
    }
}
