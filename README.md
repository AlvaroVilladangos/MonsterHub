<p align="center">
<img src="/public/img/monsterHubLogo.png">
</p>


<h1 align="center"> MonsterHub

<p align="center">
  &copy; Curso 2023/24 «MonsterHub» | Álvaro Villadangos Romo
</p>


## 1. Descripción General del Proyecto

MonsterHub consiste en una comunidad y base de datos dedicada al videojuego Monster Hunter Now. Monster Hunter Now es un juego de movil en el que vas caminando y puedes cazar monstruos en la calle. 

La aplicación tiene dos componentes principales: una wiki y una plataforma de comunidad. La wiki proporciona información y recursos sobre el juego, incluyendo detalles sobre los monstruos, armas y armaduras. La plataforma de comunidad permite a los usuarios interactuar entre ellos, agregar amigos y formar grupos. Esto facilita a los jugadores encontrar a otros con quienes jugar, especialmente si sus amigos no juegan o si están buscando salas específicas para cazar ciertos monstruos.

## 2. Funcionalidad Principal de la Aplicación

La funcionalidad principal de MonsterHub es servir como una wiki y un buscador de códigos de salas para el juego Monster Hunter Now, ya que el juego no tiene este sistema. Los jugadores también pueden acceder a información básica del juego, gestionar su gremio (un grupo grande de personas con un líder que gestiona roles, expulsa miembros o modifica los datos del gremio), gestionar su equipamiento (arma y armadura) y comentar en los perfiles de otros cazadores.


Los visitantes de la página sólo podrán acceder a los recursos del juego (monstruos, armas y armaduras ) y al registrarse o iniciar sesión como usuarios, tendrán acceso a la parte de comunidad.


Los administradores tienen un panel exclusivo donde pueden agregar nuevas entradas a la wiki, modificar las existentes, y gestionar a los usuarios (borrar comentarios, bloquear usuarios, borrar usuarios y gremios).

## 3. Objetivos Generales

- **Objetivo:** acceso a recursos del videojuego e interacción con su comunidad.
- **Casos de Uso:**
  - **Invitado (usuario no logueado):**
    - Registrarse.
    - Buscar y ver información de la wiki, armas armaduras y monstruos.
  - **Usuario:**
    - Iniciar sesión.
    - Editar su perfil.
    - Ver un perfil.
    - Comentar en un perfil de un cazador.
    - Agregar amigos.
    - Crear/Unirse a una sala. 
    - Crear/Gestionar/Unirse a una Guild.
    - Buscar y ver información de la wiki, armas armaduras y monstruos.
  - **Administrador:**
    - Crear, modificar y borrar monstruos, armaduras y armas.
    - Bloquear usuarios.
    - Borrar usuarios.
    - Borrar comentarios usuarios.
    - Borrar gremios.

## 4. Elementos de Innovación

- Uso de framwork laravel.


## Vistas aplicación

-Vista "perfil" 

<p align="center">
<img src="/public/img/vistaPerfil.png">
</p>

Este seria el perfil de un cazador, en el puede ver los ultimos comentarios que ha recibido, también aparece ahí una sala, con el código que habría que meter en el juego, este código solo es visble si estás dentro de una sala. 

-Vista "Lista monstruos" 

<p align="center">
<img src="/public/img/vistaListaMonstruos.png">
</p>

Esta seria la vista para buscar monstruos con la información mínima a la hora de cazar un monstruo (Elemento de este, y debilidad).

(Armas y armaduras se ven parecido)

-Vista monstruo 
<p align="center">
<img src="/public/img/vistaMonstruo.png">
</p>

Esta seria la vista de información mas detallada del monstruo, algo de transfondo/informació y habilidades- También aparecen las armas y armaduras que te puedes hacer con este.  (Armas y armaduras se ven parecido)


-Vista "index Admin" 
<p align="center">
<img src="/public/img/vistaAdmin.png">

Esto es el index del administrador, cada carta es un sitio que administrar. Usuarios, armaduras, armas, mosntruos y guilds.


-Vista  "gestión de monstruos" 
<p align="center">
<img src="/public/img/vistaAdminMonsters.png">

Esta es la vista en la que el admin puede editar, crear borrar o deshabilitar monstruos. (Armas y armaduras se ven parecido)

## Configuración del Entorno
### Requisitos Previos

Asegúrate de tener instalados PHP, Composer, Vite y PostgreSQL en tu sistema. Aquí tienes los comandos para instalarlos en un sistema basado en Debian como Ubuntu:

# Instalar PHP y extensiones necesarias
```bash
sudo apt install php8.2 php8.2-amqp php8.2-cgi php8.2-cli php8.2-common php8.2-curl php8.2-fpm php8.2-gd php8.2-igbinary php8.2-intl php8.2-mbstring php8.2-opcache php8.2-pgsql php8.2-readline php8.2-redis php8.2-sqlite3 php8.2-xml php8.2-zip php8.2-bcmath php8.2-gmp php-imagick
```
# Instalar Composer
```bash
sudo apt install composer
```

# Instalar PostgreSQL
```bash 
sudo apt install postgresql postgresql-client postgresql-contrib
```


# Instalar Vite
```bash 
    npm install
```

Antes de ejecutar las migraciones, asegúrate de tener configurada la base de datos PostgreSQL creando un nuevo usuario y una base de datos.

Ejecuta el siguiente comando para crear un nuevo usuario (serás solicitado a ingresar una contraseña para el nuevo usuario): 
```bash 
sudo -u postgres createuser -P **nombreUsusario**
```
Crea una nueva base de datos asignada a este usuario ejecutando: 
```bash 
sudo -u postgres createdb -O **nombreUsusario nombreDB**
```
La contraseña que asignaremos será: **contraseña**


En el archivo .env  hay que modificar las bases de datos, te dejo un ejemplo de como se podrian llamar las bases de datos asegurate de cambiar estos paramteros si las bases de datos no se llaman así.

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=monsterhub
DB_USERNAME=monsterhub
DB_PASSWORD=monsterhub


## Configuración del Proyecto

1. Clona el repositorio y navega al directorio del proyecto. Instala las dependencias de PHP con Composer.
```bash
 composer install
```

2. Con todos los pasos anterirores realizados,ya puedes hacer las migraciones. Hay una base de datos mínimas en migraciones con la que  se puede ver como funciona la pagina. Son 5 monstruos 2 armaduras 2 armas y el perfil de administrador.

```bash
 php artisan migrate:fresh --seed
```
IMPORTANTE. Los Cazadores, siempre tienen que tener un arma y una armadura. Esto se ha hecho dandoles siempre la armadura y arma 1. Estas dos instancias siempre tienen que existir en la base de datos como minimo. 

También en las migraciones hay un perfil de administrado. En caso de querer añadir mas administradores tiene que ser mediante inserciones a la base de datos.

```bash
 cuenta admin@admin.com
 contraseña admin
```



# Ejecución de la Aplicación

1. Ejecutar `npm run dev` para que se carguen los estilos.
1. Ejecutar `php artisan serve` para iniciar el servidor de desarrollo.
2. Acceder a la url que te proporciona el comando anterior para que se ejecute en local.