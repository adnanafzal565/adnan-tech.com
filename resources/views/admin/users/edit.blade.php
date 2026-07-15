@extends ("admin/layouts/app")
@section ("title", "Edit user")

@section ("main")

  @php
    $can_update = auth()->user()->has_route_access('admin.users.update');
    $can_change_password = auth()->user()->has_route_access('admin.users.change_password');
  @endphp

  <div class="pagetitle">
    <h1>Edit user</h1>
    
    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item">Edit</li>
        <li class="breadcrumb-item active">{{ $id }}</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Profile information</h5>

            <form onsubmit="updateUser(event)" id="form-update-user">
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="name" value="{{ $user->name ?? '' }}" required />
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" name="email" value="{{ $user->email ?? '' }}" disabled />
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-10">
                  <select class="form-control" name="type"
                    id="user-type" 
                    required
                    onchange="onchange_type(event.target.value || '');">
                    <option value="user" {{ $user->type === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->type === 'admin' ? 'selected' : '' }}>Admin</option>
                  </select>
                </div>
              </div>

              @if (count($routes) > 0)
              <div class="row mb-3" id="permissions-container"
                style="display: none;">
                <label class="col-sm-2 col-form-label">Permissions</label>
                <div class="col-sm-10">

                  @php
                    $selected_routes = $user->allowed_routes();
                  @endphp

                  @foreach ($routes as $route)
                    <p class="mb-0">
                      <label>
                        {{ $route['name'] }} &nbsp;
                        <input type="checkbox" name="routes[]" value="{{ $route['name'] }}"
                          {{ in_array($route['name'], $selected_routes) ? 'checked' : '' }} />
                      </label>
                    </p>
                  @endforeach
                </div>
              </div>
              @endif

              @if ($can_update)
              <input type="submit" name="submit" class="btn btn-warning" value="Update" />
              @endif
            </form>
          </div>
        </div>
      </div>
    </div>

    @if ($can_change_password)
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Change password</h5>

            <form onsubmit="changePassword(event)" id="form-change-password">
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">New password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="password" id="password" required />

                  <label class="mt-3">
                    <input type="checkbox" id="togglePassword">
                    Show password
                  </label>
                </div>
              </div>

              <input type="submit" name="submit" class="btn btn-info" value="Change password" />
            </form>
          </div>
        </div>
      </div>
    </div>
    @endif
  </section>

  <input type="hidden" id="id" value="{{ $id }}" />

  <script>
    const id = document.getElementById("id").value;

    function onchange_type(value) {
      document.getElementById("permissions-container").style.display = (value === "user" ? "none" : "");
    }

    async function changePassword(event) {
      event.preventDefault()

      const form = event.target
      form.submit.setAttribute("disabled", "disabled")

      const formData = new FormData(form)
      formData.append("id", id)

      try {
        const response = await axios.post(
          baseUrl + "/admin/users/change_password",
          formData
        )

        if (response.data.status == "success") {
          swal.fire("Change password", response.data.message, "success")
        } else {
          swal.fire("Error", response.data.message, "error")
        }
      } catch (exp) {
        swal.fire("Error", exp.message, "error")
      } finally {
        form.submit.removeAttribute("disabled")
      }
    }

    async function updateUser(event) {
      event.preventDefault()

      const form = event.target
      form.submit.setAttribute("disabled", "disabled")

      const formData = new FormData(form)
      formData.append("id", id)

      try {
        const response = await axios.post(
          baseUrl + "/admin/users/update",
          formData
        )

        if (response.data.status == "success") {
          swal.fire("Update user", response.data.message, "success")
        } else {
          swal.fire("Error", response.data.message, "error")
        }
      } catch (exp) {
        swal.fire("Error", exp.message, "error")
      } finally {
        form.submit.removeAttribute("disabled")
      }
    }

    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("password");
        const toggleCheckbox = document.getElementById("togglePassword");

        toggleCheckbox.addEventListener("change", function () {
            if (this.checked) {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        });

        onchange_type(document.getElementById("user-type").value || "");
    });
  </script>

@endsection