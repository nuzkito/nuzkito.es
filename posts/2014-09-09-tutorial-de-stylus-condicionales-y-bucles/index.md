---
layout: post.njk
title: "Tutorial de Stylus: Condicionales y bucles"
permalink: tutorial-de-stylus-condicionales-y-bucles/
date_published: 2014-09-09T15:59:36.000Z
date_updated: 2014-09-22T14:27:16.000Z
tags:
- Stylus
- Tutorial
- CSS
---

En Stylus los condicionales y los bucles funcionan de la misma forma que en otros muchos lenguajes. Sin embargo, Stylus nos ofrece algunas alternativas en cuanto a su sintaxis.

## Condicionales
Un condicional nos permite **evaluar una expresión y ejecutar una serie de instrucciones u otra dependiendo si la sentencia es evaluada cono verdadera `true` o falsa `false`**.

### if / else if / else
Es el condicional más típico:
```language-stylus
support-for-ie = true

if support-for-ie
  html.ie {
    /* Reglas para Internet Explorer */
  }
```
El único detalle a tener en cuenta es que las expresiones pueden ir sin paréntesis.

### unless
`unless` significa *a menos que*, o lo contrario a `if`.
```language-stylus
$columns = 3

unless $columns == 1
  .column
    margin (10% / 2 / $columns)
    width (90% / $columns)
```
En este ejemplo decimos que *a menos que el número de columnas sea 1, crea esta clase*. Sería exactamente lo mismo que decir `if $columns != 1` o `if !($columns == 1)`.

### Operador ternario `?:`
En Stylus también tenemos el operador ternario. Si sintaxis es la siguiente:
```
(expresion) ? resultado si cierto : resultado si falso
```
Como anteriormente, el paréntesis se puede omitir.

### Condicionales en línea
Tanto `if` como `unless` **se pueden aplicar en una sola línea**, de la siguiente forma:
```language-stylus
prefixes = webkit moz

div
  -webkit-box-sizing border-box if 'webkit' in prefixes
  -moz-box-sizing border-box if 'moz' in prefixes
  -ms-box-sizing border-box if 'ms' in prefixes
  -o-box-sizing border-box if 'o' in prefixes
  box-sizing border-box
```
Es como decir *escribe esto si esta expresión es verdadera*. Así comprobamos por cada prefijo si está en el array de `prefixes`, y si está, aparecerá en el CSS resultante:
```language-css
div {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
```

## Bucles
**Un bucle nos permite ejecutar un grupo de sentencias de forma repetida un número finito de veces**. En Stylus solo hay un tipo de bucle, `for in`, pero con él podemos hacer todas las operaciones necesarias. Funciona de la siguiente forma:
```
for valor, índice in lista
// El índice es opcional:
for valor in lista
```
El bucle `for in` recorre una lista de elementos. Cuando llega al último elemento, el bucle acaba. A cada vuelta nos devuelve el elemento y, opcionalmente, el índice que ocupa en la lista.

Tomemos el último ejemplo de los condicionales y hagámoslo con un bucle:
```language-stylus
prefixes = webkit moz

div
  for prefix in prefixes
    -{prefix}-box-sizing border-box
  box-sizing border-box
```
Sencillo, ¿cierto?

También podemos aplicar el bucle en una sola línea:
```language-stylus
prefixes = webkit moz

div
  -{prefix}-box-sizing border-box for prefix in prefixes
  box-sizing border-box
```
y obtendríamos el mismo resultado.

### Rango de números
Si queremos hacer que un bucle haga un número determinado de repeticiones, podemos crear un rango de números:
```
1..10
```
Esto generará una lista de números del 1 al 10:
```
1..10 // 1 2 3 4 5 6 7 8 9 10
```
Si ponemos 3 puntos en lugar de 2, el último número será omitido:
```
1...10 // 1 2 3 4 5 6 7 8 9
```
Podemos combinar los números para conseguir distintos resultados:
```
5..10 // 5 6 7 8 9 10
5..1 // 5 4 3 2 1
10..5 // 10 9 8 7 6 5
```

Podemos combinarlo con un bucle para que el bucle se repita un número n de veces:
```language-stylus
$columns = 5

for col in $columns..1
  .column-{col}
    width (100% / $columns) * col
```
Esto nos daría el siguiente CSS como resultado:
```language-css
.column-5 {
  width: 100%;
}
.column-4 {
  width: 80%;
}
.column-3 {
  width: 60%;
}
.column-2 {
  width: 40%;
}
.column-1 {
  width: 20%;
}
```

***

Esto es todo lo que hay que saber sobre bucles y condicionales. Es muy sencillo. Si la programación no es vuestro fuerte sería recomendable que revisaseis los conceptos básicos de programación. En el próximo artículo hablaré sobre [mixins y funciones en Stylus](/mixins-y-funciones-en-stylus), que darán paso a un par de artículos sobre la creación de mixins avanzados, donde sí que será necesario tener algunas nociones de programación básica.
