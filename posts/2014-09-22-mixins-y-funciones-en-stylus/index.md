---
layout: post.njk
title: Mixins y funciones en Stylus
permalink: mixins-y-funciones-en-stylus/
date_published: 2014-09-22T14:25:42.000Z
date_updated: 2018-08-19T04:14:49.000Z
tags:
- Stylus
- Tutorial
- CSS
---

En Stylus, las funciones y los mixins se declaran de la misma forma. La principal diferencia es que **los mixins se comportan como si fuesen declaraciones** de CSS. Las funciones, sin embargo, pueden devolver un valor.

## Funciones
Las funciones pueden recibir parámetros, operar con ellos y devolver un resultado.

```language-stylus
suma(a, b, u = false)
  if u
    return unit(a + b, u)
  else
    return a + b
```

Aquí definimos una función suma que puede recibir 3 parámetros, los dos sumandos y la unidad. Al declarar una función no es necesario agregar la palabra function como en muchos otros lenguajes. Simplemente se pone el nombre de la función seguido de los parámetros que reciba. Se pueden indicar parámetros opcionales asignándoles un valor por defecto dentro de la declaración, como en el caso de `u`.

La función hace lo siguiente: Suma los 2 valores, y si se le pasa una unidad, añade esa unidad al valor:

```language-stylus
suma(20,30) // 50
suma(20, 30, px) // 50px
suma(20, 30, \%) // 50%
```

Fijémonos en el último ejemplo. Como el signo % es en realidad un operador, **necesitamos escaparlo** usando el caracter `\`. Si no, Stylus mostrará error de sintaxis.

### return
Stylus permite **eliminar el return de las funciones**. Es capaz de detectar dónde debe poner un return de forma que no es necesario que lo especifiquemos:
```language-stylus
suma(a, b, u = false)
  if u
    unit(a + b, u)
  else
    a + b
```
La regla es simple. Stylus pone un return por nosotros cuando el resultado de una operación no se asigna a una variable. Pero cuidado, si hay varios return, el último es el que se aplica:
```language-stylus
suma(a, b)
  a + b
  a - b

suma(10, 5) // Devuelve 5.
```
Si escribes el `return`, se comportará correctamente:
```language-stylus
suma(a, b)
  return a + b
  return a - b

suma(10, 5) // Devuelve 15.
```
Por lo que para evitar errores es recomendable escribir **siempre** el `return` en las funciones.

### Argumentos
Tanto las funciones como los mixins tienen una variable local llamada `arguments`. Esta variable almacena en un array todos los valores pasados como argumentos:
```language-stylus
function()
  arguments

function(10, 'string', #252) // 10 'string' #252
```

Podemos acceder a cada valor de `arguments` mediante su índice:
```language-stylus
arguments[0] // 10
arguments[1] // 'string'
arguments[2] // #252
```

Esto nos permite poder crear funciones que acepten infinitos parámetros:
```language-stylus
suma()
  total = 0
  for n in arguments
    total = total + n
  return total

suma(3, 2) // Devuelve 5
suma(1, 2, 3, 4, 5) // Devuelve 15
```


## Mixins
Los mixins son muy útiles sobretodo a la hora de aplicar prefijos propietarios, como veremos en el siguiente ejemplo:

```language-stylus
box-sizing()
  -webkit-box-sizing arguments
  -moz-box-sizing arguments
  box-sizing arguments

div
  box-sizing border-box
```
Sin embargo los mixins pueden ser útiles en otras ocasiones. Podemos aprovecharlos para evitar la repetición de código, que en CSS sucede muy a menudo. Si en nuestro código tenemos muchas cajas que necesitamos centrar horizontalmente, podemos crear un mixin para ello:
```language-stylus
centered()
  margin-left auto
  margin-right auto

.centrado
  centered()
.otra-caja
  centered()
```
Esto nos dará el siguiente resultado:
```language-stylus
.centrado {
  margin-left: auto;
  margin-right: auto;
}
.otra-caja {
  margin-left: auto;
  margin-right: auto;
}
```
Creando mixins para todas esas situaciones al final tendremos un desarrollo más agil, pues no necesitamos repetir tanto código una y otra vez.

También podemos usarlos para autogenerar partes más complejas de nuestro código, con el objetivo de **reutilizarlos en los nuevos proyectos**. En el próximo artículo veremos [cómo crear estos mixins más avanzados](/mixins-avanzados-en-stylus), tratando de ver la utilidad de todas las propiedades y funciones que nos ofrece Stylus para ello.
