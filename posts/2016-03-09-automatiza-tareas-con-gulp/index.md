---
layout: post.njk
title: Automatiza tareas con Gulp y aprovecha mejor tu tiempo
permalink: automatiza-tareas-con-gulp/
date_published: 2016-03-09T19:05:26.000Z
date_updated: 2016-03-09T19:05:26.000Z
tags: JavaScript
---

Muchas de las tareas que tenemos que hacer como desarrolladores son repetitivas. Compilar Stylus, refrescar el navegador al hacer un cambio, comprimir los archivos js y css... [Gulp](http://gulpjs.com) nos permite automatizar todas esas tareas para poder aprovechar el tiempo en actividades más productivas. [El tiempo es el activo más valioso](http://miguelnieva.com/el-tiempo-es-el-activo-mas-valioso/), y cuantas más tareas podamos automatizar, más tiempo podremos enfocarnos en cosas importantes.

## ¿Para qué sirve y cómo funciona Gulp?
Gulp sirve para automatizar tareas. Mediante Gulp se define cómo deben ejecutarse esas tareas, y únicamente ejecutamos un comando en la terminal para que se encargue de hacer todo el trabajo por nosotros.

Con Gulp podemos coger uno o varios archivos, tratarlos y guardar el resultado en un nuevo archivo; podemos iniciar el servidor de desarrollo; podemos ejecutar los tests de nuestra aplicación; etc.

Para hacer todo esto nos permite definir tareas (`tasks`) en las que definimos la lógica de cada cosa que queramos automatizar.

## Instalación
Gulp funciona bajo [Node.js](http://nodejs.org/). Para instalarlo, abre una terminal y ejecuta:
```language-bash
npm install -g gulp
```
Esto instalará Gulp de forma global en el equipo.
Ahora hay que instalarlo de forma local en el directorio de tu proyecto:
```language-bash
npm install --save-dev gulp
```

Por último, crea un archivo llamado `gulpfile.js` en el directorio raíz de tu proyecto, y por el momento, incluye el siguiente contenido:
```language-javascript
var gulp = require('gulp');

gulp.task('default', function() {
  console.log('gulp!');
});
```

Si ahora vas a la terminal y ejecutas `gulp`, aparecerá algo como lo siguiente:
```language-bash
[20:40:29] Using gulpfile ~/Escritorio/tutorial-gulp/gulpfile.js
[20:40:29] Starting 'default'...
gulp!
[20:40:29] Finished 'default' after 55 μs
```

¡Listo! Ya sabes cómo instalar Gulp :)

## Primeros pasos
Cada tarea se define usando el método `task`:
```language-javascript
var gulp = require('gulp');

gulp.task('default', function() {
  console.log('gulp!');
});

gulp.task('hola', function() {
  console.log('Hola!');
});
```
A ese método le pasamos como primer parámetro el nombre de la tarea, y como segundo, una función. Si nos vamos a la terminal, podremos ejecutar cada tarea poniendo `gulp` + el nombre de la tarea:
```language-bash
gulp hola
```
La tarea `default` es la que se ejecutará por defecto, cuando tan solo pongamos `gulp`.

### Plugins
Existen multitud de plugins para hacer tareas con Gulp. Para poder usarlos, antes debemos instalarlos. En el [sitio web de Gulp](http://gulpjs.com/plugins/) puedes buscar entre los plugins existentes. Los plugins están en npm, por lo que se instalan igual que cualquier otro paquete, con `npm install`.

Si no sabes cómo funciona un plugin, busca en su documentación. En ocasiones puede ser que el plugin únicamente haga de conector a la librería que hace todo el trabajo, por lo que en ese caso la documentación de la librería suele ser suficiente (a los plugins únicamente se les suele pasar un objeto con la configuración).

### Abrir, modificar y guardar archivos
Para poder realizar operaciones sobre archivos, antes debemos decir a Gulp dónde se encuentran. Esto lo hacemos con el método `src()`, indicando la ruta o un array con las rutas de todos los archivos que queramos.

```language-javascript
gulp.src('src/css/estilos.css')
```

Podemos hacer modificaciones sobre el contenido de esos archivos mediante el método `pipe()`. Usando este método decimos a Gulp qué queremos hacer sobre los archivos. Si usamos plugins, tan solo tenemos que pasárselo como parámetro.

```language-javascript
gulp.src('src/css/estilos.css')
  .pipe(minify())
```

Y con el método `dest()` indicamos dónde queremos guardar el archivo.
```language-javascript
gulp.src('src/css/estilos.css')
  .pipe(minify())
  .pipe(gulp.dest('css/'));
```
Este método acepta como parámetro una ruta válida en el sistema, y guardará el archivo con el mismo nombre. En caso de que ya exista un archivo con ese nombre, lo sobreescribirá.

Cabe destacar que Gulp no hace las operaciones directamente sobre el archivo, sino que carga el archivo en memoria y debemos indicarlo cuándo y dónde queremos guardar los cambios.

### Renombrar archivos
Gulp no trae incorporado ningún método para cambiar el nombre del archivo, pero podemos instalar un plugin para ello:
```language-bash
npm install --save-dev gulp-rename
```
A este plugin le indicamos el nuevo nombre del archivo, y después lo guardamos en la ruta que queramos con `gulp.dest()`.
```language-javascript
gulp.task('css', function() {
  gulp.src('estilos.css')
    .pipe(minify())
    .pipe(rename('estilos.min.css'))
    .pipe(gulp.dest('.'));
});
```
Cada vez que ejecutemos `gulp css` se comprimirá el contenido del archivo CSS, modificaremos su nombre y lo guardaremos en el mismo directorio.

### Observar cambios en los archivos
A veces queremos hacer operaciones cada vez que modifiquemos un archivo. Para observar cuándo un archivo es modificado usamos el método `watch`.

Siguiendo el anterior ejemplo con el archivo CSS, podemos querer que nuestro archivo se comprima cada vez que guardamos los cambios.

```language-javascript
gulp.task('watch', function () {
  gulp.watch('estilos.css', ['css']);
});
```

Como primer parámetro recibe el nombre del archivo a observar, y como segundo un array con las tareas que debe ejecutar cuando haya cambios. Si queremos observar varios archivos, podemos usar el asterisco `*` como comodín:

```
*.css -> Todos los archivos CSS del directorio
*.js -> Todos los archivos JS del directorio
* -> Todos los archivos del directorio
css/*.css -> Todos los archivos CSS del directorio css/
**/*.css -> Todos los archivos CSS, incluyendo los subdirectorios
```

### Encadenar tareas
Podemos indicar que, al ejecutar una tarea, se ejecute otra antes. Por ejemplo, que la tarea que comprime el CSS antes ejecute Stylus. Para ello tenemos que pasar un array con el nombre de las tareas como segundo parámetro al método `task`.

```language-javascript
gulp.task('css', ['stylus'], function() {
  gulp.src('estilos.css')
    .pipe(minify())
    .pipe(rename('estilos.min.css'))
    .pipe(gulp.dest('.'));
});
```
Ahora, al hacer `gulp css` también se ejecutará la tarea `stylus`.

## Otros usos de Gulp
Ahora que ya sabes cómo usar Gulp, mostraré varios ejemplos para que veas qué se puede hacer con él.

Ejecutar las tareas por sí solas no suele tener ninguna ventaja pues podemos ejecutar otro comando que haga lo mismo. Lo realmente interesante viene cuando juntamos varias tareas y hacemos un montón de cosas a la vez.

Iré actualizando esta lista poco a poco.

### Iniciar un servidor local
El archivo `gulpfile.js` no deja de ser un archivo Javascript que se ejecuta con Node.js. Gracias a ello podemos usar módulos del mismo, como `child_process`, que nos permitirá ejecutar comandos.

Crearemos un servidor que se reinicia automáticamente cuando se hace un cambio en el código.
```language-javascript
var gulp = require('gulp');
var childProcess = require('child_process');
var exec = childProcess.exec;
var spawn = childProcess.spawn;

var server;

function createServer() {
  return spawn('node', ['./app/index.js'], {stdio: "inherit", cwd: process.cwd() });
}

gulp.task('server', function () {
  server = createServer();
});

gulp.task('default', ['server'], function () {
  gulp.watch('app/**/*.js', function () {
    if (server) { server.kill(); }
    server = createServer();
  });
});
```
Simple. Tenemos una función que inicia una aplicación creada en Node.js. Cuando ejecutamos Gulp se inicia el servidor, y además indicamos que observe los cambios de todos los archivos `.js` de la aplicación. Cuando haya un cambio en esos archivos, cerramos la aplicación y la iniciamos de nuevo.

También podemos crear servidores para otros lenguajes, como PHP:
```language-javascript
// Aplicaciones en PHP
gulp.task('serve-php', function () {
  exec('php -S 0.0.0.0:8000');
});

// Aplicaciones en Laravel
gulp.task('serve-laravel', function () {
  exec('php artisan serve --host=0.0.0.0 --port=8000');
});
```
En este caso es más simple porque no hace falta reiniciar nada :P, solo ejecutar el comando la primera vez.


## Contenido adicional
* [gulpjs.com](http://gulpjs.com/) - Web del proyecto
* [Building With Gulp](http://www.smashingmagazine.com/2014/06/11/building-with-gulp/)
* [Automatizando tu flujo de trabajo en el Frontend con GulpJS](http://carlosazaustre.es/blog/automatizando-tu-flujo-de-trabajo-en-el-frontend-con-gulpjs/)
* [Gulp.js en español – tutorial básico y primeros pasos](http://frontend-labs.com/1669--gulp-js-en-espanol-tutorial-basico-primeros-pasos-y-ejemplos)
