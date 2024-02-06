<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed'],
        ]);

        

        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => false,
        ]);

        $id = $user->id;

        $armaduraBasica = DB::table('armors')->where('id', '1')->first();
        $armaBasica = DB::table('weapons')->where('id', '1')->first();

        $hunter = DB::table('hunters')->insert([
            'user_id' => $id,
            'name' =>' Hunter'.$id,
            'guild_id' => null,
            'weapon_id' => $armaBasica->id,
            'armor_id' => $armaduraBasica->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()-> route('dashboard');
    }

}
