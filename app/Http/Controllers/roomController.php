<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class roomController extends Controller
{
    public function index()
    {
        
        $rooms = Room::query();
        $monsters = Monster::all();

        if (request()->has('search')) {
        $search = strtolower(request()->get('search', ''));
        $rooms = $rooms->join('monsters', 'rooms.monster_id', '=', 'monsters.id')
                       ->whereRaw('lower(monsters.name) like (?)', ["%{$search}%"])
                       ->select('rooms.*'); 
    }

        $rooms = $rooms->paginate(5);

        return view('auth.rooms', compact('rooms', 'monsters'));
    }

    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(), [
            'codigo' => [
                'required',
                'regex:/^\d{5}$/',
                'unique:rooms,room_number',
            ],
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $hunter = auth()->user()->hunter;
        $room = new Room();
    
        $room->room_number = $request->get('codigo');
        $room->monster_id = $request->get('monster');
        $room->save();
    
        $hunter->room_id = $room->id;
        $hunter->save();
    
        return redirect()->route('dashboard');
    }
    
    
}
