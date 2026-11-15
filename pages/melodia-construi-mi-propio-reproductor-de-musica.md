---
title: 'Melodia, construí mi propio reproductor de música'
path: melodia-construi-mi-propio-reproductor-de-musica
cover_image: null
created_at: '2026-11-11T18:06:37+00:00'
draft: false
rss: true
published_at: '2026-11-15T21:23:10+00:00'
type: post
tags:
    - melodia
---

Durante las últimas semanas he estado creando un reproductor de música y cliente de Spotify para Windows. Empezó siendo una prueba de concepto, pero después de varios días me pareció que me estaba quedando un proyecto chulo, así que decidí dedicarle más tiempo hasta tener una versión pulida que pudiese utilizar en mi día a día.

La idea era hacer un reproductor sencillo. La aplicación de Spotify tiene demasiadas cosas que no uso. No quería ni podcasts ni audiolibros. Tampoco quería ver las listas generadas algorítmicamente que te proponen. Además, la cola de reproducción me parece un poco confusa. Hay veces que quieres volver a escuchar la última canción, le das a volver atrás, y suena otra distinta.

Me centré en que la aplicación permita gestionar las listas de reproducción, para organizar la música a mi gusto, y en que la cola de reproducción fuese intuitiva. Además, como extra, también he conseguido una aplicación más rápida con un consumo de memoria reducido en comparación con la aplicación oficial.

![melodia.png](melodia.png)

## La elección del lenguaje: Rust
Decidí aprovechar el proyecto para aprender [Rust](https://rust-lang.org). Es un lenguaje al que llevo ya varios años queriendo echar un ojo, y últimamente parece que está ganando mucha popularidad.

Durante los últimos meses Rust se ha estado utilizando en reescrituras de varios proyectos populares en los que se han obtenido ganancias de rendimiento importantes. Además, el lenguaje parece tener ciertas cualidades que lo hacen ideal para desarrollar aplicaciones con agentes de programación, debido a cómo funciona su sistema de tipado y la gestión de memoria.



## ¿Cómo se reproduce la música?
Al crear la prueba de concepto, lo primero que quise comprobar fue si era posible reproducir la música de alguna forma en una aplicación nativa. Spotify no ofrece ningún mecanismo oficial para descargar los archivos de audio de las canciones, y el audio que se descarga en sus aplicaciones está protegido por DRM. Tras revisar su documentación vi que la única forma que había de reproducir música era utilizando el [Web Playback SDK](https://developer.spotify.com/documentation/web-playback-sdk), que sirve para integrar Spotify en una web.

Como Melodia no es una web, para poder usar el SDK, la aplicación crea un webview oculto que únicamente se encarga de la reproducción de audio. Los controles del reproductor envían las órdenes a través del webview, y el resto de acciones que no se pueden realizar con el SDK se envían a través de la [Web API](https://developer.spotify.com/documentation/web-api).

## Limitaciones de la API
Según fui construyendo el reproductor de música fui descubriendo algunas limitaciones que tiene la API oficial. Hay algunas acciones que no se pueden realizar a través de la API, como gestionar las carpetas en las que se han organizado las playlists. En este momento Melodia permite crear carpetas para organizar las playlists de forma local, pero esto no se sincroniza con Spotify porque no hay ningún mecanismo que lo permita.

Los límites de peticiones son relativamente bajos. Si se hacen demasiadas peticiones en poco tiempo, el servidor bloquea las peticiones durante un tiempo. Para algunos casos, como consultar playlits, álbumes, etc. esto se solventa implementando una caché. Sin embargo hay otros casos que no se pueden cachear, como el control del reproductor. Al principio se hacían peticiones cada varios segundos para comprobar el estado del reproductor, ya que es posible que se inicie o pause la reproducción desde otro dispositivo. Esto generaba cientos de peticiones por canción. Evité todas las que tenían que ver con los controles de reproducción utilizando el Web Playback SDK, y eliminé varias de las peticiones que se utilizan para comprobar el estado de la cola y la reproducción, a riesgo de que haya ocasiones puntuales en las que el estado del reproductor no coincida con el que almacena Spotify en sus servidores.

Las aplicaciones también tienen límite de usuarios. Para poder conectar una aplicación, hay que crear la aplicación en el panel de desarrolladores de Spotify. Por defecto, estas aplicaciones solo permiten un máximo de 5 usuarios. Por ello, al instalar la aplicación, se pide a la persona que registre una aplicación con su propia cuenta y use su propia clave de aplicación para utilizar Melodia. Hasta donde he visto, en el momento de escribir este artículo la empresa solo permite registrar aplicaciones sin límites a grandes empresas.

## Descarga Melodia
He publicado [el código del reproductor de música en GitHub](https://github.com/nuzkito/melodia), y se puede [descargar la aplicación desde su web](https://melodia.nuzkito.es). Todavía quiero mejorar algunos aspectos de la interfaz y añadir algunas funcionalidades que se me han quedado en el tintero. Iré sacando nuevas versiones poco a poco. Si te interesa el proyecto y lo quieres probar, agradezco sugerencias y comentarios para mejorar la aplicación, e incluso pull requests en GitHub ;)