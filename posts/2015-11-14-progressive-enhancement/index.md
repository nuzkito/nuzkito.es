---
layout: post.njk
title: Qué es progressive enhancement
permalink: progressive-enhancement/
date_published: 2015-11-14T18:47:12.000Z
date_updated: 2015-11-14T18:47:51.000Z
---

**Progressive enhancement** (o **mejora progresiva**) consiste en comenzar ofreciendo una web que funcione en cualquier dispositivo y navegador, e ir agregando características según aumenten las capacidades del navegador, la pantalla del dispositivo, la velocidad de la red, etc.

A veces nos olvidamos de que no todo el mundo accede en las mismas condiciones a Internet. Hay gente que accede desde dispositivos viejos, desde conexiones lentas, mediante proxys que bloquean ciertos contenidos... Por eso, es recomendable hacer que **las webs sean accesibles desde cualquier dispositivo**, de forma que, independientemente del navegador del usuario o de su velocidad de Internet, pueda acceder al contenido o usar las funciones básicas de la aplicación. Según los medios de acceso del usuario mejoren, se mejorará la experiencia agregando nuevas características a la web.

Pongamos un ejemplo para que quede más claro. Supongamos que tenemos un blog en el que usamos *flexbox* y animaciones. Un usuario que accede desde IE6 no va a ver las animaciones, y posiblemente vea algún elemento descolocado. Sin embargo, podrá acceder al contenido del blog. Si ese usuario actualiza su navegador, entonces verá los elementos posicionados de la forma correcta y funcionarán las animaciones. Desde ambos navegadores se podrá ver el contenido, solo que en navegadores más modernos se podrá ofrecer una mejor experiencia.

## Una web no tiene por qué verse igual en todos los navegadores

No hay por qué esperar a que ciertas características estén soportadas por todos los navegadores para poder usarlas. Hace tiempo me dijeron que era mala persona por usar `position: sticky;` en mi web. Actualmente, [sticky](http://caniuse.com/#search=sticky) solo está soportado por Firefox y Safari. Sin embargo, si en estos dos navegadores funciona, ¿por qué no usarlo? La gente que acceda desde otros navegadores simplemente no verán el efecto, **pero podrán seguir usando la web sin problemas**. Con el tiempo, los demás navegadores soportarán esta característica.

El *responsive design* es un claro ejemplo de que una web no tiene por que verse igual en cualquier navegador. Técnicas como *mobile first* obligan a pensar cuáles son las características mínimas que debe tener una web en pantallas pequeñas. En pantallas más grandes se pueden mostrar los elementos de distinta forma, o agregar nuevos. En cualquier caso, la versión móvil debería poder ofrecer las características mínimas.

## ¿Y si falla Javascript?

Es raro que hoy en día haya gente que tenga Javascript desactivado, pero podría haber motivos aparte por los cuales deje de funcionar (errores en el código, problemas de red...).

Pensemos en las *Single Page Apps* que se pueden crear con frameworks como Angular. Generalmente, estas aplicaciones cargan un *html* vacío con los *scripts* necesarios para ejecutarse la aplicación. **Si por alguna razón no se ejecuta Javascript, lo único que se verá es una página en blanco**. Eso no es bueno.

Hay técnicas que nos ayudan a resolver este problema. Podemos generar el HTML de la página en el servidor, de forma que si Javascript falla, al menos el contenido de la página se podrá ver, aunque no se encuentre totalmente funcional.

También tenemos que tener en cuenta otros elementos como los enlaces. Con Javascript funcionando, al pulsar en un enlace la aplicación enviaría una petición AJAX al servidor, que devuelve un JSON con los datos a mostrar en la nueva página. Sin Javascript funcionando, al pulsar el enlace simplemente recarga la página y muestra la nueva página. Vamos, el funcionamiento de toda la vida de los enlaces.

## ¿Realmente necesito hacer esto en mi web?

Depende del proyecto que estés creando, puede ser algo útil o puede que no sea necesario. Por lo general es buena idea que las aplicaciones dirigidas al público general se desarrollen de esta forma, siempre que se pueda. Conseguir que la aplicación pueda funcionar en la mayor cantidad de dispositivos posible siempre es bueno.

Sin embargo, si trabajamos para un entorno empresarial que controlamos, en el que sabemos que todos los usuarios de la aplicación usan Chrome(por ejemplo), no es necesario complicarse la vida.

Pero ten en cuenta que es más sencillo tener una base que funcione y agregarle nuevas características según aparezcan mejoras en los navegadores, que tener que compatibilizar ciertos navegadores una vez la aplicación ya está creada.
