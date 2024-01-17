<?php

namespace App\Http\Controllers;

use App\Models\Weapon;
use App\Models\Monster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\AssignOp\Mod;

class weaponController extends Controller
{

    public function index()
    {

        $weapons = Weapon::query()->where('blocked', false);;

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
        $weapon = Weapon::find($id);
        $newName = $request->input('weaponName');

        $existingWeapon = Weapon::where('name', $newName)->first();
        if ($existingWeapon && $existingWeapon->id != $id) {
            return redirect()->route('weaponsAdmin')->with('error', 'El nombre ya existe en la base de datos');
        }

        if ($request->hasFile('weaponImg')) {
            $validateIMG = $request->validate(['weaponImg' => 'image']);
            $imgPath = $request->file('weaponImg')->store('imgWeapons', 'public');
            $validateIMG = $imgPath;

            if ($weapon->img != 'imgWeapons/defaultWeapon.webp') {
                Storage::disk('public')->delete($weapon->img);
            }
        } else {
            $validateIMG = $weapon->img;
        }

        $weapon->img = $validateIMG;
        $weapon->name = $newName;
        $weapon->atk = $request->input('weaponAtk');
        $weapon->element = $request->input('weaponElement');
        $weapon->crit = $request->input('weaponCrit') . '%';
        $weapon->info = $request->input('weaponInfo');
        $weapon->monster_id = $request->input('weaponMonster_id');

        $weapon->save();

        return redirect()->route('weaponsAdmin');
    }
}
