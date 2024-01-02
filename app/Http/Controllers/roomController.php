<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Models\Room;
use Illuminate\Http\Request;

class roomController extends Controller
{
    public function index()
    {

        $rooms = Room::query();
        $monsters = Monster::all();
        if (request()->has('search')) {
            $search = strtolower(request()->get('search', ''));
            $rooms = $rooms->whereRaw('lower(name) like (?)', ["%{$search}%"]);
        }

        $rooms = $rooms->paginate(5);

        return view('auth.rooms', compact('rooms', 'monsters'));
    }

    public function store()
    {
        $hunter = auth()->user()->hunter;
        $room = new Room();
        
        do {
            $randomRoomNumber = rand(10000, 99999);
        } while (Room::where('room_number', $randomRoomNumber)->exists());
    
        $room->room_number = $randomRoomNumber;
        $room->monster_id = request()->get('monster');
        $room->save();
        
        $hunter->room_id = $room->id;
        $hunter->save();
        return redirect()->route('dashboard');
    }
    
}
