---
layout: post.njk
title: Sobre cómo usar px, em, rem y % en "Responsive Design"
permalink: sobre-como-usar-px-em-rem-y-percent-en-responsive-design/
date_published: 2014-06-08T13:17:20.000Z
date_updated: 2020-08-21T19:49:24.000Z
tags: CSS
---

Estamos en una época en la que convivimos con dispositivos con pantallas de múltiples tamaños. Esto obliga a los desarrolladores a cambiar la forma de crear las interfaces en la web. Por eso se creó el concepto de *responsive design*.

El diseño *responsive* es **crear interfaces que se adapten a los distintos tamaños de pantalla**. Esto se hace utilizando las *media queries* de CSS, y apoyándose en los *em* y los porcentajes. Sin embargo, a pesar de que mucha gente dice que hay que usar em y porcentajes, muy pocos son los que de verdad aplican esta *regla*.

El próximo paso consiste en abandonar los píxeles definitivamente. Creando interfaces usando solamente em, rem y porcentajes podremos crear sitios que se adapten no solo a los diferentes tamaños de pantalla, sino también **a las necesidades concretas del usuario**. Una cosa a tener en cuenta es que el usuario puede definir en su navegador el tamaño de letra por defecto. Si definimos con px el font-size base, estamos limitando la configuración del usuario, y una cosa que tenemos que tener en cuenta es que al final **el usuario es el que decide cómo quiere consumir el contenido**.

## Cómo crear una interfaz sin usar píxeles

Realmente es muy sencillo. Solo hay que tener clara esta forma de pensar. Lo primero que debemos no hacer es definir un `font-size` con píxeles en el body. El tamaño de letra por defecto es de 16 píxeles si el usuario no lo modifica. Podemos trabajar en base a ello sin problemas. Ahora veamos cómo y cuándo usar cada medida.

### rem

Al definir los tamaños de letra de las diferentes secciones y componentes usaremos el `rem`. El `rem` depende del tamaño de letra base. Si no hemos definido ningún font-size en el html, tomará el valor del navegador. Es decir, `1rem = 16px`. ¿Que queremos que un título tenga un tamaño de 24px? Pues le aplicamos `font-size: 1.5rem;`.

### em

A diferencia del `rem`, el `em` depende del último `font-size` definido dentro del árbol de elementos en el que se encuentra. Veamos un ejemplo.

```css
.contenedor {
    font-size: 1.25em;
}
.letra-pequeña {
    font-size: .9em;
}
```
```html
<div class="contenedor">
    <p>.contenedor tiene un tamaño de 16px * 1.25 = 20px.</p>
    <p class="letra-pequeña">.letra-pequeña tiene un tamaño de 20px * 0.9 = 18px. Toma 20px porque el em toma el último valor definido en alguno de sus contenedores.</p>
</div>
<p class="letra-pequeña">.letra-pequeña, ahora que no está dentro de .contenedor, tiene un tamaño de 16px * 0.9 = 14.4px. Toma 16px porque no se ha definido un font-size en alguno de los contenedores, por lo que toma el valor del navegador.</p>
```

<style>
.contenedor-ejemplo {
    border: 1px solid #777;
    font-size: 16px;
    padding: 1em;
}
.contenedor {
    border: 1px dashed red;
    font-size: 1.25em;
}
.letra-pequeña {
    border: 1px dashed blue;
    font-size: .8em;
}
</style>
<div class="contenedor-ejemplo">
<div class="contenedor">
    <p><code>.contenedor</code> tiene un tamaño de 16px * 1.25 = 20px.</p>
    <p class="letra-pequeña"><code>.letra-pequeña</code> tiene un tamaño de 20px * 0.8 = 16px. Toma 20px porque el em toma el último valor definido en sus contenedores.
</div>
<p class="letra-pequeña"><code>.letra-pequeña</code>, ahora que no está dentro de <code>.contenedor</code>, tiene un tamaño de 16px * 0.8 = 12.8px. Toma 16px porque no se ha definido un font-size en alguno de los contenedores, por lo que toma el valor del navegador.</p>
</div>

Teniendo en cuenta su funcionamiento podemos usarlo para crear componentes modulares. ¿A qué me refiero con componentes modulares? Por ejemplo, cuando creamos un campo de texto personalizado. Ese campo de texto tendrá un icono a la izquierda. Lo ideal sería que el tamaño del icono dependiese del tamaño general del campo de texto, y lo mismo ocurre con los márgenes interior y exterior, e incluso con los bordes. Para hacer eso podemos definir el tamaño de letra del contenedor con `rem`, y definir todos los tamaños de los elementos que lo comprendan en `em`. Dentro del campo de texto, todos los tamaños dependerán del `font-size` aplicado al contenedor.

Para que quede más claro [puedes ver un ejemplo](http://codepen.io/nuzkito/pen/rpoDI/). Usar `em` y `rem` para crear los componentes de las web es muy útil cuando tenemos componentes con diversos tamaños. En este caso, si necesitamos un input más grande simplemente tenemos que cambiar el font-size del contenedor, y **tan solo cambiando un valor en el CSS todos los tamaños se adaptarán automáticamente**.

#### Media Queries también con em

Las *media queries* también deben estar definidas en `em`. Casi todo el mundo las define en `px` porque es lo más sencillo. ¿Que hace falta que en móviles y tablets el diseño esté a una columna en lugar de a dos? Pum. Media query a 768px.

Pero hemos dicho que nada de px, así que usemos em. Tomando de nuevo los 16px como base, el media query para tablets es de 48em. Y para móviles(360px) 22.5em. Estoy tomando medidas estandar, pero posiblemente en muchos diseños los puntos de ruptura no sean tan concretos y necesiten poner una media query a 400px. En ese caso tan solo dividan los px entre 16. (400 / 16 = 25em).

##### ¿Y por qué usar em y no px, si el resultado va a ser el mismo?

Por lo que comentaba al principio. El usuario **puede modificar el tamaño de letra del navegador**. Por ejemplo, un usuario que no ve bien de cerca aumenta el tamaño de letra a 20px para poder leer mejor. Si hemos definido bien los tamaños de los elementos de nuestro diseño con `em` y `rem`, todos los elementos se ajustarán automáticamente y se verán más grandes. Si además hemos definido bien las media queries, **el diseño completo se adaptará** en caso de que necesite espacio.

Para que comprendáis esto mejor pensad en un menú que a 768px de ancho queda muy justo con un tamaño de 16px. ¿Qué pasaría si en lugar de 16px son 20px? Posiblemente las últimas opciones se salten de línea o se rompa el diseño de alguna forma. Aplicando la media query a 48 em, para esta persona el diseño cambiará cuando el ancho de la pantalla sea menor a 48 * 20 = 960px. De esta forma, si está viendo la web desde un ordenador con una pantalla pequeña, realmente **verá el diseño adaptado tablets, en lugar de un diseño desktop roto**.

### Porcentajes

Por último me queda hablar de los porcentajes. Estos se usarán sobretodo para definir anchos flexibles. Por ejemplo, cuando queremos que las imágenes se adapten al 100% del ancho del contenedor, cuyo tamaño puede variar dependiendo de la media query aplicada. O simplemente para crear un layout flexible.

### ¿Entonces el píxel está obsoleto?

No necesariamente. Puede haber ciertos casos en los que usar píxeles no sea relevante, como en bordes o sombras. Aún así, también sería genial que estos efectos dependiesen igualmente del em.

## Conclusión

No usar píxeles en nuestros diseños implica no solo que el diseño se adapte a múltiples dispositivos, sino también a ciertas necesidades del usuario y a **la forma en que este consume el contenido**. Algo de vital importancia para ofrecer una **mejor accesibilidad y experiencia de usuario**.

Si hay algo que no les quedó claro, pueden contactarme en [@nuzkito](https://twitter.com/nuzkito) para resolverles cualquier duda :).
