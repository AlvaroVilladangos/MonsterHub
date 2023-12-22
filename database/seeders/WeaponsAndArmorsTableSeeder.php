<?php

namespace Database\Seeders;

use App\Models\Monster;
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
        $monsterId = Monster::getIdByName('Felyne');

        DB::table('weapons')->insert(
            [
                [

                    'name' => 'Espada de novato',
                    'atk' => '100',
                    'crit' => '0%',
                    'element' => 'Neutra',
                    'img' => 'imgWeapons/begginer.png',
                    'info' => 'Espada inicial que te entrega tu compañero feline para las primeras cazas',
                    'monster_id' => Monster::getIdByName('Felyne'),
                ],

                [
                    'name' => 'Wyvern blade maple',
                    'atk' => '210',
                    'crit' => '0%',
                    'element' => 'Fuego',
                    'img' => 'imgWeapons/rathalosWeapon.webp',
                    'info' => 'La Espada de Sangre de Wyvern, una joya de la saga Monster Hunter, es una katana forjada a partir de las escamas y garras del temible Rathalos, el ‘Rey de los Cielos’. Esta espada, mejorada con la sangre de Rathalos, posee un poder inmenso. Con cada corte, deja un rastro de llamas ardientes, una manifestación del aliento de fuego de Rathalos. Los cazadores que empuñan esta espada son respetados y temidos, ya que su presencia trae consigo la furia y el poder del Rathalos. Cada batalla, cada victoria, fortalece el vínculo entre el cazador y Rathalos, haciendo que la Espada de Sangre de Wyvern sea aún más poderosa.',
                    'monster_id' => Monster::getIdByName('Rathalos'),
                ],
            ]
        );

        DB::table('armors')->insert(
            [
                [
                    'name' => 'Armadura de novato',
                    'def' => '100',
                    'img' => 'imgArmors/begginer.png',
                    'info' => 'Armadura inicial que te entrega tu compañero feline para las primeras cazas ',
                    'monster_id' => Monster::getIdByName('Felyne'),
                ],

                [
                    'name' => 'Rathalos set',
                    'def' => '140',
                    'img' => 'imgArmors/rathalosArmor.png',
                    'info' => 'El “Rathalos Set” es una armadura legendaria en la saga Monster Hunter, forjada a partir de las escamas y garras del temible Rathalos. Esta armadura no solo ofrece una defensa excepcional, sino que también otorga al portador una serie de habilidades únicas.
                                 La armadura está imbuida con el espíritu del Rathalos, permitiendo al portador resistir el fuego más intenso y moverse con la velocidad y gracia de este majestuoso Wyvern. Además, cada pieza de la armadura está diseñada para mejorar la eficacia del cazador en combate. El casco mejora la visión y la percepción, la coraza aumenta la resistencia y la fuerza, los guanteletes mejoran la destreza y la precisión, y las grebas proporcionan una movilidad sin igual.',
                    'monster_id' => Monster::getIdByName('Rathalos'),
                ],
            ]
        );
    }
}
