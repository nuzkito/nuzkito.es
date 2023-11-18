---
layout: post.njk
title: La función calc de CSS
permalink: la-funcion-calc-de-css/
date_published: 2014-07-04T17:08:01.000Z
date_updated: 2018-08-19T04:12:03.000Z
tags: CSS
---

Hablando con [Katarn](http://katarn.es/) me sugirió que escribiera un artículo sobre cómo usar la función calc para crear interfaces. Esta función nos permite hacer cálculos dentro de las propias hojas de estilo.

La función `calc` permite realizar operaciones con datos numéricos dentro de las hojas de estilos. Estas operaciones **se realizan en tiempo de ejecución**. Eso nos permite hacer cálculos combinando distintas unidades en una misma operación. Veamos algunos ejemplos en vivo:

<iframe height="300" style="width: 100%;" scrolling="no" title="css calc function" src="https://codepen.io/nuzkito/embed/YzrBWw?default-tab=html%2Cresult" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true">
    See the Pen <a href="https://codepen.io/nuzkito/pen/YzrBWw">
    on <a href="https://codepen.io">CodePen</a>.
</iframe>

## Operaciones aritméticas

Se pueden hacer las operaciones básicas de suma, resta, multiplicación y división. Las sumas y restas deben ser entre unidades, mientras que las multiplicaciones y divisiones deben ser entre una unidad y una o varias constantes. Por ejemplo, lo siguiente no funcionará:

```css
/* Incorrecto */
calc(100px + 100)
calc(20% * 3px)
```

Un detalle a tener en cuenta es que los signos de suma y resta **deben estar separados por un espacio** o no funcionarán.

```css
/* Incorrecto */
calc(100px+100px)
calc(100px +100px)
calc(100px+ 100px)

/* Correcto */
calc(100px + 100px)
calc(100px + -100px)
calc(-100px + 100px)
```

Sin embargo las unidades sí podrán ir precedidas de un signo negativo, indicando que son números negativos.

## Compatibilidad con navegadores

`calc` **es compatible con todos los navegadores modernos**. En el caso de Internet Explorer, a partir de la versión 9.

Algún navegador basado en Wekbit aún necesita usar el prefijo propietario, como puede ser el navegador de Blackberry 10.

## Ejemplos

Actualmente estoy usando esta función para definir las medidas de *layouts* flexibles. En el siguiente ejemplo se podrá ver claramente la ventaja de usar calc:

<iframe height="300" style="width: 100%;" scrolling="no" title="Untitled" src="https://codepen.io/nuzkito/embed/NWaobw?default-tab=html%2Cresult" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true">
    See the Pen <a href="https://codepen.io/nuzkito/pen/NWaobw">
    on <a href="https://codepen.io">CodePen</a>.
</iframe>

En el ejemplo queremos que el menú siempre tenga un ancho de 300px, mientras que la capa con contenido ocupe el resto del espacio. Para ello, a la capa de contenido le damos el siguiente ancho:

```css
.contenido {
    width: calc(100% - 300px);
}
```

Es decir, ocupa todo el ancho posible - el *100%* - y réstale los 300px que mide el menú. Así no importa cuán ancha sea la pantalla. El contenido siempre va a ocupar toda la pantalla menos 300px.

Para hacer este mismo ejemplo sin usar calc, se necesitaba poner el menú como capa absoluta o flotante. Y a la capa de contenido, darle un ancho del 100% y un margen equivalente al ancho del menú. La función calc simplifica esto, lo hace mucho más sencillo, y no necesitamos flotar los elementos, de forma que si necesitamos adaptarlo a pantallas pequeñas, simplemente con usar una *media query* que cambie a ambos el valor de `width` a 100% ya estaría resuelto.

Otro ejemplo puede ser el siguiente:

<iframe height="300" style="width: 100%;" scrolling="no" title="Untitled" src="https://codepen.io/nuzkito/embed/oNGmZX?default-tab=html%2Cresult" frameborder="no" loading="lazy" allowtransparency="true" allowfullscreen="true">
  See the Pen <a href="https://codepen.io/nuzkito/pen/oNGmZX">
  on <a href="https://codepen.io">CodePen</a>.
</iframe>

En este caso la estructura es parecida a la de muchas aplicaciones para móviles. Una cabecera fija y un menú *off canvas*. Siempre queremos que el menú ocupe toda la altura disponible de la pantalla, pero dejando visible la cabecera.

```css
header, nav {
    position: fixed;
}
header {
    height: 2.8rem;
}
nav {
    top: 2.8rem;
    height: calc(100vh - 2.8rem);
}
```

Con `height: 100vh` podemos decirle que ocupe el 100% de la altura de la pantalla (Si no sabes qué son los vh, revisa [el artículo que escribí sobre las *viewport units*](/las-viewport-units-de-css3/)). Pero la cabecera tiene que estar visible, así que le restamos su altura.
