@extends('layout')

@section('content')
<main class="content" role="main">
    <section class="Latest-posts">
        <h1>Publicaciones sobre {{ $tag->name }}</h1>
        @if(trim((string) $tag->content) !== '')
            {!! $tag->content->html() !!}
        @endif
        <ul class="Latest-posts--list">
            @foreach ($pages as $post)
                @include('partials.post-list-item')
            @endforeach
        </ul>
    </section>
</main>
@endsection
