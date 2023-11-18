---
layout: post.njk
title: Ejecutar Laravel Dusk en local y la aplicación en Homestead
permalink: ejecutar-laravel-dusk-en-local-y-la-aplicacion-en-homestead/
date_published: 2017-03-04T20:29:32.000Z
date_updated: 2017-03-04T20:31:22.000Z
---

Junto a la versión 5.4 de Laravel se liberó un nuevo componente para hacer pruebas _end to end_ o funcionales llamado [Laravel Dusk](https://laravel.com/docs/master/dusk). Este componente permite ejecutar las pruebas en un navegador real, por lo que ejecuta el código JavaScript que tenga la aplicación, lo cual es genial.

Por lo general uso [Homestead](http://laravel.com/docs/master/homestead) como entorno de desarrollo para PHP y Node.js, independientemente de que esté usando Laravel o no. Sin embargo, Dusk no funciona en Homestead debido a que para ejecutar las pruebas necesita abrir un navegador (Homestead no tiene una interfaz gráfica instalada). Por ese motivo, ejecuto Dusk desde mi equipo, el cual abre la aplicación que está instalada en Homestead.

Por desgracia, debido a cómo funciona Dusk, esto daba problemas. Las pruebas siempre fallaban por un problema de configuración de base de datos. Esto ocurre porque Dusk permite usar un fichero de configuración `.env`, el cual, durante la ejecución de las pruebas, sustituye al original. Concretamente daba problemas en la ruta de conexión a la base de datos. En la máquina virtual, la base de datos es acccesible desde 127.0.0.1:3306, pero desde mi equipo se accede desde 127.0.0.1:33060.

Claro, tanto las pruebas como la aplicación están usando la misma IP y el mismo puerto, pero se ejecutan desde distintas máquinas. Así que se me ocurrieron varias soluciones para solventar esto.

## Solución 1: Crear una base de datos local para las pruebas
Esto supone instalar MySQL en mi ordenador, cosa que no quería hacer, ya que entonces tendría que replicar completamente el entorno de desarrollo en mi equipo para ejecutar las pruebas. Si hiciese eso, no me haría falta Homestead, pero prefiero usar un entorno separado de mi máquina para ejecutar los proyectos. Así que en mi caso no lo veo como una opción factible.

## Solución 2: Modificar el mapeo de los puertos para que coincidan
Homestead mapea el puerto de MySQL, el 3306, para que sea accesible desde el puerto 33060 de la máquina física. Esto se hace para evitar conflictos en el caso de tener MySQL instalado de forma local.

Es posible cambiar esa configuración, así que podemos modificar la configuración de Homestead para que el puerto sea el 3306 en ambas máquinas. O, si tienes MySQL instalado en tu equipo, cambiar el puerto del MySQL de Homestead a cualquier otro que tengas libre en tu equipo.

## Solución 3: Modificar la configuración de la base de datos de la aplicación para las pruebas
En mi caso decidí modificar la configuración de la base de datos desde el código de las pruebas. Inicialmente mantengo todo de la misma forma, pero si estoy ejecutando las pruebas con Dusk, y sólo en dicho caso, modifico la configuración de la base de datos.

Para ello, modifiqué el método `createApplication` del _trait_ `CreatesApplication`, y añadí una condición que comprueba si en las pruebas existe un método `configure`, y en dicho caso lo ejecuta, pasándole la instancia de la aplicación.
```language-php
public function createApplication()
{
    $app = require __DIR__.'/../bootstrap/app.php';

    $app->make(Kernel::class)->bootstrap();

    if (method_exists($this, 'configure')) {
        $this->configure($app);
    }

    return $app;
}
```

Y en la clase `DuskTestCase`, añadí el método `configure`, en el que modifico la configuración de la base de datos por defecto.
```language-php
abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    // ...

    protected function configure($app)
    {
        $app->make('config')->set('database.default', 'mysql_dusk_local');
    }
}
```

Por último, agregué dicha configuración en _config/database.php_, con los datos necesarios para que las pruebas se conecten a la base de datos de la máquina virtual.
```language-php
'mysql_dusk_local' => [
    'driver' => 'mysql',
    'host' => env('SERVER_DB_HOST', '127.0.0.1'),
    'port' => env('SERVER_DB_PORT', '33060'),
    'database' => env('DB_DATABASE', 'laravel'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
    'strict' => true,
    'engine' => null,
],
```

---

Esa última opción es la que me parece más adecuada, ya que es la que requiere hacer una menor configuración al resto de miembros del equipo, o a uno mismo cuando tenga que instalar la aplicación en otro entorno de desarrollo.

Además, la solución es válida para cualquier otro entorno. Si en lugar de Homestead utilizas tu propia máquina virtual o contenedor, sólo tienes que indicar la IP y el puerto de tu base de datos.

Si se te ocurre una idea mejor, compártela en los comentarios.

## Más información sobre Laravel Dusk
* Documentación oficial: https://laravel.com/docs/master/dusk
* Contenido sobre Dusk en Styde: https://styde.net/tag/laravel-dusk/
