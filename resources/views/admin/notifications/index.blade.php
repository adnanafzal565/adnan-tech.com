@extends ("admin/layouts/app")
@section ("title", "Notifications")

@section ("main")

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Notifications</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Notifications</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12">
        <table class="table table-bordered table-responsive">
          <thead>
            <tr>
              <th>Title</th>
              <th>Content</th>
              <th>Type</th>
              <th>Entity</th>
              <th>Status</th>
              <th>Received At</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($notifications as $notification)
              <tr>
                <td>{{ $notification->title }}</td>
                <td>{{ $notification->content }}</td>
                <td>{{ $notification->type }}</td>
                <td>
                  @if (in_array($notification->type, ["job_runner_job_created"]))
                    {{ $notification->entity()?->name ?? "" }}
                  @endif
                </td>
                <td>{{ $notification->is_read ? "Read" : "Unread" }}</td>
                <td>{{ $notification->created_at_format }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        {{ $notifications->links("pagination::bootstrap-5") }}
      </div>
    </div>
  </section>

@endsection