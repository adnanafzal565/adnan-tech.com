@extends ("admin/layouts/app")
@section ("title", "Add user")

@section ("main")

  <div class="pagetitle">
    <h1>Add user</h1>
    
    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/users') }}">Users</a></li>
        <li class="breadcrumb-item active">Add</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">User information</h5>

            <form onsubmit="addUser()" id="form-add-user">
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="name" required />
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" name="email" required />
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="password" id="password" required />

                  <label class="mt-3">
                      <input type="checkbox" id="togglePassword">
                      Show password
                  </label>

                  <br>

                  <label>
                    <input type="checkbox" name="send_password_email" value="1">
                    Send password in email
                  </label>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Type</label>
                <div class="col-sm-10">
                  <select class="form-control" name="type" required
                    onchange="onchange_type(event.target.value || '');">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                  </select>
                </div>
              </div>

              @if (count($routes) > 0)
              <div class="row mb-3" id="permissions-container"
                style="display: none;">
                <label class="col-sm-2 col-form-label">Permissions</label>
                <div class="col-sm-10">
                  @foreach ($routes as $route)
                    <p class="mb-0">
                      <label>
                        {{ $route['name'] }} &nbsp;
                        <input type="checkbox" name="routes[]" value="{{ $route['name'] }}" />
                      </label>
                    </p>
                  @endforeach
                </div>
              </div>
              @endif

              <input type="submit" name="submit" class="btn btn-outline-primary" value="Add" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>

    function onchange_type(value) {
      document.getElementById("permissions-container").style.display = (value === "user" ? "none" : "");
    }

    async function addUser() {
      event.preventDefault()

      const form = event.target
      const formData = new FormData(form)
      form.submit.setAttribute("disabled", "disabled")

      try {
        const response = await axios.post(
          baseUrl + "/admin/users/add",
          formData,
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem(accessTokenKey)
            }
          }
        )

        if (response.data.status == "success") {
          swal.fire("Add user", response.data.message, "success")
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
    });
  </script>

@endsection