---
layout: post.njk
title: Usa las nuevas características de JavaScript hoy mismo con Babel
permalink: usa-las-nuevas-caracteristicas-de-javascript-hoy-mismo-con-babel/
date_published: 2016-03-12T17:04:22.000Z
date_updated: 2016-03-28T21:30:12.000Z
tags: JavaScript
---

[Babel](http://babeljs.io/) es una herramienta que **transforma nuestro JavaScript del futuro en JavaScript que entiendan los navegadores actuales (¡o Node.js!)**. El uso más común de esta herramienta ha sido transformar el código de las nuevas características de ES6. Sin embargo, la herramienta también servirá para los futuros cambios de la especificación.

Además, con Babel no sólo podremos transformar las nuevas características de Javascript. **También nos será posible transformar lenguajes como JSX**, un lenguaje que suele ser utilizado junto a React.

## ¿Cómo funciona Babel?
Babel **hace uso de plugins** para implementar las transformaciones. Para cada cosa que quieras transformar, debes agregar un plugin. Esto nos permite elegir qué características queremos que transforme. Una ventaja que otorga esta forma de trabajar es que, una vez cierta característica esté soportada, podemos eliminar únicamente el plugin de dicha característica, y continuar transformando el resto.

El equipo de Babel provee varios plugins. Puedes [consultarlos en su web](http://babeljs.io/docs/plugins/).

### Presets
_Poder decidir qué plugins usar puede ser una ventaja, pero yo quiero transformar **ya** mi código ES6 y que funcione en todos los navegadores._

**Un _preset_ es un conjunto de plugins**. Por ejemplo, tenemos un [_preset_ para usar ES2015](http://babeljs.io/docs/plugins/preset-es2015/), y otro [para usar React](http://babeljs.io/docs/plugins/preset-react/). De esta forma no tendremos que instalar los _plugins_ uno a uno. Además, la comunidad también puede crear sus propios _presets_. Puedes encontrarlos buscando [babel-preset](https://www.npmjs.com/search?q=babel-preset) en NPM.

## Instalación, uso y configuración
Babel está escrito en JavaScript, por lo que debes tener Node.js en tu equipo. Puedes instalarlo con NPM usando el siguiente comando:
```language-bash
npm install --save-dev babel-cli
```

Eso instalará la utilidad de línea de comandos de Babel de forma local. Te recomiendo hacerlo así en todos los proyectos, en lugar de instalarlo de forma local. De esta forma, podremos tener varios proyectos en nuestro equipo usando distintas versiones de Babel sin que haya conflictos.

Ahora vamos a crear un fichero de prueba para comprobar que Babel funciona correctamente. Usaré como ejemplo código extraido de la propia web de Babel.
```language-javascript
// Expression bodies
var odds = evens.map(v => v + 1);
var nums = evens.map((v, i) => v + i);

// Statement bodies
nums.forEach(v => {
  if (v % 5 === 0)
    fives.push(v);
});

// Lexical this
var bob = {
  _name: "Bob",
  _friends: [],
  printFriends() {
    this._friends.forEach(f =>
      console.log(this._name + " knows " + f));
  }
};
```

Y para ejecutar Babel, usamos el siguiente comando:
```language-bash
./node_modules/.bin/babel source.js > compiled.js
```
`source.js` es el archivo en el que tenemos nuestro código original, en ES2015 (o ES2016, o JSX, o lo que sea). `compiled.js` será el fichero en el que se guarde el código que incluiremos en nuestro navegador (o en el entorno correspondiente).

Como no estamos usándolo de forma global, usamos la ruta en la que se guarda el ejecutable tras instalarse con NPM. Para evitar tener que escribir el comando continuamente, puedes configurarlo como un script de NPM. Simplemente añade en el package.json lo siguiente:
```language-javascript
  "scripts": {
    "babel": "./node_modules/.bin/babel source.js > compiled.js"
  },

```
Así que ahora para usar Babel podrás ejecutar
```language-bash
npm run babel
```
Ahora, si observas el código resultante, verás que no ha habido cambios. Eso es porque, como comenté anteriormente, el núcleo de Babel por sí sólo no hace nada. Vamos a instalar el _preset_ de _es2015_:
```language-bash
npm install --save-dev babel-preset-es2015
```

Una vez instalado, debemos indicar a Babel que use dicho _preset_. Para ello, Babel usa un fichero de configuración llamado `.babelrc`. Si ese fichero existe en la raíz de nuestro proyecto, usará la configuración definida en él. Crea el fichero con el siguiente contenido:
```language-javascript
{
  "presets": ["es2015"]
}
```
Si instalas más _presets_, puedes definirlos ahí. En el caso de que estés usando plugins, puedes agregarlos usando la clave `plugins`:
```language-javascript
{
  "plugins": ["transform-es2015-arrow-functions"]
}
```

Si ejecutas ahora `npm run build`, podrás comprobar que ahora sí se transformó el código.

### Polyfills
Algunas características, como las promesas o los generadores, hacen uso de _polyfills_ para funcionar. Babel ya tiene un paquete que incluye todos los _polyfills_ necesarios llamado `babel-polyfill`. Para usarlo, tan sólo incluye al principio de tu código `require('babel-polyfill');`, o incluye el fichero `node_modules/babel-polyfill/dist/polyfill.min.js` en una etiqueta `<script>` en el navegador.

## Documentación oficial
Si necesitas ayuda, en la web de la herramienta está toda la documentación: http://babeljs.io/
Se explica cómo usarlo [junto a diversas herramientas](http://babeljs.io/docs/setup/), cómo [instalar cada plugin o preset](http://babeljs.io/docs/plugins/), y las correspondientes configuraciones que admite.
