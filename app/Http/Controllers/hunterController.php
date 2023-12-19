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

    public function datos()
    {

        $hunter = auth()->user()->hunter;

        $comments = $hunter->comments()->with('hunter')->get();;

        $weapon = Weapon::find($hunter->weapon_id);
        $armor = Armor::find($hunter->armor_id);


        return view('auth.hunterDashboard', compact('weapon', 'armor', 'comments'));
    }


    public function edit()
    {

        $hunter = auth()->user()->hunter;

        $weapons = Weapon::all();
        $armors = Armor::all();

        return view('auth.hunterEdit', compact('weapons', 'armors'));
    }


    public function update(){

        $hunter = auth()->user()->hunter;

        $hunter->name = request()->get('hunterName','');
        
        $hunter->bio = request()->get('bio','');


        $hunter->weapon_id = request()->get('weapon','');
        $hunter->armor_id = request()->get('armor','');


        $comments = $hunter->comments()->with('hunter')->get();;

        $weapon = Weapon::find($hunter->weapon_id);
        $armor = Armor::find($hunter->armor_id);


        return view('auth.hunterDashboard', compact('weapon', 'armor', 'comments'));
    }
}
