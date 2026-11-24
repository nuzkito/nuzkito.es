---
title: 'Mejorar la calidad del software dando un navegador a los agentes de programación'
path: mejorar-la-calidad-del-software-dando-un-navegador-a-los-agentes-de-programacion
cover_image: null
created_at: '2026-11-24T09:54:18+00:00'
draft: false
rss: true
published_at: '2026-11-24T10:06:00+00:00'
type: post
tags:
    - desarrollo-de-software
    - inteligencia-artificial
    - docker
    - agentes-de-programacion
---

Si bien los modelos de lenguaje han mejorado a pasos agigantados, para obtener mejores resultados necesitan disponer de un buen entorno de desarrollo. Una práctica que estoy utilizando desde hace un tiempo es darle a los agentes de programación la opción de que utilicen un navegador para que hagan ciertas tareas, como probar la aplicación que se está desarrollando siguiendo los pasos que haría una persona real.

Uso una imagen de Docker en la que instalo Chromium y Firefox. También incluyo Puppeteer, una librería para controlar los navegadores usando código, que es la que le digo al agente que use. He subido [la imagen que uso a Docker Hub](https://hub.docker.com/repository/docker/nuzkito/browsers/general) para poder reutilizarla rápidamente en mis proyectos. El Dockerfile es sencillo, [puedes verlo en GitHub](https://github.com/nuzkito/docker-browsers/blob/main/Dockerfile).
## Pruebas automatizadas
Las pruebas automatizadas son una de las mejores herramientas para verificar que el trabajo realizado es correcto. No solo permiten verificar que el desarrollo actual funciona, también permite comprobar que no se ha roto ninguna de las funcionalidades desarrolladas previamente.

En este proceso se puede incluir un navegador en el que se pruebe la interacción con la aplicación en un entorno más realista. Explica al agente qué librería de testing usar y cómo puede generar este tipo de pruebas, y replicará el formato.
## Pruebas exploratorias
Aparte de las pruebas automatizadas, en las que se guarda el código de la prueba para ejecutarlo durante el desarrollo posterior de la aplicación, también es útil hacer pruebas puntuales que nos permitan ir viendo cómo va el desarrollo. Es una práctica habitual durante el desarrollo, por ejemplo por si queremos ver que hemos posicionado correctamente un elemento en la interfaz o para verificar un error, y es una capacidad que también le podemos dar al agente.

La idea es que el agente abra la aplicación en el navegador cuando lo considere necesario para hacer verificaciones de diversos tipos. Pueden ser cosas como comprobar que un elemento está visible en pantalla, o leer los logs de la consola de las herramientas de desarrollo. Lo he encontrado útil para hacer ajustes de diseño o para corregir errores que no cubrían las pruebas automatizadas.

Para que el agente use los navegadores le indico en sus instrucciones qué navegadores tiene disponibles y cómo ejecutarlos. En el repositorio de la imagen incluyo [un ejemplo súper sencillo para que el agente lo replique](https://github.com/nuzkito/docker-browsers/blob/main/test/smoke.js), que se puede adaptar a cada proyecto.

```js
import assert from 'node:assert/strict';
import puppeteer from 'puppeteer-core';

const browsers = {
    chrome: { executablePath: process.env.CHROME_PATH, args: ['--no-sandbox'] },
    firefox: { executablePath: process.env.FIREFOX_PATH },
};

for (const [name, options] of Object.entries(browsers)) {
    await using browser = await puppeteer.launch({ browser: name, ...options });
    const page = await browser.newPage();
    await page.setContent('<h1>ok</h1>');
    assert.equal(await page.$eval('h1', (h1) => h1.textContent), 'ok', name);
    console.log(`${name}: ${await browser.version()}`);
}
```
## Verificación visual haciendo capturas de pantalla
Los agentes de programación más populares son capaces de leer imágenes. Si además tienen una forma de sacar capturas de pantalla, podrán usar esas capturas durante el desarrollo para verificar su trabajo. En mis pruebas ha funcionado bastante bien al hacer correcciones del diseño de la interfaz, ya que son capaces de comprobar que aparece en pantalla lo que ha creado con código.

En mi caso también le doy instrucciones a los agentes para que creen un script que genere capturas de pantalla de todas las funciones de la aplicación, y además añado que, cuando terminen un desarrollo en el que se haya modificado la interfaz, me muestren capturas de las páginas modificadas.

![Agente indicando al usuario qué capturas de pantalla ha generado.png](agente%20indicando%20al%20usuario%20qu%C3%A9%20capturas%20de%20pantalla%20ha%20generado.png)

Estas capturas las podemos usar para verificar el trabajo del agente y para ver cómo queda el diseño sin necesidad de abrir la aplicación. Además, también podemos usar el proceso para generar imágenes de documentación o ejemplos que muestren nuevas funcionalidades añadidas.
## Búsqueda de información cuando se bloquea a los agentes
En ocasiones puntuales me he encontrado que una página bloquea los *user agents* de los proveedores de modelos. Para saltar esa protección le indiqué al agente que accediese a esa web en concreto usando un navegador. Como en este caso el *user agent* es el del navegador, la web de destino no lo detecta como un modelo. También es útil si el agente que estás utilizando no tiene un mecanismo para hacer búsquedas y navegar por Internet.
## Conclusión
Que los agentes tengan capacidad de ver una web en un navegador ayuda a que el producto final tenga menos problemas y sea de mayor calidad. Al permitirles que verifiquen su propio trabajo ejecutando la aplicación en un entorno real, en el propio navegador, se reducen los errores que puedan surgir durante el desarrollo. No se trata de generar código sin más, se trata de que la aplicación funcione como se espera.
