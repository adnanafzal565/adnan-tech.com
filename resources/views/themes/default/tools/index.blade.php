@extends ("theme::layouts/app")
@section ("title", "Tools")

@section ("main")

  <div class="container py-5">
    <div class="text-center mb-5">
      <h1>Tools</h1>
      <p class="text-muted">Explore our tools and find the one that fits your work.</p>
    </div>

    <div class="row g-4">
      @foreach ($tools as $tool)
        <div class="col-md-4">
          <div class="card h-100">
            <div class="card-body d-flex flex-column">
              <h2 class="card-title h5">{{ $tool->name }}</h2>
              <p class="card-text text-muted">{{ $tool->description }}</p>

              <a href="{{ route('tools.show', $tool->slug) }}"
                class="btn btn-outline-primary mt-auto">Use</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

@endsection