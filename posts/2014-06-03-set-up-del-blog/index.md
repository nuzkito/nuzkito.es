---
layout: post.njk
title: Set Up del blog
permalink: set-up-del-blog/
date_published: 2014-06-03T18:49:11.000Z
date_updated: 2014-08-12T12:23:56.000Z
tags: Blog
---

¿Qué mejor que comenzar un blog que hablar de cómo funciona y con qué tecnologías está creado? Si os habéis fijado en el pie, Devlog está hecho con [Ghost](https://ghost.org/).

¿Y qué es Ghost? Ghost es un blog. Por ahora no es más que eso. Un proyecto de código abierto y gratuito, al igual que otros como [Wordpress](https://wordpress.org/), pero [construido en Nodejs](http://nodejs.org/). Aún **es un proyecto muy joven** que no tiene tanta potencia como puede tener Wordpress - está en la versión 0.4.2 y comenzó a ser desarrollado hace unos meses -. Sin embargo el hecho de ser un proyecto reciente ha dado la posibilidad a los desarrolladores a plantearse bien la organización del proyecto de cara a tener un proyecto escalable y fácil de desarrollar y agregar funciones.

Sigamos con el tema del *Cómo se hizo*. Quizás no en esta primera publicación, pero en futuras entregas voy a mostrar código. Para mostrar código [hago uso de Prism](http://prismjs.com/). Prism es un resaltador de sintaxis creado por [Lea Verou](http://lea.verou.me/). Es muy sencillo de usar, simplemente hay que incorporar un script y un CSS en el HTML. En la web del proyecto se da la posibilidad de incorporar varios plugins y lenguajes para personalizarlo al gusto.

Por último haré mención del servidor. Todo esto funciona sobre [Nginx](http://nginx.org/). Nginx es el servidor web que se encarga de redirigir el tráfico a la página correcta. Es un proyecto que está ganando mucha popularidad **debido a su alto rendimiento**, aunque por ahora Apache sigue siendo el rey en cuota de uso - de momento -.

Por otro lado, a diferencia de las aplicaciones hechas en PHP, es necesario mantener Node ejecutándose en un proceso. Para ello uso [forever](https://github.com/nodejitsu/forever), que se encarga de mantener la aplicación *on* y la vuelve a levantar en caso de que *se rompa misteriosamente*. También aprovecho crontab para todo aquello que forever no puede hacer por sí solo (como iniciar todo cuando se reinicia la máquina que aloja la web).

Y eso es todo. No tiene más. Realmente montar esto *es bastante simple* - excepto cuando tocas algo que no debes en el servidor y lo rompes -. Y aunque ciertamente usar Wordpress sí que habría sido sencillo - solo es soltar los archivos en un FTP y ya -, investigar y aprender nuevos proyectos nunca viene mal.
