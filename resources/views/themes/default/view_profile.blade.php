@extends ("theme::layouts/app")
@section ("title", $user->name)

@section ("main")
     
    <div class="author-detail">
        <div class="container" style="max-width: 800px;">
     
            <a href="{{ route('blog.index') }}" class="ad-back">&larr; All posts</a>
     
            {{-- Author header --}}
            <div class="ad-header">
                <img
                    src="{{ $user->profile_image_absolute ?? asset('img/user-placeholder.png') }}"
                    alt="{{ $user->name }}"
                    class="ad-avatar"
                    onerror="this.src = '{{ asset('img/user-placeholder.png') }}';"
                >
                <div>
                    <h1 class="font-display ad-name">{{ $user->name }}</h1>
                    
                    {{--
                    @if (!empty($user->bio))
                        <p class="ad-bio">{{ $user->bio }}</p>
                    @endif
                    --}}

                    @if (isset($posts))
                        <p class="ad-count">{{ $posts->total() ?? $posts->count() }} {{ Str::plural('post', $posts->total() ?? $posts->count()) }}</p>
                    @endif
                </div>
            </div>
     
            {{-- Posts by this author --}}
            <p class="ad-section-label">Posts by {{ $user->name }}</p>
     
            @if (isset($posts) && $posts->isNotEmpty())
                <div>
                    @foreach ($posts as $post)
                        <a href="{{ route('pages.show', ['slug' => $post->slug]) }}" class="ad-post-item">
                            <div class="ad-post-thumb">
                                <img
                                    src="{{ $post->image?->file_path_absolute ?? '' }}"
                                    alt="{{ $post->title }}"
                                    loading="lazy"
                                    onerror="this.src = '{{ asset('img/user-placeholder.png') }}';"
                                >
                            </div>
                            <div class="min-w-0">
                                <p class="ad-post-category">{{ implode(", ", $post->categories) }}</p>
                                <h3 class="font-display ad-post-title">{{ $post->title }}</h3>
                                <p class="ad-post-excerpt">{{ $post->excerpt }}</p>
                                <p class="ad-post-date">{{ $post->updated_at_format }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
     
                @if (method_exists($posts, 'links'))
                    <div class="mt-4">
                        {{ $posts->links("pagination::bootstrap-5") }}
                    </div>
                @endif
            @else
                <p class="ad-empty">No posts from this author yet.</p>
            @endif
     
        </div>
    </div>

    <style>
        .author-detail {
            --ad-bg: var(--bs-tertiary-bg, #FAF9F4);
            --ad-ink: var(--bs-body-color, #1B1E19);
            --ad-accent: var(--bs-primary, #2F4A3C);
            --ad-muted: var(--bs-secondary-color, #5B5D53);
            --ad-faint: var(--bs-tertiary-color, #8A8C80);
            --ad-line: var(--bs-border-color, #DEDBD1);
            --ad-media-bg: var(--bs-secondary-bg, #EFEDE4);
            background-color: var(--ad-bg);
            /*font-family: var(--bs-body-font-family, 'Inter', ui-sans-serif, system-ui, sans-serif);*/
            padding: 4rem 0 6rem;
        }
        .author-detail .font-display {
            /*font-family: 'Fraunces', ui-serif, Georgia, serif;*/
            font-optical-sizing: auto;
        }
     
        .author-detail .ad-back {
            color: var(--ad-muted);
            text-decoration: none;
            font-size: .875rem;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            margin-bottom: 2.5rem;
            transition: color .2s ease;
        }
        .author-detail .ad-back:hover { color: var(--ad-accent); }
     
        /* Header */
        .author-detail .ad-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding-bottom: 2.5rem;
            margin-bottom: 3rem;
            border-bottom: 1px solid var(--ad-line);
        }
        .author-detail .ad-avatar {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            object-fit: cover;
            background-color: var(--ad-media-bg);
            flex-shrink: 0;
        }
        .author-detail .ad-name {
            color: var(--ad-ink);
            font-size: 2.25rem;
            line-height: 1.15;
            margin-bottom: .5rem;
        }
        .author-detail .ad-bio {
            color: var(--ad-muted);
            font-size: 1rem;
            line-height: 1.6;
            max-width: 60ch;
            margin: 0;
        }
        .author-detail .ad-count {
            color: var(--ad-faint);
            font-size: .8125rem;
            margin: .5rem 0 0;
        }
     
        .author-detail .ad-section-label {
            font-size: .875rem;
            color: var(--ad-faint);
            margin-bottom: 1.5rem;
        }
     
        /* Posts list */
        .author-detail .ad-post-item {
            text-decoration: none;
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
            padding: 2rem 0;
            border-bottom: 1px solid var(--ad-line);
        }
        .author-detail .ad-post-item:first-child { padding-top: 0; }
        .author-detail .ad-post-item:last-child { border-bottom: 0; padding-bottom: 0; }
        .author-detail .ad-post-thumb {
            flex-shrink: 0;
            width: 140px;
            height: 100px;
            overflow: hidden;
            background-color: var(--ad-media-bg);
        }
        .author-detail .ad-post-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .7s ease;
        }
        .author-detail .ad-post-item:hover .ad-post-thumb img { transform: scale(1.05); }
        .author-detail .ad-post-category { color: var(--ad-accent); font-size: .75rem; margin-bottom: .375rem; }
        .author-detail .ad-post-title {
            color: var(--ad-ink);
            font-size: 1.25rem;
            line-height: 1.3;
            margin-bottom: .375rem;
            transition: color .2s ease;
        }
        .author-detail .ad-post-item:hover .ad-post-title { color: var(--ad-accent); }
        .author-detail .ad-post-excerpt {
            color: var(--ad-muted);
            font-size: .9375rem;
            line-height: 1.6;
            margin-bottom: .5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .author-detail .ad-post-date { color: var(--ad-faint); font-size: .75rem; margin: 0; }
     
        .author-detail .ad-empty { color: var(--ad-faint); padding: 2rem 0; }
    </style>

@endsection