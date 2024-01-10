<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use App\Models\Hunter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Storage;


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

        if ($guild->id == null){
            redirect() -> route('guilds.index');
        }


        $members = $guild->hunters;
        
        return view('auth.guild', compact('guild', 'members'));
    }


    public function edit(Guild $guild){

        $members = $guild->hunters;

        return view('auth.guildEdit', compact('guild', 'members'));
    }

    public function update(Guild $guild){

        if (request()->has('img')) {
            $validateIMG = request()->validate(['img' => 'image']);
            $imgPath = request()->file('img')->store('imgProfile', 'public');
            $validateIMG = $imgPath;

            if ($guild->img != 'imgGuildProfile/defaultGuildProfile.jpg') {
                Storage::disk('public')->delete($guild->img);
            }
        } else {
            $validateIMG = $guild->img;
        }

        $guild->img = $validateIMG;
        $guild->name = request()->get('guildName');        
        $guild->info = request()->get('guildInfo') ? request()->get('guildInfo') : '';
        $guild->announcement = request()->get('announcement') ? request()->get('announcement') : '';      
        $guild->save();

        $members = $guild->hunters;

        return view('auth.guild', compact('guild', 'members'));
    }


    public function expulsar(Guild $guild, Hunter $member){

        $member->guild_id = null;
        $member->save();

        $members = $guild->hunters;

        return redirect()->route('guild.edit', $guild);
    }

    public function ascender(Guild $guild, Hunter $member){
        $guild->leader_id = $member->id;
        $guild->save();
        return redirect()->route('dashboard');
    }


    public function destroy(Guild $guild){


        Guild::where('id',$guild->id)->firstOrFail()->delete();

        return redirect()->route('dashboard');
    }

}
