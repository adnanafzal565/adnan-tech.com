@extends ("theme::layouts/app")
@section ("title", "Blog Posts")

@section ("main")

    <section class="latest-posts">
        <div class="container" style="max-width: 1140px;">
     
            {{-- Section header --}}
            <div class="d-flex align-items-end justify-content-between gap-3 lp-header">
                <h2 class="font-display">From the journal</h2>
            </div>
     
            @if (!isset($posts) || $posts->isEmpty())
     
                {{-- Empty state --}}
                <div class="lp-empty text-center py-5">
                    <p class="mb-2">No stories yet</p>
                    <p>Check back soon — new posts will appear here.</p>
                </div>
     
            @else
     
                <div class="row gy-5">
     
                    {{-- Recent posts list --}}
                    @if (isset($posts) && $posts->isNotEmpty())
                        <div class="col-md-4">
                            <div class="d-flex flex-column">
                                @foreach ($posts as $post)
                                    @include ("theme::posts/single", [
                                        "post" => $post
                                    ])
                                @endforeach
                            </div>
                        </div>
                    @endif
     
                </div>

                {{ $posts->links("pagination::bootstrap-5") }}
     
            @endif
        </div>
    </section>

@endsection