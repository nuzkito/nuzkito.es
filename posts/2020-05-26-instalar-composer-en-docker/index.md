---
layout: post.njk
title: Instalar Composer en Docker
permalink: instalar-composer-en-docker/
date_published: 2020-05-26T21:23:27.000Z
date_updated: 2024-09-21
tags:
- PHP
- Docker
description: Instala Composer dentro de una imagen de PHP en una línea.
---

El gestor de dependencias más popular de PHP es [Composer](https://getcomposer.org/). Sin embargo, [las imágenes de Docker oficiales de PHP](https://hub.docker.com/_/php/) no incluyen Composer, por lo que hay que realizar la instalación aparte.

Por suerte, existe una [imagen oficial de Composer](https://hub.docker.com/_/composer). Las imágenes de Composer vienen con una versión de PHP predeterminada que no tiene por qué corresponderse con la del proyecto en el que estamos trabajando, así que si necesitas ejecutarlo con la misma versión del proyecto tendrás que hacer un paso previo.

Como Composer consta de un único archivo, es posible copiar el archivo de su imagen a la imagen de PHP. Podemos hacerlo extendiendo la imagen de PHP, creando un archivo Dockerfile en el que copiamos el archivo de Composer a la imagen de PHP que estamos creando:

```Dockerfile
FROM php:8.3

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
```
Con el comando [_COPY_](https://docs.docker.com/reference/dockerfile/#copy) le indicamos que copie de la imagen `composer:latest` el archivo `/usr/bin/composer` a la imagen que estamos creando. `latest` descargará la imagen con la última versión, pero si lo deseas puedes especificar una versión concreta.

Si usas [Docker Compose](https://docs.docker.com/compose/), puedes indicar que el servicio use el archivo Dockerfile de la siguiente forma:
```yml
services:
  php:
    build:
      context: .
      dockerfile: ./Dockerfile
```

## Artículos relacionados

- [Adding Composer to PHP docker images using multi-stage builds](https://medium.com/@othillo/adding-composer-to-php-docker-images-using-multi-stage-builds-2a10967ae6c1)
