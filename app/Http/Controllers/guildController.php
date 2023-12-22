<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\Hunter;
use Illuminate\Http\Request;

class guildController extends Controller
{
    public function index()
    {
        $guilds = Guild::query();


        $guilds = Guild::query();

        if (request()->has('search')){
            $search = strtolower(request()->get('search', ''));
            $guilds = $guilds->whereRaw('lower(name) like (?)',["%{$search}%"]);
        }

        $guilds = $guilds->paginate(5);
    
        return view('auth.guild', compact('guilds'));
    }



    public function store(){

        $guild = new Guild();

        $guild->leader_id = request()->get('leader_id');
        $guild->name = request()->get('name');        
        $guild->info = request()->get('info');        
        $guild->save();


        $hunter = Hunter::find(request()->get('leader_id'));

        $hunter->guild_id = $guild->id;
        $hunter->save();
        return redirect()-> route('guilds.index');
    }
}
