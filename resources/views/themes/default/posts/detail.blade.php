@extends ("theme::layouts/app")
@section ("title", $post->title)
@section ("meta_keywords", implode(",", $post->tags))
@section ("meta_description", $post->excerpt)
@section ("type", "article")

@section ("main")

  <style>
    .post-detail {
        --pd-bg: var(--bs-tertiary-bg, #FAF9F4);
        --pd-ink: var(--bs-body-color, #1B1E19);
        --pd-accent: var(--bs-primary, #2F4A3C);
        --pd-muted: var(--bs-secondary-color, #5B5D53);
        --pd-faint: var(--bs-tertiary-color, #8A8C80);
        --pd-line: var(--bs-border-color, #DEDBD1);
        --pd-media-bg: var(--bs-secondary-bg, #EFEDE4);
        background-color: var(--pd-bg);
        /*font-family: var(--bs-body-font-family, 'Inter', ui-sans-serif, system-ui, sans-serif);*/
        padding: 4rem 0 6rem;
    }
    .post-detail .font-display {
        /*font-family: 'Fraunces', ui-serif, Georgia, serif;*/
        font-optical-sizing: auto;
    }
 
    .post-detail .pd-back {
        color: var(--pd-muted);
        text-decoration: none;
        font-size: .875rem;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        margin-bottom: 2.5rem;
        transition: color .2s ease;
    }
    .post-detail .pd-back:hover { color: var(--pd-accent); }
 
    .post-detail .pd-categories { color: var(--pd-accent); font-size: .875rem; margin-bottom: 1rem; }
 
    .post-detail .pd-title {
        color: var(--pd-ink);
        font-size: 2.5rem;
        line-height: 1.15;
        margin-bottom: 1.75rem;
    }
    @media (min-width: 768px) {
        .post-detail .pd-title { font-size: 3.25rem; }
    }
 
    .post-detail .pd-meta {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding-bottom: 2rem;
        margin-bottom: 2.5rem;
        border-bottom: 1px solid var(--pd-line);
    }
    .post-detail .pd-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        background-color: var(--pd-media-bg);
        flex-shrink: 0;
    }
    .post-detail .pd-author-link {
        color: var(--pd-ink);
        text-decoration: none;
        font-weight: 500;
        transition: color .2s ease;
    }
    .post-detail .pd-author-link:hover { color: var(--pd-accent); }
    .post-detail .pd-meta-sub { color: var(--pd-faint); font-size: .8125rem; margin: 0; }
 
    .post-detail .pd-media {
        overflow: hidden;
        background-color: var(--pd-media-bg);
        margin-bottom: 3rem;
    }
    .post-detail .pd-media img { width: 100%; height: auto; display: block; max-height: 520px; object-fit: cover; }
 
    .post-detail .pd-body {
        color: var(--pd-ink);
        font-size: 1.125rem;
        line-height: 1.85;
        max-width: 68ch;
    }
    .post-detail .pd-body p { margin-bottom: 1.5rem; color: var(--pd-muted); }
    .post-detail .pd-body h2,
    .post-detail .pd-body h3 {
        /*font-family: 'Fraunces', ui-serif, Georgia, serif;*/
        color: var(--pd-ink);
        margin: 2.5rem 0 1rem;
    }
    .post-detail .pd-body h2 { font-size: 1.75rem; }
    .post-detail .pd-body h3 { font-size: 1.375rem; }
    .post-detail .pd-body blockquote {
        border-left: 3px solid var(--pd-accent);
        padding-left: 1.25rem;
        margin: 2rem 0;
        /*font-family: 'Fraunces', ui-serif, Georgia, serif;*/
        font-size: 1.25rem;
        color: var(--pd-ink);
    }
    .post-detail .pd-body img { max-width: 100%; height: auto; margin: 1.5rem 0; }
    .post-detail .pd-body a { color: var(--pd-accent); }
 
    .post-detail .pd-author-card {
        max-width: 68ch;
        margin-top: 3.5rem;
        padding-top: 2.5rem;
        border-top: 1px solid var(--pd-line);
        display: flex;
        gap: 1.25rem;
        align-items: flex-start;
    }
    .post-detail .pd-author-card .pd-avatar { width: 56px; height: 56px; }
    .post-detail .pd-author-card p { margin: 0; }
  </style>
   
  <div class="post-detail">
      <div class="container" style="max-width: 760px;">
   
          <a href="{{ route('blog.index') }}" class="pd-back">&larr; All posts</a>
   
          @if (!empty($post->categories))
              <p class="pd-categories">{{ implode(", ", $post->categories) }}</p>
          @endif
   
          <h1 class="font-display pd-title">{{ $post->title }}</h1>
   
          <div class="pd-meta">
              <img
                  src="{{ $post->user?->profile_image_absolute ?? asset('img/user-placeholder.png') }}"
                  alt="{{ $post->user?->name ?? '' }}"
                  class="pd-avatar"
              >
              <div>
                  <a href="{{ route('author', ['username' => $post->user?->username ?? '']) }}" class="pd-author-link">
                      {{ $post->user?->name ?? '' }}
                  </a>
                  <p class="pd-meta-sub">{{ $post->updated_at_format }}</p>
              </div>
          </div>
   
          @if ($post->image)
              <div class="pd-media">
                  <img src="{{ $post->image->file_path_absolute }}" alt="{{ $post->title }}">
              </div>
          @endif
   
          <div class="pd-body">
              {!! $post->content !!}
          </div>
   
          @if ($post->user)
              <div class="pd-author-card">
                  <img
                      src="{{ $post->user?->profile_image_absolute ?? asset('img/user-placeholder.png') }}"
                      alt="{{ $post->user?->name ?? '' }}"
                      class="pd-avatar"
                  >
                  <div>
                      <a href="{{ route('author', ['username' => $post->user->username ?? '']) }}" class="pd-author-link">
                          {{ $post->user->name }}
                      </a>
                  </div>
              </div>
          @endif
   
      </div>
  </div>

  {{--
    <div class="post-container">
        <h1 class="post-title">{{ $post->title }}</h1>
        <div class="post-meta">By {{ $post->user?->name ?? '' }} • {{ $post->created_at_formatted }}</div>
        <div class="post-cover">
          <img src="{{ $post->file_path }}" alt="{{ $post->title }}"
            onerror="this.remove();" />
        </div>
        <div class="post-content">
          {!! $post->content !!}
        </div>

        <div class="post-navigation">
          <a href="{{ $previous_post->url ?? '' }}" class="nav-card prev-post {{ $previous_post == null ? 'hide' : '' }}">
            <div class="nav-label">← Previous Post</div>
            <div class="nav-title">{{ $previous_post->title ?? "" }}</div>
          </a>

          <a href="{{ $next_post->url ?? '' }}" class="nav-card next-post {{ $next_post == null ? 'hide' : '' }}">
            <div class="nav-label">Next Post →</div>
            <div class="nav-title">{{ $next_post->title ?? "" }}</div>
          </a>
        </div>
    </div>

    <style>
        .post-navigation {
          display: flex;
          justify-content: space-between;
          margin-top: 3rem;
          gap: 1rem;
          flex-wrap: wrap;
        }

        .nav-card {
          /*flex: 1 1 45%;*/
          background: #ffffff;
          padding: 1.5rem;
          border-radius: 12px;
          box-shadow: 0 10px 25px rgba(0,0,0,0.05);
          text-decoration: none;
          color: #333;
          transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .nav-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 16px 30px rgba(0,0,0,0.1);
        }

        .nav-label {
          font-size: 0.85rem;
          color: #007bff;
          margin-bottom: 0.25rem;
          transition: color 0.3s ease;
        }

        .nav-card:hover .nav-label {
          color: #0056b3;
        }

        .nav-title {
          font-size: 1.1rem;
          font-weight: 600;
          color: #222;
          transition: color 0.3s ease;
        }

        .nav-card:hover .nav-title {
          color: #000;
        }
        @keyframes fadeInBody {
          from { opacity: 0; }
          to { opacity: 1; }
        }

        .post-container {
          background: #fff;
          max-width: 800px;
          margin: auto;
          padding: 2rem;
          border-radius: 16px;
          box-shadow: 0 20px 40px rgba(0,0,0,0.1);
          transform: translateY(20px);
          animation: slideInUp 0.6s ease-out forwards;
        }

        @keyframes slideInUp {
          from { opacity: 0; transform: translateY(40px); }
          to { opacity: 1; transform: translateY(0); }
        }

        .post-title {
          font-size: 2.5rem;
          margin-bottom: 0.5rem;
          color: #111;
          transition: color 0.3s ease;
        }

        .post-title:hover {
          color: #007bff;
        }

        .post-meta {
          color: #777;
          font-size: 0.95rem;
          margin-bottom: 1.5rem;
          transition: transform 0.3s;
        }

        .post-meta:hover {
          transform: translateX(5px);
        }

        .post-cover img {
          width: 100%;
          border-radius: 12px;
          margin-bottom: 1.5rem;
          transition: transform 0.4s ease;
        }

        .post-cover img:hover {
          transform: scale(1.03);
        }

        .post-content p {
          margin-bottom: 1rem;
          font-size: 1.1rem;
          transition: color 0.3s;
        }

        .post-content p:hover {
          color: #444;
        }
    </style>
  --}}

@endsection