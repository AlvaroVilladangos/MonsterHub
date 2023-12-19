<?php

namespace App\Http\Controllers;

use App\Models\Armor;
use App\Models\Weapon;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    public function datos()
    {

        $data = $this->getHunterData();

        return view('auth.hunterDashboard', $data);
    }


    public function edit()
    {

        $data = $this->getHunterData();
        $weapons = Weapon::all();
        $armors = Armor::all();
    
        return view('auth.hunterEdit', array_merge($data, compact('weapons', 'armors')));
    }


    public function update(){

        $hunter = auth()->user()->hunter;

        $hunter->name = request()->get('hunterName','');
        
        $bio = request()->get('bio');
        $hunter->bio = $bio !== null ? $bio : ' ';
        
        $hunter->weapon_id = request()->get('weapon','');
        $hunter->armor_id = request()->get('armor','');

        $hunter->save();


        $data = $this->getHunterData();



        return redirect()->route('dashboard');
    }


    public function destroyComment($id){
        $comment = Comment::where('id',$id)->firstOrFail()->delete();
    
        $data = $this->getHunterData();
    
        $data = $this->getHunterData();
        $weapons = Weapon::all();
        $armors = Armor::all();
    
        return redirect()->route('edit');
    }
}
