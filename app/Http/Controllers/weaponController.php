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


        
    public function destroy($id){

        weapon::where('id',$id)->firstOrFail()->delete();
        return redirect()->route('weaponsAdmin');

    }

    public function store(Request $request){
        $weapon = new weapon();
    
        $existingweapon = weapon::where('name', $request->weaponName)->first();
        if ($existingweapon) {
            return redirect()->route('weaponAdmin')->with('error', 'El nombre ya existe en la base de datos');
        }
    
        if ($request->hasFile('weaponImg')) {
            $request->validate(['weaponImg' => 'image']);
            $imgPath = $request->file('weaponImg')->store('imgWeapons', 'public');
            $weapon->img = $imgPath;
        } else {
            return redirect()->route('weaponsAdmin')->with('error', 'Debes subir una imagen para el monstruo');
        }
    
        $weapon->name = $request->weaponName;
        $weapon->weakness = $request->weaponWeakness;
        $weapon->element = $request->weaponElement;
        $weapon->physiology = $request->weaponPhysiology;
        $weapon->abilities = $request->weaponAbilities;
    
        $weapon->save();
    
        return redirect()->route('monstersAdmin')->with('success', 'Monstruo creado con éxito');
    }
    
    

}
