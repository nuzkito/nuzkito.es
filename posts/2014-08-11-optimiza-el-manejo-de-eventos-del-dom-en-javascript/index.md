---
layout: post.njk
title: Optimiza el manejo de eventos del DOM en Javascript
permalink: optimiza-el-manejo-de-eventos-del-dom-en-javascript/
date_published: 2014-08-11T16:03:21.000Z
date_updated: 2014-08-12T12:22:36.000Z
tags: JavaScript
---

Cuando empezamos a tener aplicaciones con mucho Javascript pueden empezar a surgir pequeños problemas de optimización, como que la aplicación tarde en responder o que **tenga un consumo excesivo de memoria**. Uno de esos problemas puede estar en los eventos asignados al DOM.

Supongamos que tenemos una lista bastante grande de elementos. Al hacer click en cada uno de esos elementos se ejecutará una función que muestra la información del *item* elegido. Para ello podemos tener un código como el siguiente:

```js
var elementos = document.querySelectorAll('#lista .item-lista');
elementos.forEach(function(el, i){
    el.addEventListener('click', function(e){
        // Código que se ejecuta al hacer click.
    });
});
```
Este código recoge todos los elementos de la lista, la recorre mediante un bucle y **asigna a cada elemento** un evento.

Es ahí donde podemos tener problemas. A cada elemento se le está asignando un evento, que a su vez está recibiendo una función anónima. Esto quiere decir que **si tenemos una lista de 1 000 elementos, estaremos asignando 1 000 eventos, incrementando el uso de RAM de nuestra aplicación**.

Para optimizar esto podemos hacer un solo evento sobre la lista completa, y cuando se haga click comprobar el elemento que se ha pulsado. Podemos obtener ese elemento con `event.target`:
```js
var elementos = document.querySelector('#lista');
el.addEventListener('click', function(e){
    if (e.target !== this) {
        // Código que se ejecuta al hacer click.
    }
});
```
Dentro de la función que pasamos por parámetro al evento, `this` es el elemento sobre el que se aplica el evento. En este caso es la lista. Comparamos que this sea distinto del elemento sobre el que se ha hecho click. Si es distinto quiere decir que hemos pulsado sobre un elemento de esta lista. En ese caso, ejecutamos el código.

De esa forma tan sencilla **hemos logrado reducir un número *n* de eventos a tan solo 1**. Sin embargo el problema es que `evento.target` recoge el elemento sobre el que se hizo click. Si tenemos elementos dentro de otros elementos puede que `event.target` no sea el elemento que queremos seleccionar. En ese caso nos podemos ayudar de un helper:
```js
var lista = document.querySelector('#lista');
lista.addEventListener('click', function (e) {
    var that = this;
    var helper = function (el) {
        if (el !== that) {
            if (el.classList.contains('js-item-event')) {
                return el;
            }
            return helper(el.parentNode);
        }
        return false;
    }

    var el = helper(e.target);
});
```
De esta forma vamos comprobando si el elemento al que hicimos click es el que nos interesa. Si no lo es, volvemos a llamar al helper pasándole el elemento al que pertenece. Así sucesivamente hasta encontrar el elemento correcto. En este caso, para identificar al elemento se usa la clase `.js-item-event`. Un código HTML equivalente al ejemplo sería el siguiente:
```html
<div id="lista">
    <div class="js-item-event" data-id="1">
        <h3>Título</h3>
        <p>Descripción ...</p>
    </div>
    ...
</div>
```
La clase `.js-item-event` es la que tienen todos los elementos de la lista. Al hacer click sobre el `h3`, `event.target` será el h3. Como el `h3` no tiene esa clase, pasará a comprobar el elemento al que pertenece, que sí tiene la clase. En ese caso, nos devolverá ese elemento, con lo que podremos obtener, por ejemplo, el id del item para mostrar su información en algún punto de la aplicación.

Para ahorrarnos trabajo podemos crear una función que haga esto por nosotros (y no tener que escribir el helper en cada evento):
```js
var addEvent = function(element, event, selector, func) {
    element.addEventListener(event, function(e){
        var that = this;
        var helper = function (el) {
            if (el !== that) {
                if (el.classList.contains(selector)) {
                    return el;
                }
                return helper(el.parentNode);
            }
            return false;
        }
        var el = helper(e.target);
        if (el !== false) {
            func.call(this, e);
        }
    });
};

```
Con lo que el evento para la lista de antes se crearía de la siguiente forma:
```js
var lista = document.querySelector('#lista');
addEvent(lista, 'click', 'js-item-event', function(e){
    // Código que se ejecuta al hacer click.
});
```


## Eventos con jQuery
Por suerte ya hay librerías y frameworks que pensaron en esto e implementan métodos optimizados que hacen el trabajo por nosotros. En el caso de jQuery tenemos el método `.on()`.

A este método le podemos pasar el nombre del evento al que nos suscribiremos y una función, igual que con el método nativo `addEventListener`. En ese caso, sería hacer casi lo mismo:
```js
$('#lista .js-item-event').on('click', function(e){
    // Código que se ejecuta al hacer click.
});
```
Pero al método `on` podemos indicarle el selector que queremos que compruebe de esta forma:
```js
$('#lista').on('click', '.js-item-event', function(e){
    // Código que se ejecuta al hacer click.
});
```
Aplicamos el evento sobre el selector `#lista` y le indicamos que debe ejecutarlo solo si se ha hecho click sobre un elemento con clase `.js-item-event`.

## Otras ventajas: listas dinámicas
Esta forma de asignar eventos nos proporciona algunas ventajas, como la posibilidad de tener listas dinámicas que automáticamente reconozcan el evento.

Si asignásemos los eventos a cada elemento de la lista, cuando necesitemos añadir un nuevo elemento también necesitamos asignarle el evento. De esta forma asignamos el evento al contenedor y comprobamos sobre qué elemento se ha hecho click. **No necesitamos asignar el evento a los nuevos elementos** - *y seguro que nos ahorramos muchas molestias al no saber por qué no funciona el click sobre los elementos nuevos* -.

***
La mayoría trabajan con librerías como jQuery, por lo que es muy sencillo tomar esta práctica. Recuerden que aunque estemos creando aplicaciones que funcionan en un navegador, también tenemos que tener en cuenta su rendimiento y consumo de recursos. **Muchas personas consumen la web desde dispositivos con características limitadas**. **Cuanto más optimizadas estén nuestras aplicaciones, mejor les funcionarán**.
