<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Models\User;
use App\Models\Weapon;
use Illuminate\Http\Request;

class adminController extends Controller
{
    
    public function index(){

        return view('admin.adminIndex');
    }

    public function users(){


        $users = User::query();

        if (request()->has('search')){
            $search = strtolower(request()->get('search', ''));
            $users = $users->whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
    
        $users = $users->paginate(10);

        return view('admin.adminUsers', compact('users'));
    }



    public function blockUser($id){
        $user = User::find($id);
        $user->blocked = true;
        $user->save();
        return redirect()->route('usersAdmin');
    }

    public function unBlockUser($id){
        $user = User::find($id);
        $user->blocked = false;
        $user->save();
        return redirect()->route('usersAdmin');
    }



    public function monsters(){

        $monsters = Monster::query();

        if (request()->has('search')){
            $search = strtolower(request()->get('search', ''));
            $monsters = $monsters->whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
    
        $monsters = $monsters->paginate(5);

        return view('admin.adminMonsters', compact('monsters'));
    }



    public function weapons(){

        $weapons = Weapon::query();

        if (request()->has('search')){
            $search = strtolower(request()->get('search', ''));
            $weapons = $weapons->whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
    
        $weapons = $weapons->paginate(5);

        $monsters = Monster::doesntHave('weapon')->get();

        return view('admin.adminWeapons', compact('weapons', 'monsters'));
    }

}
