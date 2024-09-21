---
layout: post.njk
title: ¡Hice una calculadora! - Creando un intérprete de código
permalink: hice-una-calculadora/
date_published: 2024-01-03
date_updated: 2024-01-03
description: Desarrollé un intérprete de código que realiza operaciones matemáticas
---

En el artículo anterior publiqué una serie de enlaces a sitios de documentación sobre cómo hacer [compiladores e intérpretes](/compiladores-e-interpretes/). Me estuve documentando porque quería rehacer un proyecto que hice hace varios años: ¡Una calculadora! :D

Pero no es una calculadora cualquiera. En esta calculadora escribes las operaciones que quieras realizar en una línea, y al lado te muestra el resultado.

![La calculadora en cuestión.](/images/2024/01/03/calculadora.png)

Para desarrollar este pequeño proyecto hice un pequeño algoritmo que separa cada token indicando de qué tipo es (número, operador, paréntesis, variable...).

Luego, se procesa esa cadena de tokens para comprobar si sigue una sintaxis válida (no puedes empezar una operación con un *, por ejemplo).

Al mismo tiempo, se construye un árbol de nodos que representa las operaciones a realizar (primero se multiplican estos 2 números, luego se le suma este otro, etc.).

Y finalmente, se ejecutan las operaciones siguiendo el orden dado.

Como extra, en mi caso también implementé un sistema de resaltado de sintaxis para mostrar cada tipo de token de un color.

Por el momento he implementado operaciones aritméticas simples, potencias y agrupación con paréntesis. También se pueden definir variables para usarlas más tarde. Y se pueden poner comentarios.

Puedes revisar su funcionamiento en https://calculator.nuzkito.es/ y el código en https://github.com/nuzkito/calculator.

El sistema se puede extender de forma sencilla para añadir nuevos operadores. Mi idea para un futuro artículo es mostrar de forma básica cómo se puede crear y extender un intérprete como este.

Si buscas una aplicación de ese tipo con un desarrollo más profesional, existen varias aplicaciones de ese estilo. Por ejemplo, para Mac he encontrado un par de aplicaciones de pago, [Soulver](https://soulver.app/) y [Numi](https://numi.app/), mucho más completas que mi pequeño proyecto.

También he encontrado un proyecto open source que funciona en web, [NoteCalc](https://bbodi.github.io/notecalc3/). Por lo que he visto, está escrito en Rust y usa WebAssembly para poder ser ejecutado en el navegador. Si te interesa saber cómo está hecha, puedes [echarle un ojo al código fuente](https://github.com/bbodi/notecalc3).
