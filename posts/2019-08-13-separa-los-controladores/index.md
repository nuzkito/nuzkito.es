---
layout: post.njk
title: ¡Separa los controladores!
permalink: separa-los-controladores/
date_published: 2019-08-13T18:08:00.000Z
date_updated: 2020-05-24T14:01:57.000Z
tags: Arquitectura de software
description: Explico cómo separar el código de los controladores en archivos más pequeños de forma que el código quede mejor organizado.
---

Lo que veo más habitual al trabajar en una aplicación web, principalmente en el caso del backend, es que los puntos de entrada de la aplicación se organicen en controladores, y que cada controlador agrupe los métodos relacionados con una entidad en concreto.

Por ejemplo, teniendo una entidad *Post* en la aplicación, se suele crear un *PostController* con los correspondientes métodos para listar, ver, crear, editar y eliminar los artículos. Es decir, las acciones del típico CRUD.

```text
PostController
    index
    show
    create
    update
    delete
```

Si además la aplicación también genera el HTML, serán necesarios como mínimo un par de métodos más para mostrar los formularios de edición y creación.

```text
PostController
    index
    show
    create
    store
    edit
    update
    delete
```
‌Pero, ¿qué pasa si también se necesita poder votar artículos o guardarlos como favoritos? Posiblemente acaben en el mismo controlador, porque son acciones que se realizan sobre el artículo... ¿no?

```text
PostController
    index
    show
    create
    store
    edit
    update
    delete
    vote
    unvote
    fav
    unfav
```

Con las acciones para añadir y eliminar votos y favoritos, el PostController ya tiene 11 métodos. Si más adelante hay que añadir nuevas funcionalidades, es posible que se junten aquí, y el controlador empiece a crecer desmesuradamente ganando líneas y líneas. Por lo general, como desarrolladores queremos que nuestras clases no tengan demasiadas líneas para que sea más fácil leer el código, por lo que voy a explicar cómo se puede mejorar.

Un primer paso es tratar los votos y los favoritos como entidades. Posiblemente sean una relación muchos a muchos entre la entidad de usuarios y la de artículos, por lo que estas nuevas entidades serían un equivalente a las tablas pivote mediante las que se relacionan.

Teniendo dichas entidades, usando el patrón de un controlador por entidad, ahora existiría lo siguiente.

```text
PostController
    index
    show
    create
    store
    edit
    update
    delete

VoteController
    store
    delete

FavController
    store
    delete
```

‌Si ahora hubiese que añadir una funcionalidad para comentar un artículo, se puede crear un controlador de comentarios, a pesar de que la acción comentar se realice sobre un artículo, y a pesar de que la ruta pueda ser *POST /posts/7/comments*. Así se libera al controlador de artículos de tanta carga. Además, de esta forma es posible mantener los métodos típicos utilizados en un CRUD.

Ahora vamos a ir un poco más allá. Al crear un artículo este no va a ser publicado de inmediato, sino que estará en borrador para poder ampliarlo y hacer correcciones antes de publicarlo. Por lo que será necesario añadir otra acción... pero las de crear y actualizar ya están pilladas, ¿qué se puede hacer? Quizás lo más adecuado sea añadir un método publish al controlador de artículos...

Y varias funcionalidades después nos damos cuenta de que el controlador de artículos vuelve a crecer. Además ahora sí que hay acciones únicamente relacionadas con el artículo, por lo que no se puede sacar una entidad de ahí. Por ejemplo, la acción de publicar un artículo lo único que hace es guardar la fecha de publicación.

Una opción para evitar que los controladores sigan creciendo es dejar de juntar las acciones relacionadas con un modelo. En su lugar, se creará un controlador por cada acción que se pueda realizar en la API. Estos controladores tendrían un único método, por lo que el controlador representaría en su conjunto a la acción que se quiere realizar.

Trabajar de esta forma nos permite encapsular cada funcionalidad en su propio controlador, de forma que cumplimos con el principio de responsabilidad única en los controladores. Por otro lado, también nos permite definir un nombre más conciso a cada controlador, de forma que en el propio nombre del mismo quede claro qué acción representa el mismo. Por ejemplo, en el caso de la acción de publicar el artículo, el controlador puede ser *PublishPostController*.

Ahora bien, ¿en qué momento se debe comenzar a separar los controladores de esta forma? Bueno... depende. De tu aplicación y del criterio que quieras seguir.

Al comentar esto con otras personas, la mayoría dijeron que no harían un controlador para cada acción, sino que mantendrían los controladores CRUD, y crearían controladores de una única acción sólo en esos casos en los que una nueva funcionalidad no encaja dentro de un CRUD. Esta idea [la comenta Freek Van der Herten, entre otros pequeños consejos, en su charla *Simplification Tips and Tricks*](https://www.youtube.com/watch?v=FxACh4X-Xc0)*.*

También he visto algún caso en el que el controlador mapea directamente con una ruta, y el nombre que tiene se compone de la entidad o acción y del método de HTTP utilizado. Puedes ver un ejemplo en [el repositorio de ejemplo que utilizan en algunos cursos de CodelyTV](https://github.com/CodelyTV/cqrs-ddd-php-example/tree/49a662180858e08251a25a83169b600c972dfd11/applications/mooc_backend/src/Controller/Video). En su caso, *VideoPostController* sería el controlador para publicar un vídeo, y se asociaría a la ruta *POST /videos*, mientras que el *VideoGetController* sería el controlador que obtiene los datos de un vídeo, y se asociaría a la ruta *GET /videos/:id*.

Y por último me pareció interesante este artículo titulado [*Goodbye controllers, hello request handlers*](https://jenssegers.com/85/goodbye-controllers-hello-request-handlers), que introduce el concepto de *request handler* en sustitución del concepto de controlador. En el artículo, el autor comenta las ventajas que le ve a crear un controlador (o *request handler*) por acción.

---

Añado también este artículo, [The Beauty of Single Action Controllers](https://driesvints.com/blog/the-beauty-of-single-action-controllers/), donde también comentan el mismo punto de vista.
