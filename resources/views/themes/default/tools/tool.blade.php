@extends ("theme::layouts/app")
@section ("title", $tool->name)

@section ("main")

  <div class="container py-5">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tools.index') }}">Tools</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $tool->name }}</li>
      </ol>
    </nav>

    <h1 class="mb-2">{{ $tool->name }}</h1>
    <p class="lead text-muted mb-5">{{ $tool->description }}</p>

    @include ($tool_view, ["tool" => $tool])
  </div>

@endsection