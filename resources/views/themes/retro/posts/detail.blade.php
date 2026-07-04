@extends ("theme::layouts/app")
@section ("title", $post->title)
@section ("meta_keywords", implode(",", $post->tags))
@section ("meta_description", $post->excerpt)
@section ("type", "article")

@section ("main")

    <!-- Post Content -->
      <div class="retro-container post-detail">
        <article class="retro-post">
          <h2>{{ $post->title }}</h2>
          <p class="post-meta">Posted on {{ $post->created_at_formatted }} · by {{ $post->user_name }}</p>

          <img src="{{ $post->file_path }}"
            alt="{{ $post->title }}"
            style="margin-bottom: 30px;" 
            onerror="this.remove();" />

          <div class="post-body">
            {!! $post->content !!}
          </div>

            <a href="{{ $previous_post->url ?? '' }}"
                class="retro-back-link {{ $previous_post == null ? 'hide' : '' }}">
                ← {{ $previous_post->title ?? "" }}
            </a>

            <a href="{{ $next_post->url ?? '' }}"
                class="retro-back-link {{ $next_post == null ? 'hide' : '' }}"
                style="float: right;">
                {{ $next_post->title ?? "" }} →
            </a>
        </article>
      </div>

      <style>
        /* Post detail page */
        .post-detail {
          margin-top: 40px;
        }

        .retro-post {
          background: #111;
          border: 3px double #00ffcc;
          border-radius: 8px;
          padding: 30px;
          animation: fadeIn 0.6s ease;
        }

        .retro-post h2 {
          color: #ffcc00;
          font-size: 16px;
          margin-bottom: 10px;
        }

        .post-meta {
          font-size: 10px;
          color: #00ffff;
          margin-bottom: 20px;
          display: block;
        }

        .post-body p {
          font-size: 12px;
          line-height: 1.6;
          color: #00ff99;
          margin-bottom: 16px;
        }

        .post-body h3 {
          color: #ff00cc;
          margin-top: 25px;
          font-size: 14px;
        }

        .post-body ul {
          padding-left: 20px;
        }
        .post-body ul li {
          font-size: 12px;
          margin-bottom: 8px;
          color: #00ffcc;
        }

        .retro-back-link {
          display: inline-block;
          margin-top: 30px;
          font-size: 12px;
          color: #00ffff;
          text-decoration: underline;
        }
        .retro-back-link:hover {
          color: #ff00cc;
        }

        /* Optional animation */
        @keyframes fadeIn {
          from { opacity: 0; transform: translateY(20px); }
          to { opacity: 1; transform: translateY(0); }
        }
      </style>

@endsection