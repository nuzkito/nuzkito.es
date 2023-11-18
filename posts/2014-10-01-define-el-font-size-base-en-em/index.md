---
layout: post.njk
title: Define el font-size base en em
permalink: define-el-font-size-base-en-em/
date_published: 2014-10-01T19:25:41.000Z
date_updated: 2014-10-01T19:25:41.000Z
tags: CSS
---

Es una práctica bastante común que los desarrolladores al comenzar un nuevo proyecto hagan lo siguiente:

```language-css
body {
  font-size: 16px;
}
```

De esta forma podemos controlar el tamaño que tendrá el texto, con independencia de que el navegador del usuario tenga configurado otro tamaño. **Pero esta es una mala práctica**. Veamos por qué.

## El usuario decide cómo ver el contenido

El usuario puede **modificar el valor del tamaño de la fuente del navegador** por cualquier motivo. El ejemplo más claro son las personas con algún tipo de deficiencia visual. Estas personas podrán aumentar el tamaño del texto para poder **leer mejor**.

Cuando establecemos en nuestra hoja de estilos un tamaño de fuente fijo estamos **suprimiendo esa configuración, limitando al usuario**.

No basta con que nosotros lo leamos bien. Dejemos **que el usuario elija** cómo lo quiere ver.

## Define el font-size en el elemento raíz

Esto es, en el `html` o `:root`. Se debe a que la unidad `rem` **equivale al tamaño de fuente definido en la raíz del documento**.

Si tenemos lo siguiente:
```language-css
html {
  font-size: 20px;
}
```

`1rem` será equivalente a `20px`. Esto nos ayuda al trabajar con esta unidad, pues `1rem` siempre será igual a la medida que hayamos decidido definir.

## ¿Por qué en em?
Debes [evitar usar píxeles para que la interfaz sea lo más adaptable posible](/sobre-como-usar-px-em-rem-y-percent-en-responsive-design) a las diferentes situaciones que pueda haber. El tamaño de pantalla **no es la única variable** a tener en cuenta. Cuando el usuario decide usar un tamaño de fuente mayor, **toda la interfaz debe escalar** para evitar que haya textos que descuadren el contenido.

Por defecto, la mayoría de los navegadores tienen el tamaño configurado a 16px. Si queremos que en nuestra aplicación el tamaño de la fuente sea de 18px, podremos ponerlo en em haciendo un sencillo cálculo:


    Tamaño deseado / Tamaño por defecto =
    = 18 / 16 = 1.125em

Y en el CSS ponemos

```language-css
html {
  font-size: 1.125em;
}
```

¿Qué pasa si el usuario configura su navegador para que tenga un tamaño de fuente de 20px?

    20 * 1.125 = 22.5px

Simplemente que el tamaño que verá el usuario será equivalente a 22.5px, en lugar de 18px.

## Distintas formas de implementarlo

Sí, es una cosa sencilla, pero a muchos lo de los cálculos no se les da bien. Puedes hacer una implementación sencilla en la que solo necesites definir el tamaño en `px`, y después ya se encargara CSS de convertirlo en `em`.

Puedes usar la función `calc`:
```language-css
html {
  font-size: calc(18 * 1em / 16);
}
```
El primer valor (el 18 en este caso) es el tamaño deseado.

También puedes aprovechar variables:
```language-css
:root {
  --font-size: 18;
}

html {
  font-size: calc(var(--font-size) * 1em / 16);
}
```
El problema de esta solución es que las variables de CSS aún no están implementadas en todos los navegadores.

Eso lo podemos arreglar con preprocesadores. El siguiente ejemplo funciona con Stylus:
```language-stylus
$fontSize = 18;

html
  font-size unit($fontSize / 16, 'em')
```

***

¡Y listo!  
¿Te ha gustado el tip? No te olvides compartirlo a tus amigos, en Twitter, o donde quieras :)
