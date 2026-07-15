@extends ("admin/layouts/app")
@section ("title", "Contact us")

@section ("main")

  @php
    $can_delete = auth()->user()->has_route_access('admin.contact.destroy');
  @endphp

  <div class="pagetitle">
    <h1>Contact us</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Contact us</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

    <div class="row">

      <!-- Left side columns -->
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>IP</th>
                <th>Date & Time</th>

                @if ($can_delete)
                <th>Action</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $d)
                <tr data-id="{{ $d->id ?? 0 }}"
                  class="{{ $d->is_read == 0 ? 'table-warning' : '' }}">
                  <td>{{ $d->name ?? "" }}</td>
                  <td>{{ $d->email ?? "" }}</td>
                  <td>{{ $d->message ?? "" }}</td>
                  <td>{{ $d->ip ?? "" }}</td>
                  <td>{{ date("d F, Y h:i a", strtotime($d->created_at . " UTC")) }}</td>
                  
                  @if ($can_delete)
                  <td>
                    <button type="button" class="btn btn-sm btn-danger"
                      onclick="doDelete(event, '{{ $d->id ?? 0 }}');">Delete</button>
                  </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>

          {{ $data->links("pagination::bootstrap-5") }}
      </div>
    </div>
  </section>

  <script>
    function doDelete(event, id) {
      const node = event.currentTarget;

      swal.fire({
        title: "Delete this message ?",
        showCancelButton: true,
        confirmButtonText: "Delete"
      }).then(async function (result) {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          node.setAttribute("disabled", "disabled");
          try {
            const formData = new FormData();
            formData.append("id", id);

            const response = await axios.post(
              baseUrl + "/admin/contact_us/delete",
              formData
            )

            if (response.data.status == "success") {
              document.querySelector("[data-id='" + id + "']").remove();
            } else {
              swal.fire("Error", response.data.message, "error");
            }
          } catch (exp) {
            swal.fire("Error", exp.message, "error");
          } finally {
            node.removeAttribute("disabled");
          }
        }
      });
    }
  </script>

  <style>
    .unread-row {
      background-color: #fff3cd; /* Bootstrap warning background */
    }
  </style>

@endsection