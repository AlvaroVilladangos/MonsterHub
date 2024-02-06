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
                'name' => 'Felyne',
                'weakness' => 'Neutro',
                'element' => 'Neutro',
                'physiology' => 'Los Felyne son gatos antropomorfos que caminan de forma bípeda como los humanos. Se caracterizan por su pelaje claro y su marca marrón en forma de zarpa. Los Felyne llevan un pequeño pico hecho con un diente o garra de wyvern, que utilizan para coger cosas, y una bellota donde almacenan lo que obtienen. Sus ojos suelen ser azules. ',
                'abilities' => 'Forman aldeas junto a los Melynx en cualquier lugar, suelen aparecer en diferentes zonas buscando materiales valiosos. Son dóciles y no atacarán a no ser que se les provoque, o si aparece un monstruo grande en la misma área, en ese caso atacarán con sus picos o lanzando bombas.

                Algunos Felynes se han adentrado en la sociedad humana y habitan en aldeas o ciudades, ya que son capaces de realizar acciones típicamente humanas, con lo cual suelen ejercer de ayudantes para los humanos, cocineros, vendedores, guías, etc. ',
                'img' => 'img/imgMonsters/defaultFelyne.webp',
            ],
            
            [
                'name' => 'Rathalos',
                'weakness' => 'Dragón',
                'element' => 'Fuego',
                'physiology' => 'Los Rathalos son wyverns grandes y bípedos con una piel blindada y espinosa que cubre su cuerpo. Su capa exterior presenta colores mucho más brillantes y vibrantes que la de su contraparte femenina, la Rathian. Es principalmente de color rojo brillante, con manchas negras por todas partes. Al igual que los Rathian, los Rathalos poseen un saco de llamas que se utiliza para producir proyectiles de fuego mortales desde la boca. Las garras de sus pies son muy venenosas y se sabe que infligen heridas mortales tóxicas a presas más grandes. Además, su cola larga y gruesa presenta un garrote con púas pesadas al final. Las membranas de las alas de Rathalos presentan patrones ornamentados que probablemente se utilizan para atraer parejas potenciales.',
                'abilities' => 'Los Rathalos son expertos voladores y, como tal, tienden a cazar desde los cielos. Al lanzar un ataque aéreo sorpresa, pueden infligir heridas venenosas con sus garras o quemar a su presa con proyectiles en llamas. En el suelo, los Rathalos siguen siendo oponentes formidables. Usando sus poderosas patas, pueden perseguir a su presa desde la distancia o infligir daño contundente con su cola en forma de maza. A una distancia lo suficientemente cercana, se sabe que usan sus afilados dientes para morder a sus enemigos. Algunos Rathalos son capaces de permanecer en el aire y lanzar “algunas” bolas de fuego antes de volver a aterrizar',
                'img' => 'img/imgMonsters/defaultRathalos.webp',
            ],

            [
                'name' => 'Almudron',
                'weakness' => 'Fuego',
                'element' => 'Agua',
                'physiology' => 'Como su nombre lo indica, Almudron pasa mucho tiempo acechando en el barro, al menos hasta que emerge para asfixiar a sus presas. De su cola rezuma un extraño fluido dorado, que Almudron utiliza para disolver el suelo debajo de sus presas, deteniéndolas en un lodo para poder arrastrarlas hacia abajo. Cuando se enfurece, produce más líquido, tornando el barro dorado. Cuando veas oro, ¡cuidado!',
                'abilities' => 'Almudron es un monstruo feroz con un conjunto de movimientos muy complejo. Sus ataques básicos consisten en golpes de garra y mordiscos rápidos, pero es más amenazante cuando usa su enorme cola combinada con una gran cantidad de ataques de barro. Todos sus ataques de barro infligirán el efecto de estado Waterblight en los golpes directos, lo que reducirá significativamente la tasa de recuperación de resistencia del cazador.',
                'img' => 'img/imgMonsters/defaultAlmudron.webp',
            ],
            [
                'name' => 'Anjanath',
                'weakness' => 'Agua',
                'element' => 'Fuego',
                'physiology' => 'El Anjanath se asemeja al Deviljho, pues ambos están basados en un tiranosaurio. Su piel es rosada, y la parte superior de su cuerpo está cubierto de un plumaje oscuro. Su boca está armada con grandes colmillos que sobresalen desde la mandíbula inferior, y su nariz puede inflarse como un globo para poder captar mejor los olores. Cuando se enfurece, puede extender dos velas espinosas sobre su lomo para intimidar a sus enemigos.',
                'abilities' => 'El Anjanath puede atacar con sus enormes fauces, arremetiendo con su cuerpo o dando coletazos, no obstante, cuando se enfurece es capaz de utilizar fuego para atacar. De forma similar al Glavenus, un órgano en su garganta le permite imbuir su boca en llamas, pudiendo luego expulsar llamaradas para atacar o dar mordiscos. ',
                'img' => 'img/imgMonsters/defaultAnjanath.webp',
            ],
            [
                'name' => 'Arzuros',
                'weakness' => 'Fuego',
                'element' => 'Neutro',
                'physiology' => 'El Arzuros recuerda a un gran oso de pelaje azul verdoso. La piel de su lomo es gruesa y dura, como un caparazón, y sus brazos están cubiertos de una dura concha con espinas y está armado con unas afiladas garras rojas. A ambos lados de su cabeza y su frente posee un largo pelaje claro que recorre sus costados. Puede moverse tanto a cuatro como a dos patas. ',
                'abilities' => 'El Arzuros es un monstruo agresivo, pero huirá frente a monstruos mucho mayores que él, como Zinogre. Al tratarse de un monstruo encontrado al comienzo, es bastante fácil de vencer. Ataca principalmente con sus garras para dar varios zarpazos seguidos, y también puede embestir o abalanzarse hacia delante con sus garras. Si los cazadores llevan miel realizará un ataque restrictivo para quitársela de encima. ',
                'img' => 'img/imgMonsters/defaultArzuros.webp',
            ],

            [
                'name' => 'Barioth',
                'weakness' => 'Fuego',
                'element' => 'Hielo',
                'physiology' => 'El Barioth es un monstruo cuadrúpedo cuyas alas se han convertido parcialmente en patas. Su lomo está protegido por un caparazón blanco, mientras que el resto de su cuerpo está cubierto de un pelaje blanco también. Además, sus alas y patas poseen afilados pinchos y garras para aferrarse al hielo. Su cabeza es corta y posee dos prominentes colmillos de color ámbar, mientras que su cola es larga y se divide en dos en la punta. ',
                'abilities' => 'El Barioth suele atacar con velocidad, saltando de un lado para otro para despistar y luego embestir o saltar sobre su víctima, también puede golpear lateralmente o dar un coletazo deslizando su cola por el hielo. También puede lanzar un pequeño trozo de hielo que crea un tornado helado por unos segundos y que provoca muñeco de nieve. Por otra parte puede echar el vuelo para luego caer en picado o también crear un tornado. ',
                'img' => 'img/imgMonsters/defaultBarioth.webp',
            ],


            [
                'name' => 'Diablos',
                'weakness' => 'Hielo',
                'element' => 'Neutro',
                'physiology' => 'Es un robusto wyvern de gran tamaño, de color marrón claro, cubierto con unas conchas muy densas, duras y pesadas. Sus alas están más adaptadas a excavar que a volar, con unas fuertes garras. Su característica más notable son los dos grandes cuernos retorcidos de su cabeza, que se parecen mucho a los cuernos de un toro, aunque a veces les puede faltar uno, además poseen dos grandes colmillos y un pequeño collarín dentado. Su cola termina en una pesada maza. ',
                'abilities' => 'Los Diablos son capaces de excavar y moverse a gran velocidad bajo tierra. Su oído muy agudo, por lo que cuando está bajo la arena se le puede aturdir con una bomba sónica. A pesar de ello, este monstruo es temido por su fuerte rugido, conocido como la pesadilla de los cazadores.

                Utilizan únicamente la fuerza bruta para atacar y carecen de ataque de aliento. Su forma principal de ataque es arremetiendo con sus cuernos, y a veces pueden quedar atrapados momentáneamente en una pared rocosa. También pueden usar su cola como maza, o salir violentamente desde el suelo.',
                'img' => 'img/imgMonsters/defaultDiablos.webp',
            ],

        ]);
    }
}
