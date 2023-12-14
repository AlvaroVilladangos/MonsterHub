<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersAndHunters extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $armaduraBasica = DB::table('armors')->where('name', 'Armadura de novato')->first();
        $armaBasica = DB::table('weapons')->where('name', 'Espada de novato')->first();


        for ($i = 1; $i < 5 ; $i++){

            DB::table('users')->insert([
                'nombre' => 'usuario' . $i,
                'email' => 'usuario'.$i. '@gmail.com',
                'password' => Hash::make('usuario'. $i),
                'admin' => false,
            ]);

            DB::table('hunters')->insert([
                'user_id' => $i+1,
                'name' =>' Hunter'.$i,
                'guild_id' => null, // Puedes cambiar esto según tus necesidades
                'weapon_id' => $armaBasica->id,
                'armor_id' => $armaduraBasica->id,
            ]);
        }
    }
}
