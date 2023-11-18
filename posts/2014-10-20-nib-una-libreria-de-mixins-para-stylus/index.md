---
layout: post.njk
title: Nib, una librería de mixins para Stylus
permalink: nib-una-libreria-de-mixins-para-stylus/
date_published: 2014-10-20T11:18:19.000Z
date_updated: 2014-10-20T11:18:31.000Z
tags:
- Stylus
- Tutorial
- CSS
---

En el [primer artículo de este tutorial](/tutorial-de-stylus-no-temas-a-la-terminal) explicamos cómo usar Nib en Stylus. Ahora nos centraremos en para qué sirve y cómo utilizar algunas de sus funciones.


## ¿Para qué sirve Nib?
Nib se conoce como un plugin de Stylus que sirve para agregar los prefijos propietarios necesarios para todos los navegadores. Sin embargo, Nib también da soporte a versiones antiguas de las especificaciones de CSS - como ocurre con `linear-gradient` o *flexbox model* -. E incluso ofrece algunos pollyfils y generadores.


## ¿Cómo hago para instalar Nib?
Lo primero que hay que hacer es instalar Nib en el equipo. Se hace con este comando:
```
npm install nib
```

Ahora, cuando ejecutemos Stylus, debemos indicarle que queremos usar Nib:
```
stylus estilos.styl --use nib
```

Y por último, hacer un import a Nib en nuestro archivo de Stylus:
```language-stylus
@import 'nib'
```

Nib nos permite usar una una o varias funciones, en lugar de usar la funcionalidad completa. Si solo queremos generar los gradientes con Nib, podemos importarlos por separado:
```language-stylus
@import 'nib/gradients'
```

Revisa [el código fuente de Nib](https://github.com/visionmedia/nib/tree/master/lib/nib) para saber qué otras funcionalidades puedes importar.

## Usando Nib
Nib hace todo de forma transparente, al igual que los mixins que podemos crear nosotros.
```language-stylus
.gradiente
  background-image linear-gradient(to right, red, blue 80%)
```
Este código generará lo siguiente:
```language-css
.gradiente {
  background-image: -webkit-linear-gradient(left, #f00, #00f 80%);
  background-image: -moz-linear-gradient(left, #f00, #00f 80%);
  background-image: -o-linear-gradient(left, #f00, #00f 80%);
  background-image: -ms-linear-gradient(left, #f00, #00f 80%);
  background-image: linear-gradient(to right, #f00, #00f 80%);
}
```
Como veis, tan solo hay que escribir el CSS tal y como lo haríamos si no necesitase los prefijos. **Nib se encargará de incluirlos por nosotros**.

En el caso de que usemos *flexbox model* generará lo siguiente:
```language-css
.flex {
  display: -webkit-box;
  display: -moz-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: box;
  display: flex;
}
```
En este caso Nib genera el código para la [versión antigua de la especificación de flexbox](http://caniuse.com/#search=flexbox), que es la que soportan IE10 y versiones anteriores de Android. Gracias a ello podemos usar *flexbox* casi sin problemas a día de hoy.

Pero Nib también nos ofrece alguna otra utilidad interesante.

### Posicionamiento
Nib incluye algunos mixins personalizados para el posicionamiento de cajas.

```language-stylus
.absolute
  absolute(top 10px left 20px)
```
Este mixins genera lo siguiente:
```lanugage-css
.absolute {
  position: absolute;
  top: 10px;
  left: 20px;
}
```
Es decir, nos genera las propiedades position y top/right/bottom/left. Se puede hacer lo mismo con otros valores de `position` como `fixed` o `relative`.
```language-stylus
.menu-fijo
  fixed(top 0 right 0)
```

Aunque los paréntesis son opcionales, recomiendo usarlos en este caso, pues estas no son propiedades existentes en CSS y puede provocar confusión. Usando los paréntesis sabemos en todo momento que son un mixin.

### Imágenes responsive
Nib también tiene un mixin para ayudar a generar el CSS para backgrounds con imágenes responsive. Para ello se usa `image()`:
```language-stylus
.background-responsive
  image('images/background.jpg')
```
que nos devuelve el código compatible con todos los navegadores:
```language-css
.background-responsive {
  background-image: url("images/background.jpg");
}
@media all and (-webkit-min-device-pixel-ratio: 1.5), (min--moz-device-pixel-ratio: 1.5), (-o-min-device-pixel-ratio: 1.5/1), (min-device-pixel-ratio: 1.5), (min-resolution: 138dpi), (min-resolution: 1.5dppx) {
  .background-responsive {
    background-image: url("images/background@2x.jpg");
    -webkit-background-size: auto auto;
    -moz-background-size: auto auto;
    background-size: auto auto;
  }
}
```

### Aplicar prefijos usando las funciones nativas
Nib tiene diversas funciones para realizar todas las operaciones necesarias que podemos utilizar en caso necesario. Por defecto, Nib no aplica prefijo a la función calc. En caso de que lo necesitemos podemos usar la función `vendor-value` de la siguiente forma:
```language-stylus
.menu-lateral
  height vendor-value(calc(100vh - 2em), webkit)
```
devolviendo el siguiente CSS:
```language-css
.menu-lateral {
  height: -webkit-calc(100vh - 2em);
  height: calc(100vh - 2em);
}
```

E igualmente tenemos `vendor` para hacer lo mismo con las propiedades:
```language-stylus
.class
  vendor('propiedad', valor, webkit moz official)
```

***

Puedes ver otras funciones de Nib [revisando su código](https://github.com/visionmedia/nib/tree/master/lib/nib). Además, también podrás comprobar cómo configurar algunas de sus funciones. Por ejemplo, si quieres usar `display flex` pero solo la última versión de la especificación, puedes definir una variable que diga
```language-stylus
flex-version = flex
```
y ahora el código generado será el siguiente:
```language-css
.flex {
  display: -webkit-flex;
  display: flex;
}
```
