---
layout: post.njk
title: Consejos para programar usando inteligencia artificial generativa
permalink: consejos-para-programar-usando-inteligencia-artificial-generativa/
date_published: 2025-03-23 19:31:00
date_updated: 2025-03-23 19:31:00
description: Consejos para programar usando inteligencia artificial generativa.
---

He estado redactando una serie de consejos que me parecen útiles cuando se crea código con inteligencia artificial.

## Define los requisitos
Detalla los requisitos de lo que le estás pidiendo lo mejor posible. Cuanto más detallado esté lo que quieres, mejores resultados vas a conseguir.

Por ejemplo, si estás comenzando a hacer una aplicación web y quieres usar Vue, especifícalo en los requisitos, ya que si no podría usar otro *framework*.

De igual forma puedes definir la [estructura de directorios, arquitectura o forma de escribir código](https://codely.com/blog/como-implementar-codigo-ddd-usando-ia). El algoritmo sabe generar código, pero, por el momento, no son buenos seleccionando entre una arquitectura u otra.

O si quieres usar determinadas funciones o clases que ya tienes implementadas en el código. E incluso pasar como contexto código o documentación que consideres que puede ser útil.

Por ejemplo, una de las cosas que estoy haciendo al trabajar con HTML y CSS para hacer una nueva sección es indicarle que ya tengo ciertas clases de CSS con ciertos estilos, para que reutilice esas clases en el nuevo código generado, y evitar que genere CSS que luego tenga que cambiar o borrar.

Además, en determinadas ocasiones es posible que convenga añadir un ejemplo de cómo sería un resultado final. Por ejemplo, a la hora de definir una respuesta de una API en JSON puedes añadir cómo sería ese JSON final.

## Rehaz cosas de 0 si tienes problemas
En ocasiones es más sencillo pedirle a la inteligencia artificial generativa que rehaga la solución de 0. En ocasiones, incluso puede ser buena idea iniciar una nueva conversación para que comience de nuevo sin contexto.

Al comenzar de 0 es posible que el algoritmo vaya por otros derroteros más convenientes o cometa menos errores.

Esto me parece útil cuando no consigues arreglar algún problema en la implementación en la que estás trabajando, o cuando se enfrasca en hacer las cosas de una manera no deseada y no consigues cambiar ese comportamiento.

## Revisa el código generado
Revisa todo el código que genere el algoritmo. Comprueba que no haya problemas de seguridad o de rendimiento. Ejecuta el código para comprobar que funcione. En caso de que se añadan nuevas librerías, comprueba también que están actualizadas a la última versión.

No te fíes del resultado hasta que no lo revises completamente y te asegures de que hace lo que debe.

La supervisión es importante para evitar problemas a futuro. Los algoritmos nos permitirán generar código más rápido, pero también pueden hacer que creemos problemas más rápido.

## Refactoriza
Tras revisar el código, haz la refactorización necesaria para simplificarlo, evitar código duplicado, transformar el código que no siga la guía de estilo del proyecto...

No importa si este paso lo haces de forma manual, o sigues utilizando la herramienta que estés usando para generar el código. Y no lo dejes para luego. El objetivo es que el código sea fácil de mantener y de modificar.

## Define los requisitos usando afirmaciones
Hace poco leí a una persona que recomendaba que, en lugar de decir al algoritmo que «no haga tal cosa», darle la vuelta para usar una frase afirmativa.

Personalmente, he tenido malas experiencias al indicar en el *prompt* que no se debe hacer algo. A veces lo hace igualmente.

Parece que funciona mejor pedir las cosas usando una frase afirmativa. Por ejemplo «genera siempre títulos y párrafos» en lugar de «no generes listas enumeradas».

## Sigue formándote
Aunque parezca que la inteligencia artificial generativa se va a comer el trabajo de la gente que desarrolla *software*, es importante que detrás de esa inteligencia artificial haya una persona con una formación técnica adecuada.

Cuando el algoritmo genere código que no entiendas o librerías que no conozcas, invierte un tiempo en investigar por qué ha generado ese código o qué hacen las librerías que ha incluido. Ese aprendizaje te permitirá realizar una mejor labor de supervisión.

Considero que la experiencia es lo que marcará la diferencia. Así que, independientemente de si eres estudiante, llevas poco en el sector, o ya tienes unos cuantos años de experiencia, no dejes de formarte.
