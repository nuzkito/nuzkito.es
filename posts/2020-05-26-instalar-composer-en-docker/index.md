---
layout: post.njk
title: Instalar Composer en Docker
permalink: instalar-composer-en-docker/
date_published: 2020-05-26T21:23:27.000Z
date_updated: 2020-05-26T21:23:27.000Z
tags:
- PHP
- Docker
description: Instala Composer dentro de una imagen de PHP en una línea.
---

Composer es el gestor de paquetes de PHP que más se utiliza actualmente. Sin embargo, las imágenes oficiales de PHP no incluyen Composer, por lo que hay que realizar la instalación aparte.

Por suerte, también existen imágenes con Composer. Además, como Composer consta de un único archivo, es posible extraer dicho archivo de forma sencilla usando el comando COPY de Docker en el Dockerfile de nuestra imagen con PHP.

```Dockerfile
FROM php:7.4

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
```
Le indicamos que debe copiar el archivo de la imagen de composer, en este caso de la última versión que haya, al directorio de binarios de nuestra imagen con PHP.

## Artículos relacionados

- [Adding Composer to PHP docker images using multi-stage builds](https://medium.com/@othillo/adding-composer-to-php-docker-images-using-multi-stage-builds-2a10967ae6c1)
