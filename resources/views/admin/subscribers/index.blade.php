@extends ("admin/layouts/app")
@section ("title", "Contact us")

@section ("main")

  <div class="pagetitle">
    <h1>Newsletter Subscribers</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Newsletter Subscribers</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

    <div class="row">

      <!-- Left side columns -->
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead>
              <tr>
                <th>Email</th>
                <th>Subscribed at</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($subscribers as $subscriber)
                <tr data-id="{{ $subscriber->id ?? 0 }}">
                  <td>{{ $subscriber->email ?? "" }}</td>
                  <td>{{ date("d F, Y h:i a", strtotime($subscriber->subscribed_at . " UTC")) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>

          {{ $subscribers->links("pagination::bootstrap-5") }}
      </div>
    </div>
  </section>

@endsection