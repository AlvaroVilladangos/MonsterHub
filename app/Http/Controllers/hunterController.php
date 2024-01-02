<?php

namespace App\Http\Controllers;

use App\Models\Armor;
use App\Models\Weapon;
use App\Models\Comment;
use App\Models\Hunter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class hunterController extends Controller
{
    /*     public function weaponName(){
        $weaponId = auth()->user()->hunter->weapon_id;

        $weapon = Weapon::find($weaponId);

        return view('auth.hunter', compact('weapon'));
    }


    public function armorName(){
        $armorId = auth()->user()->hunter->armor_id;

        $armor = Armor::find($armorId);

        return view('auth.hunter', compact('armor'));
    }

 */

 public function getHunterData()
{
    $hunter = auth()->user()->hunter;

    $comments = $hunter->comments()->with('hunter')->get();

    $weapon = Weapon::find($hunter->weapon_id);
    $armor = Armor::find($hunter->armor_id);

    return compact('weapon', 'armor', 'comments');
}

    public function dashboard()
    {

        $datos = $this->getHunterData();

        $hunter = Auth::user()->hunter;

        $comments = $hunter->comments()->with('hunter')->get();
        return view('auth.hunterDashboard', compact('hunter', 'datos', 'comments'));
    }



    public function show(Hunter $hunter){

        $datos = $this->getHunterData();
        $comments = $hunter->comments()->with('hunter')->paginate(5);
        return view('auth.hunter', compact('hunter', 'comments', 'datos'));
    }


    public function index(){

        $hunters = hunter::query();

        if (request()->has('search')){
            $search = strtolower(request()->get('search', ''));
            $hunters = $hunters->whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
    
        $hunters = $hunters->paginate(5);
    
        return view('auth.hunters', compact('hunters'));
    }

    public function edit()
    {

        $datos = $this->getHunterData();
        $weapons = Weapon::all();
        $armors = Armor::all();
    
        return view('auth.hunterEdit', array_merge($datos, compact('weapons', 'armors')));
    }


    public function update(){

        $hunter = auth()->user()->hunter;
    
        if (request()->has('img')){
            $validateIMG = request()->validate(['img' => 'image']);
            $imgPath = request()->file('img')->store('imgProfile', 'public');
            $validateIMG = $imgPath;
    
            if ($hunter->img != 'imgProfile/defaultProfile.webp'){
                Storage::disk('public')->delete($hunter->img);
            }
        } else {
            $validateIMG = $hunter->img;
        }
    
        $hunter->name = request()->get('hunterName','');
        
        $bio = request()->get('bio');
        $hunter->bio = $bio !== null ? $bio : ' ';
        $hunter->img = $validateIMG;
        $hunter->weapon_id = request()->get('weapon','');
        $hunter->armor_id = request()->get('armor','');
    
        $hunter->save();
    
        $datos = $this->getHunterData();
    
        return redirect()->route('dashboard');
    }
    

    public function destroyComment($id){
        $comment = Comment::where('id',$id)->firstOrFail()->delete();
    
        $datos = $this->getHunterData();
    
        $datos = $this->getHunterData();
        $weapons = Weapon::all();
        $armors = Armor::all();
    
        return redirect()->route('edit');
    }


    public function leaveGuild(){

        $hunter = Auth::user()->hunter;

        $hunter->guild_id = null;

        $hunter->save();

        return redirect()->route('dashboard');
    }

    public function comment(){

        $msg = request() -> get('commentMsg');

        $from = Auth::user()->hunter->id;

        $to = request()->get('hunter_id');   

        $comment = new Comment;

        $comment->from_id = $from;

        $comment->to_id = $to;

        $comment->msg = $msg;

        $comment->save();

        return redirect()->route('hunter.show', ['hunter' => $to]);

    }
}
