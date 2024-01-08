<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Models\Weapon;
use App\Models\Armor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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



    public function data($id)
    {
    $monster = Monster::find($id);
    return response()->json($monster);
    }



    public function update(Request $request, $id){
        $monster = Monster::find($id);
        $newName = $request->input('monsterName');
    
        $existingMonster = Monster::where('name', $newName)->first();
        if ($existingMonster && $existingMonster->id != $id) {
            return redirect()->route('monstersAdmin')->with('error', 'El nombre ya existe en la base de datos');
        }
    
        if ($request->hasFile('monsterImg')) {
            $validateIMG = $request->validate(['monsterImg' => 'image']);
            $imgPath = $request->file('monsterImg')->store('imgMonsters', 'public');
            $validateIMG = $imgPath;
    
            if ($monster->img != 'imgMonsters/defaultMonster.webp') {
                Storage::disk('public')->delete($monster->img);
            }
        } else {
            $validateIMG = $monster->img;
        }
    
        $monster->img = $validateIMG;
        $monster->name = $newName;
        $monster->weakness = $request->input('monsterWeakness');
        $monster->element = $request->input('monsterElement');
        $monster->physiology = $request->input('monsterPhysiology');
        $monster->abilities = $request->input('monsterAbilities');
    
        $monster->save();
    
        return redirect()->route('monstersAdmin');
    }
    
    
    public function destroy($id){

        Monster::where('id',$id)->firstOrFail()->delete();
        return redirect()->route('monstersAdmin');

    }

    public function store(Request $request){
        $monster = new Monster();
    
        $existingMonster = Monster::where('name', $request->monsterName)->first();
        if ($existingMonster) {
            return redirect()->route('monsterAdmin')->with('error', 'El nombre ya existe en la base de datos');
        }
    
        if ($request->hasFile('monsterImg')) {
            $request->validate(['monsterImg' => 'image']);
            $imgPath = $request->file('monsterImg')->store('imgMonsters', 'public');
            $monster->img = $imgPath;
        } else {
            return redirect()->route('monstersAdmin')->with('error', 'Debes subir una imagen para el monstruo');
        }
    
        $monster->name = $request->monsterName;
        $monster->weakness = $request->monsterWeakness;
        $monster->element = $request->monsterElement;
        $monster->physiology = $request->monsterPhysiology;
        $monster->abilities = $request->monsterAbilities;
    
        $monster->save();
    
        return redirect()->route('monstersAdmin')->with('success', 'Monstruo creado con éxito');
    }
    
    
}
