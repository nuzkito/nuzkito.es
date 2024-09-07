---
layout: post.njk
title: No sabemos estimar
permalink: no-sabemos-estimar/
date_published: 2024-09-07
description: Una de las cosas que solemos hacer al desarrollar software es estimar cuánto vamos a tardar. El problema es que se nos da mal estimar por nuestra cuenta, por lo que tenemos que buscar alternativas que nos permitan tener mejores estimaciones.
---
Una de las cosas que suelen tratar de hacer las empresas es estimar cuánto van a tardar en construir el software. Por lo general, la responsabilidad de realizar esas estimaciones recae sobre la gente que programa ese software.

De primeras parece tener sentido. La persona que está haciendo el trabajo es la que más conocimiento tiene para saber cuánto va a tardar en hacer ese trabajo. Pero, ¿realmente sabemos cómo hacer esas estimaciones?

El proceso de estimar cuánto se va a tardar en programar algo es totalmente subjetivo, y además depende de cada persona. Es muy complicado estimar un proyecto de desarrollo de software en base a unas reglas deterministas.

En mi caso, cuando trato de estimar una nueva funcionalidad a desarrollar, lo intento encajar en una de las siguientes categorías:
- Fácil y rápido.
- Fácil pero lento.
- Difícil pero rápido.
- Difícil y lento.

Que son subjetivas y relativas a unos criterios propios que, probablemente, no coincidan con los de mis compañeros.

En ningún momento pienso en “voy a tardar tantas horas en programar esto”. Habrá veces que lo intente y me acerque, pero lo normal es que me equivoque. Y peor, lo normal es que lo subestime. Casi siempre termino tardando más de lo que esperaba.

## ¿Qué hace que un proyecto de software sea tan difícil de estimar?

Por desgracia, el desarrollo de software no es como una fábrica de montaje, en la que el tiempo de construcción se puede medir de una forma bastante objetiva. Si estás fabricando tornillos, y fabricas un tornillo por segundo, sabes que 1000 tornillos van a tardar 1000 segundos en fabricarse. Aunque haya un margen de error más o menos subjetivo, puedes medir de forma bastante certera la mayor parte del proceso.

El desarrollo de software es un trabajo creativo, en el que influyen los conocimientos de cada persona, las características del negocio y otros factores difíciles de controlar. El conjunto de esos factores puede hacer que dos proyectos aparentemente similares tengan tiempos de desarrollo totalmente distintos.

Además es común encontrarse errores, problemas y cambios inesperados que retrasan el desarrollo. Aunque se puedan implementar medidas para mitigarlos, siempre van a estar ahí, en mayor o menor medida.

## Cómo hacer estimaciones más objetivas

La mejor forma que se me ocurre de hacer estimaciones es que esas estimaciones no las hagan personas. De esa forma, eliminamos los sesgos que tengamos en nuestra cabeza. Podemos buscar una alternativa que aplique criterios objetivos, dentro de lo posible.

En el fondo, lo que intentamos hacer en nuestra cabeza es tener en cuenta cuánto tardamos en hacer algo similar en el pasado. La mejor forma que se me ocurre de hacer eso eliminando nuestros sesgos eso es usar la estadística.

Lo primero que tenemos que hacer es un trabajo de categorización. Por ejemplo, una empresa que se dedique a desarrollar webs a clientes podría categorizar sus desarrollos en landings y crms. Una landing es sencilla de hacer, mientras que un crm requiere desarrollar numerosas funcionalidades, por lo que quizás deban analizarse por separado. Hay que tener cuidado de no mezclar categorías.

Tras esa categorización, si de media se tarda 1 semana en hacer una nueva funcionalidad para un crm, se puede estimar que las próximas 10 funcionalidades que se añadan costarán unas 10 semanas.

Una vez se hayan hecho los correspondientes análisis, podemos dejar que las futuras estimaciones las haga una fórmula que tenga en cuenta los datos que hemos acumulado con el tiempo.

***

Tengo claro que a las personas se nos da mal realizar estimaciones por nuestra cuenta. Por ello, hacer los cálculos en base a los datos que ya tenemos es la mejor forma que se me ocurre de obtener unas estimaciones lo más objetivas posibles.
