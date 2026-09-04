@extends ("theme::layouts/app")
@section ("main")

    <h2>Latest Posts</h2>

    <table>
      <thead>
        <tr>
          <th>Image</th>
          <th>Title</th>
          <th>Excerpt</th>
        </tr>
      </thead>
      <tbody>
        @foreach (get_cached_posts() as $post)
          <tr>
            <td>
              <a href="{{ route('pages.show', ['slug' => $post->slug]) }}">
                <img src="{{ $post->image?->file_path_absolute ?? '' }}"
                    alt="{{ $post->title }}"
                    width="100"
                    height="75"
                    onerror="this.remove();" />
              </a>
            </td>
            <td>
              <a href="{{ route('pages.show', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
            </td>
            <td>{{ $post->excerpt }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

@endsection