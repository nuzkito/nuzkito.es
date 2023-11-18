---
layout: post.njk
title: SVG en línea como sustituto a las fuentes de iconos
permalink: svg-en-linea-como-sustituto-a-las-fuentes-de-iconos/
date_published: 2016-03-28T21:08:03.000Z
date_updated: 2016-03-28T21:08:03.000Z
tags: SVG
---

Hace algunos años, con la popularización de las fuentes externas, apareció una técnica para añadir iconos a las webs mediante la creación de fuentes de texto. Esas fuentes, en lugar de contener letras, contienen los iconos que se mostrarán en la web.

Sin embargo, el uso de fuentes de iconos tiene algunos inconvenientes para mí:

* Necesitas generar todos los formatos necesarios para que se muestren en todos los navegadores (aunque este problema desaparecerá pronto).
* Requieren cargar un fichero extra para poderlos usar.
* Los iconos son en realidad texto, por lo que se ven afectados por las mismas propiedades que afectan a los textos. Esto puede dar algún problema a la hora de alinear los iconos, por ejemplo.
* Al tener que cargar otro fichero para usar la fuente, si tarda en cargar no se mostrarán los iconos. También puede ocurrir que no se muestren por algún problema con algún navegador (mala configuración, falta el formato compatible con dicho navegador...).
* Sólo permiten un color.

La mejor alternativa que encontré fue usar SVG insertado en el propio HTML de la página. SVG es un lenguaje basado en XML, al igual que HTML, que se utiliza para crear imágenes en formato vectorial. Esto implica que **una imagen creada con SVG no se va a _pixelar_ al aumentar su tamaño**. Es un formato idóneo para nuestros iconos.

Podemos insertar SVG directamente en el navegador como si fuese HTML. Esto funcionará correctamente si el navegador lo soporta. Puedes [comprobar en Can I Use](http://caniuse.com/#feat=svg) que el soporte no es un problema actualmente.

El SVG que insertaremos en la página tendrá un formato parecido al siguiente:
```markup
<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <defs>
        <symbol id="icon-twitter" viewBox="0 0 24 28">
            <title>twitter</title>
            <path class="path1" d="..."></path>
        </symbol>
        <symbol id="icon-facebook" viewBox="0 0 24 28">
            <title>facebook</title>
            <path class="path1" d="..."></path>
        </symbol>
    </defs>
</svg>
```
Cada elemento `<symbol>` representa un icono. También es posible usar otros elementos como `<g>`, pero [_symbol_ tiene algunas ventajas](https://css-tricks.com/svg-symbol-good-choice-icons/). Desde cualquier otra parte de la web podemos hacer referencia a dichos iconos de la siguiente forma:
```markup
<svg class="icon icon-twitter">
    <use xlink:href="#icon-twitter"></use>
</svg>
```
En el _href_ se indica el valor del atributo _id_ que tiene la etiqueta _symbol_.

## Creación de los iconos en SVG
Para crear los iconos tienes varias opciones:

### Crear el SVG a mano
SVG es un lenguaje de etiquetas. Puedes crear los iconos con código sin ningún problema.

### Usar herramientas que exporten a SVG
Herramientas como Illustrator o Inkscape permiten trabajar con vectores y generar imágenes SVG. Si dominas estas herramientas puedes crear tus propios iconos rápidamente.

En este caso, antes tendrás que combinar los iconos en un fichero con el formato que muestro anteriormente. Existen plugins para [Gulp](https://github.com/w0rm/gulp-svgstore), [Grunt](https://github.com/FWeinb/grunt-svgstore) y [otras herramientas](https://github.com/search?q=svgstore) que te ayudarán con esta tarea.

### Generadores de iconos
Desde hace tiempo existen generadores de fuentes de iconos en los que puedes seleccionar los iconos que que quieres usar, y te generan la fuente ya preparada para su uso. Algunos de estos generadores también permiten exportar a SVG. [Icomoon](https://icomoon.io/) es la aplicación que uso.

Lo bueno de estos generadores es que ya te dan el código preparado para usar. Sólo tienes que copiar el SVG y el CSS correspondiente en la web.

## Contenido adicional
* Recomiendo leer el artículo [Icon System with SVG Sprites](https://css-tricks.com/svg-sprites-use-better-icon-fonts/), en el que explican algunos detalles adicionales que no comento en mi artículo.
* En [la web de Sara Soueidan](https://sarasoueidan.com/) puedes encontrar contenido interesante sobre SVG (en inglés).
* Si prefieres en español, puedes [seguir a Jorge Aznar](http://jorgeatgu.com/).
