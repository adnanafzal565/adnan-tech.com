@extends ("admin/layouts/app")
@section ("title", "Users")

@section ("main")

  @php
    $can_add = auth()->user()->has_route_access(\App\Helpers\Constants::USERS_CREATE);
    $can_edit = auth()->user()->has_route_access(\App\Helpers\Constants::USERS_EDIT);
    $can_delete = auth()->user()->has_route_access(\App\Helpers\Constants::USERS_DELETE);
    $can_block = auth()->user()->has_route_access(\App\Helpers\Constants::USERS_BLOCK);
    $can_see_trash = auth()->user()->has_route_access(\App\Helpers\Constants::USERS_TRASH);
  @endphp

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Users</h1>

      @if ($can_add)
      <a href="{{ route(\App\Helpers\Constants::USERS_CREATE) }}" class="btn btn-outline-primary btn-sm ms-3">Add user</a>
      @endif

      @if ($can_see_trash)
      <a href="{{ route(\App\Helpers\Constants::USERS_TRASH) }}" class="btn btn-outline-primary btn-sm ms-2">Trash</a>
      @endif
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route(\App\Helpers\Constants::DASHBOARD) }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Users</li>
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
              <th>Registered at</th>

              @if ($can_edit || $can_delete || $can_block)
              <th>Actions</th>
              @endif
            </tr>
          </thead>

          <tbody>
            @foreach ($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                  <img src="{{ $user->profile_image }}"
                    style="width: 100px;"
                    onerror="this.remove();" />
                </td>
                <td>{{ $user->type }}</td>
                <td>{{ $user->created_at_format }}</td>

                @if ($can_edit || $can_delete || $can_block)
                <td>
                  @if ($can_edit)
                  <a href="{{ route(\App\Helpers\Constants::USERS_EDIT, ['id' => $user->id]) }}"
                    class="btn btn-warning">Edit</a>
                  @endif

                  @if ($can_block)
                  @if ($user->is_block)
                    <button type="button" class="btn btn-success" onclick="unBlockUser(event, '{{ $user->id }}', '{{ $user->name }}');">Un-block</button>
                  @else
                    <button type="button" class="btn btn-info" onclick="blockUser(event, '{{ $user->id }}', '{{ $user->name }}');">Block</button>
                  @endif
                  @endif
                  
                  @if ($can_delete)
                  <button type="button" class="btn btn-danger" onclick="deleteUser(event, '{{ $user->id }}', '{{ $user->name }}')">Delete</button>
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
    function blockUser(event, id, name) {
      const node = event.currentTarget;

      swal.fire({
        title: "Block user: " + name,
        text: "This user won't be able to access the platform.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, do it!"
      }).then(async function (result) {
        if (result.isConfirmed) {
          node.setAttribute("disabled", "disabled");
   
          const formData = new FormData();
          formData.append("id", id);
   
          try {
            const response = await axios.post(
              baseUrl + "/admin/users/block",
              formData
            );
 
            if (response.data.status == "success") {
              node.remove();
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

    function unBlockUser(event, id, name) {
      const node = event.currentTarget;

      swal.fire({
        title: "Un-block user: " + name,
        text: "This user will be able to access the platform.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, do it!"
      }).then(async function (result) {
        if (result.isConfirmed) {
          node.setAttribute("disabled", "disabled");
   
          const formData = new FormData();
          formData.append("id", id);
   
          try {
            const response = await axios.post(
              baseUrl + "/admin/users/un-block",
              formData
            );
 
            if (response.data.status == "success") {
              node.remove();
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

    function deleteUser(event, id, name) {
      const node = event.currentTarget;

      swal.fire({
        title: "Delete user: " + name,
        text: "Are you sure you want to delete this user ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(async function (result) {
        if (result.isConfirmed) {
          node.setAttribute("disabled", "disabled");
          try {
            const formData = new FormData()
            formData.append("id", id)

            const response = await axios.post(
              baseUrl + "/admin/users/delete",
              formData
            )

            if (response.data.status == "success") {
              node.parentElement.parentElement.remove();
            } else {
              swal.fire("Error", response.data.message, "error")
            }
          } catch (exp) {
            swal.fire("Error", exp.message, "error")
          } finally {
            node.removeAttribute("disabled");
          }
        }
      })
    }
  </script>

@endsection