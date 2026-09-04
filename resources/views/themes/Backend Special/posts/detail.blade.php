@extends ("theme::layouts/app")
@section ("title", $post->title)
@section ("meta_keywords", implode(",", $post->tags))
@section ("meta_description", $post->excerpt)
@section ("type", "article")
@section ("main")

  <article class="post-detail">
    <img src="{{ $post->image?->file_path_absolute ?? '' }}" alt="{{ $post->title }}" onerror="this.remove();" />

    <h2>{{ $post->title }}</h2>
    <p class="meta">Published on {{ $post->created_at_formatted }} &middot; by {{ $post->user_name }}</p>

    <div class="post-body">
      {!! $post->content !!}
    </div>

    <hr />

    <a href="{{ url('/') }}">&larr; Back to all posts</a>
  </article>

@endsection