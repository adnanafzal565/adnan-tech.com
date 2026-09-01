<a href="{{ route('pages.show', ['slug' => $post->slug]) }}" class="lp-list-item">
    <div class="lp-list-thumb">
        <img
            src="{{ $post->image?->file_path_absolute ?? '' }}"
            alt="{{ $post->title }}"
            loading="lazy"
            onerror="this.src = '{{ asset('img/user-placeholder.png') }}';"
        >
    </div>
    <div class="min-w-0">
        <p class="lp-list-category">{{ implode(", ", $post->categories) }}</p>
        <h4 class="font-display lp-list-title">
            {{ $post->title }}
        </h4>
        <p class="lp-list-date">
            {{ $post->updated_at_format }}
        </p>
    </div>
</a>

<style>
    .latest-posts {
        --lp-bg: var(--bs-tertiary-bg, #FAF9F4);
        --lp-ink: var(--bs-body-color, #1B1E19);
        --lp-accent: var(--bs-primary, #2F4A3C);
        --lp-muted: var(--bs-secondary-color, #5B5D53);
        --lp-faint: var(--bs-tertiary-color, #8A8C80);
        --lp-line: var(--bs-border-color, #DEDBD1);
        --lp-media-bg: var(--bs-secondary-bg, #EFEDE4);
        background-color: var(--lp-bg);
        /*font-family: var(--bs-body-font-family, 'Inter', ui-sans-serif, system-ui, sans-serif);*/
        padding: 5rem 0;
    }
    .latest-posts .font-display {
        /*font-family: 'Fraunces', ui-serif, Georgia, serif;*/
        font-optical-sizing: auto;
    }
    .latest-posts .lp-header {
        border-bottom: 1px solid var(--lp-line);
        padding-bottom: 1.5rem;
        margin-bottom: 3rem;
    }
    .latest-posts .lp-header h2 {
        color: var(--lp-ink);
        font-size: 2.5rem;
        font-weight: 500;
        margin: 0;
    }
    .latest-posts .lp-all-link {
        color: var(--lp-accent);
        text-decoration: underline;
        text-decoration-color: var(--lp-line);
        text-underline-offset: 4px;
        white-space: nowrap;
        transition: color .2s ease, text-decoration-color .2s ease;
    }
    .latest-posts .lp-all-link:hover {
        color: var(--lp-ink);
        text-decoration-color: var(--lp-accent);
    }
    .latest-posts .lp-empty p:first-child {
        /*font-family: 'Fraunces', ui-serif, Georgia, serif;*/
        font-size: 1.5rem;
        color: var(--lp-ink);
    }
    .latest-posts .lp-empty p:last-child { color: var(--lp-faint); }
 
    /* Featured post */
    .latest-posts .lp-featured { text-decoration: none; display: block; }
    .latest-posts .lp-featured-media {
        overflow: hidden;
        background-color: var(--lp-media-bg);
        margin-bottom: 1.5rem;
    }
    .latest-posts .lp-featured-media img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        transition: transform .7s ease;
    }
    @media (min-width: 768px) {
        .latest-posts .lp-featured-media img { height: 420px; }
    }
    .latest-posts .lp-featured:hover .lp-featured-media img { transform: scale(1.03); }
    .latest-posts .lp-meta { color: var(--lp-accent); font-size: .875rem; margin-bottom: .75rem; }
    .latest-posts .lp-featured-title {
        color: var(--lp-ink);
        font-size: 2rem;
        line-height: 1.15;
        margin-bottom: .75rem;
        transition: color .2s ease;
    }
    @media (min-width: 768px) {
        .latest-posts .lp-featured-title { font-size: 2.25rem; }
    }
    .latest-posts .lp-featured:hover .lp-featured-title { color: var(--lp-accent); }
    .latest-posts .lp-excerpt { color: var(--lp-muted); line-height: 1.7; max-width: 58ch; }
 
    /* Recent posts list */
    .latest-posts .lp-list-item {
        text-decoration: none;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        padding: 1.5rem 0;
        border-bottom: 1px solid var(--lp-line);
    }
    .latest-posts .lp-list-item:last-child { border-bottom: 0; padding-bottom: 0; }
    .latest-posts .lp-list-item:first-child { padding-top: 0; }
    .latest-posts .lp-list-thumb {
        flex-shrink: 0;
        width: 80px;
        height: 80px;
        overflow: hidden;
        background-color: var(--lp-media-bg);
    }
    .latest-posts .lp-list-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .7s ease;
    }
    .latest-posts .lp-list-item:hover .lp-list-thumb img { transform: scale(1.05); }
    .latest-posts .lp-list-category { color: var(--lp-accent); font-size: .75rem; margin-bottom: .25rem; }
    .latest-posts .lp-list-title {
        color: var(--lp-ink);
        font-size: 1.125rem;
        line-height: 1.25;
        transition: color .2s ease;
    }
    .latest-posts .lp-list-item:hover .lp-list-title { color: var(--lp-accent); }
    .latest-posts .lp-list-date { color: var(--lp-faint); font-size: .75rem; margin-top: .375rem; margin-bottom: 0; }
</style>