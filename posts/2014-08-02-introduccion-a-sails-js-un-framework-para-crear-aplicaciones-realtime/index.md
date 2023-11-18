---
layout: post.njk
title: Introducción a Sails.js, un framework para crear aplicaciones realtime
permalink: introduccion-a-sails-js-un-framework-para-crear-aplicaciones-realtime/
date_published: 2014-08-02T16:55:50.000Z
date_updated: 2014-08-02T20:36:11.000Z
tags:
- JavaScript
---

![](/images/2014/Aug/sails.png)

[Sails.js](http://www.sailsjs.org) es un framework para [Node.js](http://nodejs.org/). Está realizado bajo el [framework Express](http://expressjs.com/), incluyendo varias capas de abstracción para hacer un desarrollo más fácil. Posee un [ORM](http://es.wikipedia.org/wiki/Mapeo_objeto-relacional), métodos para crear [API RESTful](http://es.wikipedia.org/wiki/Representational_State_Transfer) y soporte para manejar peticiones en tiempo real [gracias a Socket.io](http://socket.io/). Es especialmente bueno para realizar **aplicaciones que funcionan en tiempo real**, como chats, juegos, o aplicaciones colaborativas.

El día de ayer lanzaron la versión 0.10 de este framework. A continuación veremos una introducción al mismo para comprobar lo sencillo que puede llegar a ser.


## Instalación
Como cualquier otra dependencia de Node.js, Sails se instala mediante npm:
```bash
sudo npm install sails -g
```
Esto instalará la última versión en nuestro sistema.

Para generar un proyecto hay que ejecutar el comando `sails new`. Automáticamente **generará todos los archivos necesarios**:
```bash
mkdir sails-example
cd sails-example
sails new
sails lift
```
Sails también generará el `package.json` y una serie de archivos de Grunt para automatizar diversas tareas.

Con `sails lift` le decimos que inicie el servidor. Con esto ya tenemos el framework funcionando y listo para comenzar el desarrollo.


## Creando una API REST en 2 minutos
Sails incorpora métodos para crear de forma muy sencilla una API REST, y también tiene un generador de modelos y controladores.

Vamos a crear una aplicación sencilla que permite enviar y recibir mensajes. Para ello crearemos un modelo Mensajes:
```bash
sails generate api message
```
Esto nos generará un controlador y un modelo para manejar los mensajes. Ahora volvemos a ejecutar `sails lift` y accedemos a http://localhost:1337/message.

Y... ¡Oops! Nos muestra una página en blanco con unos corchetes. Eso es porque no tenemos ningún mensaje, así que creemos alguno.

Para probarlo puedes utilizar algún plugin para el navegador que uses. Por ejemplo RESTClient o RESTConsole. Estos plugins permitirán probar las API sin necesidad de implementarlas.

![](/images/2014/Aug/enviando-un-mensaje.png)

Enviaremos una petición POST a la ruta antes mencionada que tenga como contenido el mensaje. En la respuesta veremos que el servidor nos devuelve el mensaje creado, y si volvemos a http://localhost:1337/message veremos que el mensaje aparece.

¿Habéis visto qué sencillo? ¡Y **aún no hemos tenido que tocar el código** para nada! El único problema es que no existen limitaciones de ningún tipo, por lo que si enviamos más parámetros aparte de `content`, Sails los guardará en el modelo. Es ahora cuando tenemos que ir al código para definir las reglas. Pero eso lo detallaremos más adelante, en otro artículo ;)


## Realtime
Sails.js implementa la API a través de socket.io, por lo que nos podemos suscribir a diversas rutas. Cuando alguien haga un cambio de la base de datos, automáticamente **se enviarán los nuevos datos a todos los clientes conectados**.

Para esto Sails implementa los métodos get, post, put y delete sobre Socket.io. Para poder usar esto necesitamos incluir un archivo en nuestro HTML, que se encuentra en la ruta `/js/dependencies/sails.io.js`, dentro del directorio assets. Este es el directorio que mostrará como público y en el que estarán todos los archivos del cliente.

Vamos a crear una página simple en la que mostrar el ejemplo. Pero antes de nada vamos a definir una ruta en la que mostraremos el ejemplo. Para ello abrimos el archivo `/config/routes.js` y añadimos:
```js
{
    ...
    '/': {
        view: 'homepage'
    },

    '/app': {
        view: 'app'
    },
    ...
}
```
En este archivo podremos configurar nuestras propias rutas. lo que hacemos es asignar a la ruta `/app` una vista llamada `app`. Ahora creamos esa vista. La guardaremos en `views/app.ejs`. Sails viene con el sistema de plantillas EJS, pero puede ser sustituido con facilidad por el de vuestra preferencia modificando la configuración.
```html
<!DOCTYPE html>
<html>
    <head>
        <title>Mensajes realtime</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <p>Envía un mensaje:</p>
        <input type="text" id="send" placeholder="Mensaje...">
        <button id="button">Enviar</button>

        <ul id="mensajes"></ul>

        <script src="/js/dependencies/sails.io.js"></script>
        <script>
            var mensajes = document.querySelector('#mensajes');
            var button = document.querySelector('#button');
            var input = document.querySelector('#send');

            function addMessage(content) {
            mensajes.innerHTML = '<li>' + content + '</li>' + mensajes.innerHTML;
            }

            io.socket.get('/message', function(data, response) {
            data.forEach(function(value) {
                addMessage(value.content);
            });
            });

            button.addEventListener('click', function(e) {
            var data = {
                content: input.value
            }
            io.socket.post('/message', data, function(data, response) {
                input.value = null;
            });
            });

            io.socket.on('message', function(response){
            if (response.verb === 'created') {
                addMessage(response.data.content);
            }
            });
        </script>
    </body>
</html>
```
Con esto ya tenemos nuestra pequeña aplicación.

Inicialmente recogemos algunos elementos del DOM necesarios y creamos una función que agrega los mensajes a una lista:
```js
var mensajes = document.querySelector('#mensajes');
var button = document.querySelector('#button');
var input = document.querySelector('#send');

function addMessage(content) {
    mensajes.innerHTML = '<li>' + content + '</li>' + mensajes.innerHTML;
}
```

Obtenemos todos los mensajes y los mostramos:
```js
io.socket.get('/message', function(data, response) {
    data.forEach(function(value) {
        addMessage(value.content);
    });
});
```

Enviamos nuestro mensaje cuando hagamos click en el botón de enviar:
```js
button.addEventListener('click', function(e) {
    var data = {
        content: input.value
    }
    io.socket.post('/message', data, function(data, response) {
        input.value = null;
    });
});
```

Y nos suscribimos al socket de mensajes para que cada vez que se introduzca un mensaje nuevo nos lo notifique:
```js
io.socket.on('message', function(response){
    if (response.verb === 'created') {
        addMessage(response.data.content);
    }
});
```

¡Y listo! Cada vez que enviemos un mensaje a través de `io.socket.post()` se notificará a todos los clientes conectados, y se ejecutará el callback que hemos pasado a `io.socket.on()`. En la respuesta se indicará el verbo utilizado. En este caso solo queremos mostrar los mensajes creados, pero también podríamos hacer que se pudiesen actualizar y eliminar mensajes. Para hacerlo tenemos `io.socket.put()` y `io.socket.delete()`.

Ahora, tan solo abre dos navegadores y disfruta. Y lo mejor de todo es que hacer esto no toma más que unos minutos.

***

Ya hemos visto lo sencillo que puede ser trabajar con Sails. Por supuesto, como todo framework, para dominarlo hay que practicar. Más adelante publicaré algún artículo más detallado. Pero si Sails te interesa puedes [acceder a la documentación](http://sailsjs.org/#/documentation/) ya mismo.

Y cuando lo hayas hecho, envíame un tweet a [@nuzkito](https://twitter.com/nuzkito) o deja un comentario y cuéntame qué te ha parecido o qué proyectos estás haciendo con Sails.
