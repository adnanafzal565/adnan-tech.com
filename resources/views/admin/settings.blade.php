@extends ("admin/layouts/app")
@section ("title", "Settings")

@section ("main")

  @php
    $can_update = auth()->user()->has_route_access(\App\Helpers\Constants::SETTINGS_UPDATE);
  @endphp

  <div class="pagetitle">
    <h1>Settings</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Settings</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">

    <form onsubmit="saveSettings(event)" id="form-settings"
      enctype="multipart/form-data"></form>

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Site Info</h5>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Logo</label>
              <div class="col-sm-9">
                <input type="file" accept="image/*" class="form-control" form="form-settings" name="logo" />

                @if (isset($settings["logo"]))
                  <img src="{{ url('/storage/' . $settings['logo']) }}"
                    style="width: 100px; margin-top: 10px;" />
                @endif
              </div>
            </div>

            <div class="row mb-3">
              <label class="col-sm-3 col-form-label">Title</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" form="form-settings" name="title"
                  value="{{ $settings['title'] ?? '' }}" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{--
    <div class="row">
      <div class="col-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">SMTP settings</h5>
            <div class="row mb-3">
              <label for="inputText" class="col-sm-3 col-form-label">Host</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" form="form-settings" name="smtp_host" value="{{ $settings['smtp_host'] ?? '' }}" />
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-3 col-form-label">Port</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" form="form-settings" name="smtp_port" value="{{ $settings['smtp_port'] ?? '' }}" />
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-3 col-form-label">Encryption</label>
              <div class="col-sm-9">
                <label>
                  SSL
                  <input
                    type="radio"
                    name="smtp_encryption"
                    form="form-settings"
                    value="ssl"
                    {{ ($settings['smtp_encryption'] ?? '') == 'ssl' ? 'checked' : '' }}
                  />
                </label>

                <label>
                  TLS
                  <input
                    type="radio"
                    name="smtp_encryption"
                    form="form-settings"
                    value="tls"
                    {{ ($settings['smtp_encryption'] ?? '') == 'tls' ? 'checked' : '' }}
                  />
                </label>
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-3 col-form-label">Username</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" form="form-settings" name="smtp_username" value="{{ $settings['smtp_username'] ?? '' }}" />
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-3 col-form-label">Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" form="form-settings" name="smtp_password" value="{{ $settings['smtp_password'] ?? '' }}" />
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-3 col-form-label">From email</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" form="form-settings" name="smtp_from" value="{{ $settings['smtp_from'] ?? '' }}" />
              </div>
            </div>

            <div class="row mb-3">
              <label for="inputText" class="col-sm-3 col-form-label">From name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" form="form-settings" name="smtp_from_name" value="{{ $settings['smtp_from_name'] ?? '' }}" />
              </div>
            </div>
          </div>
        </div>
      </div>
      --}}

      <div class="col-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Account settings</h5>
            <div class="row mb-3">
              <label for="inputText" class="col-sm-6 col-form-label">Verify email on registration</label>
              <div class="col-sm-6" style="position: relative; top: 5px;">
                <label>
                  Yes
                  <input type="radio" form="form-settings" name="verify_email" value="yes" />
                </label>

                <label style="margin-left: 10px;">
                  No
                  <input type="radio" form="form-settings" name="verify_email" value="no" />
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if ($can_update)
    <div class="row">
      <div class="col-6">
        <button type="submit" name="submit" class="btn btn-primary" form="form-settings">Save settings</button>
      </div>
    </div>
    @endif
  </section>

  <script>
    async function saveSettings(event) {
      event.preventDefault()
      const form = event.target
      const formData = new FormData(form)
      form.submit.setAttribute("disabled", "disabled")

      try {
        const response = await axios.post(
          baseUrl + "/admin/save-settings",
          formData
        )

        if (response.data.status == "success") {
          // swal.fire("Save settings", response.data.message, "success")
          window.location.reload();
        } else {
          swal.fire("Error", response.data.message, "error")
        }
      } catch (exp) {
        swal.fire("Error", exp.message, "error")
      } finally {
        form.submit.removeAttribute("disabled")
      }
    }

    /*async function onInit() {
      try {
        const response = await axios.post(
          baseUrl + "/api/admin/fetch-settings",
          null,
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem(accessTokenKey)
            }
          }
        )

        if (response.data.status == "success") {
          const settings = response.data.settings
          const form = document.getElementById("form-settings")

          if (settings != null) {
            form.host.value = settings.smtp_host || ""
            form.port.value = settings.smtp_port || ""
            form.encryption.value = settings.smtp_encryption || ""
            form.username.value = settings.smtp_username || ""
            form.password.value = settings.smtp_password || ""
            form.from.value = settings.smtp_from || ""
            form.from_name.value = settings.smtp_from_name || ""
            form.verify_email.value = settings.verify_email || ""
          }
        } else {
          swal.fire("Error", response.data.message, "error")
        }
      } catch (exp) {
        swal.fire("Error", exp.message, "error")
      }
    }*/
  </script>

@endsection