@extends ("theme::layouts/app")

@section ("main")

    <!-- Main Content -->
    <main class="container">
        <div class="blog-posts">
            @foreach (get_cached_posts() as $post)
                <article class="post-card" style="display: flex;">
                    <img src="{{ $post->file_path ?? '' }}"
                        alt="{{ $post->title }}"
                        style="width: 200px;
                          height: 150px;
                          object-fit: cover;"
                        onerror="this.remove();" />

                    <div style="margin-left: 20px;">
                        <h2 class="post-title"><a href="{{ $post->url }}">{{ $post->title }}</a></h2>
                        <p class="post-excerpt">{{ $post->excerpt }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </main>

@endsection