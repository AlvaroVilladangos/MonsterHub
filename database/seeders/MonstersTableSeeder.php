<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonstersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('monsters')->insert([
            [
                'name' => 'Rathalos',
                'weakness' => 'Dragón',
                'info' => 'Conocido como el "Rey de los Cielos".'
            ],
            [
                'name' => 'Nargacuga',
                'weakness' => 'Trueno',
                'info' => 'Un wyvern volador conocido por su velocidad.'
            ],
            [
                'name' => 'Zinogre',
                'weakness' => 'Hielo',
                'info' => 'Un wyvern brutal que utiliza la electricidad.'
            ],
            [
                'name' => 'Lagiacrus',
                'weakness' => 'Fuego',
                'info' => 'Un wyvern acuático temido como el "Señor de los Mares".'
            ],
            [
                'name' => 'Brachydios',
                'weakness' => 'Agua',
                'info' => 'Un wyvern brutal que utiliza explosivos de lodo verde.'
            ],

            [
                'name' => 'Felyne',
                'weakness' => 'Neutro',
                'info' => 'Es el compañero de aventuras de todo cazadors, ayuda a los cazadores con equipo inicial, les encanta el pescado.'
            ],
        ]);
    }
}
