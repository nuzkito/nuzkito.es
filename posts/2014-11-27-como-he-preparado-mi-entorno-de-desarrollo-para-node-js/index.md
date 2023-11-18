---
layout: post.njk
title: Cómo he preparado mi entorno de desarrollo para Node.js
permalink: como-he-preparado-mi-entorno-de-desarrollo-para-node-js/
date_published: 2014-11-27T16:25:35.000Z
date_updated: 2014-11-27T16:25:35.000Z
tags: Nodejs
---

Llegamos a un punto en el que cuando estamos desarrollando comenzamos a automatizar tareas repetitivas, como ejecutar un preprocesador de CSS cuando hacemos algún cambio, actualizar el navegador automáticamente, iniciar el servidor local, minificar los archivos estáticos, etc.

Puestos a automatizar, me gustaría automatizar lo máximo posible. Explicaré un poco lo que hago yo. Y también quisiera saber cómo lo hacéis vosotros.

## Máquina virtual
Uso [una máquina virtual con Vagrant](https://www.vagrantup.com/), que tiene instalado el mismo entorno que en el servidor. Nodejs, Nginx, MySQL, MongoDB, Redis... Es una forma de asegurarse de que la aplicación va a funcionar bien en el servidor una vez pase a producción. También es útil cuando se trabaja en equipo, evitando el "en mi máquina no funciona". Todos tendrían el mismo entorno en sus equipos.

Sin embargo, se hace un poco tedioso encender la máquina virtual, acceder a ella y ejecutar la aplicación. Para encenderla de forma automática me hice un simple script sh:
```language-bash
#!/bin/bash

cd ~/Vagrant/Nodejs
vagrant up

exit
```
Muy sencillito. Tan solo accede al directorio de configuración de la máquina y ejecuta el comando para iniciarla. Ese script lo podéis dejar en el escritorio para tenerlo a mano o iniciarlo automáticamente cada vez que encendáis el ordenador.

Al iniciar la máquina virtual también se inicia la aplicación, exactamente igual que si estuviese en el servidor. Para ello uso pm2.

## pm2
[pm2](https://github.com/Unitech/PM2) nos permite mantener las aplicaciones en ejecución. Si se rompe la aplicación, la levanta de nuevo. Permite usar clusters. Está bastante interesante. Lo podemos instalar con npm
```
npm install -g pm2
```
Pero cuando estamos desarrollando queremos al menos que pasen 2 cosas:

* Al hacer un cambio en nuestros archivos, la aplicación debe reiniciarse.
* Poder hacer debug.

Eso lo podemos configurar el iniciar la aplicación con pm2:
```
PORT=3100 pm2 start --node-args="--debug=4100" server.js --watch
```
Indicamos el puerto de la app, le pasamos el argumento de *--debug* con el puerto en el que queremos hacer debug, y añadimos la opción *--watch* para que observe los cambios y reinicie el servidor.

Ahora si iniciamos `node-inspector` podremos acceder sin problemas usando el puerto que hemos indicado.

Para poder ver los logs en la terminal, se puede usar `pm2 logs`. Eso empezará a mostrar todos los logs de las aplicaciones iniciadas con pm2. También se puede usar el paquete `pm2-web` (`npm install -g pm2-web`), que permite ver en el navegador información del estado del servidor(o en este caso la máquina virtual) y las aplicaciones iniciadas. Entre otras cosas nos muestra el consumo de memoria o el log.

## Gulp
Antes usaba [Gulp](http://gulpjs.com/) para todo, incluyendo iniciar el servidor y cualquier otra dependencia. Pero desde que comencé a usar una máquina virtual prefiero delegar todo eso en la propia máquina virtual. Y así me evito instalar MySQL, Redis y todo lo demás en mi equipo, con la ventaja de que si un día cambio de equipo, solo tengo que copiar la máquina virtual al nuevo y listo.

Con Gulp hago las tareas típicas como ejecutar Stylus, minificar assets o livereload. Aunque igualmente se podría hacer la parte de iniciar el servidor, y reiniciarlo cuando haya cambios, pero lo dicho antes, la idea era tener el mismo entorno en local y en el servidor, o lo más similar posible.

## ¿Y cómo trabajáis vosotros?
Este artículo no es para que lo hagáis como yo, sino para mostrar cómo lo hago y para que me contéis cómo lo hacéis vosotros. He estado haciendo varias pruebas durante esta semana y esto es lo que más me gustó, pero no quiere decir que sea lo correcto. Son solo pruebas ;). Me gustaría saber vuestra opinión. Podéis dejar un comentario o escribirme a [@nuzkito](https://twitter.com/nuzkito).
