---
layout: post.njk
title: Escribe buen código a pesar de las fechas de entrega
permalink: escribe-buen-codigo-a-pesar-de-las-fechas-de-entrega/
date_published: 2017-06-05T14:47:20.000Z
date_updated: 2017-06-05T14:47:20.000Z
---

Algo muy común en las empresas es que a los desarrolladores les impongan una fecha de entrega para entregar tal aplicación o tal funcionalidad. En ocasiones, tales fechas de entrega son demasiado ajustadas, y eso acaba resultando en un conflicto a la hora de programar. Muchos desarrolladores, para tratar de cumplir los plazos de entrega que les imponen, acaban reduciendo la calidad de su código, ya que escribir mal código es más rápido que escribir buen código... o al menos eso es lo que parece.

Cuando escribes mal código para acabar rápido esa funcionalidad que tiene que estar para ya, estás generando una [deuda técnica](https://es.wikipedia.org/wiki/Deuda_t%C3%A9cnica). Esa deuda técnica puede no ser un problema a corto plazo. Además, has entregado la funcionalidad a plazo, el cliente está contento, tú te sientes satisfecho porque te lo has quitado de encima... ¿cuál es el problema?

![alt](/images/2017/06/Strip-Bien-fixer-ou-bien-bien-fixer-650-finalenglish-1.jpg)

Al cabo de un tiempo, que pueden ser 2 años o pueden ser 3 meses, empiezan a surgir problemas. Cada vez aparecen más errores. Y depurar el código para corregir esos errores es toda una aventura. Agregar funcionalidades que tendrían que ser coser y cantar **se vuelve un trabajo lento y tedioso por la acumulación de malas prácticas en el código**... llegando incluso al punto de que se hace imposible agregar modificaciones en algunas partes del proyecto. Y llegado el momento, lo único que quieres es reescribir la aplicación.

Con el paso del tiempo, los problemas de haber escrito mal código comienzan a verse como algo normal. Cada poco tiempo surge algo, **los problemas son cada vez más complicados de resolver, los tiempos de desarrollo se vuelven más lentos**... Al final, todos acaban aceptando la situación, pero acaba habiendo un descontento por parte del cliente, jefe de proyecto, o la persona o personas que correspondan.

## El tiempo como excusa

Todos los que nos dedicamos a esto sabemos que programar no es fácil. Pero, ¿realmente tiene que ser así de complicado? ¿Y si te dijera que hay una forma de minimizar los problemas a largo plazo?

La solución es sencilla: **trata de escribir siempre buen código**. No pongas excusas. No digas que no tienes tiempo. No pienses que ya lo harás bien en otro momento, porque "nunca vas a tener tiempo". Cuando acabes lo que estás haciendo, vas a tener otra tarea que entregar, y luego otra, y luego otra más...

Por eso, trata de hacer bien las cosas desde el principio. ¿Que ves que no vas a llegar al plazo de entrega? No tomes el camino corto. Avisa. Pero avisa con antelación, no esperes al último momento para decir que no te va a dar tiempo. Defiende tu postura. Explica por qué necesitas más tiempo, y pide que se amplíe el plazo de entrega.

## Acostúmbrate a escribir buen código

Al principio hacer las cosas bien te puede llevar más tiempo. Pero **una aplicación bien hecha es más fácil de modificar** y ampliar. Y seguramente surjan menos problemas.

Si te acostumbras a hacer las cosas bien, con el tiempo ganarás agilidad en el desarrollo. Así que igual hoy te cuesta más, pero la próxima vez te será más fácil, porque lo tendrás interiorizado.

No es necesario que utilices todos los patrones de diseño existentes. Sólo los que veas necesarios. Organiza tu código de forma adecuada. Plantea bien cómo será la base de datos, que cambiarla después cuesta mucho más. Si veas algo que se puede mejorar, mejóralo. **Haz pruebas automatizadas**. Estas son más fáciles de hacer si las haces desde el principio del proyecto, así que no te saltes este paso, aunque te parezca una pérdida de tiempo. Te permitirán asegurarte de que no has roto algo. Acostúmbrate a hacerlo bien desde el principio.

## Prioriza

Pero ojo. Tampoco se trata de utilizar esto como excusa para no cumplir las fechas de entrega. Ten en cuenta las prioridades.

A veces no queda otra que añadir algún parche de 5 minutos, o hacer algún que otro *Ctrl+C Ctrl+V* porque hace falta algo para ya (me refiero a los casos en los que hace falta para ya de verdad, no en los que el cliente se le antoja). En estos casos, simplemente ten en mente que más tarde, si lo ves necesario, tendrás que hacer una pequeña refactorización.

Tampoco hace falta que el código de tu aplicación sea el mejor del mundo. **Busca un equilibrio entre el buen código y el tiempo** que tardes en desarrollar la funcionalidad. No te tires un mes perfeccionando tu código si lo puedes tener en una semana con una calidad aceptable. Al final, la idea es que el código sea fácil de entender y fácil de modificar. Siempre **puedes refactorizar más adelante**.

Y por último, ten en cuenta que si estás haciendo algo de usar y tirar, la calidad del código no es tan importante. Una demo no tiene por qué ser un ejemplo de arquitectura de software. Una demo es para lo que es. Prográmala, haz que funcione, preséntala, y olvidate de su código. No inviertas tiempo en algo que no vas a necesitar mantener. Ya te preocuparás cuando tengas que hacer la aplicación de verdad. Pero recuerda, cuando llegue el momento de ponerse con el proyecto de verdad, **escribe buen código**.

## Enlaces interesantes

Estos artículos están relacionados están relacionados con el tema. Te animo a leerlos:

- La deuda técnica. Todo el mundo debería saber que la mala calidad software al final se paga [http://www.javiergarzas.com/2012/11/deuda-tecnica-2.html](http://www.javiergarzas.com/2012/11/deuda-tecnica-2.html)
- Deadlines — Bad reason for bad code. [https://dev.to/jolasladislas/deadlinesbad-reason-for-bad-code](https://dev.to/jolasladislas/deadlinesbad-reason-for-bad-code)
- Entendiendo el concepto de deuda técnica [https://www.enriquedans.com/2017/06/entendiendo-el-concepto-de-deuda-tecnica.html](https://www.enriquedans.com/2017/06/entendiendo-el-concepto-de-deuda-tecnica.html)
