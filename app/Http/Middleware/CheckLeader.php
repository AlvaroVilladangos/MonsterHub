<?php

namespace App\Http\Middleware;

use App\Models\Guild;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLeader
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
        
        $guildData = $request->route('guild');
        $guildId = json_decode($guildData)->id;

        $guild = Guild::where( 'id', $guildId)->first();
    
        if ($guild === null) {
            return redirect()->route('guilds.index');
        }
    
        if ($guild->leader_id != $hunter->id) {
            return redirect()->route('guild.show', compact('guild'));
        }
        return $next($request);
    }
}
