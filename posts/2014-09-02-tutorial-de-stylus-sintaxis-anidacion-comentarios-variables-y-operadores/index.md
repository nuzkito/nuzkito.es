---
layout: post.njk
title: "Tutorial de Stylus: Sintaxis, anidación, comentarios, variables y operadores"
permalink: tutorial-de-stylus-sintaxis-anidacion-comentarios-variables-y-operadores/
date_published: 2014-09-02T15:00:20.000Z
date_updated: 2018-08-19T04:15:13.000Z
tags:
- Stylus
- Tutorial
- CSS
---

En [el anterior artículo](/tutorial-de-stylus-no-temas-a-la-terminal) vimos **cómo usar los comandos de Stylus desde la consola**, y un pequeño apunte de cómo era su sintaxis. A continuación explicaré de forma detallada los elementos básicos que nos ofrece Stylus.

Podemos considerar a Stylus como un **lenguaje de programación que genera código CSS**. Stylus **provée variables, condicionales, bucles y funciones, como los lenguajes de programación comunes**. Todo ello con una sintaxis simple de leer.

## La sintaxis de Stylus
La sintaxis de Stylus tiene un estilo a lenguajes como Python o Ruby. **No se usan llaves para delimitar los bloques como en CSS, sino que se usa la *indentación***.
```language-css
/* Código CSS */
body {
  font-family: Arial;
  font-size: 16px;
  color: #111;
}
```
es igual a
```language-stylus
/* Código Stylus */
body
  font-family Arial
  font-size 16px
  color #111
```
Se pueden usar tantos espacios como se deseen, pero hay que ser consistente. **Si usas 2 espacios, que sean 2 espacios en todo el código**.

Como ya habrás visto, **en Stylus se pueden omitir los *dos puntos* y los *punto y coma***. Esto hace que escribir código en Stylus sea más simple y **cometamos menos errores** por olvidar poner algún *punto y coma*.

Aún así, si no te gusta esa sintaxis, **Stylus permite usar la sintaxis tradicional** de CSS, o combinar ambas. Podrías si problemas hacer lo siguiente:
```language-stylus
/* Código Stylus */
body {
  font-family Arial
  font-size 16px
  color #111
}
```
o esto otro:
```language-stylus
/* Código Stylus */
body
  font-family: Arial;
  font-size: 16px;
  color: #111;
```
o esto:
```language-stylus
/* Código Stylus */
body
  font-family: Arial
  font-size: 16px
  color: #111
```
Stylus lo acepta. Pero te recuerdo que **la consistencia es importante**, así que hazlo de la misma forma en todo el código.

## Selectores
En Stylus los selectores funcionan de la misma forma que en CSS, a excepción de un caso.

Cuando queremos aplicar un mismo estilo a varios elementos, en CSS separamos los selectores con comas:
```language-css
.clase1, .clase2 {}
```
En Stylus conseguimos lo mismo si cada selector lo ponemos en una línea distinta:
```language-stylus
.clase1
.clase2
  color #333
```
Por supuesto, si lo deseamos también podemos usar la coma:
```language-stylus
.clase1,
.clase2
  color #333
```

## Anidación
Una de las ventajas de los preprocesadores de CSS es que permiten anidar selectores de la siguiente forma:
```language-stylus
.header
  background-color #333
  .title
    color white
```
La clase `.title` está dentro de la clase `.header`. Es decir, de esta forma indicamos un elemento descendiente. Esto tendrá como resultado el siguiente CSS:
```language-css
.header {
  background-color: #333;
}
.header .title {
  color: white;
}
```

Se pueden seguir anidando elementos infinitamente, aunque no es recomendable. **A más elementos anidados, más ocupan los selectores, más pesa el archivo y más trabajo tendrá que hacer el navegador**.

### Referencia a selectores con `&`
Stylus provee un selector especial `&`. Lo podemos usar dentro de anidaciones para hacer referencia al selector principal. Veamos un ejemplo:
```language-stylus
a
  color #555
  &:hover
    color #777
```
`&` está haciendo referencia al selector `a`. En este ejemplo `&:hover` equivale a poner `a:hover` sin anidar:
```language-stylus
a
  color #555
a:hover
  color #777
```
Ambos códigos serán convertidos a este CSS:
```language-css
a {
  color: #555;
}
a:hover {
  color: #777;
}
```

También podemos aprovechar esta funcionalidad para generar nuevos selectores. Podemos hacer esto:
```language-stylus
.cuadrado
  height 200px
  width 200px
  &-rojo
    background-color red
```
En este caso `&` equivale a `.cuadrado`. Si lo juntamos con `-rojo` quedará `.cuadrado-rojo`:
```language-css
.cuadrado {
  height: 200px;
  width: 200px;
}
.cuadrado-rojo {
  background-color: #f00;
}
```
Esto puede ser muy útil cuando trabajamos CSS con técnicas como BEM, permitiéndonos construir nuestros selectores de esta forma:
```language-stylus
.Modulo
  &-elemento
    &--modificador
  &--modificador
```
que daría lugar al siguiente CSS:
```language-css
.Modulo {}
.Modulo-elemento {}
.Modulo-elemento--modificador {}
.Modulo--modificador {}
```

El `&` no necesita estar al comienzo. Por lo que podemos hacer lo siguiente:
```language-stylus
.header
  background-image linear-gradient()
  html.old-ie &
    background-image url("gradient.png")
```
En este ejemplo queremos aplicar un estilo distinto al `.header` cuando el `html` tenga la clase `.old-ie`, para ofrecer compatibilidad con versiones antiguas de Internet Explorer. En este caso el selector quedará así:
```language-css
.header {
  background-image: linear-gradient();
}
html.old-ie .header {
  background-image: url("gradient.png");
}
```

## Comentarios
En Stylus tenemos 3 tipos de comentarios.

* Comentarios en línea `//`. Estos comentarios no se muestran en el CSS final.
* Comentarios en bloque `/* ... */`. Estos comentarios se muestran en el CSS final si este no ha sido comprimido.
* Comentarios en bloque `/*! ... */`. Estos comentarios se muestran siempre en el CSS resultante, aunque haya sido comprimido.

El uso de los comentarios **nos permitirá mantener documentado el código**, mostrando en el CSS final solo aquellos comentarios que nos interesen.

## Variables
Las variables nos permiten almacenar valores y utilizarlos cuantas veces queramos en nuestro código. En una variable podemos guardar diversos tipos de datos como números, cadenas de texto, listas, objetos, valores y funciones de CSS, y bloques:
```language-stylus
numero = 4
texto = 'hola mundo'
objeto = {
  color: red,
  size: 16px
}
lista = 1 2 3 4 5 // lista[2] --> 3
otraLista = 1, 2, 3, 4, 5
pixeles = 10px
rojo = red
color = #25662e
gradiente = linear-gradient(to right, blue 20%, red)
resultado = miFuncion()
bloque =
  width 200px
  height 200px
otroBloque = @block {
  width 300px
  height 300px
}
```
Para usar una variable simplemente hay que escribirla en el lugar que queramos:
```language-stylus
ancho = 200px
.caja
  width ancho
```
```language-css
.caja {
  width: 200px;
}
```

Si queremos usar una variable en el nombre de la propiedad o en el selector **se debe poner entre llaves**:
prefijo = webkit
```language-stylus
prefijo = webkit
nombreClase = caja
.{nombreClase}
  -{prefijo}-box-sizing border-box
  box-sizing border-box
```
```language-css
.caja {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}
```
Ocurre lo mismo cuando queremos usar un bloque:
```language-stylus
cuadro =
  width 200px
  height 200px

.cuadrado
  background-color red
  {cuadro}
```
```language-css
.cuadrado {
  background-color: #f00;
  width: 200px;
  height: 200px;
}
```

### Cómo nombrar las variables en Stylus
Mi recomendación es nombrar las variables anteponiendo el signo del dólar `$`. Así **identificaremos de forma rápida las variables** en nuestro código, y evitaremos confusión con las palabras reservadas de CSS.
```language-stylus
$miVariable = valor
```

### Acceso al valor de las propiedades
Cuando estamos dentro de un selector, podemos acceder al valor que hayamos definido en otras propiedades de la siguiente forma, usando la `@` y el nombre de la propiedad:
```language-stylus
.caja
  background-color #256215
  p
    color invert(@background-color)
```
`invert` es una función que nos permite sacar el color inverso. A esa función le pasamos como parámetro `@background-color`, que coge el valor definido en el anterior `background-color`.

## Operadores
En Stylus existen diversos operadores para hacer operaciones aritméticas o comparaciones. En [la documentación oficial](http://learnboost.github.io/stylus/docs/operators.html) podéis ver todos los que existen.

Hay algún comportamiento a destacar, como en el caso de las operaciones matemáticas. Si tratas de sumar 2 unidades distintas sin ninguna relación, como por ejemplo `200px + 50s` (píxeles + segundos), el resultado de la operación será `250px`. Es decir, hace la operación numérica y le pone la unidad del primer sumando. Sin embargo, cuando las unidades tienen algún tipo de relación tratará de efectuar la operación correcta:
```language-stylus
25px + 20% = 30px // el 20% de 25 es 5
5s + 500ms = 5.5s // 500ms son 0.5s
#123 + #456 = #579 // También se puede operar con colores
```

También existen casos en los que las operaciones no se realizarán:
```language-stylus
border-radius: 20px/10px;
```
En este caso Stylus dejará el valor tal cual, porque la sintaxis de border-radius acepta ese valor. Si queremos que esa operación se ejecute debemos poner los operandos entre paréntesis:
```language-stylus
border-radius: (20px/10px);
```

Otro detalle es el operador de asignación condicional `?=`. Este operador asignará el valor a la variable solo si la variable no ha sido definida anteriormente. Nos puede ser útil para hacer plugins o módulos. En el módulo podemos definir algo así:
```language-stylus
/* modulo.styl */
responsive ?= true
```
y en nuestro archivo principal, si no queremos usar responsive en el proyecto, tan solo definimos la variable como false:
```language-stylus
/* estilos.styl */
responsive = false
```
Al ya tener el valor de `false`, cuando Stylus llega al módulo y ve el operador `?=`, se lo salta y mantiene el valor de `false` en la variable.

De esta forma es como se maneja el soporte a Internet Explorer en los mixins, agregando la variable `support-for-ie`.

***

Espero que hasta ahora vaya quedando todo claro. Continuaremos con [los condicionales y bucles en el próximo artículo](/tutorial-de-stylus-condicionales-y-bucles). **Ya viene lo divertido ;)**
