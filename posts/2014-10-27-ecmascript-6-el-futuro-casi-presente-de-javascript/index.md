---
layout: post.njk
title: ECMAScript 6, el futuro casi presente de Javascript
permalink: ecmascript-6-el-futuro-casi-presente-de-javascript/
date_published: 2014-10-27T15:51:19.000Z
date_updated: 2015-10-11T11:16:19.000Z
tags: JavaScript
---

Seguramente muchos ya hayan oído hablar de la nueva versión de la especificación de Javascript, **ECMAScript 6** (o ES6 para abreviar), también llamada **Harmony**. Esta nueva versión traerá numerosos cambios a Javascript con el objetivo de mejorar el lenguaje.

Algunas de las mejoras propuestas ya se pueden usar en las versiones más nuevas de los navegadores y en Node.js, aunque por desgracia aún hace falta tiempo para poder usarlo con seguridad. Sin embargo para estar preparado ya he comenzado a investigar sobre las nuevas características del lenguaje. Durante las próximas semanas publicaré contenido sobre algunas de estas nuevas características, a la par que investigo sobre ellas.

ES6 viene con algunos cambios muy interesantes, otros no tanto, y otros que no me gustan nada, como las clases. Podremos definir clases en Javascript, así como ya se puede hacer en otros lenguajes, con la diferencia de que se mantiene la herencia mediante prototipos, algo que puede confundir a programadores que vengan de otros lenguajes (pero igualmente es interesante).

Entre las características que me gustan se encuentran las siguientes:


## Variables locales con let
En Javascript las variables son globales.

```language-javascript
numero = 7;

function algo() {
  numero = 13;
}

algo();

console.log(numero) // Devuelve 13
```
Al definir una variable dentro de una función, esta pasa a existir en toda nuestra aplicación y dentro de cualquier otra función. Eso es un problema. Hasta ahora para solventar esto debemos usar `var` para declarar las variables.
```language-javascript
var numero = 7;

function algo() {
   var numero = 13;
   console.log(numero) // 13
}

algo();

console.log(numero) // 7
```
Gracias a `var` la variable solo existirá en el ámbito de la función, pero no fuera de ella, por lo que no sobreescribimos la variable externa. Sin embargo aún puede haber algún problema:
```language-javascript
for ( var index = 0; index < 10; index++ ) {
  // Hace algo
}
console.log(index) // 10
```
Cuando hacemos un bucle `for` aunque definamos index con `var`, la variable index va a permanecer definida en el resto de la función, algo que puede que no nos interese y que puede ser fuente de errores. Para ello en ES6 se implementa `let`:
```language-javascript
for ( let index = 0; index < 10; index++ ) {
  // Hace algo
}
console.log(index) // 'index' not defined
```
Gracias a `let` podemos definir entornos de variables locales que en lugar de pertenecer a la funcion, pertenecen al bloque. En este caso la variable `index` solo existen dentro del for. Ocurre lo mismo con otro tipo de estructuras como los `if`:
```language-javascript
let numero = 13;

if (true) {
  let numero = 7;
  console.log(numero) // 7
}
console.log(numero) // 13
```

## Bucle for-of
En Javascript existen varias formas de recorrer un `array`. Aparte de las clásicas como usar un `while` o un `for`, tenemos el `for-in`. El problema es que este bucle recore **todas** las propiedades del array, incluyendo las que no son valores:
```language-javascript
var arr = [1,2,3];  
arr.saludo = 'hola';

for (indice in arr) {  
  console.log(indice, '=>', arr[indice]);
}

// Resultado:
// 0 => 1
// 1 => 2
// 2 => 3
// saludo => 'hola'

```
Esto puede ser un problema. Con el bucle for-of nos aseguramos de que sólo se recorrerán los valores del array:

```language-javascript
var arr = [1,2,3];
arr.saludo = 'hola';

for (numero of arr) {
  console.log(numero);
}

// Resultado:
// 1
// 2
// 3
```

Igualmente nos ocurre el mismo problema cuando queremos recorrer todas las propiedades de un objeto.

## Arrow functions
En ES6 tenemos una nueva forma de declarar funciones. La sintaxis es así:
```language-javascript
var suma = (a, b) => a + b

suma(1, 2) // 3
```

Es una sintaxis alternativa para escribir funciones, bastante simple, y además nos ahorra escribir continuamente `function`. Además, como habréis notado, tampoco es necesario escribir el `return`.

Detallaré sus características en un artículo aparte (ójo, que no es simplemente una nueva sintaxis).

***

Esto solo ha sido una pequeña introducción a lo nuevo que se viene a Javascript. Iremos viendo cosas nuevas poco a poco. Recuerda que los nuevos navegadores ya implementan algunas de estas características, por lo que **puedes probarlas en sus herramientas para desarrolladores**.
