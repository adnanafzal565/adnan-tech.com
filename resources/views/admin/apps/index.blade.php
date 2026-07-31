@extends ("admin/layouts/app")
@section ("title", "Apps")

@section ("main")

  <div class="pagetitle">

    <div style="display: flex;">
      <h1>Apps</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Apps</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12">
        <table class="table table-bordered table-responsive">
          <thead>
            <tr>
              <th>Name</th>
              <th>Identifier</th>
              <th>Actions</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($apps as $app)
              <tr data-id="{{ $app->id }}">
                <td>{{ $app->name }}</td>
                <td>{{ $app->identifier }}</td>

                <td>
                  <a href="{{ route('admin.apps.detail', [ 'id' => $app->id ]) }}"
                    class="btn btn-dark">View</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>

@endsection