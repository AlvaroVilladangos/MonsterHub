<?php

namespace App\Http\Controllers;

use App\Models\Armor;
use App\Models\Weapon;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function datos(){

        $hunter = auth()->user()->hunter;

        $weaponId = $hunter->weapon_id;
        $armorId = $hunter->armor_id;
        
        $hunterId = $hunter->id;

/*         $comments = DB::table('comments')->where('to_id', $hunterId)->get();
 */
        $comments = $hunter->comments()->with('hunter')->get();;
        
        $weapon = Weapon::find($weaponId);
        $armor = Armor::find($armorId);
        

        return view('auth.hunterDashboard', compact('weapon', 'armor', 'comments'));

    }
}
