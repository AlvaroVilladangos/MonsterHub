<?php

namespace App\Http\Controllers;

use App\Models\Armor;
use App\Models\Guild;
use App\Models\Hunter;
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
    
        $users = $users->orderBy('name')->paginate(10);

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
    
        $monsters = $monsters->orderBy('name')->paginate(10);

        return view('admin.adminMonsters', compact('monsters'));
    }


    public function guilds(){

        $guilds = Guild::query();

        if (request()->has('search')){
            $search = strtolower(request()->get('search', ''));
            $guilds = $guilds->whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
    
        $guilds = $guilds->orderBy('name')->paginate(10);

        return view('admin.adminGuilds', compact('guilds'));
    }


    public function weapons(){

        $weapons = Weapon::query();

        if (request()->has('search')){
            $search = strtolower(request()->get('search', ''));
            $weapons = $weapons->whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
    
        $weapons = $weapons->orderBy('name')->paginate(10);

        $monsters = Monster::doesntHave('weapon')->get();

        return view('admin.adminWeapons', compact('weapons', 'monsters'));
    }


    public function armors(){

        $armors = Armor::query();

        if (request()->has('search')){
            $search = strtolower(request()->get('search', ''));
            $armors = $armors->whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
    
        $armors = $armors->orderBy('name')->paginate(10);

        $monsters = Monster::doesntHave('armor')->get();

        return view('admin.adminArmors', compact('armors', 'monsters'));
    }


        public function hunterComments($id){

            $hunter = Hunter::find($id);
            $comments = $hunter->sentComments()->with('receiver')->paginate(5);        
            return view('admin.adminUserComments', compact('comments', 'hunter'));
        }

}
