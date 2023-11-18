---
layout: post.njk
title: "Tutorial de Stylus: No temas a la terminal"
permalink: tutorial-de-stylus-no-temas-a-la-terminal/
date_published: 2014-08-26T15:08:01.000Z
date_updated: 2018-08-19T04:15:37.000Z
tags:
- Stylus
- Tutorial
- CSS
---

En el anterior artículo hablé sobre [qué es un preprocesador de CSS](/que-es-un-preprocesador-de-css/). Si no tienes claro qué es o por qué es bueno usarlos **léelo antes**.

Este artículo será el primero de una serie de artículos sobre Stylus. Trataré de explicarlo todo partiendo de lo básico, y avanzando hasta que puedas ser un experto en Stylus. Pero si no quieres esperar [puedes revisar ya mismo la documentación](http://learnboost.github.io/stylus/).

Antes de comenzar haré un apunte: **Stylus NO se instala en el servidor**. Stylus genera un archivo CSS. Ese archivo generado es el que debéis subir al servidor. Es una duda que tiene mucha gente al comenzar con preprocesadores, por lo que es importante tenerlo claro desde el principio.

## Sintaxis de Stylus
Lo primero que debes saber sobre Stylus es cómo es su Sintaxis. En Stylus **se pueden omitir** las *llaves* `{}`, los *dos puntos* `:` y los *punto y coma* `;`. Stylus se encargará por nosotros de ponerlos en el CSS final.

Como no se usan llaves, **la forma de indentificar las propiedades que van con cada selector es mediante el sangrado o *indentación***. Lo normal es dejar 4 espacios de separación con el margen.

Si tenemos el siguiente código en CSS
```css
body {
    color: #111;
}
```
en Stylus sería así:
```stylus
body
    color #111
```

Esto simplifica el código, y nos puede evitar errores al escribir el código, como olvidar cerrar una llave o poner un punto y coma.

## Instalación
Stylus está construido sobre [Node.js](http://nodejs.org/), por lo que para instalar Stylus antes necesitamos instalar Node en nuestra máquina. Desde [su sitio web](http://nodejs.org/) puedes descargar el paquete e instalarlo. Si estás en Linux te recomiendo instalarlo desde un repositorio:
```bash
sudo add-apt-repository ppa:chris-lea/node.js
sudo apt-get update
sudo apt-get install nodejs npm
```

Para comprobar que Node.js se instaló correctamente pon en la terminal `node -v`.

Una vez instalado Node.js, usaremos el gestor de paquetes de Node.js para instalar el paquete de Stylus. Este gestor es [npm](https://www.npmjs.org/) (Node Package Manager). Para instalar Stylus con este gestor ejecutamos en la terminal lo siguiente:
```bash
npm install -g stylus
```

> Para instalar paquetes de forma global necesitas permisos de administrador. Por eso debes poner *sudo* o lo equivalente en tu sistema operativo.  
En Windows debes ejecutar la consola con permisos de administrador.

Ahora solo esperamos a que se descarguen todos los archivos y listo. Con `-g` le decimos a npm que instale Stylus de forma global en el equipo. Es decir, será accesible desde cualquier directorio de nuestra máquina.

También podemos instalar Stylus de forma local para un solo proyecto si omitimos el `-g`. Esto es algo que recomiendo si trabajáis en proyectos con otras personas. De esta forma nos aseguramos que todas las personas del equipo trabajen con la misma versión de Stylus.

Te recomiendo investigar un poco sobre Node.js y Npm para saber cómo funcionan y poder aprovecharlo mejor.

Para comprobar que Stylus se ha instalado correctamente tan solo ejecuta `stylus -V`. Esto debería decirte la versión. Al momento de escribir este artículo es la `0.48.1`.

Si en el futuro quieres actualizar Stylus a la última versión debes ejecutar `sudo npm update -g stylus`.

## Stylus desde la terminal
>La terminal no debe darte miedo. Es tu amiga. Solo intenta ponerte las cosas más fácil.

Terminal, consola, línea de comandos... llámala como quieras. Saber usar la terminal es importante. Stylus viene con varias funciones ejecutables desde la terminal para convertir Stylus a CSS.

Para ver todas las funciones, y una ayuda de las mismas, podemos ejecutar `stylus --help`. Mostraré a continuación cómo usar las opciones más comunes.

Para las pruebas, crea un archivo llamado `estilos.styl` con el siguiente contenido:
```stylus
body
    font-family Arial
    font-size 16px
    color #111

.header
    background-color #333

    .title
        color #fff
```

### Convertir de Stylus a CSS
Para convertir un archivo de Stylus a CSS tan solo hace falta poner `stylus estilos.styl`. En la terminal nos aparecerá un mensaje como el siguiente:
```bash
compiled estilos.css
```
En este caso, el archivo se ha procesado correctamente. Y si observamos el directorio veremos que se ha creado un archivo `estilos.css`, que debe tener el siguiente contenido:
```css
body {
    font-family: Arial;
    font-size: 16px;
    color: #111;
}
.header {
    background-color: #333;
}
.header .title {
    color: #fff;
}
```

**Si hay algún error, Stylus nos avisará** e intentará decirnos la línea del error y otros datos para debug. Cometamos un error a propósito para comprobarlo, por ejemplo poniendo un menos delante de un color. Nos devolverá esto:
```bash
/usr/lib/node_modules/stylus/bin/stylus:644
              throw err;
                    ^
Error: estilos.styl:7:23
    3|     font-size 16px
    4|     color #111
    5| 
    6| .header
    7|     background-color -#333
----------------------------^
    8| 
    9|     .title
   10|         color #fff

...
```
Como veis, **Stylus nos tratará de ayudar a encontrar el error**.

También podemos querer guardar el archivo en un directorio diferente. Podemos usar `--out` o `-o`. Si queremos guardar nuestro archivo en el directorio `css/` pondremos lo siguiente:
```bash
stylus estilos.styl --out css/
```
> ***Nota:***  
> El directorio `css/` debe estar creado. Si no, fallará.

También podemos hacer lo siguiente:
```bash
stylus < estilos.styl > css/app.css
```
Después de `<` ponemos el archivo de stylus. Tras el `>` indicamos la ruta y el nombre del archivo css.


### Compresión
Stylus puede comprimir en una sola línea todo el código CSS resultante con la opción `--compress` o `-c`:
```bash
stylus -c estilos.css
```
El resultado será el siguiente:
```css
body{font-family:Arial;font-size:16px;color:#111}.header{background-color:#333;}.header .title{color:#fff}
```
Gracias a la compresión el archivo pesará algo menos y tardará menos en descargarse en el navegador del usuario. Es una buena práctica que el CSS que sirváis a los navegadores esté comprimido.

### Convertir automáticamente cuando haya cambios
Tenemos el inconveniente de que cada vez que hagamos un cambio tendremos que ejecutar nuevamente Stylus para convertir los archivos a CSS. Para solventar esto podemos decirle a Stylus que se mantenga *escuchando* al archivo seleccionado para que se ejecute automáticamente cuando hagamos un cambio. Lo podemos hacer con la opción `--watch` o `-w`:
```bash
stylus -w estilos.styl
```
Ahora solo tenemos que dejar la terminal abierta y comenzar a trabajar con el archivo. En cuanto guardemos, el CSS se actualizará.


### Convertir CSS a Stylus
Puede que estés comenzando con Stylus pero en tu proyecto ya tengas creado el CSS y quieras convertirlo. Stylus incorpora una utilidad para poder hacerlo de forma sencilla:
```bash
stylus -css archivo.css
```
En lugar de indicarle un archivo con estensión `.styl`, le indicamos un `.css`. Esto nos generará el archivo `.styl` con la sintaxis de Stylus.

Sin embargo, aunque usemos esta opción tendremos que editar el archivo a mano si queremos comenzar a añadir variables, funciones, etc. Mi recomendación es crear los nuevos proyectos con Stylus desde cero. Si ya tienes un proyecto antiguo con CSS, continúa con ello, o aprovecha un rediseño para hacer el cambio a Stylus.

### Plugins
Existen algunos plugins que implementan características adicionales a Stylus. Uno de ellos es Nib. Este plugin es una librería de mixins que pondrá los prefijos necesarios para las propiedades de CSS que lo necesiten. Hablaremos de él más tarde.

Para importar esos plugins tendremos que incluir en nuestro archivo de Stylus la sentencia `@import`.

Para usar plugins como Nib, debemos indicar en la consola que estamos usando el plugin:
```bash
stylus estilos.styl --use nib
```
Y debemos importarlo en nuestro archivo de Stylus `estilos.styl`:
```css
@import 'nib'

/* Código de Stylus */
```


## Stylus y Gulp
[Gulp](http://gulpjs.com/) es una utilidad que **nos pemite automatizar tareas** y ejecutarlas en cola. Podemos configurar Gulp para mantener ejecutado Stylus, levantar un servidor y actualizar el navegador cada vez que hagamos cambios en nuestros archivos. Es muy útil. Solo tenemos que configurarlo una vez y no necesitamos saber qué comando ejecutar en cada proyecto. Porque cada proyecto puede tener rutas distintas o usar diferentes plugins. Esta es una forma eficaz de organizar los ejecutables de nuestro proyecto.

En lugar de Gulp puedes usar [Grunt](http://gruntjs.com/). Ambos hacen lo mismo, solo que tienen una forma diferente de trabajar.

Trataré el tema de Gulp en un artículo aparte de este tutorial.


## Programas con interfaz gráfica para Stylus
Si te sientes más a gusto utilizando aplicaciones con interfaz gráfica, hay algunas que pueden procesar archivos de Stylus:

* [Codekit](https://incident57.com/codekit/) - Mac
* [Prepros](http://alphapixels.com/prepros/) - Windows y Mac
* [Mixture](http://mixture.io/) - Windows y Mac
* [SiteFlow](http://siteflow.witiz.com/) - Mac

Todas estas aplicaciones incorporan varios preprocesadores. Stylus es uno de ellos, pero también se puede usar con Less o Sass, u otros preprocesadores de HTML (Jade, Haml) o Javascript (Coffescript), además de múltiples funcionalidades interesantes, como compresión o detección de errores.

Lo que se puede hacer con ellos es similar a lo que se podría con Gulp o Grunt, solo que bajo una interfaz gráfica. Lo único que hay que hacer es decirle el directorio de nuestro proyecto y configurar la aplicación.

***

En el siguiente artículo verás [la sintaxis, anidación, comentarios, variables y operadores de Stylus](/tutorial-de-stylus-sintaxis-anidacion-comentarios-variables-y-operadores/). Puedes dejar un comentario contando qué te ha parecido hasta ahora. Tu *feedback* es importante.
