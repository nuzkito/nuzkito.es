<li class="Latest-posts--item">
    <a class="Latest-posts--link" href="{{ $web->url->append($post->path) }}/">{{ $post->title }}</a>
    @if(isset($post->revised_at) && ! $post->revised_at->isSameDay($post->published_at))
        <time class="Latest-posts--date" datetime="{{ $post->revised_at->toIso8601String() }}">
            Actualizado el
            {{ $post->revised_at->locale('es')->isoFormat('LL') }}
        </time>
    @else
        <time class="Latest-posts--date" datetime="{{ $post->published_at->toIso8601String() }}">
            {{ $post->published_at->locale('es')->isoFormat('LL') }}
        </time>
    @endif
</li>
