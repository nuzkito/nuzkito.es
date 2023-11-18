---
layout: post.njk
title: Actualiza el navegador al guardar cambios con Browser Sync
permalink: actualiza-el-navegador-al-guardar-cambios-con-browser-sync/
date_published: 2015-02-15T14:24:52.000Z
date_updated: 2015-02-15T14:30:51.000Z
tags: Herramientas
---

Una de las tareas más pesadas cuando estamos desarrollando es actualizar el navegador cada vez que hacemos un cambio en el código. Por suerte, se crearon herramientas como [LiveReload](http://livereload.com/) que nos **actualizan el navegador automáticamente**. Sin embargo, la herramienta que más me ha llamado la atención ha sido [BrowserSync](http://www.browsersync.io/).

BrowserSync, además de actualizar el navegador automáticamente, también **sincroniza el scroll y los clicks en todos los navegadores conectados**, permitiendo sincronizar los movimientos a través de la web en todos los dispositivos. Algo muy útil en el desarrollo y testeo.

<video style="width: 100%;" controls src="https://s3.amazonaws.com/quickcast/1290/76006/quickcast.webm"></video>

También tiene una interfaz gráfica que permite configurar la herramienta, consultar el historial, sincronizar todos los dispositivos en la misma página de la aplicación, herramientas para hacer debug, y simular una conexión lenta para comprobar cómo se comporta la aplicación en conexiones lentas.

## Instalación y uso
BrowserSync está hecho sobre [Node.js](http://nodejs.org/download/). Se puede instalar mediante NPM:
```language-bash
npm install -g browser-sync
```
Se puede ejecutar de dos modos distintos. En el caso de no estar trabajando con un servidor, BrowserSync podrá iniciar un servidor por nosotros en la ruta en la que nos encontremos.
```language-bash
cd directorio/del/proyecto
browser-sync start --server --file "css/*.css, *.html"
```
Los archivos que queramos que observe los indicamos con la opción `--file`.

Si ya tenemos un servidor creado, usaremos el comando con la opción `--proxy`:
```language-bash
browser-sync start --proxy "localhost:3000" --files "css/*.css"
```
Esto generará una nueva url en otro puerto en la que inyecta el JS necesario para que la página se actualice sola. Mientras que en localhost:3000 podemos ver la aplicación sin sincronizar, en localhost:3001 tendremos la versión que se sincroniza automáticamente. Y en localhost:3002 tendremos la interfaz gráfica.

Al ejecutar el comando se abrirá automáticamente una nueva pestaña en el navegador con la versión sincronizada, y también nos indicará la IP desde la que se puede acceder mediante otros dispositivos conectados a la red para que podamos hacer debug en múltiples dispositivos más fácilmente.

### Integración con Gulp o Grunt
BrowserSync también se puede integrar con otras herramientas. En la [documentación](http://www.browsersync.io/docs/) vienen ejemplos sobre cómo hacerlo.

En mi caso hago lo siguiente:
```language-javascript
var gulp = require('gulp');
var browserSync = require('browser-sync');
gulp.task('watch', function () {
  gulp.watch('src/stylus/**/*.styl', ['css', browserSync.reload]);
  gulp.watch('src/js/**/*.js', ['js', browserSync.reload]);
});
gulp.task('browser-sync', function() {
  browserSync({
    proxy: "http://localhost:2368"
  });
});
```
