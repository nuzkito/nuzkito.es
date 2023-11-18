---
layout: post.njk
title: Gráficos circulares y animaciones de carga o progreso en puro CSS
permalink: graficos-circulares-y-animaciones-de-carga-o-progreso-en-puro-css/
date_published: 2014-07-28T16:25:17.000Z
date_updated: 2014-07-28T16:29:37.000Z
tags: CSS
---

Hace unos días vi un ejemplo de [Lea Verou](http://lea.verou.me/) en el que hacía un [gráfico circular animado con CSS](http://dabblet.com/gist/127de0e3bb8ae0bbb75b) de una forma muy sencilla. Usando pseudo-elementos, gradientes y formas se pueden crear gŕaficos simples o animaciones de carga para nuestros sitios web. Veamos cómo.

## Lógica del gráfico circular
En CSS, por ahora, no hay una propiedad que nos permita crear gráficos circulares de una forma sencilla, por lo que debemos ingeniarnosla para simularlo. Para simular el gráfico combinaremos el uso de semicírculos y animaciones.

Dos semicírculos del mismo color forman un círculo completo, el cual podemos considerar como un gráfico al 0%, o al 100%. Cuando giramos uno de los semicírculos, el gŕafico empieza a indicar 1%, 2%, 5%, 10%, etc., así hasta el 50%. Si seguimos girando, como la segunda mitad no se ha movido y sigue cambiando de color, el círculo se volverá a rellenar.

Para simular que el gráfico se completa del 0 al 100% haremos que el semicírculo, cuando haya dado media vuelta - es decir, el gráfico estará al 50% - haremos que vuelva a la posición inicial y cambie al color de fondo. Una vez haya hecho eso, seguimos girando el semicírculo.

## Código paso a paso
El código HTML necesario tan solo es una capa, a la que pondremos una clase:
```html
<div class="grafico-circular"></div>
```
El resto lo haremos con CSS.

Comencemos haciendo el círculo:
```css
.grafico-circular {
    background-color: #7fdbff;
    border-radius: 50%;
    overflow: hidden;
    height: 200px;
    width: 200px;
}
```
La propiedad overflow se aplica para evitar que las capas que conformarán los semicírculos provoquen scrolls indeseados.

Solo se moverá uno de los semicírculos, por lo que podemos simular una mitad haciendo uso de un gradiente. En este caso el color para la mitad izquierda del círculo será el del gráfico vacío, y la mitad derecha tendrá el color del gráfico lleno:
```css
.grafico-circular {
    background-image: linear-gradient(90deg, #7fdbff 50%, #0074d9 0);
}
```
Recuerden que el gradiente debe ir en la propiedad `background-image`, no en `background-color`. Suele ser un error bastante común.

Ahora haremos el semicírculo para tapar la segunda mitad. Aprovecharemos el pseudo-elemento `:before`:
```css
.grafico-circular:before {
    background-color: #7fdbff;
    content: '';
    display: block;
    margin-left: 50%;
    height: 200px;
    width: 100px;
}
```
No es más que un rectángulo que ocupa la mitad derecha del círculo. Hay algunos navegadores que muestran el rectángulo completo a pesar de haber puesto `overflow: hidden;`. Para corregir eso podemos usar `border-radius` y darle al rectángulo forma de semicírculo:
```css
.grafico-circular:before {
    border-radius: 0 100% 100% 0 / 50%;
}
```

Ya esta casi todo listo. Solo falta girar el semicírculo. Eso podemos hacerlo con la propiedad `transform`. Hay un pequeño problema, y es que al aplicar un giro a una capa, el centro de rotación se toma en el punto `x=0,y=0` de la capa, es decir, desde la esquina superior izquierda. Para solventar esto aplicaremos la propiedad transform-origin, que sirve para indicar el punto de origen de una transformación:
```css
.grafico-circular:before {
    transform-origin: left;
    transform: rotate(30deg);
}
```

Podemos ver que modificando el valor de rotación ya tenemos el gráfico listo. O al menos la primera mitad. Pasemos ahora a animarlo. Usaremos las animaciones para completar el giro.

Primero hagamos que el semicírculo rote. Antes mencioné que el semicírculo solo iba a hacer medio giro, y después cambiaría de color para volver a hacer otro medio giro y completar el círculo. Para eso haremos dos animaciones, una para cada cosa:
```css
@keyframes spin-rotate {
    to {
        transform: rotate(180deg);
    }
}

@keyframes spin-color {
    50% {
        background-color: #0074d9;
    }
}
```
Y ponemos la propiedad `animate` en el pseudo-elemento:
```css
.grafico-circular:before {
    animation: spin-rotate 3s linear infinite, spin-color 6s step-end infinite;
}
```
Como el semicírculo solo hace la mitad del giro, la animación de este debe durar la mitad que la animación del cambio de color. Por otro lado,el color debe cambiar de golpe, y no transicionar como sí hace el giro. Para eso añadimos `step-end`.

Y con esto, ¡*voilá*!, ya tenemos el gráfico circular hecho, con animación incluida. Modificando los valores de la animación podemos hacer que el gráfico se rellene hasta el punto que queramos y pararlo ahí. El problema de esta solución es que solo se pueden mostrar dos partes, pero puede usarse para mostrar, por ejemplo, un progreso, o como animación de carga.
***
Puede que algunos quieran que al dar una vuelta, la siguiente contunúe con el color contrario en lugar de empezar de nuevo. Para hacer eso modificaremos las animaciones.

El semicírculo sigue rotando de la misma forma, por lo que no tocaremos la rotación. La animación del color la modificaremos de la siguiente forma:
```css
@keyframes spin-color {
    25% {
        background-color: #0074d9;
    }
    75% {
        background-color: #7fdbff;
    }
}
```
Cada 25% equivale a media vuelta, es decir, el semicírculo hará medio giro y volverá a su posición inicial. En la primera media vuelta (0%-25%) el color será el que le hemos puesto a la capa por defecto, por lo que no hace falta indicarlo. Las segunda y tercera medias vueltas tiene que tener el segundo color. Y la última vuelve al color inicial. Ahora la animación equivale a dos vueltas, por lo que tenemos que multiplicar por 2 el tiempo de esta animación.

Aparte del semicírculo, también tenemos que modificar el color de fondo del círculo. El problema que hay ahora es que necesitamos invertir los colores una vez termine la primera vuelta.

Recordemos que lo hacíamos con un gradiente, que viene a ser una imagen generada con una función de CSS. En lugar de modificar el gradiente de nuevo, lo que haremos será simplemente mover el fondo:
```css
@keyframes bg-circle {
    50% {
        background-position: 100px 0;
    }
}
```
Lo que hacemos es simplemente mover el fondo a la derecha. Concretamente hay que moverlo la mitad del ancho del círculo.

Las animaciones quedarían de esta forma:
```css
.grafico-circular {
    animation: bg-circle 12s step-end infinite;
}
.grafico-circular:before {
    animation: spin-rotate 3s linear infinite, spin-color 12s step-end infinite;
}
```
La animación del semicírculo dura la mitad del tiempo en dar una vuelta, y el resto, el doble.

Por supuesto, aquí está el ejemplo completo:
<p data-height="256" data-theme-id="0" data-slug-hash="ukLCf" data-default-tab="result" class='codepen'>See the Pen <a href='http://codepen.io/nuzkito/pen/ukLCf/'>Animated pie chart - style loader with CSS</a> (<a href='http://codepen.io/nuzkito'>@nuzkito</a>) on <a href='http://codepen.io'>CodePen</a>.</p>
<script async src="//codepen.io/assets/embed/ei.js"></script>
