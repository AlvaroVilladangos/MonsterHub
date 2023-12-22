<?php

namespace App\Http\Controllers;

use App\Models\Armor;
use App\Models\Monster;
use Illuminate\Http\Request;

class armorController extends Controller
{
    public function index()
    {

        $armors = Armor::query();

        if (request()->has('search')){
            $search = strtolower(request()->get('search', ''));
            $armors = $armors->whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
    
        $armors = $armors->paginate(5);
    
        return view('armorsTable', compact('armors'));
    }


    public function show(armor $armor){


        $monster = Monster:: where('id', $armor->monster_id)->first();

        return view('armor', compact('armor', 'monster'));
    }

}
