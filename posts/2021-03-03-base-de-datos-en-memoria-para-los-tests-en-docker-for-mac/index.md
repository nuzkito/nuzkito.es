---
layout: post.njk
title: Cómo mejorar el rendimiento de los tests en Docker for Mac
permalink: base-de-datos-en-memoria-para-los-tests-en-docker-for-mac/
date_published: 2021-03-03T18:09:37.000Z
date_updated: 2021-03-03T18:10:24.000Z
---

Es conocido que [el acceso al sistema de archivos en Mac desde un contenedor de Docker es lento](https://github.com/docker/for-mac/issues/77). Esto da lugar a que, entre otras cosas, los tests que ejecutan consultas a la base de datos sean más lentos que en otros sistemas.

En nuestro caso, en el que usamos MySQL, la mejor forma que hemos encontrado de mejorar el rendimiento ha sido ha sido montar el directorio */var/lib/mysql* del contenedor en memoria. De esa forma, los tests se ejecutan en memoria, pero utilizando el mismo motor de base de datos que se usa luego en producción.

Esto se puede configurar de la siguiente forma, en el archivo *docker-compose.yml*:

```yml
services:
    test_database:
        image: mysql
        tmpfs:
            - /var/lib/mysql
```
