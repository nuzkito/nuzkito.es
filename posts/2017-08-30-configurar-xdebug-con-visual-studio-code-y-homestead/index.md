---
layout: post.njk
title: Configurar Xdebug con Visual Studio Code y Homestead
permalink: configurar-xdebug-con-visual-studio-code-y-homestead/
date_published: 2017-08-30T19:40:31.000Z
date_updated: 2020-05-22T18:40:05.000Z
---

El otro día me instalé [Visual Studio Code](https://code.visualstudio.com/), por probar. He visto que varias personas lo usan porque tiene buenas herramientas para desarrollar con PHP y JavaScript, y al parecer tiene bastante buen rendimiento.

Aprovechando que estaba instalando un nuevo editor, quise configurar Xdebug para poder depurar PHP de forma más sencilla. Uso mucho la idea del `dd` de Laravel (dump and die), pero en ocasiones el depurador puede venir de gran ayuda, ya que te da bastante información.

Así que, tras haberlo configurado, dejo una pequeña guía de cómo hacerlo. Pondré de antemano un resumen, para los impacientes o los que quieran ir al grano, y después el proceso un poco más detallado.

## Resumen

Instala, si no lo tienes ya, la extensión PHP Debug.

Agraga una nueva configuración de depuración en la sección del depurador con el siguiente contenido:

```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for XDebug",
            "type": "php",
            "request": "launch",
            "port": 9000,
            "localSourceRoot": "${workspaceRoot}",
            "serverSourceRoot": "/ruta/al/proyecto/en/el/servidor"
        }
    ]
}
```

En `serverSourceRoot` pon la ruta correspondiente a tu proyecto.

En la máquina virtual de Homestead, en el archivo `/etc/php/7.1/fpm/conf.d/20-xdebug.ini` añade:

```plain-text
xdebug.remote_autostart = 1
```

Reinicia php-fpm:

```bash
sudo service php7.1-fpm restart
```

¡Y listo! Ya puedes comenzar a depurar :D

## Explicación más detallada

Para poder depurar con Visual Studio Code debes asegurarte de que tienes instalador en el editor la extensión de PHP Debug. Las extensiones se buscan en el icono de abajo del menú de la izquierda.

![Búsqueda de la extensión PHP Debug](/images/2017/08/php-debug-vscode.png)

Una vez instalado, accede a la opción de depuración, en el cuarto icono del menú de la izquierda. Ahí podrás agregar una configuración para depurar PHP con Xdebug. Verás que en la parte superior hay un selector, y a su lado, un engranaje. Al pulsar en el engranaje te pedirá que indiques el lenguaje a depurar. Selecciona PHP.

![Sección del depurador](/images/2017/08/agregar-configuracion-debug-vscode.png)

Al seguir estos pasos se creará un archivo launch.json en el directorio .vscode, que se habrá creado en la raíz de tu proyecto si no lo tenías ya. Ese archivo contendrá el siguiente código por defecto:

```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for XDebug",
            "type": "php",
            "request": "launch",
            "port": 9000
        },
        {
            "name": "Launch currently open script",
            "type": "php",
            "request": "launch",
            "program": "${file}",
            "cwd": "${fileDirname}",
            "port": 9000
        }
    ]
}
```

En este archivo es donde se agregarán todas las configuraciones de depuración del proyecto que tengamos abierto. Cada objeto contenido en el array `configurations` será una opción para el debug que aparecerá en el selector que hay en la parte de arriba del depurador. Ten en cuenta que estas configuraciones son locales, para tu máquina, así que no debes subir el directorio .vscode al control de versiones.

Como vamos a utilizar Xdebug en una máquina virtual, debemos configurar el editor para que pueda funcionar de forma remota. Para ello hay que indicarle cuál es la ruta de nuestro proyecto tanto en nuestro equipo como en el servidor (en este caso Homestead).

Esto lo podemos hacer agregando al JSON las propiedades `localSourceRoot` y `serverSourceRoot`. Para la ruta local podemos utilizar una variable de VSCode en la configuración, ${workspaceRoot}, y así no tenemos que preocuparnos de la ruta. En el caso de la ruta del servidor, sí que la debemos especificar. La configuración quedaría de la siguiente forma:

```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for XDebug",
            "type": "php",
            "request": "launch",
            "port": 9000,
            "localSourceRoot": "${workspaceRoot}",
            "serverSourceRoot": "/home/vagrant/www/test"
        }
    ]
}
```

He omitido la otra configuración que genera el editor automáticamente ya que para este ejemplo no es necesaria. Tú la puedes mantener si lo deseas. Recuerda configurar la ruta de tu proyecto en Homestead en la propiedad `serverSourceRoot`.

Para que Xdebug se inicie automáticamente al ejecutar la aplicación, es necesario configurar la opción "xdebug.remote_autostart" a 1. Esto debes hacerlo accediendo a la máquina virtual y editando el archivo `/etc/php/7.1/fpm/conf.d/20-xdebug.ini`. Este archivo, si no lo has modificado anteriormente, tendrá el siguiente contenido:

```text
zend_extension=xdebug.so
xdebug.remote_enable = 1
xdebug.remote_connect_back = 1
xdebug.remote_port = 9000
xdebug.max_nesting_level = 512
```

Simplemente debes agregar la siguiente línea:

```text
xdebug.remote_autostart = 1
```

Y por último, para que los cambios apliquen, es necesario reiniciar el servicio de php-fpm. Lo puedes hacer con el siguiente comando:

```bash
sudo service php7.1-fpm restart
```

¡Ya está todo configurado!

Para iniciar el depurador, puedes hacer click en el icono del *play* del menú del depurador, o pulsar F5. Para establecer un punto de ruptura, puedes hacer click a la izquierda de los números que indican la línea, o pulsar F9 teniendo el cursor en la línea en la que quieres poner el punto de ruptura.

![Depurador parado en un punto de ruptura](/images/2017/08/depurando-php.png)

## Posibles problemas

Si te ocurre que, tras seguir los pasos, el depurador aparentemente no funciona (la ejecución del programa no se para en los puntos de ruptura), es posible que se deba a que algún proceso está utilizando el puerto 9000, que es el que usa Xdebug por defecto.

En ese caso, intenta cerrar tal proceso para evitar el conflicto. También puedes cambiar el puerto que usa Xdebug. Para hacer esto edita el puerto en el `launch.json` que generó VSCode, y en el archivo `/etc/php/7.1/fpm/conf.d/20-xdebug.ini` de Homestead. Asegúrate de poner el mismo puerto en ambos, y de reiniciar php-fpm tras modificarlo.
