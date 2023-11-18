---
layout: post.njk
title: ¿Estás seguro de que tu aplicación necesita un framework de JS?
permalink: estas-seguro-de-que-tu-aplicacion-necesita-un-framework-de-js/
date_published: 2016-02-15T16:34:29.000Z
date_updated: 2016-02-15T16:37:32.000Z
tags: JavaScript
---

**Javascript es un lenguaje muy flexible** que se puede utilizar prácticamente en cualquier entorno. La comunidad ha crecido un montón durante los últimos años, y gracias a ello tenemos una gran cantidad de herramientas, librerías y frameworks para desarrollar. El hecho de que esté tan de moda hace que, en ocasiones, elijamos usar algunas de esas herramientas por moda, **sin analizar previamente si de verdad nos ayudan a solucionar los problemas** de nuestra aplicación de forma eficaz.

## jQuery por defecto

Creo que jQuery es la librería de JS más usada. Muchos desarrolladores lo incluyen por defecto en sus proyectos. El problema es que para mucha gente **jQuery === Javascript**. Hay gente que se empeña en cargar jQuery para hacer algo simple que se puede hacer con unas pocas líneas de Javascript.

Puede ser que tu proyecto vaya a hacer mucho uso de jQuery, así que en ese caso vale, usa jQuery. Pero otras veces, **si el código es demasiado simple no merece la pena cargar una librería completa**.

Y si usas jQuery sólo por las peticiones AJAX, hay librerías más pequeñas para usar únicamente esa funcionalidad, como [fetch](https://github.com/github/fetch), que además [es parte del estándar](https://fetch.spec.whatwg.org/), o [xhr](https://github.com/Raynos/xhr), que funciona tanto en el navegador como en Node.js.

El sitio [You Might Not Need jQuery](http://youmightnotneedjquery.com/) muestra el reemplazo en Javascript para los métodos de jQuery.

## Yo uso Angular porque es de Google

Eso lo he oído en muchas ocasiones. AngularJS se puso de moda, y por eso, muchos desarrolladores comenzaron a usarlo, porque era lo que se llevaba. Y además es de Google, ¿cómo no usarlo?. Seguro que Google hace bien las cosas.

Claro, después anunciaron Angular 2 y dijeron que no sería compatible con Angular 1. Aunque esa es otra historia. Realmente el problema es que incluir Angular en algunas aplicaciones en realidad complica el desarrollo. Y lo mismo aplica a otras herramientas. Hoy en día una pregunta habitual al comenzar un proyecto es: *¿Qué framework de Javascript uso?*.

Pero la realidad es que, en ocasiones, sobretodo **cuando el proyecto es simple o no tiene demasiada interacción en el *frontend*, es mucho más sencillo devolver el HTML ya formado** desde el *backend*. Vamos, lo que se ha hecho desde siempre. Eso reduce las dependencias de nuestra aplicación y la hace más fácil de mantener. Ya no tenemos un framework completo en el *frontend*, a lo sumo dos o tres librerías más pequeñas y fáciles de usar. **Hay veces que agregar un framework agrega complejidad innecesaria al proyecto**.

## Ventajas y desventajas

Usar frameworks puede tener algunas ventajas:

- Cuando la aplicación es grande, ayudan a estructurar el código de forma ordenada.
- Si existe mucha interacción del usuario en el navegador, algunas herramientas nos ayudan a lidiar con ello de forma sencilla.

Pero también desventajas:

- Aumenta la cantidad de bytes que debe descargar la página, lo que aumenta el tiempo de carga de la web.
- Si lo usas para algo sencillo, es posible que, más que ayudarte, te complique más la vida.
- Javascript es un entorno muy cambiante. Si te equivocas al elegir, puede que la herramienta que elegiste se quede sin soporte en unos meses.

## Y tú, ¿qué opinas?

No he hecho más que exponer mi opinión al respecto. Tú también puedes dar tu punto de vista. Más adelante **quiero expander este artículo** agregando más argumentos tanto en contra como a favor, y comentar diferentes casos de uso.
