---
layout: post.njk
title: Diferentes formas de subir los archivos css y js finales a producción
permalink: diferentes-formas-de-subir-los-archivos-css-y-js-finales-a-produccion/
date_published: 2016-08-21T08:00:00.000Z
date_updated: 2016-08-21T17:32:57.000Z
---

Una práctica muy común actualmente al trabajar con CSS y JS es aplicar ciertas transformaciones al código, con la idea de mejorar tanto el flujo de desarrollo del proyecto, como el rendimiento de cara al usuario. Aunque depende del proyecto, por lo general se acaba con un par de ficheros que contienen todo el CSS y el JS de la aplicación.

Ahora bien, estos ficheros hay que subirlos a producción. ¿Cómo lo hacemos? ¿Los agregamos a Git? ¿Transformamos el código fuente directamente en el servidor? ¿Lo subimos de forma manual? Estuve investigando sobre cuál podría ser la mejor forma de lidiar con esto.

## Subirlo todo a Git (o el sistema de control de versiones que uses)

Es lo más sencillo. Haces un cambio en un fichero, ejecutas el programa que empaqueta el código, y haces un *commit* con el archivo. `git push` y ya lo tienes todo listo. Pero no todo es tan bonito.

Por un lado, cada vez que se hace un cambio en el código y se agrega un nuevo *commit*, tendremos ese fichero resultante modificado. Si esto no te preocupa, entonces no tendrás problema en trabajar de esta forma.

Otro posible problema puede encontrarse al trabajar en equipo. Si hay varias personas trabajando en el *frontend*, puede llegar a suceder que haya continuamente conflictos en estos ficheros. Solucionar esto no es un problema, pero es una molestia.

Una solución ante estos dos posibles problemas es subir el código empaquetado sólo en la rama de producción. En la rama de desarrollo, los ficheros se mantienen ignorados. Y cuando se va a subir una nueva versión de la aplicación a producción, se ejecutan las transformaciones y se sube el resultado al sistema de control de versiones.

## Subir los ficheros de forma manual

Esto quizás no tenga mucho sentido. Cada vez que se suben cambios hay que hacer pasos adicionales para poder subir todos los ficheros. A menos que estés subiendo todos los ficheros de forma manual (por ejemplo mediante un FTP), esto acaba resultando molesto.

Sin embargo quizás sí tenga sentido cuando se hace un tema para un CMS, puesto que en esos casos se le suele dar a los usuarios o clientes un fichero comprimido que contiene todos los ficheros ya preparados para funcionar. En tal caso, no sería totalmente necesario guardar una copia en el control de versiones.

## *Compilar* en el servidor al subir nuevos cambios a producción.

Es otra posible forma de actuar. Subes todos los cambios, y ejecutas [Gulp](http://gulpjs.com/), [Grunt](http://gruntjs.com/), [Webpack](http://webpack.github.io/) o lo que sea que uses.

Tras investigar, mucha gente menciona que esto da demasiados problemas. Si hay un fallo en el proceso, como la aplicación está en producción, es posible que afecte a los usuarios conectados en ese momento. Si por algún motivo no puede solucionarse fácilmente, puede convertirse en un problema grave. Esto es un detalle importante a tener en cuenta.

## Subir los ficheros a un CDN

Antes de subir los cambios a producción, se suben todos los ficheros necesarios a un CDN. Hay que tener en cuenta que lo ideal es que el proceso de publicar en el CDN sea sencillo, para que no se haga tedioso subir a producción. Existen diversas herramientas que automatizan este proceso.

También es recomendable que la aplicación en producción tenga algún mecanismo para seleccionar unos ficheros del CDN u otros, de forma que, al subir los cambios a producción, automáticamente pase a usar los nuevos ficheros.

## Utilizar herramientas de despliegue

Una opción podría ser realizar la actualización en un directorio secundario del servidor de producción, y cuando estén todos los cambios listos, modificar un enlace simbólico o renombrar los directorios. De esta forma, generaríamos los ficheros en producción, pero teniendo la posibilidad de hacer pruebas antes de pasar finalmente a producción la nueva versión de la aplicación. De esta forma, si ocurriese un problema, se podrá solucionar antes de que la aplicación sea actualizada, sin dar problemas a los usuarios conectados en ese momento.

Existen herramientas que facilitan esta tarea, y además se pueden encargar de ejecutar pruebas automatizadas y otros procesos. Conversando con la comunidad de [Styde](https://styde.net/) sobre este tema, [Ramón Lapenta](https://ramonlapenta.com/) mencionó [http://deployer.org/](http://deployer.org/). Por Twitter, [Jaime Obregón](https://www.linkedin.com/in/jaimegomezobregon) me comentó que [ellos utilizan git hooks](https://twitter.com/JaimeObregon/status/767404892692549636) para realizar la optimización y el despliegue de forma automática al hacer un `git push`.

## Resumen

Existen numerosas formas de publicar los archivos CSS y JS *compilados* en producción, cada una con sus pros y sus contras. Si estás haciendo una aplicación pequeña, o eres la única persona que está trabajando en el *frontend* de la aplicación, creo que subir los ficheros al sistema de control de versiones es sencillo y no supone ningún problema.

Por otra parte, si en la aplicación que estás haciendo se realiza un proceso de despliegue, o se usa un CDN, quizás sea mejor publicar los ficheros con estas herramientas en lugar de guardarlos en el control de versiones, ya que no necesitan estar ahí, y el propio proceso de despliegue se va a encargar de generarlos.

## ¿Qué es lo que yo hago?

Bueno, depende. Por lo general subo todo a Git y me despreocupo. Aunque en una aplicación en la que trabajo, en el servidor se ejecuta una tarea que empaqueta toda la aplicación antes de pasar a producción, usando Grunt para procesar los ficheros. Y **por ahora** no he tenido ningún problema.

¿Qué proceso sigues tú para desplegar los CSS y JS en producción? ¿Tienes algún consejo?
