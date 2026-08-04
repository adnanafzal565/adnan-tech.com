@extends ("admin/layouts/app")
@section ("title", $app->name)

@section ("main")

  <input type="hidden" id="id" value="{{ $app->id }}" />

  <script>
    const id = parseInt(document.getElementById("id").value);
  </script>

  <div class="pagetitle">

    <div style="display: flex;">
      <h1>{{ $app->name }}</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.index') }}">Apps</a></li>
        <li class="breadcrumb-item active">{{ $app->name }}</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Identifier: {{ $app->identifier }}</div>
          </div>
        </div>

        @if ($app->identifier === "email_renderer" && is_module_exists("EmailRenderer"))
          @include("EmailRenderer::admin/templates_list", [
            "data" => $data
          ])
        @endif
        
      </div>
    </div>
  </section>

@endsection