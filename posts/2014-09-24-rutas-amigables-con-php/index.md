---
layout: post.njk
title: Rutas amigables con PHP
permalink: rutas-amigables-con-php/
date_published: 2014-09-24T16:02:15.000Z
date_updated: 2014-09-24T16:05:16.000Z
tags: PHP
---

A día de hoy las rutas amigables son casi indispensables para cualquier aplicación o sitio web, independientemente de que nuestro sitio necesite tener un buen SEO o sea una aplicación privada. **Las rutas amigables permiten al usuario recordar con facilidad la URL**.

## Requisitos para que funcionen las rutas amigables
Antes de tocar nada en el código de la aplicación, necesitamos configurar el servidor. Dependiendo de si usas Apache, Nginx, u otro servidor la forma de configurarlo variará.

En el caso de Apache, necesitas crear un .htaccess con el siguiente contenido:
```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>
    RewriteEngine On

    # Redirect Trailing Slashes...
    RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```
*Si has desarrollado con Laravel, es el mismo .htaccess*. Si usas otro servidor en lugar de Apache, la regla que hay que tener en cuenta es que todas las peticiones deben ser enviadas al `index.php`.

## Obtener la ruta desde PHP
Algunos CMS como Drupal agregan la ruta amigable a un parámetro GET. En este caso no hemos hecho eso sino que directamente enviamos la petición al index.php. No tenemos un parámetro GET que recoga la ruta, pero podemos acceder a ella mediante `$_SERVER['REQUEST_URI']`.

Esta variable guarda todo lo que haya después del dominio. Si accedemos a la dirección `http://dominio.tld/tienda/productos?search=libro`, la URI será igual a ` '/tienda/productos?search=libro'`.

Lo primero que haremos con esa cadena es eliminar los parámetros GET, es decir, todo lo que vaya después de la interrogación. No nos interesa esa parte de la cadena, pues podremos acceder a esos parámetros desde `$_GET`.
```language-php
$route = $_SERVER['REQUEST_URI'];
if (strpos($route, '?')) {
    $route = strstr($route, '?', true);
}
```
Con `strpos` comprobamos si en la URI hay alguna interrogación, y si es así guardamos la cadena sin los parámetros GET usando la función `strstr`.

Ahora nos quedará una cadena como la siguiente: `/tienda/productos`, que es la parte que nos interesa.


## Creando rutas
Hago uso de expresiones regulares para identificar si la url corresponde con una de las urls amigables definidas en el código.
```language-php
function router($url, $closure) {
    $route = $_SERVER['REQUEST_URI'];
    if (strpos($route, '?')) {
        $route = strstr($route, '?', true);
    }

    $urlRule = preg_replace('/:([^\/]+)/', '(?<\1>[^/]+)', $url);
    $urlRule = str_replace('/', '\/', $urlRule);

    preg_match_all('/:([^\/]+)/', $url, $parameterNames);


    if (preg_match('/^' . $urlRule . '\/*$/s', $route, $matches)) {

        $parameters = array_intersect_key($matches, array_flip($parameterNames[1]));
        call_user_func_array($closure, $parameters);
    }
}
```
Esta función recibe la url y un *closure*, una función anónima, que se ejecutará sólo si la ruta a la que hemos accedido corresponde con la que hemos definido. Para definir la ruta por defecto se hace así:
```language-php
router('/', function () {
    echo '<h1>Inicio</h1>';
});
```
Igualmente podemos definir otras rutas:
```language-php
router('/productos', function () {
    echo '<h1>Listado de productos</h1>';
});
```
Y rutas con parámetros:
```language-php
router('/productos/:nombre', function ($nombre) {
    echo "<h1>Producto: $producto</h1>";
});
```

Los parámetros se recogen gracias a las expresiones regulares. Por un lado se obtienen los parámetros que acepta esa ruta:
```language-php
$urlRule = preg_replace('/:([^\/]+)/', '(?<\1>[^/]+)', $url);
$urlRule = str_replace('/', '\/', $urlRule);

preg_match_all('/:([^\/]+)/', $url, $parameterNames);
```

Y si la ruta coincide, se recogen los resultados que devuelve la función `preg_match`, y se compara con los parámetros que acepta la ruta:
```language-php
$parameters = array_intersect_key($matches, array_flip($parameterNames[1]));
```
De esta forma eliminamos de los resultados cadenas que no son parámetros de nuestro closure, como `/productos/`, y nos quedamos con el valor del nombre.

Finalmente llamamos al closure y le enviamos todos los parámetros de la ruta. Como esos parámetros pueden variar dependiendo de la ruta, usamos la función `call_user_func_array` para poder ejecutar una función enviándole un array de parámetros.
```language-php
call_user_func_array($closure, $parameters);
```

## Orientado a objetos
En el punto anterior estabamos usando una función. Funciona, pero lo mejor es usar objetos. Los objetos permiten agregar funcionalidades de forma más rápida y sencilla. Sobretodo si se hace bien.

Pueden revisar [este repositorio de GitHub](https://github.com/nuzkito/rutas-amigables-con-php) en el que implemento el mismo sistema de rutas con objetos.

El sistema se compone de 2 clases. La clase `Router`, que almacena todas las rutas y ejecuta la ruta correcta. Y la clase `Route`, que define cómo es cada una de las rutas y la lógica para obtener los parámetros.

Es un sistema básico. Se podría añadir validación, agregar una forma de filtrar los parámetros de las rutas, crear varios tipos de respuesta, etc. Aprovecharé para hacer una implementación sencilla de todo ello junto en mi [Mini Framework de PHP](https://github.com/nuzkito/mini-framework-php).
