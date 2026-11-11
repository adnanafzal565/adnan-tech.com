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
        /*max-width: 68ch;*/
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
      <div class="container">
   
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
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4328287883552246"
                     crossorigin="anonymous"></script>
                <ins class="adsbygoogle"
                     style="display:block; text-align:center;"
                     data-ad-layout="in-article"
                     data-ad-format="fluid"
                     data-ad-client="ca-pub-4328287883552246"
                     data-ad-slot="6974790312"></ins>
                <script>
                     (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                
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

@endsection