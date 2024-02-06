<p align="center">
<img src="/public/img/monsterHubLogo.png">
</p>


<h1 align="center"> MonsterHub

<p align="center">
  &copy; Curso 2023/24 «MonsterHub» | Álvaro Villadangos Romo
</p>


## 1. Descripción General del Proyecto

MonsterHub consiste en una comunidad y base de datos dedicada al videojuego Monster Hunter Now. Monster Hunter Now es un juego de movil en el que andas y puedes cazar mosntruos ya sea solo o con gente a través. Por el lado de wiki, el propósito es de disponer de información y recursos del juego, como los monstruos, armas y aramduras.

Por el lado de comunidad, los usuarios podrán interactuar entre ellos, agregar amigos y hacer grupos. Con la idea de conocer a más gente que juegue a Monster Hunter y así no jugar solo si tus amigos no juegan, os simpleamente usar la aplicación para encontrar salas porque quieres matar X Monstruo y no puedes porque no tienes en el juego ninguna misión para ello.

## 2. Funcionalidad Principal de la Aplicación

La funcionalidad principal de la aplicación es permitir a los jugadores de esta saga poder conseguir códigos del juego Monster Hunter Now y que esta pagina te sirva como wiki, y a parte un buscador de salas del juego, ya que el propio juego no tiene este sistema.Además de poder acceder a la información básica del juego, gestionar su gremio/guild (que viene a ser un grupo grande de personas en la que hay un lider que gestiona roles, expulsa gente o modifica los datos de la guild.), gestionar lo que llevas equipado (arma y armadura), comentar en perfiles de otros cazadores. 


Los visitantes de la página solo podrán acceder a los recursos del juego (monstruos, armas y armaduras ) y al registrarse o iniciar sesión como usuarios, tendrán acceso a la parte de comunidad.

Los administradores tendrán un panel de administrácion, en el cual ellos serán los únicos capaces de agregar nuevas entradas a la wiki y también podrán modificar las existentes. También tendran un control sobre los usuarios, podran borrar comentarios, bloquear usuarios, borrar usuarios y borrar gremios


## 3. Objetivos Generales

- **Objetivo:** acceso a recursos del videojuego e interacción con su comunidad.
- **Casos de Uso:**
  - **Invitado (usuario no logueado):**
    - Registrarse.
    - Buscar y ver información de la wiki, armas armaduras y monstruos.
  - **Usuario:**
    - Iniciar sesión.
    - Editar su perfil.
    - Crear/Unirse a una sala. 
    - Crear/Gestionar/Unirse a una Guild.
    - Agregar amigos.
    - Comentar en un perfil de un cazador.
    - Ver un perfil.
    - Buscar y ver información de la wiki, armas armaduras y monstruos.
  - **Administrador:**
    - Crear, modificar y borrar monstruos, armaduras y armas.
    - Bloquear usuarios.
    - Borrar usuarios.
    - Borrar gremios.
    - Borrar comentarios usuarios.

## 4. Elementos de Innovación

- Uso de framwork laravel.


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