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
    
        return view('auth.guilds', compact('guilds'));
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

    public function show(Guild $guild){

        $leader = $guild->leader;
        
        $members = $guild->hunters;
        
        return view('auth.guild', compact('guild', 'leader', 'members'));
    }


    public function edit(Guild $guild){

        $members = $guild->hunters;

        return view('auth.guildEdit', compact('guild', 'members'));
    }
}
