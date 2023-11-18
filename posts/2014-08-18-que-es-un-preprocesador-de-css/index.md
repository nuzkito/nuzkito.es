---
layout: post.njk
title: ¿Qué es un preprocesador de CSS?
permalink: que-es-un-preprocesador-de-css/
date_published: 2014-08-18T17:04:18.000Z
date_updated: 2018-08-19T04:13:56.000Z
tags:
- Stylus
- CSS
---

Un preprocesador de CSS es una herramienta que **nos permite escribir pseudo-código CSS que luego será convertido a CSS** real. Ese pseudo-código se conforma de variables, condiciones, bucles o funciones. Podríamos decir que **tenemos un lenguaje de programación que genera CSS**.

El objetivo de estos preprocesadores es tener un código más **sencillo de mantener y editar**. Los preprocesadores incluyen características tales como variables, funciones, mixins, anidación o modularidad. Explicaremos todo ello más adelante.


## ¿Qué preprocesadores existen?
Actualmente existen muchos preprocesadores, aunque las características principales son comunes en casi todos. Los más populares son [Less](http://lesscss.org/) y [Sass](http://sass-lang.com/). [Stylus](http://learnboost.github.io/stylus/) también tiene bastante popularidad.

Existen otros muchos, menos conocidos. Uno bastante interesante es [Myth](http://www.myth.io/), que trata de seguir los estándares simulando las características de CSS que ya están en la especificación pero que aún no han sido adoptadas por los navegadores.


## Variables
Una de las principales características de los preprocesadores es que nos permiten tener **variables**. Gracias a las variables podemos **almacenar valores y reutilizarlos** en cualquier parte del código. Nos ahorrarán mucho trabajo cuando tengamos que editar un valor que se repite a lo largo de nuestro código.



## Funciones, mixins y *prefixing*

Gracias a las funciones y los mixins podemos **evitar escribir código duplicado**. También los podemos usar para evitar escribir continuamente los prefijos propietarios de cada navegador.

Por ejemplo, la propiedad box-sizing requiere los prefijos -moz y -webkit para funcionar en los correspondientes navegadores. Para evitar escribir continuamente esos prefijos podemos tener algo así:
```css
/* Cuidado, esto no es un ejemplo real */
mixin box-sizing(valor) {
    -webkit-box-sizing: valor;
    -moz-box-sizing: valor;
    box-sizing: valor;
}
```
Ahora al necesitar usar esta propiedad en nuestro código la usaríamos sin más:
```css
div {
    box-sizing: border-box;
}
```
O así, dependiendo del preprocesador
```css
div {
    box-sizing(border-box);
}
```
Y al preprocesar el código, el CSS resultante sería el siguiente:
```css
div {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
```
Esto, en un proyecto con mucho más código, nos **ayudará mucho a evitar la repetición de código**.

También podemos aprovechar las funciones para crear grillas, triángulos, u otras cosas posibles con CSS que necesitemos repetir en nuestro código.


## Modulariza el código
Muchos preprocesadores ofrecen la caracerística de importar archivos. En lugar de escribir todo en un CSS, o tener varios archivos CSS, tendremos **varios archivos *preprocesables* que serán unidos en uno solo** que recoge el CSS resultante.

Gracias a esto podremos modularizar nuestros archivos de una forma lógica y sencilla de mantener, teniendo distintos módulos para cada elemento de la web. Por ejemplo podemos tener un archivo en el que se definan los estilos de los botones, otro para los formularios, otro para el sistema de grillas, etc. E igualmente podríamos dividirlo por páginas creando un archivo para el home, otro para el blog, otro para la sección de contacto, y así sucesivamente.

Al hacer nuestro código de esa forma, encontrar lo que queremos modificar es mucho más sencillo. Si queremos cambiar el color de los botones, vamos al archivo de los botones y lo cambiamos. No perdemos tiempo en buscar dónde está el código de los botones en un achivo inmenso.


## Vale, me has convencido. Pero ahora, ¿qué preprocesador elijo?
Se dice que Less es el más simple y más sencillo de aprender, mientras que SASS y Stylus tienen funciones más avanzadas. Por otro lado, Less y Sass son los que tienen una mayor comunidad. Eso es bueno, porque siempre habrá documentación actualizada por la propia comunidad.

Yo creo que lo mejor es probar los tres, ver con cuál está más a gusto cada uno, y elegir ese. Yo uso Stylus por su sintaxis. Otros prefieren mantener la sintaxis clásica de CSS y no quieren funciones muy avanzadas, así que se conforman con Less.


## Cuidado: usar un preprocesador no te hace mejor
Para usar bien un preprocesador antes debes saber cómo funciona CSS. Los preprocesadores ayudan, pero **abusar de algunas de sus características puede resultar en un CSS poco óptimo**.

Una de las características de la que abusan mucho algunos desarrolladores es la anidación. La anidación permite anidar selectores y ahorrarse escribirlos enteros de nuevo. Por ejemplo
```css
div {
    p {
        ...
    }
}
```
da como resultado
```css
div {}
div p {}
```
Abusar de la anidación anidando muchos elementos puede resultar en selectores lentos, pesados y que además incrementan el peso del archivo.
```css
html {
    body {
        div {
            p {
                span {...}
            }
        }
    }
}
```
es igual a
```css
html {}
html body {}
html body div {}
html body div p {}
html body div p span {}
```
Si seguimos anidando cada vez habrá selectores más grandes. Lo cuál puede ser un problema si tenemos un proyecto grande con mucho código

Por estos detalles es conveniente conocer bien CSS. Un preprocesador no te hace mejor si no sabes si el CSS que produce es bueno.

***

Ampliaré todos los conceptos de los preprocesadores aplicados a Stylus en un tutorial que estoy preparando y que iré publicando poco a poco. Me centraré en Stylus porque es el preprocesador de CSS que más me gusta, y es el que uso. En él trataré de explicar a fondo las características de Stylus comenzando con lo básico, y avanzando hasta mostrar diversos ejemplos sobre cómo crear mixins complejos, o cómo modularizar los archivos.

Si te interesa, puedes seguirme en Twitter en [@nuzkito](https://twitter.com/nuzkito), donde iré anunciando los nuevos artículos.
