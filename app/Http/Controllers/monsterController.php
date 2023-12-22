<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Models\Weapon;
use App\Models\Armor;
use Illuminate\Http\Request;

class monsterController extends Controller
{
    public function index()
    {

        $monsters = Monster::query();

        if (request()->has('search')){
            $search = strtolower(request()->get('search', ''));
            $monsters = $monsters->whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
    
        $monsters = $monsters->paginate(5);
    
        return view('monstersTable', compact('monsters'));
    }


    public function show(Monster $monster){

        $weapon = Weapon:: where('monster_id', $monster->id)->first();
        $armor = Armor:: where('monster_id', $monster->id)->first();
        return view('monster', compact('monster', 'armor', 'weapon'));
    }


}
