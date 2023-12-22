<?php

namespace App\Http\Controllers;

use App\Models\Weapon;
use App\Models\Monster;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Mod;

class weaponController extends Controller
{
    
    public function index()
    {

        $weapons = Weapon::query();

        if (request()->has('search')){
            $search = strtolower(request()->get('search', ''));
            $weapons = $weapons->whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
    
        $weapons = $weapons->paginate(5);
    
        return view('weaponsTable', compact('weapons'));
    }


    public function show(weapon $weapon){


        $monster = Monster:: where('id', $weapon->monster_id)->first();

        return view('weapon', compact('weapon', 'monster'));
    }


}
