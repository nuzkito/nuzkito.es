@extends('layout')

@section('content')
<main class="content" role="main">
    <section class="Latest-posts">
        <h1 class="Latest-posts--title">Mis últimas publicaciones</h1>
        <ul class="Latest-posts--list">
            @foreach ($pages->filter(fn ($page) => $page->type === 'post') as $post)
                @include('partials.post-list-item')
            @endforeach
        </ul>
    </section>
</main>
@endsection
