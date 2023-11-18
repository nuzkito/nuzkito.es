---
layout: post.njk
title: Reutiliza tu código en React usando mixins
permalink: reutiliza-tu-codigo-en-react-usando-mixins/
date_published: 2015-05-18T16:43:19.000Z
date_updated: 2015-05-18T16:43:18.000Z
tags:
- JavaScript
- Tutorial
- React
---

En el [anterior artículo sobre React](/comenzando-con-react) vimos cómo hacer el *frontend* de un chat. Terminamos el chat, pero [dejamos un paso sin hacer](https://github.com/nuzkito/react-chat/tree/09/public). En este artículo veremos qué son los *mixins* y cómo hacer que se actualice solo el *hace cuánto se envió* el mensaje.

La idea bajo React es crear componentes reusables. Si varios de nuestros componentes poseen la misma funcionalidad, podemos crear un módulo y reusarlo en todos ellos. Los *mixins* nos permiten hacer eso.

Para que el tiempo de *hace cuánto se envió el mensaje* se actualice solo podemos usar `setInterval`. Pero una vez se acumulen 100 mensajes, los últimos mensajes enviados se irán eliminando, por lo que tenemos que eliminar el `setInterval`. Esa funcionalidad podemos definirla directamente en el componente, pero también podemos extraerla a un mixin por si necesitamos reutilizarla. En este caso el chat es sencillo, pero en aplicaciones más complejas puede suceder que tengamos varios componentes totalmente distintos que usan `setInterval`.

## Definir un mixin

Para crear un mixin hay que crear un objeto con los métodos necesarios para agregar la funcionalidad.
```language-javascript
var SetIntervalMixin = {

  componentWillMount: function() {
    this.intervals = [];
  },

  setInterval: function() {
    this.intervals.push(setInterval.apply(null, arguments));
  },

  componentWillUnmount: function() {
    this.intervals.map(clearInterval);
  },

};
```
Podemos usar los métodos de los componentes de React (como `componentWillMount` o `componentWillUnmount`), con la ventaja de que si usamos varios mixins que definen los mismos métodos, se ejecutarán ambos, uno detrás de otro.

En este caso, antes de que el componente se cree (`componentWillMount`), se crea un *array* para guardar todos los *intervals* que pueda tener. Y cuando el componente se vaya a eliminar (`componentWillUnmount`), se llama a la función `clearInterval` sobre todos los *intervals* almacenados. El método `setInterval` del mixin es el que usaremos para agregar nuevos *intervals*, que como ves, llama a `setInterval` y guarda el valor que devuelve en el array.

## Usar un mixin en un componente
Para poder usar un mixin debemos agregarlo en la propiedad `mixins` del componente:
```language-javascript
var Componente = React.createClass({

  mixins: [Mixin1, Mixin2, Mixin3, ...],

  ...

});
```

Y ahora, en nuestro componente podemos usar `this.setInterval`, pasándole el método `updateTime`, que se encargará de asignar a `this.state.time` el texto que mostrará el componente (*hace 15 minutos*, *hace 2 horas*, etc.), el cual generamos con *Moment*.
```language-javascript
var TimeAgo = React.createClass({

  mixins: [SetIntervalMixin],

  render: function () {
    return (
      <small className="time-ago">{this.state.time}</small>
    );
  },

  componentDidMount: function () {
    this.setInterval(this.updateTime, 1000);
  },

  getInitialState: function () {
    return { time: moment(this.props.children).fromNow() };
  },

  updateTime: function () {
    this.setState({ time: moment(this.props.children).fromNow() });
  },

});
```
Así es como queda finalmente el componente. Ahora, si necesitas usar `setInterval` en otro lugar, puedes reutilizar el Mixin. Puedes ver más información en la [documentación de React](https://facebook.github.io/react/docs/reusable-components.html).
