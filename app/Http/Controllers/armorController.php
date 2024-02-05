<?php

namespace App\Http\Controllers;

use App\Models\Armor;
use App\Models\Monster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

        $validatedData = $request->validate([
            'armorName' => 'required|unique:armors,name|min:2|regex:/^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/',
            'armorImg' => 'required|image',
            'armorDef' => 'required|numeric|max:300',
            'armorInfo' => 'required|min:10',
        ]);


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

        $validator = Validator::make($request->all(), [
            'armorName' => 'required|unique:armors,name,'.$id.'|min:2|regex:/^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/',
            'armorImg' => 'sometimes|image',
            'armorDef' => 'required|numeric|max:200',
            'armorInfo' => 'required|min:10',
            'armorMonster_id' => 'required|unique:armors,monster_id,' . $id
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $armor = armor::find($id);
    
        if ($request->hasFile('armorImg')) {
            $imgPath = $request->file('armorImg')->store('imgArmors', 'public');
    
            if ($armor->img != 'imgarmors/defaultarmor.webp') {
                Storage::disk('public')->delete($armor->img);
            }
    
            $armor->img = $imgPath;
        }
    
        $armor->name = $request->input('armorName');
        $armor->def = $request->input('armorDef');
        $armor->info = $request->input('armorInfo');
        $armor->monster_id = $request->input('armorMonster_id');
    
        $armor->save();
    
        return redirect()->route('armorsAdmin');
    }
    
}
