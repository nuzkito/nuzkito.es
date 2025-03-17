---
layout: post.njk
title: Eventos de animaciones de CSS
permalink: eventos-de-animaciones-de-css/
date_published: 2025-03-17
date_updated: 2025-03-17
description: Breve explicación de cómo escuchar los eventos de las animaciones de CSS desde JS.
---

Las [animaciones de CSS](https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_animations/Using_CSS_animations) emiten eventos que se pueden escuchar desde JS, útil para ejecutar algo antes o después de una animación.

No era consciente de esto hasta que, haciendo un pequeño experimento, se me dio un caso en el que me venía bien ejecutar JS justo cuando acabase la animación de un elemento determinado.

Se pueden emitir 4 eventos distintos del tipo [AnimationEvent](https://developer.mozilla.org/en-US/docs/Web/API/AnimationEvent):
- [animationstart](https://developer.mozilla.org/en-US/docs/Web/API/Element/animationstart_event), cuando la animación comienza.
- [animationend](https://developer.mozilla.org/en-US/docs/Web/API/Element/animationend_event), cuando la animación termina.
- [animationcancel](https://developer.mozilla.org/en-US/docs/Web/API/Element/animationcancel_event), cuando la animación se cancela sin que haya terminado.
- [animationiteration](https://developer.mozilla.org/en-US/docs/Web/API/Element/animationiteration_event), cada vez que la animación se repite de nuevo, si esta se ejecuta más de 1 vez seguida.

Además, una de las propiedades del evento es `animationName`, útil para diferenciar la animación en caso de que el elemento tenga varias.
Para escuchar estos eventos desde JS, hay que seleccionar el elemento que tiene la animación y añadir el «listener» de la misma forma que se hace con otros eventos de JS.
```js
const animatedElement = document.querySelector('.animatedElement')

animatedElement.addEventListener('animationend', function (event) {
	console.log(event.animationName)
})
```

Usar estos eventos me parece útil para construir experiencias interactivas. Puedes ver un par de ejemplos en [el código de esta demo](https://github.com/nuzkito/lab/blob/main/916/index.html), en donde se escucha el evento `animationend` de varios elementos determinados para comenzar a reproducir un audio.

```js
lastFadeOut.addEventListener('animationend', () => {
    audio.currentTime = 0
    audio.play()
}, { once: true })
```
```js
start.addEventListener('animationend', () => {
    mediaQuery.addListener(event => {
        if (event.matches) {
            play()
        } else {
            pause()
        }
    })
}, { once: true })
```
