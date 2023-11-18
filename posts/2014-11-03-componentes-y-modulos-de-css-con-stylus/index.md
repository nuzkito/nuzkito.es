---
layout: post.njk
title: Componentes y módulos de CSS con Stylus
permalink: componentes-y-modulos-de-css-con-stylus/
date_published: 2014-11-03T17:33:20.000Z
date_updated: 2014-11-09T15:31:06.000Z
tags:
- Stylus
- Tutorial
- CSS
---

Gracias a los preprocesadores de CSS **es muy sencillo modularizar nuestro código** separándolo en múltiples archivos, dejando que cada uno defina estilos de un componente de nuestro sitio. Tener cada elemento separado en un archivo nos permitirá tener el **código mucho más organizado** y será **más fácil de editar**, sobretodo en proyectos grandes.

Una forma de modularizar es por componentes. Una barra de búsqueda podría ser un componente, que incluye un campo de texto y un botón. Un comentario a un artículo puede ser otro componente. Y el propio artículo, otro.

## Identifica los componentes de tu sitio
Los componentes se suelen definir en la etapa de diseño. El diseñador ya se habrá encargado de hacer una guía de estilos con los diferentes elementos del diseño.

Normalmente en un diseño hay elementos que se repiten, como pueden ser los botones. Todos los botones tienen un mismo estilo, aunque pueden tener variaciones. **Un componente representará los estilos comunes de todos los botones y sus variaciones**.

## Creando componentes con Stylus
Como mencioné al principio, cada componente estará en un archivo distinto. Puedes crear un directorio en el que guardar todos los componentes. Desde un archivo principal se importarán todos ellos.

Vamos a crear la estructura de un componente para una barra de búsqueda:
*estilos.styl*
```language-stylus
// Importamos el componente en el archivo principal
@import 'componentes/search-bar'
```
*componentes/search-bar.styl*
```language-stylus
$searchBarFontSize ?= 1em
$searchBarFontColor ?= #111
$searchBarBackgroundColor ?= #fff

.SearchBar {
  font-size $searchBarFontSize
  background-color $searchBarBackgroundColor
  color $searchBarFontColor

  input {
    background-color inherit
  }
  
  button {
  
  }

}
```

La primera parte del codigo son variables condicionales. Si la variable ya ha sido definida, no la sobreescribe. Definir las variables de esta forma **nos permite sobreescribir la configuración base de nuestro componente** desde un archivo de variables. De esta forma podremos reutilizar el componente en otros proyectos sin necesidad de modificar su código.

Debemos definir **una clase única para nombrar al componente**, nunca usar dos o más clases. Si en algún momento estás usando dos clases para un componente posiblemente debas juntar esas dos clases en una. Como es obvio, esa clase sólo se usará para ese componente.

En este ejemplo hemos supuesto que el HTML será el siguiente:
```language-markup
<form class="SearchBar">
  <input type="search">
  <button type="submit">Buscar</button>
</form>
```
Sin embargo, si no sabes qué elemento vas a usar, o si puede variar, lo recomendable es usar clases para definir los elementos que componen el componente.
```language-stylus
.SearchBar { ... }
.SearchBar-input { ... }
.SearchBar-sendButton { ... }
```
Como ves, estos elementos tienen como prefijo el nombre del componente al que pertenecen, permitiéndonos cumplir con la regla que mencioné al principio de usar una sola clase. El HTML quedaría así:

```language-markup
<form class="SearchBar">
  <input type="search" class="SearchBar-input">
  <button type="submit" class="SearchBar-sendButton">Buscar</button>
</form>
```

En Stylus también podemos hacer lo siguiente:
```language-stylus
.SearchBar {
  &-input { ... }
  &-sendButton { ... }
}
```
El `&` nos permite concatenar el nombre del componente de forma que no tengamos que repetirlo constantemente, y nos ayuda a organizar el código de una forma más visual.

Cuando queramos crear una variación del componente, por ejemplo un campo de búsqueda más grande, podemos crear un modificador de forma similar a los subelementos.
```language-stylus
.SearchBar {
  font-size $searchBarFontSize
  &--big {
    font-size $searchBarBigFontSize
  }
}
```
Pero con esto tenemos el problema de que para aplicar los estilos principales al componente modificado tendríamos que asignar las dos clases al elemento:
```language-markup
<form class="SearchBar SearchBar--big"></form>
```
Esto no es lo que queremos. Podemos solucionarlo de esta forma:
```language-stylus
.SearchBar {
  &,
  &--big {
    font-size $searchBarFontSize
  }
  &--big {
    font-size $searchBarBigFontSize
  }
}
```
Hacemos un uso inteligente del `&`(recordemos que es lo mismo que poner `.SearchBar`), y le decimos que a él y a las variaciones les aplique los estilos base. Después, cada variación reecribirá los estilos principales. Y ahora podremos usar indistintamente `SearchBar` o `SearchBar--big`.

Finalmente la estructura de nuestro componente podría quedar tal que así:
```language-stylus
$searchBarFontSize ?= 1em
$searchBarBigFontSize ?= 2em
$searchBarSmallFontSize ?= .7em
$searchBarFontColor ?= #111
$searchBarBackgroundColor ?= #fff

.SearchBar {
  &,
  &--small,
  &--big {
    font-size $searchBarFontSize
    background-color $searchBarBackgroundColor
    color $searchBarFontColor
  }
  
  &--small {
    font-size $searchBarSmallFontSize
  }
  
  &--big {
    font-size $searchBarBigFontSize
  }

  &-input {
    background-color inherit
  }
  
  &-sendButton {
    estilo loquesea
  }

}
```
Ahora solo falta que añadas tus propios estilos :).

El CSS resultante de este ejemplo es el siguiente:
```language-css
.SearchBar,
.SearchBar--small,
.SearchBar--big {
  font-size: 1em;
  background-color: #fff;
  color: #111;
}
.SearchBar--small {
  font-size: 0.7em;
}
.SearchBar--big {
  font-size: 2em;
}
.SearchBar-input {
  background-color: inherit;
}
.SearchBar-sendButton {
  estilo: loquesea;
}
```


## Nomenclatura
Yo uso una nomenclatura basada en BEM(Block, Element, Modifier). El nombre del componente comienza con mayúsculas, y si tiene varias palabras, cada una de ellas también inicia con mayúscula. Es lo que se conoce como CamelCase.
```
SearchBar // Barra de búsqueda
```
Cuando un componente tiene subelementos, estos comienzan en minúscula y se separan por un guión del nombre del componente.
```
SearchBar-sendButton // Botón de enviar de la Barra de búsqueda
```
Si el componente tiene una variación, se hace igual pero con dos guiones:
```
SearchBar--big // Barra de búsqueda grande
```

Puedes seguir la nomenclatura que quieras, o la que haya definido el equipo de trabajo. No hay por qué seguir la que yo utilizo. Lo importante es **ser consistente** y usar la misma en todo el proyecto.
