<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class adminController extends Controller
{
    
    public function index(){

        return view('auth.adminIndex');
    }

    public function users(){


        $users = User::query();

        if (request()->has('search')){
            $search = strtolower(request()->get('search', ''));
            $users = $users->whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
    
        $users = $users->paginate(5);

        return view('auth.adminUsers', compact('users'));
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
}
