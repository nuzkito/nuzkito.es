<main class="content" role="main">
    <article class="Post">
        <header class="Post-header">
            @if($page->cover_image)
                <div
                    class="Post-cover"
                    style="background-image: url({{ $web->url->append($page->path)->append(rawurlencode($page->cover_image)) }});">
                    <h1 class="Post-titleCovered">{{ $page->title }}</h1>
                </div>
            @else
                <h1 class="Post-title">{{ $page->title }}</h1>
            @endif
            @unless(collect($page->tags)->contains('id', 'static-pages'))
                <section class="Post-meta">
                    <div class="Post-publishedAt">
                        Publicado el <time class="Post-date" datetime="{{ $page->published_at->toIso8601String() }}">{{ $page->published_at->locale('es')->isoFormat('LL') }}</time>
                    </div>
                    @if(isset($page->revised_at) && ! $page->revised_at->isSameDay($page->published_at))
                        <div class="Post-modifiedAt">
                            Actualizado el <time class="Post-date" datetime="{{ $page->revised_at->toIso8601String() }}">{{ $page->revised_at->locale('es')->isoFormat('LL') }}</time>
                        </div>
                    @endif
                    @if($page->tags)
                        <nav class="Post-tags">
                            @foreach($page->tags as $tag)
                                @if($tag->hasPage())
                                    <a href="{{ $web->url->append($tag->path) }}/">{{ $tag->name }}</a>
                                @else
                                    <span>{{ $tag->name }}</span>
                                @endif
                            @endforeach
                        </nav>
                    @endif
                </section>
            @endunless
        </header>
        <section class="Post-content">
            {!! $page->content->html() !!}
        </section>
    </article>
</main>
