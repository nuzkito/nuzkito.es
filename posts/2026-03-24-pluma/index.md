---
layout: post.njk
title: Pluma
permalink: pluma/
date_published: 2026-03-24
date_updated: 2026-03-24
description: Pluma
---

Recientemente he creado mi propia aplicación para generar webs a partir de Markdown. Como es una aplicación pensada para escribir, he decidido llamarla Pluma. El nombre viene de las plumas estilográficas que se utilizaban para escribir antiguamente. He subido el proyecto a GitHub, por lo que cualquiera puede ver el código y utilizarlo https://github.com/nuzkito/pluma

Ya existen multitud de herramientas que generan webs estáticas en HTML a partir de Markdown u otros formatos. Así, que recuerde al vuelo, están Eleventy, Hugo, Gastby o Jekyll. Y existen decenas, o cientos más. Entonces, ¿por qué crear el mío propio?

Actualmente estoy utilizando [Eleventy](https://www.11ty.dev). Es sencillo de usar, tiene una buena comunidad a su alrededor, y realmente cumple su propósito, pero hay algunos detalles que quiero mejorar.

Por un lado, quiero algo que pueda adaptar completamente a mis necesidades. Si necesito alguna funcionalidad concreta, la programo y personalizo a mi gusto. El problema de usar herramientas de terceros es que me tengo que adaptar a ellas, no son ellas las que se adaptan a mí.

Por otro lado, quiero tener un editor en el que escribir y una interfaz en la que gestionar las páginas escritas. No conozco ninguno que funcione en local que tenga un editor incorporado. Que seguramente lo haya, pero como decidí hacer el mío propio no busqué más a fondo. Sí que hay mogollón de servicios, cada uno con sus características, pero no quiero depender de un servicio que no controle. Y tampoco quiero gestionar por mi cuenta la infraestructura necesaria para montar un Ghost o un Wordpress.

Por último, actualmente los avances en inteligencia artificial generativa facilitan mucho programar este tipo de proyectos. Los modelos actuales permiten generar código más rápido, por lo que paso menos tiempo escribiendo código, lo que me permite dedicar más tiempo a pensar cómo debe funcionar la aplicación.

Tras dedicarle unos días, tengo una primera versión funcional en la que puedo crear y editar páginas, añadir imágenes y otros recursos, y generar la web completa en HTML.

![Interfaz de Pluma](/images/2026/pluma.png)

He desarrollado la aplicación usando PHP y Laravel, por lo que para ejecutarlo es necesario tener instalado PHP.

Pluma se puede instalar de forma global con Composer:

```bash
composer global require nuzkito/pluma
```

Necesita una estructura de archivos concreta para funcionar. Se puede crear automáticamente con un comando.

```bash
pluma new
```

Para generar la web en HTML, se usa el comando `generate`, que creará la web completa en el directorio `site/`.

```bash
pluma generate
```

También hay un comando que permite lanzar el editor y un servidor que permite visualizar la web generada.
```bash
pluma serve
```

A la interfaz del editor se accede vía web. Por defecto, a través de http://localhost:8000. La web se puede previsualizar en http://localhost:8001

El editor permite crear borradores y marcarlos como publicados. Las páginas no publicadas no se incluyen en la web final.

Las páginas se guardan en archivos Markdown con Frontmatter en la carpeta `pages` dentro del proyecto, así que también se pueden editar de forma manual para hacer cambios rápidos, y se pueden exportar o importar fácilmente a otros generadores.

La generación inicial también incorpora las vistas de cada tipo de página. Se encuentran en la carpeta `views/`. Se pueden personalizar al gusto, al igual que con otros generadores de sitios estáticos. Se usa Blade como sistema de plantillas, que es el que viene por defecto con Laravel.

En `resources` se podrán guardar todos los archivos necesarios para el front (CSS, JS, imágenes, robots.txt, etc). Estos archivos se copiarán a la web cuando se genere con el comando `generate` o cuando se ejecute el editor.

El proyecto aún está verde. Tengo que seguir trabajándolo. Faltan funcionalidades que iré añadiendo poco a poco según las necesite. Aunque realmente he creado este proyecto para uso personal, si te gusta, puedes utilizarlo libremente. Y, por supuesto, puedes proponer sugerencias.

Para terminar, poco después de publicar este artículo publicaré otro en el que contaré cómo he usado inteligencia artificial generativa para crear este proyecto, y algunos de los problemas que me he encontrado.
