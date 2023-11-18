---
layout: post.njk
title: Crea PDF en el servidor con Chrome
permalink: crea-pdf-en-el-servidor-con-chrome/
date_published: 2017-07-09T13:52:45.000Z
date_updated: 2017-07-09T13:53:42.000Z
---

Odio PDF. Me parece un formato horrible. Es pesado, no se adapta bien a cualquier pantalla, y hasta hace poco necesitabas un programa adicional para poder abrirlos (hoy en día los navegadores web incluyen mecanismos para visualizar archivos PDF). Pero a la gente le encanta. Así que, como desarrollador, a veces tengo que generar documentos en PDF.

Trabajo creando aplicaciones web, por lo que lo normal es que los usuarios de las aplicaciones en las que trabajo utilicen un navegador web. Prácticamente todos los navegadores que conozco tienen un mecanismo para generar un PDF de la web. De hecho una parte de la especificación de CSS está dedicada a estilos de impresión, que son los que se aplican cuando se genera un PDF.

Por ese motivo siempre he estado a favor de utilizar la función propia de los navegadores para generar un PDF. El navegador se encarga de generar el PDF. El desarrollador únicamente tiene que añadir los estilos de impresión.

El problema es que, en ocasiones, hay que enviar un PDF por correo, o guardar una copia, o lo que sea. Vamos, que por el motivo que sea hay que generar el PDF en el servidor antes de enviárselo al usuario. En estos casos utilizo Wkhtmltopdf, una librería que permite generar PDF usando HTML y CSS. Funciona bastante bien y es la alternativa más rápida que he encontrado. Además es gratis :P. Sin embargo tiene algún problema que hace que no me convezca del todo. Entre otras cosas, la versión de Webkit que implementa es algo antigua, por lo que no es posible utilizar nuevas características de CSS.

Hace poco salió la versión 59 de Chrome. En esta versión implementan un modo al que han llamado "headless". A grandes rasgos, es para ejecutar Chrome sin necesidad de una interfaz gráfica. Es decir, que se puede ejecutar Chrome en un servidor. Bueno, realmente ya se podía antes, pero había que hacer un poco de "magia oscura".

La cosa es que Chrome puede generar un PDF de una página HTML, y ahora Chrome se puede ejecutar en un servidor de forma sencilla, así que, ¿por qué no generar los PDF en el servidor con Chrome? Es posible con tan sólo un comando:

```bash
google-chrome --headless --disable-gpu --print-to-pdf=result.pdf http://google.es
```

- `google-chrome` es... bueno, el binario. Dependiendo del sistema y del navegador tendrás que poner el nombre o ruta correcta.
- `--headless` es para indicar que se ejecute sin interfaz gráfica.
- `--disable-gpu`, como su nombre indica, es para desactivar el uso de la GPU. Realmente no sé si es necesario, yo lo copié de la web de Google en la que hablan de esto. Pero tiene sentido, un servidor no suele necesitar GPU.
- `--print-to-pdf` sirve para indicar que genere un PDF. Se le puede pasar la ruta en la que queremos que se genere el PDF.
- Y en el último argumento, la url de la página que queremos pasar a PDF.

Lo bueno es que le podemos pasar cualquier url válida. Si queremos convertir a PDF un archivo HTML que tenemos en nuestro sistema, tan sólo hay que usar el protocolo `file://` e indicar la ruta al HTML:

```bash
google-chrome --headless --disable-gpu --print-to-pdf=result.pdf file:///var/www/factura.html
```

E igualmente podemos usar `data:` y pasarle directamente una cadena con el HTML:

```bash
google-chrome --headless --disable-gpu --print-to-pdf=result.pdf data:text/html,<h1>Hello World!</h1>
```

Esto funciona en Linux y Mac desde la versión 59 de Chrome. En Windows lo implementan en la versión 60. Además funciona tanto en la versión oficial de Chrome, como en las versiones Canary y Chromium. En estos dos últimos casos tendrás que usar el binario correspondiente.

## Genera los PDF usando PHP
Actualmente, en mi día a día trabajo con PHP. Por ese motivo he decidido crear un pequeño componente que abstraiga los comandos a ejecutar, para que sea un poco más sencillo de utilizar.

Puedes instalarlo con Composer:
```bash
composer require nuzkito/chrome-html-to-pdf
```

Este es el código mínimo necesario para generar un PDF:
```php
<?php

use Nuzkito\ChromePdf\ChromePdf;

$pdf = new ChromePdf();
$pdf->output('result.pdf');
$pdf->generateFromHtml('<h1>Hello world!</h1>');
```

Puedes ver el resto de la documentación en [el repositorio de GitHub](https://github.com/nuzkito/chrome-pdf-php).
