<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeaponsAndArmorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $monsters = DB::table('monsters')->get();

        foreach ($monsters as $monster) {


            if ($monster->name == "Felyne") {
                DB::table('weapons')->insert([
                    'name' => 'Espada de novato',
                    'atk' => '100',
                    'element' => 'Neutra',
                    'info' => 'Espada inicial que te entrega tu compañero feline para las primeras cazas',
                    'monster_id' => $monster->id
                ]);

                DB::table('armors')->insert([
                    'name' => 'Armadura de novato',
                    'def' => '100',
                    'info' => 'Armadura inicial que te entrega tu compañero feline para las primeras cazas ',
                    'monster_id' => $monster->id
                ]);
                } else {


                DB::table('weapons')->insert([
                    'name' => 'Arma para ' . $monster->name,
                    'atk' => '100',
                    'element' => 'Fuego',
                    'info' => 'Una poderosa arma para ' . $monster->name,
                    'monster_id' => $monster->id
                ]);

                DB::table('armors')->insert([
                    'name' => 'Armadura para ' . $monster->name,
                    'def' => '100',
                    'info' => 'Una resistente armadura para ' . $monster->name,
                    'monster_id' => $monster->id
                ]);
            }
        }
    }
}
