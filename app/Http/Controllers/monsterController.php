<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Models\Weapon;
use App\Models\Armor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class monsterController extends Controller
{
    public function index()
    {

        $monsters = Monster::query()->where('blocked', false);

        if (request()->has('search')) {
            $search = strtolower(request()->get('search', ''));
            $monsters = $monsters->whereRaw('lower(name) like (?)', ["%{$search}%"]);
        }

        $monsters = $monsters->orderBy('name')->paginate(5);

        return view('monstersTable', compact('monsters'));
    }


    public function show(Monster $monster)
    {

        $weapon = Weapon::where('monster_id', $monster->id)->first();
        $armor = Armor::where('monster_id', $monster->id)->first();
        return view('monster', compact('monster', 'armor', 'weapon'));
    }



    public function data($id)
    {
        $monster = Monster::find($id);
        return response()->json($monster);
    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'monsterName' => 'required|regex:/^[A-ZÁÉÍÓÚÑ][a-zA-ZáéíóúÁÉÍÓÚÑñ\s]*$/|unique:monsters,name,' . $id,
            'monsterImg' => 'image',
            'monsterWeakness' => 'required',
            'monsterElement' => 'required',
            'monsterPhysiology' => 'required|min:10',
            'monsterAbilities' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $monster = Monster::find($id);

        if ($request->hasFile('monsterImg')) {
            $imgPath = $request->file('monsterImg')->store('imgMonsters', 'public');

            if ($monster->img != 'imgMonsters/defaultMonster.webp') {
                Storage::disk('public')->delete($monster->img);
            }

            $monster->img = $imgPath;
        }

        $monster->name = trim($request->input('monsterName'));
        $monster->weakness = $request->input('monsterWeakness');
        $monster->element = $request->input('monsterElement');
        $monster->physiology = $request->input('monsterPhysiology');
        $monster->abilities = $request->input('monsterAbilities');

        $monster->save();

        return redirect()->route('monstersAdmin');
    }

    public function destroy($id)
    {

        Monster::where('id', $id)->firstOrFail()->delete();

        return redirect()->route('monstersAdmin');
    }

    public function blockMonster($id)
    {

        $monster = Monster::find($id);
        $monster->blocked = true;
        $monster->save();

        $weapons = Weapon::where('monster_id', $id)->get();
        foreach ($weapons as $weapon) {
            $weapon->blocked = true;
            $weapon->save();
        }

        $armors = Armor::where('monster_id', $id)->get();
        foreach ($armors as $armor) {
            $armor->blocked = true;
            $armor->save();
        }

        return redirect()->back();
    }


    public function unBlockMonster($id)
    {

        $monster = Monster::find($id);
        $monster->blocked = false;
        $monster->save();
        return redirect()->back();
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'monsterName' => 'required|regex:/^[A-Za-z]+$/|unique:monsters,name',
            'monsterImg' => 'required|image',
            'monsterWeakness' => 'required',
            'monsterElement' => 'required',
            'monsterPhysiology' => 'required|min:10',
            'monsterAbilities' => 'required|min:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $monster = new Monster();

        if ($request->hasFile('monsterImg')) {
            $imgPath = $request->file('monsterImg')->store('imgMonsters', 'public');
            $monster->img = $imgPath;
        }

        $monster->name = trim($request->input('monsterName'));
        $monster->weakness = $request->input('monsterWeakness');
        $monster->element = $request->input('monsterElement');
        $monster->physiology = $request->input('monsterPhysiology');
        $monster->abilities = $request->input('monsterAbilities');

        $monster->save();

        return redirect()->route('monstersAdmin')->with('success', 'Monstruo creado con éxito');
    }
}
