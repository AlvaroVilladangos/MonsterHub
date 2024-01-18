<?php

namespace App\Http\Controllers;

use App\Models\Armor;
use App\Models\Monster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class armorController extends Controller
{
    public function index()
    {

        $armors = Armor::query()->where('blocked', false);

        if (request()->has('search')) {
            $search = strtolower(request()->get('search', ''));
            $armors = $armors->whereRaw('lower(name) like (?)', ["%{$search}%"]);
        }

        $armors = $armors->orderBy('name')->paginate(5);

        return view('armorsTable', compact('armors'));
    }


    public function show(armor $armor)
    {


        $monster = Monster::where('id', $armor->monster_id)->first();

        return view('armor', compact('armor', 'monster'));
    }



    public function data($id)
    {
        $armor = armor::find($id);
        return response()->json($armor);
    }


    public function destroy($id)
    {

        armor::where('id', $id)->firstOrFail()->delete();
        return redirect()->route('armorsAdmin');
    }




    public function blockArmor($id){

        $armor = Armor::find($id);
        $armor->blocked = true;
        $armor->save();
        return redirect()->back();
    }


    public function unBlockArmor($id){

        $armor = Armor::find($id);
        $armor->blocked = false;
        $armor->save();
        return redirect()->back();
    }

    public function store(Request $request)
    {
        $armor = new armor();

        $existingarmor = armor::where('name', $request->armorName)->first();
        if ($existingarmor) {
            return redirect()->route('armorsAdmin')->with('error', 'El nombre ya existe en la base de datos');
        }

        if ($request->hasFile('armorImg')) {
            $request->validate(['armorImg' => 'image']);
            $imgPath = $request->file('armorImg')->store('imgarmors', 'public');
            $armor->img = $imgPath;
        } else {
            return redirect()->route('armorsAdmin')->with('error', 'Debes subir una imagen para el monstruo');
        }

        $armor->name = $request->armorName;
        $armor->def = $request->armorDef;
        $armor->info = $request->armorInfo;
        $armor->monster_id = $request->armorMonster_id;

        $armor->save();

        return redirect()->route('armorsAdmin')->with('success', 'Arma creada con éxito');
    }


    public function update(Request $request, $id)
    {
        $armor = armor::find($id);
        $newName = $request->input('armorName');

        $existingarmor = armor::where('name', $newName)->first();
        if ($existingarmor && $existingarmor->id != $id) {
            return redirect()->route('armorsAdmin')->with('error', 'El nombre ya existe en la base de datos');
        }

        if ($request->hasFile('armorImg')) {
            $validateIMG = $request->validate(['armorImg' => 'image']);
            $imgPath = $request->file('armorImg')->store('imgarmors', 'public');
            $validateIMG = $imgPath;

            if ($armor->img != 'imgarmors/defaultarmor.webp') {
                Storage::disk('public')->delete($armor->img);
            }
        } else {
            $validateIMG = $armor->img;
        }

        $armor->img = $validateIMG;
        $armor->name = $newName;
        $armor->def = $request->input('armorDef');
        $armor->info = $request->input('armorInfo');
        $armor->monster_id = $request->input('armorMonster_id');

        $armor->save();

        return redirect()->route('armorsAdmin');
    }
}
