@extends ("theme::layouts/app")

@section ("main")

    <!-- Blog Grid -->
    <div class="retro-container">
      <h2>Latest Posts</h2>
      <div class="retro-grid">

        @foreach (get_cached_posts() as $post)
            <article class="retro-card">
              <h3>{{ $post->title }}</h3>
              <p>{{ $post->excerpt }}</p>
              <a href="{{ $post->url }}">Read More →</a>
            </article>
        @endforeach

      </div>
    </div>

@endsection