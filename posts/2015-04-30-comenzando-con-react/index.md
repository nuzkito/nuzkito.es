---
layout: post.njk
title: Comenzando con React
permalink: comenzando-con-react/
date_published: 2015-04-30T22:10:09.000Z
date_updated: 2016-03-12T17:10:42.000Z
tags:
- JavaScript
- Tutorial
- React
---

[React es una librería de Javascript](https://facebook.github.io/react/) creada por los desarrolladores de Facebook para **construir interfaces de usuario de forma modular**. Su principal característica es su capacidad para hacer cambios en el DOM de la página de una forma muy eficiente.

Puedes encontrar su documentación en https://facebook.github.io/react/

## Cómo funciona React
React hace uso de un **DOM virtual**. No trabaja directamente con el DOM, sino con una copia en memoria. Cuando una acción hace un cambio en la página, React regenera ese DOM virtual, lo compara con el DOM real, y hace únicamente los cambios necesarios en el DOM para que sea igual a la copia virtual. Esto, aunque no lo parezca, **es más rápido que trabajar directamente con el DOM**.

A diferencia de lo que se suele hacer actualmente en los desarrollos no maneja plantillas de HTML, sino que crea los nodos directamente con Javascript.
```language-javascript
React.render(
  React.createElement('h1', null, 'Hello, world!'),
  document.getElementById('example')
);
```

Para simplificar la creación del HTML se puede usar JSX, [una sintaxis alternativa similar a XML](https://facebook.github.io/jsx/), que se convertirá a Javascript para que el navegador lo entienda.
```language-javascript
React.render(
  <h1>Hello, world!</h1>,
  document.getElementById('example')
);
```

Está orientado a un desarrollo totalmente **modular**, donde **cada elemento de la interfaz es un componente distinto**. Si tenemos una lista de elementos, la lista sería un componente, y cada elemento sería otro componente distinto. Esos elementos podrían tener más componentes dentro (un temporizador, un contador, etc.).

## Creando un chat con React
Para ilustrar React he hecho este pequeño tutorial que muestra cómo programar la interfaz de un chat simple usando React. Para que puedas centrarte en el tutorial, podrás encontrar en [este repositorio de GitHub](https://github.com/nuzkito/react-chat) el código necesario para el servidor y los estilos. Además podrás seguir los pasos realizados mediante las *tags*. Cada *tag* es un paso del tutorial.

> _Editado el 12 de marzo de 2016:_
> Actualmente se recomienda [usar Babel](/usa-las-nuevas-caracteristicas-de-javascript-hoy-mismo-con-babel/) para transformar el código JSX. El componente para transformar JSX está obsoleto y no será actualizado.

### Preparando el HTML inicial
Para instalar React, puedes [descargarlo desde su sitio](https://facebook.github.io/react/downloads.html) o instalarlo mediante gestores como [npm](https://www.npmjs.com/) o [Bower](http://bower.io/). Por simplicidad, en este tutorial usaremos un CDN. También incluiremos la librería [Moment](http://momentjs.com/), para manejo de fechas, y [Socket.io](http://socket.io/), para la comunicación a tiempo real.

```language-markup
<!-- tag 01 -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Chat with React</title>
  <link rel="stylesheet" href="https://necolas.github.io/normalize.css/3.0.2/normalize.css">
  <link rel="stylesheet" href="chat.css">
</head>
<body>

  <div id="chat">
    
  </div>

  <!-- Scripts externos -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.1/react.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/react/0.13.1/JSXTransformer.js"></script>
  <script src="http://momentjs.com/downloads/moment.min.js"></script>
  <script src="/socket.io/socket.io.js"></script>

  <!-- Scripts de nuestra aplicación -->
  <script src="/app.js"></script>
  <script src="/chat.jsx" type="text/jsx"></script>
</body>
</html>
```

Este será el `index.html`. Observa que hay un archivo llamado `JSXTransformer.js`. Este archivo se encargará de transformar JSX a Javascript real. Esto no es recomendado en producción. Al terminar veremos cómo procesar el JSX antes de subir el código a producción.

Para que JSXTransformer funcione, debemos indicar a nuestro archivo que tenga extensión `.jsx` y que sea de tipo `text/jsx`.

El el archivo `app.js` se inicia Socket.io. El código para el chat lo crearemos en `chat.jsx`.

### De HTML a componentes de React
Lo más sencillo para crear los componentes de la aplicación es comenzar con un prototipo en HTML que nos permita ver cómo están estructurados los elementos.

```language-markup
<!-- tag 02 -->
<div id="chat">
  <div class="chat-box">
    <h1 class="title">Chat con ReactJS</h1>
    <ul class="message-list">
      <li class="message">
        <strong>Usuario:</strong> Mensaje enviado <small class="time-ago">hace dos minutos</small>
      </li>
      <li class="message">
        <strong>Usuario:</strong> Mensaje enviado <small class="time-ago">hace dos minutos</small>
      </li>
      <li class="message">
        <strong>Usuario:</strong> Mensaje enviado <small class="time-ago">hace dos minutos</small>
      </li>
    </ul>
    <form class="chat-form">
      <input class="input username-input" type="text" placeholder="Nombre de usuario">
      <input class="input body-input" type="text" placeholder="¡Escribe algo! :D">
      <button class="button">Enviar</button>
    </form>
  </div>
</div>
```

Tenemos un contenedor principal `div#chat` que contendrá el HTML del chat. Dentro hay un `div.chat-box`. Ese será el componente principal del chat, del cual dependerán los demás. Dentro tenemos otros dos elementos principales, una lista con los mensajes `ul.message-list`, y un formulario `form.chat-form`. Y dentro de la lista de mensajes, cada mensaje será un componente independiente.

Si vamos disgregando el HTML nos queda un árbol así:

* Chat
  * Lista de mensajes
     * Mensaje
  * Formulario

Lo ideal es que cada componente cumpla una única función, manteniéndolos lo más pequeños posibles. Podríamos hacer que la lista de mensajes se encargue de todas las tareas relacionadas con los mensajes, pero si lo descomponemos podremos separar nuestro código y hacerlo más reutilizable.

Y se puede modularizar más. Fijémonos un momento en la etiqueta `small.time-ago`. Se usará para mostrar el tiempo que pasó desde que se envió el mensaje. Ese tiempo además se actualizará automáticamente. Podemos separarlo en un componente independiente que únicamente se encargue de mostrar hace cuánto fue enviado el mensaje. Además, siendo un componente, podemos reutilizarlo, por ejemplo en un sistema de comentarios.

El árbol de componentes y la función de cada uno sería el siguiente:

* Chat: Se comunica con el servidor y envía los nuevos mensajes al listado de mensajes.
  * Lista de mensajes: Itera los mensajes para mostrarlos.
     * Mensaje: Muestra el contenido del mensaje.
         * Indicador de tiempo: Muestra hace cuánto se envió el mensaje.
  * Formulario: Permite enviar nuevos mensajes.

Y ahora que sabemos qué componentes formarán el chat, creemos los componentes con React.

```language-javascript
// tag 04
var TimeAgo = React.createClass({

  render: function () {
    return (
      <small className="time-ago">hace dos minutos</small>
    );
  }

});
```

Para crear un componente de React debemos usar el método `createClass`, al cual le pasaremos un objeto con los métodos que tendrá el componente. Todos los componentes deben tener obligatoriamente el método `render`. Este método se encargará *dibujar* el elemento en la página. Debe devolver un nodo del DOM, por lo que siempre debemos devolver un solo elemento. En este caso, devolvemos un único elemento `<small>`. Si tuviesemos varios elementos, se deben englobar dentro de uno solo.

Dentro de un componente podemos incluir otros como si fueran otra etiqueta más de HTML.
```language-javascript
// tag 04
var Message = React.createClass({

  render: function () {
    return (
      <li className="message"><strong>Usuario:</strong> Mensaje <TimeAgo>hace dos minutos</TimeAgo></li>
    );
  },

});
```

Dentro del componente del mensaje incluimos una etiqueta `TimeAgo`, que es como hemos llamado al componente que va a mostrar hace cuanto se envió el mensaje. Es como crear nuestras propias etiquetas.

> Para diferencias los componentes de React de las etiquetas de HTML, los componentes deben empezar por mayúscula.

Así podemos ir creando el resto de componentes. El resultado final sería el siguiente:

```language-javascript
// Contenedor del chat
var ChatBox = React.createClass({

  render: function () {
    return (
      <div className="chat-box">
        <h1 className="title">Chat con ReactJS</h1>
        <MessageList />
        <ChatForm />
      </div>
    );
  },

});

// Formulario para enviar mensajes
var ChatForm = React.createClass({

  render: function () {
    return (
      <form className="chat-form">
        <input className="input username-input" type="text" placeholder="Nombre de usuario" />
        <input className="input body-input" type="text" placeholder="¡Escribe algo! :D" />
        <button className="button">Enviar</button>
      </form>
    );
  },

});

// Listado de mensajes
var MessageList = React.createClass({

  render: function () {
    return (
      <ul className="message-list">
        <Message />
        <Message />
        <Message />
      </ul>
    );
  },

});

// Cada mensaje individual
var Message = React.createClass({

  render: function () {
    return (
      <li className="message"><strong>Usuario:</strong> Mensaje <TimeAgo>hace dos minutos</TimeAgo></li>
    );
  },

});

// ¿Hace cuanto se envió el mensaje?
var TimeAgo = React.createClass({

  render: function () {
    return (
      <small className="time-ago">hace dos minutos</small>
    );
  }

});


// Iniciar chat
React.render(<ChatBox />, document.getElementById('chat'));
```

La última línea es la que iniciará la aplicación. A `React.render` le pasamos el componente principal de la aplicación, y el elemento en el que queramos que se inserte, en este caso el `div#chat`.

Si ejecutas el código ahora, debe mostrarte 3 mensajes.

> Si te has fijado, en lugar de usar el atributo `class` para definir las clases de CSS, se usa `className`. También ocurre con el atributo `for`, que debemos ponerlo como `htmlFor`. Esto es debido a que `class` y `for` son palabras reservadas.

### Propiedades (*props*) de los componentes.
Tenemos varios componentes, pero son totalmente estáticos. Lo normal es que los componentes reciban datos y hagan algo con ellos. En el componente `ChatBox` vamos a definir un array con varios mensajes que le pasaremos al componente `MessageList` para que los muestre.
```language-javascript
// tag 05
var ChatBox = React.createClass({

  render: function () {

    var messageList = [
      {
        id: 1,
        username: 'Usuario',
        body: 'Contenido del mensaje',
        time: new Date(),
      },
      {
        id: 2,
        username: 'Usuario',
        body: 'Contenido del mensaje',
        time: new Date(),
      },
      {
        id: 3,
        username: 'Usuario',
        body: 'Contenido del mensaje',
        time: new Date(),
      },
    ];

    return (
      <div className="chat-box">
        <h1 className="title">Chat con ReactJS</h1>
        <MessageList messageList={messageList} />
        <ChatForm />
      </div>
    );
  },

});
```

A `MessageList` le añadimos un atributo para pasarle los mensajes. Así es como se pasan datos entre los componentes.

> Para usar variables dentro del JSX debemos ponerlas entre llaves `{}` en lugar de entre comillas `""`. Todo lo que pongamos entre llaves se ejecutará como Javascript, por lo que también podemos usar funciones.

Los atributos se reciben como propiedades (*props*) del componente. Las propiedades se consideran datos inmutables del componente. Es decir, no se pueden cambiar. Pueden ser accedidas desde `this.props`.

Dentro de `MessageList` podemos acceder al array de mensajes con `this.props.messageList`. Como queremos mostrar el listado de mensajes, haremos un bucle que genera todos los componentes `Message` necesarios usando el método `map`.
```language-javascript
// tag 05
var MessageList = React.createClass({

  render: function () {
    var messageList = this.props.messageList.map(function (message) {
      return (
        <Message name={message.username} time={message.time}>{message.body}</Message>
      );
    });

    return (
      <ul className="message-list">
        {messageList}
      </ul>
    );
  },

});
```

A Message, a su vez, le pasamos más atributos. En este caso, `message.body` no se está enviando como atributo, sino como hijo. Podemos pasar texto o elementos a los componentes, que podrán ser accedidos desde `this.props.children`.

Los otros componentes son iguales. Recogen datos de las props y se pasan a los subcomponentes.
```language-javascript
// tag 05
var Message = React.createClass({

  render: function () {
    return (
      <li className="message"><strong>{this.props.name}:</strong> {this.props.children} <TimeAgo>{this.props.time}</TimeAgo></li>
    );
  },

});

var TimeAgo = React.createClass({

  render: function () {
    return (
      <small className="time-ago">{moment(this.props.children).fromNow()}</small>
    );
  }

});
```

Si ejecutas el código ahora, el resultado debe ser el mismo que antes. Solo que si ahora modificas los datos del array, podrás ver cómo se modifican los datos mostrados.

### Enviando mensajes
Los componentes ya no son estáticos, pero no tenemos forma de enviarles nuevos datos. Vamos a ver cómo podemos agregar mensajes al chat.

Agregaremos los mensajes desde el componente de formulario `ChatForm`, pero tenemos que llevarlos hasta `MessageList`. Para eso, los mensajes deben pasar antes por `ChatBox`. Pero React es unidireccional. Podemos enviar datos a los subcomponentes pasándoselos como atributo, pero no podemos hacer lo contrario. Para poder enviar los mensajes a `ChatBox` debemos usar eventos.

No es más que pasarle una función al subcomponente, que la ejecutará cuando sea necesario actualizar un dato, en este caso, enviar un mensaje. En `ChatBox` crearemos ese método, que enviará el mensaje a otro método que crearemos luego.
```language-javascript
// tag 06
handleMessageSubmit: function (message) {
  this.addNewMessage(message);
},
```

Este método se lo pasamos a `ChatForm`:
```language-markup
<ChatForm onMessageSubmit={this.handleMessageSubmit} />
```

Y así lo podremos acceder desde `this.props.onMessageSubmit()`.

En `ChatForm` necesitamos crear una función que se ejecute cuando se envíe el formulario. Esto se puede hacer agregando un evento *submit*.
Para usar eventos nativos de Javascript sobre elementos de HTML solo hay que poner el nombre del evento comenzando en mayúscula precedido de *on* (*onClick*, *onSubmit*, etc.).

Al recoger datos de formulario, primero debemos obtener el elemento del cual queremos obtener un dato. Para ello, podemos identificarlos con el atributo `ref`, y para acceder a ellos usamos `this.refs`. Y para poder obtener el Nodo real del DOM (recordemos que React trabaja con un DOM virtual) puedes usar `React.findDOMNode`, o el método `getDOMNode` de las `refs` (`this.refs.username.getDOMNode()`).
```language-javascript
var ChatForm = React.createClass({

  render: function () {
    return (
      <form className="chat-form" onSubmit={this.handleSubmit}>
        <input className="input username-input" type="text" placeholder="Nombre de usuario" ref="username" />
        <input className="input body-input" type="text" placeholder="¡Escribe algo! :D" ref="body" />
        <button className="button">Enviar</button>
      </form>
    );
  },

  handleSubmit: function (event) {
    event.preventDefault();

    var message = {
      username: React.findDOMNode(this.refs.username).value.trim(),
      body: React.findDOMNode(this.refs.body).value.trim(),
    }

    if (!message.username || !message.body) {
      return;
    }

    this.props.onMessageSubmit(message);
    React.findDOMNode(this.refs.body).value = '';
  },

});
```

Y tras validar el mensaje, se llama al método `onMessageSubmit` que definimos en `ChatBox`. Así es como hemos conseguido enviar el mensaje a `Chatbox`.

En el método `addNewMessage` que definiremos en `ChatBox` agregaremos el mensaje al array de mensajes y actualizaremos los subcomponentes que sean necesarios para que se muestre el mensaje. Para hacer esto usaremos estados (`states`). Los estados nos permiten guardan información del componente, al igual que las propiedades. La diferencia es que los estados sí pueden ser modificados. Únicamente deben ser usados para datos que pueden variar dentro del componente, como es el caso de nuestra lista de mensajes.

Los estados deben tener un valor inicial. La primera vez que se cargue el chat la lista de mensajes estará vacía, y para que no nos de error al tratar de acceder a la misma, debemos indicar que el estado inicial sea un *array* vacío. Eso lo haremos con el método `getInitialState`, que debe devolver un objeto con todos los estados iniciales del componente.
```language-javascript
getInitialState: function () {
  return {
    messageList: [],
  }
},
```

Para usar los estados los debemos acceder desde `this.states`, por lo que ahora le pasaremos los mensajes a `MessageList` de esta forma:
```language-markup
<MessageList messageList={this.state.messageList} />
```

Si quieres, para probar que todo va funcionando correctamente puedes definir como estado inicial el array que habíamos declarado en el método `render`.

Para finalizar, debemos actualizar el estado cuando enviamos un nuevo mensaje. Dentro del método `addNewMessage` llamaremos al método `setState`, pasándole un objeto con el estado que queremos cambiar. Este método se encargará de llamar al método `render` automáticamente para que se actualicen los subcomponentes y se muestre el mensaje.
```language-javascript
addNewMessage: function (message) {
  var messageList = this.state.messageList;
  if (messageList.length > 100) {
    messageList.shift();
  }
  messageList.push(message);
  this.setState({ messageList: messageList });
},
```

En el código, además de añadir el mensaje, si tenemos más de 100 los vamos eliminando. Así evitamos acumular miles de mensajes.

### Comunicación con el servidor
Ahora ya debes poder enviar mensajes. Pero aún no podemos hablar con otras personas, porque no se envían al servidor. Veamos cómo hacerlo.

Para comunicarnos con el servidor usamos Socket.io. Ya tenemos una variable global llamada `socket`, que se inicia en el archivo `app.js`. En el servidor tenemos un evento `message` escuchando que recibirá los nuevos mensajes y los reenviará a los demás usuarios conectados.
```language-javascript
handleMessageSubmit: function (message) {
  socket.emit('message', message);
  this.addNewMessage(message);
},
```

En otros proyectos, podrías usar AJAX sin ningún problema en este punto. La forma con la que envíes mensajes al servidor es independiente de React.

Ya podemos enviar mensajes al servidor, pero aún no podemos recibirlos. Para ello, debemos escuchar 2 eventos del servidor. `messages` nos devolverá la lista de mensajes la primera vez que nos conectemos. `message` nos enviará los nuevos mensajes que envíen los demás usuarios. Esto esta definido en el archivo server.js que puedes encontrar el el repositorio. No forma parte de React, pero puedes echarle un vistazo.

El código para escuchar esos eventos del servidor lo pondremos en el método `componentDidMount`. Este método se ejecuta automáticamente después de que el componente se cree, y solo se ejecutará una vez. Justo lo que queremos.
```language-javascript
componentDidMount: function () {
  socket.once('messages', function (messages) {
    this.setState({ messageList: messages });
  }.bind(this));

  socket.on('message', function (message) {
    this.addNewMessage(message);
  }.bind(this));
},
```

Y al recibir los mensajes, lo que hacemos es llamar al método `setState` para actualizar el estado y que se dibujen los nuevos mensajes en pantalla.

¡Y listo! Con esto ya tenemos un chat funcional creado con React. Pero aún quedan cosas por mejorar.

### Convertir JSX a Javascript
Hasta ahora, para que funcione JSX hemos incluido el archivo `JSXTransformer.js`, que se encarga de que el JSX funcione en el navegador. Pero esto no es lo más óptimo para usar en producción. Lo que debes hacer es transformar el JSX en Javascript y llamar al fichero `.js` que se ha generado.

Para generar el `.js` hay que instalar [react-tools](https://facebook.github.io/react/downloads.html#npm) con `npm install react-tools -g`. Ahora tendremos disponible el comando `jsx` para transformar los ficheros `.jsx` a `.js`.
```language-bash
jsx public/chat.jsx public/chat.js
```

Y en el HTML eliminamos la llamada a `JSXTransformer.js` y usamos `chat.js` en lugar de `chat.jsx`.
```language-markup
<script src="/chat.js"></script>
```

Y ahora sí, el chat ya está terminado :D

***

Me he saltado el *tag 09* del repositorio. Ese paso es para lograr que el tiempo de los mensajes se actualice automáticamente. Puedes ver cómo hacerlo en [el siguiente artículo](/reutiliza-tu-codigo-en-react-usando-mixins) y [en GitHub](https://github.com/nuzkito/react-chat/tree/09) :)

## ¿Qué te ha parecido?
Cuéntame qué te ha parecido este artículo-tutorial y qué te parece React. ¿Lo usarás en algún proyecto? :)

Y no te olvides, comparte el *post* con tus amigos, en redes sociales, etc. :)
