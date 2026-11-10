@extends('layout')

@php(Head::title('Página no encontrada'))

@section('content')
<main class="content" role="main">
    <section class="Latest-posts">
        <h1 class="Latest-posts--title">Vaya, esta página no existe :(</h1>
        <p>Pero por si te interesa, te dejo por aquí enlaces a lo último que he escrito:</p>
        <ul class="Latest-posts--list">
            @foreach ($pages->take(5) as $post)
                @include('partials.post-list-item')
            @endforeach
        </ul>
    </section>
</main>
@endsection
