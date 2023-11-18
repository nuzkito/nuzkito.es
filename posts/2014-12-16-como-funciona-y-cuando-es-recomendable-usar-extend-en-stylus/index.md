---
layout: post.njk
title: Cómo funciona y cuándo es recomendable usar @extend en Stylus
permalink: como-funciona-y-cuando-es-recomendable-usar-extend-en-stylus/
date_published: 2014-12-16T16:38:16.000Z
date_updated: 2014-12-16T16:38:16.000Z
tags:
- Stylus
- Tutorial
- CSS
---

![Stylus](/images/2014/Dec/stylus.png)

La [directiva `@extends` de Stylus](http://learnboost.github.io/stylus/docs/extend.html) permite **heredar estilos** de un selector en otro. Puede ser útil cuando tenemos un elemento con los mismos estilos que otro ya definido. Al segundo elemento le decimos que extienda del primero, y nos ahorramos volver a escribir las mismas reglas.

Funciona de la siguiente manera:
```language-stylus
.Button {
  border: 1px solid #888;
  border-radius: .2em;
  background-color: white;
}

.Button--primary {
  @extend .Button
  background-color: cyan;
}
```
Tenemos una clase `.Button` que define los estilos para los botones, y una clase `.Button--primary`. `.Button--primary`, y cualquier otro botón que se pueda crear posteriormente, extienden los estilos de `.Button`, pues todos los botones tendrán esos estilos. Lo que hace `@extend` es coger la clase en la que lo hemos definido (`.Button--primary`) y juntarla con el selector `.Button` de la siguiente forma:
```language-css
.Button,
.Button--primary {
  border: 1px solid #888;
  border-radius: 0.2em;
  background-color: #fff;
}
.Button--primary {
  background-color: #0ff;
}
```

### ¿`@extend` o `@extends`?
Algo bastante curioso es que Stylus permite ambas formas, por lo que no os tenéis que preocupar de si es con o sin *s*.

## Extendiendo de *placeholder selectors*
En lugar de extender de una clase, podemos extender de una variable especial que guarde los valores que se van a heredar:
```language-stylus
$button
  border: 1px solid #888;
  border-radius: .2em;
  background-color: white;

.Button {
  @extend $button
}

.Button--primary {
  @extend $button
  background-color: cyan;
}
```
Esa *variable* **debe comenzar** por el símbolo `$`. Su sintaxis es como la de cualquier otra regla en Stylus, con la única característica de que no se mostrará en el CSS final.

## Diferencias con los mixins
Esto mismo podríamos tratar de hacerlo con mixins:
```language-stylus
button()
  border: 1px solid #888;
  border-radius: .2em;

.Button {
  button()
  background-color: white;
}

.Button--primary {
  button()
  background-color: cyan;
}
```
La diferencia está en el CSS generado:
```language-css
.Button {
  border: 1px solid #888;
  border-radius: 0.2em;
  background-color: #fff;
}
.Button--primary {
  border: 1px solid #888;
  border-radius: 0.2em;
  background-color: #0ff;
}
```
Con `@extends` evitamos el CSS duplicado, mientras que con mixins generaremos aún más CSS cada vez que lo usemos. Por ello, `@extends` nos puede venir bien en determinados casos para evitar repetir CSS. Sin embargo, usando Gzip esto tampoco supone un problema.

Por supuesto, también podríamos escribir los selectores a mano, pero el uso de `@extends` nos puede ayudar a identificar qué selectores usan los estilos de otro, como en este caso, que `.Button--primary` usa los mismo estilos que `.Button`.


## Otras formas de lograr el mismo resultado
Aprovechando las características de Stylus podemos simular la salida de `@extends` de esta otra forma:
```language-stylus
.Button
  &,
  &--primary
    border: 1px solid #888;
    border-radius: .2em;
    background-color: white;

  &--primary
    background-color: cyan;
```
El código anterior genera el mismo resultado que usar `@extends`. `&` hace referencia a `.Button`, por lo que ese código se traduce a
```language-stylus
.Button,
.Button--primary
  border: 1px solid #888;
  border-radius: .2em;
  background-color: white;

.Button--primary
  background-color: cyan;
```

También podemos hacer lo mismo combinando esta sintaxis con los *placeholder selectors*:
```language-stylus
$button
  border: 1px solid #888;
  border-radius: .2em;
  background-color: white;

.Button
  @extends $button

  &--primary
    @extends $button
    background-color: cyan;
```
Que no es más que otra forma de escribir el mismo código de antes.

## No abuses de `@extend`
En principio parece ser beneficioso, pero como todo, si se usa mal podemos lograr el efecto contrario. En [este artículo de csswizardry.com](http://csswizardry.com/2014/11/when-to-use-extend-when-to-use-a-mixin/) lo explican mejor de lo que yo podría explicarlo. Recomiendo que lo lean. Dicho artículo habla sobre Sass, pero todo es aplicable a Stylus.

El principal consejo que doy es que revisen la salida de Stylus y hagan pruebas. Y tengan en mente que cuando sirvan ese archivo a los usuarios, lo van a enviar **comprimido con Gzip**.
