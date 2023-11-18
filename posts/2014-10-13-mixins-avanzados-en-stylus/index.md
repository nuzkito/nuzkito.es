---
layout: post.njk
title: Mixins avanzados en Stylus
permalink: mixins-avanzados-en-stylus/
date_published: 2014-10-13T13:32:24.000Z
date_updated: 2014-10-13T13:46:15.000Z
tags:
- Stylus
- Tutorial
- CSS
---

Anteriormente hemos visto lo básico sobre [mixins y funciones en Stylus](/mixins-y-funciones-en-stylus). Pero se pueden construir mixins más complejos utilizando algunas propiedades que nos ofrece Stylus.

## Añadir prefijos propietarios con mixins
Cuando queremos añadir los prefijos propietarios a alguna propiedad de CSS podemos crear un mixin con el mismo nombre de la propiedad. Es una forma muy transparente de agregar los prefijos.

```language-stylus
transform()
  -webkit-transform arguments
  -ms-transform arguments
  transform arguments

.rotar
  transform rotate(45deg)
```

Con este mixin agregamos los prefijos a la propiedad transform. Esto nos da el siguiente resultado:

```language-css
.rotar {
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
```

Pero en CSS existen otras muchas propiedades que pueden requerir prefijos. Para **evitar repetir código continuamente** podemos hacer un mixin genérico que sirva para cualquier propiedad:

```language-stylus
vendor(prop, val, prefixes = ())
  for prefix in prefixes
    -{prefix}-{prop} val
  {prop} val

transform()
  vendor('transform', arguments, webkit ms)

.rotar
  transform rotate(45deg)
```

`vendor` nos permite generar los prefijos de la propiedad que queramos pasándole el nombre de la propiedad, el valor, y una lista de los prefijos necesarios. Un bucle recorrerá esa lista de prefijos. Ahora podemos crear un mixin para cada propiedad que necesite prefijos que llame a este otro mixin.

## Prefijos en valores
¿Pero qué pasa cuando el prefijo lo queremos añadir en el valor de alguna propiedad? Por ejemplo, cuando hacemos una transición de elementos que requieren prefijo.

```language-css
.rotar {
  -webkit-transition: -webkit-transform 1s ease;
  -ms-transition: -ms-transform 1s ease;
  transition: transform 1s ease;
}
```

En este caso hay que analizar los valores para comprobar si existe alguna propiedad que debe llevar prefijo. Para ello hay que comprender cómo se estructuran estos valores al ser recibidos como argumentos de un mixin o función.

En CSS hay propiedades que pueden recibir múltiples valores. Estos valores son recogidos como un array, por lo que pueden ser recorridos mediante bucles.

Lo siguiente:
```language-css
transition: color 1s ease, transform 1s ease
```
sería equivalente a tener un array como el siguiente:
```language-javascript
[
  [color, 1s, ease],
  [transform, 1s, ease]
]
```
Es decir, **un array bidimensional**. El cual podemos recorrer fácilmente con dos bucles
```language-stylus
transition()
  for v1, k1 in arguments
    for value, k2 in v1
      p(value)
```

La variable `value` nos irá dando cada valor de los argumentos. Así comprobaremos si cada valor es una propiedad que requiera prefijo.

> La función `p()` nos permite mostrar el valor de esa variable en la terminal. Es una función de depuración, por lo que no muestra nada en el CSS procesado.

> Existen otras funciones de este tipo para el control de errores:

> * `warn(message)` muestra una advertencia en la consola.
> * `error(message)` muestra un mensaje y finaliza la ejecución de Stylus.

Teniendo esto en mente podemos crear un mixin que compruebe si alguno de los valores necesita un prefijo, y en dicho caso, lo añade.

```language-stylus
transition()
  // Lista de propiedades que requieren prefijo
  require-prefix = (transform)

  // Bucle que recorre todos los prefijos necesarios
  for prefix in (webkit ms)
    // Variable que almacenará el nuevo valor con los prefijos
    new-value = null

    // Recorremos todos los valores
    for v1, k1 in arguments
      for v2, k2 in v1
        // Si el valor está en la lista de prefijos
        // añadimos el prefijo
        if v2 in require-prefix
          new-value = new-value s('-%s-%s', prefix, v2)
        // y si no, añadimos el valor sin más
        else
          new-value = new-value v2
      // En caso de que haya valores separados por comas, se añaden las comas
      new-value = s('%s,', new-value) unless k1 == length(arguments) - 1
    // Agrega la propiedad con prefijo
    add-property(s('-%s-%s', prefix, unquote(current-property[0])), new-value)
  
  // Finalmente se muestra la declaración sin prefijos
  transition arguments
```

En los comentarios está descrito lo que hace cada parte de la función. Dentro se usan algunas funciones que explico a continuación:

### s()
Esta función nos permite sustituir valores en un string. Se le pasa un string como primer parámetro, y el resto de parametros son los elementos a sustituir.
```language-stylus
s('-%s-%s', 'webkit', 'transform') // -webkit-transform
```
Cada `%s` se sustituirá por el parámetro correspondiente. El primero por `webkit` y el segundo por `transform`. Y así sucesivamente con otros parámetros que pudiese haber.

### unquote()
Nos permite eliminar las comillas de una cadena. Puede ser útil cuando tenemos una variable con un string, pero necesitamos mostrar un valor de CSS.
```language-stylus
$color = '#345'

html
  color unquote($color)
```
Si no usaramos `unquote` el resultado sería el siguiente:
```language-css
html {
  color: '#345';
}
```

### add-property()
Nos permite añadir una propiedad con su valor. Las propiedades que se añadan con esta función se añadirán antes de mostrar el resultado.
```language-stylus
box-sizing()
  add-property('-webkit-box-sizing', arguments)
  add-property('box-sizing', arguments)
```
Este mixin sería exactamente igual a hacer lo siguiente:
```language-stylus
box-sizing()
  -webkit-box-sizing arguments
  box-sizing arguments
```
La función `add-property` puede ser útil en casos en los que no podamos usar la segunda forma, o en casos en los que usar la segunda forma pueda resultar confusa.


### current-property
Esta variable nos indica la propiedad actual sobre la cual se está trabajando. Es un array, por lo que para acceder al nombre de la propiedad debemos acceder al primer elemento del mismo, `current-property[0]`.


## Funciones de CSS con prefijo
Algunas funciones propias de CSS como `calc` o `linear-gradient` requieren prefijo para funcionar en algunos navegadores. En este caso la solución es algo más compleja, por lo que veremos varias formas de solucionarlo en una segunda parte de este artículo.
