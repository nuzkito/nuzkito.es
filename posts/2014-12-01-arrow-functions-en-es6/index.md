---
layout: post.njk
title: Arrow functions en ES6
permalink: arrow-functions-en-es6/
date_published: 2014-12-01T17:02:20.000Z
date_updated: 2014-12-01T17:02:20.000Z
tags: JavaScript
---

Ya comenté un poco sobre las *arrow functions* en [el anterior artículo sobre ES6](/ecmascript-6-el-futuro-casi-presente-de-javascript). Aparentemente son una nueva forma de escribir funciones en Javascript, pero realmente no es así.

## El this de las funciones
Mediante la palabra *this* se puede acceder al mismo objeto desde el que se llama. Cuando queremos, por ejemplo, pasar una función como *callback* en la que tenemos que usar alguna propiedad del objeto, es necesario asignar *this* a una variable, típicamente llamada *that*, *self* o *_this*, o usar un *bind* para que esa nueva función tenga el mismo contexto que nuestro objeto.

```language-javascript
function Objeto() {
  this.loQueSea = 13;
  var that = this;

  setTimeout(function cincoSegundosDespues() {
    console.log(that.loQueSea);
  }, 5000)
}
var o = new Objeto();
```

Por el contrario, las *arrow functions* hacen un *bind* de *this* por nosotros. Tienen el mismo *scope* que el del objeto en la que son definidas, y por ello podrán usar *this* dentro de ellas.

```language-javascript
function Objeto() {
  this.loQueSea = 13;

  setTimeout(() => {
    console.log(this.loQueSea);
  }, 5000)
}
var o = new Objeto();
```

Gracias a esto podremos evitar unos cuantos `var that = this;`. Pero también tenemos que tener cuidado de no usar *arrow functions* cuando no debemos. No es una alternativa a las funciones normales, se complementan.

## Sintaxis
Las *arrow functions* tienen una sintaxis bastante sencilla, pero puede ser un poco complicada de entender al principio si no lo has visto antes. La definición es la siguiente:
```
parámetros => expresión
```
Si la función tiene un parámetro, los paréntesis son opcionales. Si no tiene o tiene más de uno, deben ponerse.
```language-javascript
// Sin parámetros
var af = () => {};
// Con un parámetro
var af = a => {};
// Con varios parámetros
var af = (a, b, c) => {};
```

Con las espresiones ocurre algo similar. Si solo es una expresión se pueden omitir las llaves, pero si son varias, deben ponerse:
```language-javascript
var suma = (a, b) => a + b;

var suma = (a, b) => {
  var resultado = a + b;
  console.log('El resultado de la suma es', resultado)
  return resultado;
}
```

## Devolución implítica, o *implicit return*
Solo cuando no usamos llaves se omite el return. Javascript entenderá que el resultado de la expresión se va a devolver como resultado.

```language-javascript
var suma = (a, b) => a + b;

suma(1, 2); // 3
```

Si usamos llaves, entonces sí se debe poner el *return*, o la función devolverá undefined.

```language-javascript
var suma = (a, b) => { a + b };
suma(1, 2); // undefined

var suma = (a, b) => { return a + b };
suma(1, 2); // 3
```

## Documentación adicional

* [Especificación](http://people.mozilla.org/~jorendorff/es6-draft.html#sec-arrow-function-definitions)
* [Mozilla Development Network](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Functions/Arrow_functions)
* [ES6Rocks](http://es6rocks.com/2014/10/arrow-functions-and-their-scope/)
