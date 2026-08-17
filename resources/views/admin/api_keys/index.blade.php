@extends ("admin/layouts/app")
@section ("title", "API Keys")

@section ("main")

  <div class="pagetitle">

    <div style="display: flex;">
      <h1>API Keys</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">API Keys</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12">
        <table class="table table-bordered table-responsive">
          <thead>
            <tr>
              <th>User</th>
              <th>Name</th>
              <th>Status</th>
              <th>Remaining</th>
              <th>Last Used At</th>
              <th>Actions</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($api_keys as $api_key)
              <tr data-id="{{ $api_key->id }}">
                <td>{{ $api_key->user?->name ?? "" }}</td>
                <td>{{ $api_key->name }}</td>
                <td>{{ $api_key->status === 1 ? "Active" : "Inactive" }}</td>
                <td>{{ $api_key->remaining }}</td>
                <td>{{ $api_key->last_used_at_format }}</td>

                <td>
                  <a href="{{ route('admin.api_keys.edit', [ 'id' => $api_key->id ]) }}"
                    class="btn btn-warning">Edit</a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        {{ $api_keys->links("pagination::bootstrap-5") }}
      </div>
    </div>
  </section>

@endsection