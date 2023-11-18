---
layout: post.njk
title: Mediaqueries en Stylus
permalink: mediaqueries-en-stylus/
date_published: 2014-12-08T18:19:29.000Z
date_updated: 2014-12-08T18:19:29.000Z
tags:
- Stylus
- Tutorial
- CSS
---

Al trabajar con preprocesadores, hacer *mediaqueries* no supone ningún problema. No hay ninguna diferencia entre usar CSS o usar un preprocesador. Sin embargo, ya que estamos usando preprocesadores, podrían ayudarnos un poco.

Para ello crearemos un *mixin*. El *mixin* se encargará de crear la *mediquery* completa a partir de 1 o 2 parámetros. Eso nos facilitará el escribir la cabecera de la regla (`@media screen and (min-width: XXem)`) y nos permitirá definir de forma más rápida los puntos de ruptura de nuestro diseño. Pero antes de ver cómo hacer esto veamos cómo afectan las *mediaqueries* al rendimiento.

## ¿Tener muchas *mediaqueries* afecta al rendimiento?

En [artículos anteriores menciono que cada componente debe estar en un archivo](/componentes-y-modulos-de-css-con-stylus). Todo el código, incluyendo las *mediqueries* necesarias para adaptar ese componente. Modularizar demasiado es malo, no es recomendable poner las reglas `@media` en otro archivo distinto. El 'problema' es que si tenemos muchos componentes podemos acabar con una gran cantidad de *mediaqueries* en el CSS final.

Entonces llega la primera pregunta: ¿Tener muchas mediaqueries afecta al rendimiento del navegador? [Pues parece que no](https://helloanselm.com/2014/web-performance-one-or-thousand-media-queries/). Quizás sí lo haga si llegamos a tener miles, pero no creo que nadie llegue a ese caso ;).

La segunda cuestión es el peso del archivo. Cuantas más reglas `@media`, más aumentará el peso del archivo resultante. Sin embargo, **activando la compresión *gzip*** en el servidor esto no debería suponer un problema.

En resumen, no importa que tengamos 2 o 3 *mediaqueries* por componente.

## Mixins para crear las *mediaqueries*
En la mayoría de proyectos actuales el *responsive design* se centra en establecer unos puntos de ruptura en los cuales el diseño sufrirá algún cambio. Ese es el uso más común de la regla `@media`, establecer esos cambios de diseño usando `min-width` o `max-width`.

En general, suele haber entre 3 y 5 puntos de ruptura. Los definiremos en una variable.
```language-stylus
$breakpoints = {
  'small': 30em,
  'medium': 45em,
  'large': 60em,
  'x-large': 75em
}
```
En la variable guardamos un diccionario de clave-valor, donde la clave es el nombre del punto de ruptura. Ese nombre será el que usemos al llamar al mixin. Se deben evitar los *números mágicos*. Además es mucho más sencillo recordar palabras. Si vemos una mediaquery a 45em, ¿qué es, para móviles, tablets, escritorio? Sin embargo al ver `medium` lo asocias directamente.

Y he aquí el mixin en cuestión:
```language-stylus
mq($breakpoint = 'small', $first = 'mobile')
  if ($first == 'mobile')
    $media = 'min-width: '
  else if ($first == 'desktop')
    $media = 'max-width: '

  if ($breakpoint is a 'string')
    $media += $breakpoints[$breakpoint]
  else
    $media += $breakpoint

  @media ({$media})
    {block}
```
Puede recibir 2 parámetros opcionales: El nombre del breakpoint y si es *mobile-first* o *desktop-first*.

En el primer parámetro indicamos el nombre del breakpoint que queremos usar de la variable
`$breakpoints`.
```language-stylus
  if ($breakpoint is a 'string')
    $media += $breakpoints[$breakpoint]
  else
    $media += $breakpoint
```
También se da la opción de usar una unidad, para cubrir casos excepcionales, por eso la comprobación de si la variable `$breakpoint` es un string.

Dependiendo del segundo parámetro usará *min-width* o *max-width*.
```language-stylus
  if ($first == 'mobile')
    $media = 'min-width: '
  else if ($first == 'desktop')
    $media = 'max-width: '
```
Los valores válidos son `'mobile'` y `'desktop'`. Pero se puede adaptar esta parte para que funcione con otras propiedades si es necesario.

Y finalmente se muestra el código:
```language-stylus
  @media ({$media})
    {block}
```
Al mixin le estamos pasando un bloque, que **dentro** del mixin podrá accederse desde la variable `block`. Para poder mostrarlo hay que ponerlo entre llaves, para evitar que Stylus lo confunda con un elemento de html. ¡Y listo! Para usar el mixin hacemos lo siguiente:
```language-stylus
+mq('large', 'mobile')
  html
    font-size 1.2em
```
Lo cual nos devolverá el siguiente código CSS:
```language-css
@media (max-width: 45em) {
  html {
    font-size: 1.2em;
  }
}
```
Pero también podríamos hacer esto:
```language-stylus
+mq(45em)
  html
    font-size 1.2em
```

Recordemos que cuando llamamos a un mixin que recibe un bloque, debemos poner el signo `+` delante, o no funcionará.

Este mixin les servirá para la mayoría de los casos, por lo que pueden usarlo tal cual. Si necesitan algo concreto como tener `min-width` o `max-width` a la vez, modifíquenlo o creense su mixin personalizado.
