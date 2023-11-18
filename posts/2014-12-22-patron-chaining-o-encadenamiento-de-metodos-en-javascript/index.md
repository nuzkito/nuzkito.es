---
layout: post.njk
title: Patrón chaining o encadenamiento de métodos en Javascript
permalink: patron-chaining-o-encadenamiento-de-metodos-en-javascript/
date_published: 2014-12-22T14:17:19.000Z
date_updated: 2015-02-09T21:39:25.000Z
tags: JavaScript
---

<figure>
![Cadenas](/images/2014/Dec/cadenas-1.jpg)
<figcaption><em>Imagen por <a href="http://www.flickr.com/photos/aloriel/6292261464" target="_blank">Jorge Gonzalez</a> - Modificada</em></figcaption>
</figure>

Seguramente hayáis visto que en librerías como jQuery podemos hacer lo siguiente:

```language-javascript
$('#main').addClass('MainSection').attr('role', 'main');
```
Se ejecuta la función `$()`, e inmediatamente se ejecutan 2 o más métodos seguidos, sin necesidad de guardarlo en una variable. Todo ello en una línea. Así nos evitamos hacer lo siguiente:
```language-javascript
var main = $('#main');
main.addClass('MainSection');
main.attr('role', 'main');
```

Tratemos de hacer algo similar emulando el comportamiento de jQuery:
```language-javascript
var D = function (selector) {

  var element = document.querySelector(selector);

  if (!element) {
    return null;
  }

  return {

    addClass: function (className) {
      element.classList.add(className);
    },

    attr: function (attr, value) {
      element.setAttribute(attr, value);
    }

  };
}
```
Esto emula de forma muy simple el comportamiento de los métodos de jQuery usados en el ejemplo. Sin embargo, si tratamos de hacer
```language-javascript
D('#main').addClass('MainSection').attr('role', 'main');
```
nos devolverá un error:
```language-javascript
TypeError: D(...).addClass(...) is undefined
```

Pero entonces, ¿cómo podemos hacer esto en nuestras propias librerías?

Tanto en Javascript como en otros lenguajes, dentro de los objetos existe una variable `this` que apunta al propio objeto. Gracias a esa variable especial podemos acceder a otras propiedades o métodos del objeto desde dentro del mismo.

Esa variable también puede ser devuelta con `return`. Es decir, podemos devolver el propio objeto al ejecutar un método. Devolver this es lo que nos permite encadenar métodos uno tras otro.

Hagamos ese cambio en el código de antes añadiendo `return this` a los métodos `addClass` y `attr`:
```language-javascript
var D = function (selector) {

  var element = document.querySelector(selector);

  if (!element) {
    return null;
  }

  return {

    addClass: function (className) {
      element.classList.add(className);
      return this;
    },

    attr: function (attr, value) {
      element.setAttribute(attr, value);
      return this;
    }

  };
}
```
Si ahora volvemos a ejecutar
```language-javascript
D('#main').addClass('MainSection').attr('role', 'main');
```
¡funciona!
```language-markup
<div role="main" class="MainSection" id="main"></div>
```
¿Por qué funciona? Cuando se ejecuta el primer método, `D('#main').addClass('MainSection')`, se devuelve el objeto a sí mismo. Sería igual que tener `objeto.attr('role', 'main')`, con la diferencia de que en lugar de tener el objeto almacenado en una variable, lo obtenemos como resultado del método anterior.

Esto solo se puede aplicar a los *setters*. Si un método devuelve algún dato, no se podrá devolver this a la vez, por lo que no se podrá seguir encadenando métodos.

Eso ha sido todo. Es más simple de aplicar en el código que de explicar.
