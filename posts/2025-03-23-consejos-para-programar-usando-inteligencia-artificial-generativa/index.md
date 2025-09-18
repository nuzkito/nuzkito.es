---
layout: post.njk
title: Consejos para programar usando inteligencia artificial generativa
permalink: consejos-para-programar-usando-inteligencia-artificial-generativa/
date_published: 2025-03-23 19:31:00
date_updated: 2025-09-18 17:10:00
description: Consejos para programar usando inteligencia artificial generativa.
---

Este último año se han popularizado las herramientas que utilizan inteligencia artificial para programar. Durante los últimos meses he estado probando varias aplicaciones y diferentes modelos de lenguaje. Y poco a poco he ido viendo qué cosas me funcionaban, y cuáles no me daban buenos resultados.

En mi caso, lo que mejor me funciona es tener una participación activa en la conversación con el LLM. Más que usarlo como un generador de código sin más, lo utilizo como apoyo, tratando de mantener el mismo nivel de calidad que si no utilizase un LLM. En ningún caso me limito a aceptar el código que me propone sin más, si no que itero la propuesta y hago los cambios necesarios para adaptarlo a mis criterios.

Durante el artículo voy a usar el término «LLM» (Large Language Model) en lugar de otros como «IA» o «agente», ya que me parece un término más adecuado. Al fin y al cabo, lo que hay detrás de todas estas herramientas, independientemente de cómo las categoricen, es un LLM.

Ten en cuenta que lo que voy a explicar a continuación está enfocado en realizar aplicaciones que quieres mantener a lo largo del tiempo, en las que buscas que el código sea de calidad, que el software sea fácil de mantener y de ampliar.

## Planificación
Cuando quiero comenzar a programar una funcionalidad hago una pequeña planificación de cómo quiero hacer el código. Lo hago igual que si no usase un LLM. Pienso en qué patrones usar, cómo se van a llamar las clases y funciones, y cómo se comunican los diferentes componentes entre sí. La única diferencia es que, en lugar de guardármelo para mí y ponerme a escribir código, lo pongo por escrito para explicárselo al LLM.

Durante esta fase, en ocasiones pregunto dudas al LLM. Cosas como «qué puede ser mejor, hacer *A* o *B*», o «qué ventajas tiene la librería *X* respecto a la *Y*», o incluso preguntas sobre el código actual de la aplicación. No le pido código aún, tan sólo estoy usando el LLM como si fuese una especie de buscador, para poder aclarar cómo enfocar el desarrollo. Algo así como pedirle a un compañero que te dé su opinión. Luego ya decidiré si hacerle caso o no en base a mis conocimientos. Esto no elimina el hecho de buscar información directamente en Internet. Si estoy buscando información sobre alguna librería, no me limito a preguntar al LLM, también voy a la propia documentación de la librería.

Una vez tengo claro qué quiero hacer y cómo, le doy las instrucciones al LLM para que, ahora sí, genere el código.

## Cómo dar las instrucciones al LLM
Lo primero de todo, cuando comienzo a trabajar en cualquier cosa, es crear una conversación nueva con el LLM. Siempre. Esto es por evitar mezclar contextos de otras cosas que, aunque puedan estar relacionadas, pueden confundir al LLM.

Al detallar las instrucciones me limito a explicar qué es lo que quiero hacer lo más detalladamente posible. Doy detalles técnicos, entre los que incluyo:
- Principales tecnologías utilizadas, como por ejemplo lenguajes, frameworks y guías de estilos utilizadas en el proyecto
- Patrones de diseño a utilizar en el código a generar
- Qué nombres usar para algunos componentes
- Referencias a código o librerías que puedan ser útiles para ese desarrollo
- Ejemplos de código de programación, formatos de respuestas en json, xml, csv... Cualquier cosa que sea relevante
- Las pruebas automatizadas a crear

La idea es que el código que genere el LLM siga las reglas que yo le indico. Le especifico cómo debe crear esa funcionalidad, junto con toda la información que sea necesaria. De esa forma, mantengo el control de cómo se crea el código, y así una buena parte del código generado va a ser en base a mi propio criterio.

Tras una primera versión de código generado, si es necesario, continúo la conversación con el LLM para iterar la solución hasta que llegue a un punto en el que considero que el LLM no puede ofrecer una mejor solución. En ese momento, paso a la revisión y refactorización del código.

### Instrucciones comunes
En algunas ocasiones, algunas de las instrucciones son comunes a todas las conversaciones. Un ejemplo claro son las tecnologías del proyecto. Si estoy programando algo con PHP, especifico al principio de la conversación que el lenguaje utilizado en el proyecto es PHP. Esto ahorra tiempo al LLM, que no necesita ver qué código tiene el proyecto para saber que es PHP, y además ayuda a evitar que genere, de forma errónea, código en otros lenguajes.

Estas instrucciones comunes las especifico en el _system prompt_ o en el mecanismo equivalente que presente la herramienta que estoy utilizando. Algunas herramientas tienen su propio sistema para definir estas instrucciones comunes, aunque varias de las más populares han empezado a estandarizarlo utilizando un archivo llamado [AGENTS.md](https://agents.md/) en el que se incluyen las instrucciones en formato Markdown.

### Conflictos con los _system prompts_ de las herramientas
Algo que aconsejo es echar un ojo al system prompt de la herramienta que utilices. La idea es evitar introducir contradicciones en las instrucciones que le demos al LLM. Si por ejemplo el system prompt de la herramienta dice que debe incluir comentarios en el código, y luego le digo en mis instrucciones que no utilice comentarios, le estoy generando una contradicción. Cuando pasa eso, el resultado puede ser impredecible, así que es algo que intento evitar.

### Pruebas automatizadas
Para mí, crear los tests es la parte más pesada y aburrida del desarrollo de software. Pero también es una de las tareas más importantes en proyectos que deben mantenerse a largo plazo. Así que en esto me apoyo casi totalmente en el LLM, pero con ciertas consideraciones.

Suelo especificar qué pruebas quiero generar. Puedo pedir un test que compruebe que «el campo de email recibe un email de forma correcta», y otro que «el campo de email de un error si no se introduce un email bien formado». En ocasiones también puedo pedir al LLM que complemente los tests, por si se le ocurre un caso de uso que no se me ha ocurrido a mí. Sin embargo, sigo manteniendo la parte en la que analizo previamente qué tests necesito. El LLM, por muy bueno que sea, también se puede dejar casos de uso sin probar.

Una cosa que me ha funcionado relativamente bien es pedir al LLM que ejecute los tests que haya creado. En caso de utilizar una herramienta que no tiene capacidad para ejecutar tests, tambien puede funcionar pegar los errores en la conversación. Si encuentra algún error, entonces le dejo que intente solucionarlo por su cuenta. No siempre consigue arreglar el problema, pero en ocasiones ahorra un poco de tiempo.

## Revisión y refactorización
Al generar código con un LLM, la revisión es un punto muy importante. Primero trato de entender cómo funciona el código que ha generado. Entender qué hace el código me parece una de las cosas más importantes.

Luego, compruebo que el código efectivamente funciona como he especificado. Y si puede haber problemas de rendimiento o de seguridad. También reviso los tests. Las pruebas automatizadas también deben probar los casos de uso correctos, por lo que aunque los tests pasen, es importante revisar que efectivamente prueban lo que deben.

Si el código y los tests son correctos, entonces paso a refactorizar el código, en caso de que lo vea necesario. Para esto suelo usar las funciones del editor de código. Cosas como renombrar elementos, mover código de un lado a otro o pasar el linter ya lo hace bien el editor, por lo que no es necesario usar el LLM.
