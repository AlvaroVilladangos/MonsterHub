<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Models\Weapon;
use App\Models\Armor;
use Illuminate\Http\Request;

class monsterController extends Controller
{
    public function getMonsters()
    {
        $monsters = Monster::paginate(5);
    
        return view( 'monstersTable', compact('monsters') );
    }


    public function show(Monster $monster){

        $weapon = Weapon:: where('monster_id', $monster->id)->first();
        $armor = Armor:: where('monster_id', $monster->id)->first();
        return view('monster', compact('monster', 'armor', 'weapon'));
    }
}
