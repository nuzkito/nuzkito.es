<!doctype html>
<html lang="{{ $web->language }}">
    <head>
        <meta charset="utf-8">
        <meta name="HandheldFriendly" content="True"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="referrer" content="no-referrer-when-downgrade"/>
        @head
        <link rel="shortcut icon" href="{{ $web->url->append('favicon.ico') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ $web->url->append('favicon-16x16.png') }}">
        <link rel="manifest" href="{{ $web->url->append('site.webmanifest') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Reddit+Mono&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ $web->url->append('css/index.css') }}">
    </head>
    <body>
        <header class="Header">
            <a href="{{ $web->url }}/" class="main-link">
                <h1 class="name">Holi, soy Nuzkito</h1>
                <p class="description">{{ $web->description }}</p>
            </a>
        </header>
        <nav class="Nav">
            <a href="{{ $web->url }}/">Publicaciones</a>
            <a href="{{ $web->url->append('contacto') }}/">Contacto</a>
        </nav>
        @yield('content')
        <footer class="Footer site-footer clearfix">
            <p>&copy; 2014 - {{ date('Y') }}</p>
        </footer>
    </body>
</html>
