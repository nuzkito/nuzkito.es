---
layout: post.njk
title: Plantillas en JavaScript con ES2015
permalink: plantillas-en-javascript-con-es2015/
date_published: 2016-08-15T15:16:13.000Z
date_updated: 2016-09-15T15:51:46.000Z
tags: JavaScript
---

Una de las características añadidas a JavaScript con ES2015 fueron los `template literals`, la posibilidad de tener cadenas de texto que se comportan como plantillas. Esta funcionalidad nos permite incluir expresiones dentro de cadenas de texto, haciendo que concatenar strings sea mucho más sencillo y legible.

Tradicionalmente en JavaScript podemos crear cadenas de texto tanto con comillas simples como con comillas dobles. No hay ninguna diferencia entre usar una u otra opción. Para usar un `string` como plantilla se ha incluido una tercera, usando el caracter ``` ` ```.

```javascript
const language = 'JavaScript';
const message = `<h1>${language}</h1>`;
console.log(message); // <h1>JavaScript</h1>
```

En este ejemplo, la variable `language` es un `string` normal, mientras que `message` es una plantilla. La forma de introducir expresiones dentro de una plantilla es con el símbolo del dolar y las llaves `${}`. En este caso se está concatenando una variable, pero podemos incluir cualquier otra expresión, como una llamada a una función.

Fíjate que para hacer la misma concatenación con `strings` normales, el código se vería así:

```javascript
const message = '<h1>' + language + '</h1>';
```

Según se va ganando complejidad, la legibilidad empeora.

```javascript
const n1 = 7;
const n2 = 3;
// ES5
console.log('La suma de ' + n1 + ' + ' + n2 ' es ' + (n1 + n2) + '.');
// ES6
console.log(`La suma de ${n1} + ${n2} es ${n1 + n2}`);
```

## Modifica el comportamiento de las plantillas

Por defecto, las plantillas envían las cadenas literales y los resultados de las expresiones a una función, que concatena todos los valores y devuelve el resultado.

Podemos crear una función que modifique dicho comportamiento. Para llamarla hay que poner el nombre delante del primer ``` ` ```.

```javascript
function template() {
    return 'Hola mundo';
}

console.log(template`Hello world`); // Hola mundo
```

A estas funciones se las llama _tags_(etiquetas). Esta función recibe como primer parámetro todos los literales que tenga la plantilla, y en los sucesivos parámetros el resultado de las expresiones.

```javascript
function template(strings, hello, world) {
    console.log(strings);
    console.log(hello);
    console.log(world);
}

const hello = 'Hola';
const world = 'mundo';
template`<h1>${hello} ${world}</h1>`;
// [ '<h1>', ' ', '</h1>' ]
// Hola
// mundo
```

Como las expresiones de cada plantilla pueden variar, se puede usar el operador `...` para recoger todos los valores en un array.

```javascript
function template(strings, ...values) {
    console.log(strings);
    console.log(values);
}
```

Podemos reproducir la funcionalidad por defecto de esta forma, por ejemplo.

```javascript
function template(strings, ...values) {
    let result = '';

    for (let i = 0; i < strings.length; i += 1) {
        result += strings[i];
        result += values[i] || '';
    }

    return result;
}
```

## Plantillas complejas

Si queremos crear componentes más complejos, que puedan por ejemplo iterar sobre una lista de elementos, es posible sin ningún problema usar alguna función como map para mostrar dichos elementos.

```javascript
function render(title, items) {
    return `
        <h1>${title}</h1>
        <ul>
            ${items.map(item => `<li>${item}</li>`)}
        </ul>
    `
}

console.log(render('Lenguajes', ['HTML', 'CSS', 'JS']));
```

Esto funciona, pero tenemos un pequeño problema. El método map devuelve un `array`, y cuando se transforma un `array` a `string`, se incluye una coma entre cada elemento.

```javascript
// <li>HTML</li>,<li>CSS</li>,<li>JS</li>
```

Esto se puede solucionar usando el método `join` tras `map`.

```javascript
${items.map(item => `<li>${item}</li>`).join('')}
```

Pero eso nos obliga a tener lógica adicional en la plantilla. Podemos abstraer esta lógica creando una etiqueta que modifique el comportamiento al momento de concatenar un `array`.

Partamos de la función `template` creada anteriormente.

```javascript
function template(strings, ...values) {
    let result = '';

    for (let i = 0; i < strings.length; i += 1) {
        result += strings[i];
        result += values[i] || '';
    }

    return result;
}
```

Aunque antes voy a refactorizar un poco el código.

```javascript
function getPieces(strings, values) {
    return strings.map(function(string, i) {
        return [string, values[i]];
    }).reduce(function(accumulator, item) {
        return [...accumulator, ...item];
    }, []).filter(a => a);
}

function template(strings, ...values) {
    return getPieces(strings, values).join('');
}
```

La función `getPieces` devolverá un `array` con todas las piezas a concatenar en orden. De esta forma será más sencillo agregar modificaciones. Usando el método `join` sobre el resultado de `getPieces` se obtiene el mismo resultado que teníamos al principio.

Pero lo que queríamos era que, si en la plantilla teníamos algún `array`, este se concatenase sin las comas. Para ello antes de hacer el `join` tenemos que hacer un `map` que compruebe si el valor es un `array`, y en dicho caso, haga un `join` sobre él.

```javascript
function template(strings, ...values) {
    return getPieces(strings, values).map(function(item) {
        return Array.isArray(item) ? item.join('') : item;
    }).join('');
}
```

Fácil, ¿no?. Ahora ya podemos usar `map` en las plantillas sin necesidad de hacer un `join`.

```javascript
function render(title, items) {
    return template`
        <h1>${title}</h1>
        <ul>
            ${items.map(item => `<li>${item}</li>`)}
        </ul>
    `
}
```

De la misma manera podrían agregarse más funcionalidades, como protección contra vulnerabilidades de XSS en caso de que usemos las plantillas para crear HTML, como en los ejemplos.

## Más información

* [https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals){targe="_blank"}
* Los _template literals_ son mejores _strings_ (en inglés) https://ponyfoo.com/articles/template-literals-strictly-better-strings
