@extends ("admin/layouts/app")
@section ("title", "Dashboard")

@section ("main")

  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

      <div class="row">

        <!-- Left side columns -->
        <div class="col-md-12">
          <div class="row">

            @if ($users > 0)
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Users</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="fa fa-users"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $users }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif

            @if ($posts > 0)
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Posts</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                      style="color: black !important;">
                      <i class="fa fa-newspaper"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $posts }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif

            @if ($pages > 0)
            <div class="col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Pages</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                      style="color: teal !important;">
                      <i class="fa fa-file"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{ $pages }}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif

          </div>

          <div class="row">
            <div class="col-md-12">
              <canvas id="userChart" width="600" height="300"></canvas>
            </div>
          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>

    <input type="hidden" id="user-labels" value="{{ json_encode($user_labels) }}" />
    <input type="hidden" id="user-counts" value="{{ json_encode($user_counts) }}" />

    <script>

      const userLabels = JSON.parse(document.getElementById("user-labels").value || "");
      const userCounts = JSON.parse(document.getElementById("user-counts").value || "");

      const ctx = document.getElementById('userChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: userLabels,
                datasets: [{
                    label: 'User Registrations',
                    data: userCounts,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { title: { display: true, text: 'Date' } },
                    y: { title: { display: true, text: 'Users' }, beginAtZero: true }
                }
            }
        });
    </script>

@endsection