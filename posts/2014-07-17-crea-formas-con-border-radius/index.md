---
layout: post.njk
title: Crea formas con la propiedad border-radius de CSS3
permalink: crea-formas-con-border-radius/
date_published: 2014-07-17T16:15:00.000Z
date_updated: 2014-07-17T16:28:42.000Z
tags: CSS
---

La propiedad border-radius de CSS3 nos permite **redondear los bordes de las cajas**. Se usa principalmente en el diseño de las cajas que muestran el contenido de una web y para hacer algunas figuras sencilla, como los círculos. Sin embargo, con un poco de imaginación podemos aprovecharlo para crear formas más complejas.

## Cómo funciona border-radius
La propiedad border-radius es en realidad un shorthand de varias propiedades. Estas propiedades son:

* border-top-left-radius: Esquina de arriba a la izquierda.
* border-top-right-radius: Esquina de arriba a la derecha.
* border-bottom-right-radius: Esquina de abajo a la derecha.
* border-bottom-left-radius: Esquina de abajo a la izquierda.

Su funcionamiento es similar al de otras propiedades (como margin, padding, etc.), solo que en lugar de aplicar el valor a un lado, se lo aplicamos a una esquina. La diferencia es que **cada esquina puede tener dos valores** distintos:

<div class="example">
<style scoped>
.example .caja {
    height: 150px;
    margin: auto;
    text-align: center;
    color: white;
    background: #ff4136;
    border-top-left-radius: 50px 100px;
    border-bottom-right-radius: 50px 100px;
}
</style>
    <div class="caja">
        border-top-left-radius: 50px 100px;<br>
        border-bottom-right-radius: 50px 100px;
    </div>
</div>

Esas dos medidas son la distancia (*x*,*y*) de la esquina al centro de la elipse que dibuja el borde redondeado. Las distancias se corresponden con la distancia al centro más pequeña y la más grande de la elipse.

![Valores x,y](/images/2014/Jul/SelecciC3n_007.png)

En la forma acortada, `border-radius`, estos valores se indican separándolos mediante una barra `/`:
```css
border-radius: 50px 0 50px 0 / 100px 0 100px 0;
```
Para los que no sepáis de matemáticas, cuando estos dos valores de la elipse son iguales, el resultado es un círculo. Cuando definimos solo uno de los valores CSS entiende que los dos son iguales, y genera un borde totalmente redondo.

Cabe destacar que no se puede redondear el borde si uno de los dos valores (x o y) es 0.
```css
/* Esto no pintará borde redondeado */
border-radius: 1000px 0 0 / 0;
```

## Creando formas
Sabiendo cómo funciona la propiedad border-radius pasemos a mostrar cómo podemos lograr diversas formas.

Lo más básico es lo que hace todo el mundo, redondear una caja.
<div class="example">
<style scoped>
.example .rounded {
    height: 50px;
    width: 300px;
    margin: auto;
    background: #0074d9;
    border-radius: .5em;
}
</style>
    <div class="rounded"></div>
</div>

```css
.forma {
    border-radius: .5em;
}
```

Poniendo un radio de 50% en una capa con un ancho y alto iguales conseguiremos un círculo.
<div class="example">
<style scoped>
.example .circulo {
    height: 200px;
    width: 200px;
    margin: auto;
    background: #0074d9;
    border-radius: 50%;
}
</style>
    <div class="circulo"></div>
</div>

```css
.circulo {
    height: 200px;
    width: 200px;
    border-radius: 50%;
}
```

Si el ancho y el alto son distintos, obtendremos una elipse. (Recordemos que un círculo es una elipse en la que x es igual a y).
<div class="example">
<style scoped>
.example .elipse {
    height: 100px;
    width: 300px;
    margin: auto;
    background: #0074d9;
    border-radius: 50%;
}
</style>
    <div class="elipse"></div>
</div>

```css
.elipse {
    height: 100px;
    width: 300px;
    border-radius: 50%;
}
```

Podemos combinar distintas medidas en cada esquina para crear formas interesantes
<div class="example">
<style scoped>
.example .cuarto-de-circunferencia {
    height: 200px;
    width: 200px;
    margin: auto;
    background: #0074d9;
    border-radius: 100% 0 0;
}
</style>
    <div class="cuarto-de-circunferencia"></div>
</div>

```css
.cuarto-de-circunferencia {
    height: 200px;
    width: 200px;
    border-radius: 100% 0 0;
}
```

<div class="example">
<style scoped>
.example .semicirculo {
    height: 100px;
    width: 200px;
    margin: auto;
    background: #0074d9;
    border-radius: 50% / 100% 100% 0 0;
}
</style>
    <div class="semicirculo"></div>
</div>

```css
.semicirculo {
    height: 100px;
    width: 200px;
    border-radius: 50% / 100% 100% 0 0;
}
```

<div class="example">
<style scoped>
.example .hoja {
    height: 200px;
    width: 200px;
    margin: auto;
    background: #3d9970;
    border-radius: 10% 100% 0 100%;
}
</style>
    <div class="hoja"></div>
</div>

```css
.hoja {
    height: 200px;
    width: 200px;
    border-radius: 10% 100% 0 100%;
}
```

<div class="example">
<style scoped>
.example .huevo {
    height: 200px;
    width: 140px;
    margin: auto;
    background: #feeeda;
    border-radius: 50% / 65% 65% 40% 40%;
}
</style>
    <div class="huevo"></div>
</div>

```css
.huevo {
    height: 200px;
    width: 140px;
    border-radius: 50% / 65% 65% 40% 40%;
}
```

Y si además añadimos algunas propiedades extra...
<div class="example">
<style scoped>
.example .ojo {
    height: 13em;
    width: 13em;
    margin: auto;
    background: #dddddd;
    transform: rotate(45deg);
    border-radius: 95% 0;
    position: relative;
}
.example .ojo:before {
    content: '';
    display: block;
    background: #3d9970;
    width: 7em;
    height: 7em;
    position: absolute;
    -webkit-transform: translate(3em, 3em);
    transform: translate(3em, 3em);
    border-radius: 50%;
}
.example .ojo:after {
    content: '';
    display: block;
    background: #222;
    width: 3.5em;
    height: 3.5em;
    position: absolute;
    -webkit-transform: translate(4.75em, 4.75em);
    transform: translate(4.75em, 4.75em);
    border-radius: 50%;
}
</style>
    <div class="ojo"></div>
</div>

```css
.ojo {
    height: 13em;
    width: 13em;
    margin: auto;
    background: #dddddd;
    transform: rotate(45deg);
    border-radius: 95% 0;
    position: relative;
}
.ojo:before {
    content: '';
    display: block;
    background: #3d9970;
    width: 7em;
    height: 7em;
    position: absolute;
    transform: translate(3em, 3em);
    border-radius: 50%;
}
.ojo:after {
    content: '';
    display: block;
    background: #222;
    width: 3.5em;
    height: 3.5em;
    position: absolute;
    transform: translate(4.75em, 4.75em);
border-radius: 50%;
}

```
E incluso con animaciones
<div class="example">
<style>
@-webkit-keyframes animacion-cargando {
    to { -webkit-transform: rotate(1turn); }
}
@keyframes animacion-cargando {
    to { transform: rotate(1turn); }
}
</style>
<style scoped>
.example .cargando {
    height: 200px;
    width: 200px;
    margin: auto;
    background: #0074d9;
    position: relative;
    border-radius: 50%;
    -webkit-animation: animacion-cargando 2s linear infinite;
    animation: animacion-cargando 2s linear infinite;
}
.example .cargando:before,
.example .cargando:after {
    content: '';
    display: block;
    position: absolute;
    background: #7fdbff;
    width: 50%;
    height: 50%
}
.example .cargando:before {
    top: 50%;
    left: 50%;
border-radius: 0 0 100%;
}
.example .cargando:after {
    border-radius: 100% 0 0
}
</style>
  <div class="cargando"></div>
</div>

```css
@keyframes animacion-cargando {
    to { transform: rotate(1turn); }
}
.cargando {
    height: 200px;
    width: 200px;
    margin: auto;
    background: #0074d9;
    position: relative;
    border-radius: 50%;
    animation: animacion-cargando 2s linear infinite;
}
.cargando:before,
.cargando:after {
    content: '';
    display: block;
    position: absolute;
    background: #7fdbff;
    width: 50%;
    height: 50%
}
.cargando:before {
    top: 50%;
    left: 50%;
border-radius: 0 0 100%;
}
.cargando:after {
    border-radius: 100% 0 0
}
```

## Conclusiones
Con estos ejemplos se puede ver cómo esta propiedad, que la mayoría usa tan solo para redondear sus diseños, puede dar bastante juego. Os animo a que experimentéis y me mostréis vuestros resultados ;)

Puedes ver estos ejemplos, y los que añada en el futuro, [en este pen](http://codepen.io/nuzkito/pen/LBvKu).
