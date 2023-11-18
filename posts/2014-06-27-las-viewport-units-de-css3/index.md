---
layout: post.njk
title: Las "Viewport Units" de CSS3
permalink: las-viewport-units-de-css3/
date_published: 2014-06-27T19:22:32.000Z
date_updated: 2014-07-04T17:06:41.000Z
tags: CSS
---

Una de las novedades que incorporó CSS3 son las *viewport units*. Estas unidades de medida se basan en el ancho y el alto del contenedor inicial. El contenedor inicial generalmente es el *viewport* del navegador, aunque en el caso de los iframes, tomará en cuenta el tamaño del iframe.

Estas unidades son excelentes para hacer *responsive design*, precisamente por ser relativas al tamaño del *viewport*. Veamos a continuación cómo funcionan.

## ¿Cuáles son estas medidas?

Existen 4 unidades:

- **vh**: 1vh es equivalente al 1% de la altura del *viewport*. 100vh es equivalente al 100% de la altura.
- **vw**: Exactamente igual que el vh, pero respecto al ancho.
- **vmin**: La menor de las dos medidas.
- **vmax**: La mayor de las dos medidas.

## ¿Y esto lo soportan todos los navegadores?

A la hora de escribir este post, casi todos los navegadores soportan estas medidas, aunque en algunos casos solo parcialmente. Según [Can I Use](http://caniuse.com/viewport-units) en Safari para iOS hay un error con la medida *vh*, y en varios navegadores no está implementado *vmax*. Posiblemente en poco tiempo el único que de problemas sean las viejas versiones de IE, que por suerte poco a poco van desapareciendo.

## Responsive design

El principal uso de estas medidas es para crear diseños que se adapten a la pantalla. Un buen ejemplo puede ser [este cronómetro](/experimentos/cronometro/) que hice aprovechando la unidad *vmin*. Todas las medidas están basadas en esta unidad, y con ello se consigue que el cronómetro siempre ocupe todo el espacio posible de la pantalla. Simplemente redimensionad el navegador para comprobar como el tamaño se mantiene proporcional en todo momento.

La combinación de las diferentes unidades puede ser útil en diversas situaciones a la hora de crear diseños basados en el tamaño del *viewport*.

Un claro ejemplo es cuando queremos hacer algo que se adapte a la altura de la pantalla. Por ejemplo, queremos que un menú lateral ocupe el 100% de la altura. Podemos hacer fácilmente lo siguiente:

```css
.menu {
    height: 100vh;
}
```

## Detalles a tener en cuenta

- El tamaño del contenedor inicial se ve afectador por la presencia de las barras de scroll. Si por ejemplo el ancho del navegador tiene 1600px y existe una barra de scroll (vamos a poner que tiene 20px de ancho), 100vw equivalen a 1580px.
- Como mencioné al principio, si el contenido se muestra dentro de un iframe, las medidas del contenedor inicial serán las del iframe, de nuevo, restando el tamaño de las barras de scroll.

Esto es lo básico a conocer sobre las *viewport units*. En un próximo artículo hablaré sobre cómo combinarlas con las medidas ya existentes aprovechando la función calc.
