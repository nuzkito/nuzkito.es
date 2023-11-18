---
layout: post.njk
title: HTTPS con Let's Encrypt
permalink: https-con-lets-encrypt/
date_published: 2015-12-06T20:50:34.000Z
date_updated: 2016-02-15T16:36:53.000Z
tags:
- HTTP
- HTTPS
---

[HTTP](https://es.wikipedia.org/wiki/Hypertext_Transfer_Protocol) es el principal protocolo que se utiliza en la web. Cuando visitas una web, esta se carga a través del protocolo HTTP. Sin embargo, existe un inconveniente: las peticiones HTTP no se cifran. Por suerte, para esto tenemos [HTTPS](https://es.wikipedia.org/wiki/Hypertext_Transfer_Protocol_Secure), que es el mismo protocolo, pero con una capa añadida que le agrega el cifrado a los datos que se envían en cada petición.

HTTPS **es imprescindible en sectores como el del comercio electrónico o la banca online**. **Sin una conexión cifrada, un intermediario podría ver los datos que se envían entre nuestro dispositivo y el servidor**, pudiendo, por ejemplo, obtener los datos de nuestra tarjeta de crédito, o las contraseñas de los sitios a los que accedemos.

Para poder tener HTTPS en una web, es necesario conseguir un certificado firmado por una tercera entidad que verifique la identidad del sitio web. Hasta ahora, para conseguir esos certificados era necesario pagar a una de estas entidades. Pero ahora, gracias a [Let's Encrypt](https://letsencrypt.org/), podremos conseguir un certificado para poner HTTPS en nuestras webs **de forma gratuita**.

## ¿Qué es Let's Encrypt?
Es un proyecto que busca **facilitar la tarea de instalar y renovar** los certificados necesarios. Simplemente descargando la herramienta en nuestro servidor y ejecutando unos comandos, tendremos lista nuestra web para funcionar con HTTPS.

El software actualmente está en fase Beta, pero ya es público para ser utilizado por cualquier persona.

## Instalación en el servidor
Para instalar el cliente de Let's Encrypt debes acceder mediante terminal al servidor. Una vez dentro, clona el repositorio del proyecto desde GitHub.
```bash
git clone https://github.com/letsencrypt/letsencrypt
cd letsencrypt
```
Con
```bash
./letsencrypt-auto --help
```
podremos ver la ayuda.

## Obtener los certificados
El cliente viene con un método para configurarlo automáticamente con Apache. Si estás usando Apache, simplemente tienes que ejecutar
```bash
./letsencrypt-auto --apache -d misitioweb.com -d www.misitioweb.com
```
Con la opción `-d` indicamos las urls que tendrán https. Ten en cuenta que si tienes varios dominios y subdominios, tendrás que indicar todos ellos.

También existe una opción para configurar Nginx, aunque aún de forma experimental.

Si quieres configurar el servidor de forma manual, antes de nada debes parar cualquier aplicación que esté escuchando en los puertos 80 y 443. Además el firewall debe estar configurado para que acepte conexiones a través de esos puertos. Una vez hecho esto, ejecuta
```bash
./letsencrypt-auto certonly
```
Esto lanzará una aplicación que te irá pidiendo los datos necesarios para generar los certificados. Si por alguna razón la aplicación no puede continuar porque los puertos está ocupados o inaccesibles, te lo indicará y te pedirá que lo soluciones.

Si quieres saltarte esos pasos, puedes definir los datos directamente en el comando:
```bash
./letsencrypt-auto certonly --standalone --email tuemail@gmail.com -d misitioweb.com -d www.misitioweb.com
```

Una vez se hayan generado los certificados, aparecerá un mensaje como el siguiente:
```bash
IMPORTANT NOTES:
 - Congratulations! Your certificate and chain have been saved at
   /etc/letsencrypt/live/misitioweb.com/fullchain.pem. Your cert will
   expire on 2016-02-16. To obtain a new version of the certificate in
   the future, simply run Let's Encrypt again.
```

## Configurar HTTPS en Nginx
Una vez tenemos los certificados, debemos agregarlos en la configuración de Nginx. Para ello, debemos indicar las rutas a los mismos. En el mensaje anterior nos indican que la ruta de los mismos es `/etc/letsencrypt/live/nombre de nuestro dominio`. En esa ruta debemos tener cuatro archivos `.pem`. En la regla `ssl_certificate` debemos indicar la ruta al fichero `fullchain.pem`, y en la regla `ssl_certificate_key`, el fichero `privkey.pem`.

En mi caso, la configuración básica queda así:
```bash
server {
    listen 443 ssl;
    server_name misitioweb.com;
    ssl_certificate /etc/letsencrypt/live/misitioweb.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/misitioweb.com/privkey.pem;
}
```
No olvides agregar el resto de configuraciones que necesites.

Una vez editada la configuración de tu sitio, reinicia Nginx
```bash
sudo service nginx restart
```
Y si todo ha ido bien, tendrás activo HTTPS en tu sitio. Ahora los navegadores te deberían mostrar mensajes como este si haces click en el candado de la barra de direcciones:
![Conexión segura en Firefox](/images/2015/12/https-firefox.jpg)
*Conexión segura en Firefox*
![Conexión segura en Chrome](/images/2015/12/https-chrome.jpg)
*Conexión segura en Chrome*

## Tener HTTPS en nuestra web no la hace automáticamente segura
Esto solo es el primer paso. Lo que he mostrado en el artículo es una configuración básica para configurar HTTPS, pero se pueden hacer muchas otras cosas para mejorar la seguridad. Asegúrate de **tener el software del servidor actualizado, y una configuración correcta** del mismo. Debajo dejo enlaces con información adicional, entre ellos una herramienta que genera automáticamente la configuración para incluir HTTPS en nuestra web, y otra herramienta que comprueba si el servidor es vulnerable ante ciertos ataques.

## Más información
Algunos enlaces que te pueden servir de ayuda:

* [Sitio web de Let's Encrypt](https://letsencrypt.org/)
* [Documentación](https://letsencrypt.readthedocs.org)
* [Artículo que explica cómo instalar los certificados con Let's Encrypt en Nginx](https://blog.rudeotter.com/lets-encrypt-ssl-certificate-nginx-ubuntu/), en inglés
* [Documentación de Nginx sobre cómo configurar HTTPS](http://nginx.org/en/docs/http/configuring_https_servers.html)
* [Cómo actualizar Nginx en Ubuntu](http://leftshift.io/upgrading-nginx-to-the-latest-version-on-ubuntu-servers), por si tienes una versión antigua
* [Configuración de Nginx recomendada para Ghost](http://support.ghost.org/setup-ssl-self-hosted-ghost/)
* [Generador de configuraciones SSL](https://mozilla.github.io/server-side-tls/ssl-config-generator/), genera automáticamente configuraciones para Nginx, Apache, etc.
* [Servicio para comprobar si la comunicación con el servidor es segura](https://www.ssllabs.com/ssltest/)
