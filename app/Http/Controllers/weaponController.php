<?php

namespace App\Http\Controllers;

use App\Models\Weapon;
use App\Models\Monster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\AssignOp\Mod;

class weaponController extends Controller
{

    public function index()
    {

        $weapons = Weapon::query()->where('blocked', false);

        if (request()->has('search')) {
            $search = strtolower(request()->get('search', ''));
            $weapons = $weapons->whereRaw('lower(name) like (?)', ["%{$search}%"]);
        }

        $weapons = $weapons->orderBy('name')->paginate(5);

        return view('weaponsTable', compact('weapons'));
    }


    public function show(weapon $weapon)
    {


        $monster = Monster::where('id', $weapon->monster_id)->first();

        return view('weapon', compact('weapon', 'monster'));
    }



    public function data($id)
    {
        $weapon = Weapon::find($id);
        return response()->json($weapon);
    }


    public function destroy($id)
    {

        weapon::where('id', $id)->firstOrFail()->delete();
        return redirect()->route('weaponsAdmin');
    }



    public function blockWeapon($id){

        $weapon = Weapon::find($id);
        $weapon->blocked = true;
        $weapon->save();
        return redirect()->back();
    }


    public function unBlockWeapon($id){

        $weapon = Weapon::find($id);
        $weapon->blocked = false;
        $weapon->save();
        return redirect()->back();
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'weaponName' => 'required|unique:weapons,name|min:2|regex:/^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/',
            'weaponImg' => 'required|image',
            'weaponAtk' => 'required|numeric|min:100|max:1000',
            'weaponCrit' => 'required|numeric|max:100',
            'weaponInfo' => 'required|min:10',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $weapon = new weapon();

        $existingweapon = weapon::where('name', $request->weaponName)->first();
        if ($existingweapon) {
            return redirect()->route('weaponsAdmin')->with('error', 'El nombre ya existe en la base de datos');
        }

        if ($request->hasFile('weaponImg')) {
            $request->validate(['weaponImg' => 'image']);
            $imgPath = $request->file('weaponImg')->store('imgWeapons', 'public');
            $weapon->img = $imgPath;
        } else {
            return redirect()->route('weaponsAdmin')->with('error', 'Debes subir una imagen para el monstruo');
        }

        $weapon->name = $request->weaponName;
        $weapon->atk = $request->weaponAtk;
        $weapon->element = $request->weaponElement;
        $weapon->crit = $request->weaponCrit . '%';
        $weapon->info = $request->weaponInfo;
        $weapon->monster_id = $request->weaponMonster_id;

        $weapon->save();

        return redirect()->route('weaponsAdmin')->with('success', 'Arma creada con éxito');
    }



    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'weaponName' => 'required|unique:weapons,name,'.$id.'|min:2|regex:/^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/',
            'weaponImg' => 'sometimes|image',
            'weaponAtk' => 'required|numeric|min:100|max:1000',
            'weaponCrit' => 'required|numeric|max:100',
            'weaponInfo' => 'required|min:10',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $weapon = Weapon::find($id);
    
        if ($request->hasFile('weaponImg')) {
            $imgPath = $request->file('weaponImg')->store('imgWeapons', 'public');
    
            if ($weapon->img != 'imgWeapons/defaultWeapon.webp') {
                Storage::disk('public')->delete($weapon->img);
            }
    
            $weapon->img = $imgPath;
        }
    
        $weapon->name = $request->input('weaponName');
        $weapon->atk = $request->input('weaponAtk');
        $weapon->element = $request->input('weaponElement');
        $weapon->crit = $request->input('weaponCrit') . '%';
        $weapon->info = $request->input('weaponInfo');
        $weapon->monster_id = $request->input('weaponMonster_id');
    
        $weapon->save();
    
        return redirect()->route('weaponsAdmin');
    }
    
}
