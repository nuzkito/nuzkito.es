---
layout: post.njk
title: Más allá de console.log()
permalink: mas-alla-de-console-log/
date_published: 2017-01-25T17:40:59.000Z
date_updated: 2017-01-25T17:41:54.000Z
tags: JavaScript
---

El otro día, a raíz de un vídeo en el que usaban `console.table()` para visualizar datos en la consola, decidí investigar sobre qué otros métodos tiene el objeto `console` de JavaScript para depurar con JavaScript. `console.table()` ya lo conocía, sin embargo vi que había otros métodos que puede que no esté de más conocer.

## `console.log()` y derivados
Aparte de `log()`, hay otros métodos que hacen exactamente lo mismo, pero en algunos entornos se mostrarán de una u otra forma. Esos métodos son:

- `console.info()`
- `console.warn()`
- `console.error()`

Creo que los nombres describen adecuadamente cómo van a mostrar el valor:

<figure>
![alt](/images/2017/01/console-log-firefox-developer-edition.png)
<figcaption>Visualización en Firefox Developer Edition</figcaption>
</figure>

<figure>
![alt](/images/2017/01/console-log-chrome.png)
<figcaption>Visualización en Chrome</figcaption>
</figure>

En algunos entornos pueden tener comportamientos adicionales. Por ejemplo, en Node.js `warn()` y `error()` muestran la salida en el `stderr`.

## Visualizar datos en forma de tabla
Si se usa `console.table()` en lugar de `log()`, algunos navegadores mostrarán los datos en una tabla, algo bastante más legible que un objeto plano.
<figure>
![alt](/images/2017/01/console-table.png)
<figcaption>Visualización de `console.table()`</figcaption>
</figure>

## Contadores
Con `console.count()` podemos contar el número de veces que se ejecuta cierto código. Además, podemos tener varios contadores con tan sólo pasar el nombre del contador como parámetro del método.

Si quieres medir cuánto tiempo tarda en ejecutarse un fragmento de código, puedes usar `console.time()` y `console.timeEnd()`. En este caso, es obligatorio pasar el nombre del contador como parámetro para que funcione. `timeEnd()` se encargará de mostrar en la consola el tiempo que tardó en ejecutarse el código desde que se llamó a `time()`;
```javascript
console.time('contador');

codeHere();

console.timeEnd('contador');
```

## Obtener la traza
Podemos obtener la traza por la que ha pasado la ejecución del programa hasta el punto en el que hemos definido un `console.trace()`. Creo que puede ser adecuado para saber si tal código se está ejecutando. En lugar de poner varios `log()` por el código, cada uno con un valor, podemos usar `trace()`, que nos va a indicar el nombre de la función ejecutada, y el resto de la traza.


## Documentación adicional
Aparte de los que he mencionado, existen otros métodos, y algunos varían de un entorno a otro. Dejo algunos enlaces adicionales que hablan sobre el objeto `console`:

* https://developer.mozilla.org/en-US/docs/Web/API/Console
* http://www.2ality.com/2013/10/console-api.html
* https://nodejs.org/api/console.html
