@extends ("admin/layouts/app")
@section ("title", "Trashed Users")

@section ("main")

  @php
    $can_restore = auth()->user()->has_route_access(\App\Helpers\Constants::USERS_RESTORE);
    $can_delete = auth()->user()->has_route_access(\App\Helpers\Constants::USERS_FORCE_DELETE);
  @endphp

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Users</h1>
      <a href="{{ route(\App\Helpers\Constants::USERS_INDEX) }}" class="btn btn-outline-primary btn-sm ms-3">All Users</a>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route(\App\Helpers\Constants::DASHBOARD) }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Trashed Users</li>
      </ol>
    </nav>
  </div>

  <section class="section" id="users-app">
    <div class="row">
      <div class="col-12">
        <table class="table table-bordered table-responsive">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Profile</th>
              <th>Type</th>
              <th>Deleted at</th>

              @if ($can_restore || $can_delete)
              <th>Actions</th>
              @endif
            </tr>
          </thead>

          <tbody>
            @foreach ($users as $user)
              <tr data-id="{{ $user->id }}">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                  <img src="{{ $user->profile_image }}"
                    style="width: 100px;"
                    onerror="this.remove();" />
                </td>
                <td>{{ $user->type }}</td>
                <td>{{ $user->deleted_at_format }}</td>
                @if ($can_restore || $can_delete)
                <td>
                  @if ($can_restore)
                  <button type="button" class="btn btn-warning"
                    onclick="restoreData(event, '{{ $user->id }}', '{{ $user->name }}');">Restore</button>
                  @endif

                  @if ($can_delete)
                  <button type="button" class="btn btn-danger"
                    onclick="deleteData(event, '{{ $user->id }}', '{{ $user->name }}');">Delete Permanently</button>
                  @endif
                </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>

        {{ $users->links("pagination::bootstrap-5") }}
      </div>
    </div>
  </section>

  <script>
    function deleteData(event, id, name) {
      const node = event.currentTarget;

      swal.fire({
        title: "Delete user: " + name,
        showCancelButton: true,
        confirmButtonText: "Do it"
      }).then(async function (result) {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          node.setAttribute("disabled", "disabled");
          
          try {
            const formData = new FormData();
            formData.append("id", id);

            const response = await axios.post(
              baseUrl + "/admin/users/delete-permanently",
              formData
            )

            if (response.data.status == "success") {
              document.querySelector("[data-id='" + id + "']").remove();
            } else {
              swal.fire("Error", response.data.message, "error")
            }
          } catch (exp) {
            swal.fire("Error", exp.message, "error")
          } finally {
            node.removeAttribute("disabled")
          }
        }
      });
    }

    function restoreData(event, id, name) {
      const node = event.currentTarget;

      swal.fire({
        title: "Restore user: " + name,
        showCancelButton: true,
        confirmButtonText: "Do it"
      }).then(async function (result) {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          node.setAttribute("disabled", "disabled");
          
          try {
            const formData = new FormData();
            formData.append("id", id);

            const response = await axios.post(
              baseUrl + "/admin/users/restore",
              formData
            )

            if (response.data.status == "success") {
              document.querySelector("[data-id='" + id + "']").remove();
            } else {
              swal.fire("Error", response.data.message, "error")
            }
          } catch (exp) {
            swal.fire("Error", exp.message, "error")
          } finally {
            node.removeAttribute("disabled")
          }
        }
      });
    }
  </script>

@endsection