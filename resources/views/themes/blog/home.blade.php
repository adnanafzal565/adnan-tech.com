@extends ("theme::layouts/app")

@section ("main")

    <!-- Main Blog Section -->
      <div class="blog-section container">
        <h2>Latest Posts</h2>
        <div class="blog-grid">

          <!-- Blog Post Card -->
          @foreach (get_cached_posts() as $post)
            <a href="{{ $post->url }}" style="color: black; text-decoration: none;">
              <article class="blog-card">
                <img src="{{ $post->file_path ?? '' }}"
                    alt="{{ $post->title }}"
                    style="width: 200px;
                      height: 150px;
                      object-fit: cover;"
                    onerror="this.remove();" />
                <div class="card-content">
                  <h3>{{ $post->title }}</h3>
                  <p>{{ $post->excerpt }}</p>
                </div>
              </article>
            </a>
          @endforeach

        </div>
      </div>

@endsection
