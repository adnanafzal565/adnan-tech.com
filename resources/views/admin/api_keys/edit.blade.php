@extends ("admin/layouts/app")
@section ("title", $api_key->name)

@section ("main")

    <div class="pagetitle">

        <div style="display: flex;">
          <h1>{{ $api_key->name }}</h1>
        </div>

        <nav class="mt-3">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.api_keys.index') }}">API Keys</a></li>
            <li class="breadcrumb-item active">{{ $api_key->id }}</li>
          </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <form onsubmit="save(event);">
                    <input type="hidden" name="id" value="{{ $api_key->id }}" />
                    
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update Key</h5>
                            
                            <div class="row mb-3">
                              <label class="col-sm-3 col-form-label">Remaining</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" name="remaining"
                                  value="{{ $api_key->remaining }}" />
                              </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        async function save(event) {
          event.preventDefault()
          const form = event.target
          const formData = new FormData(form)
          form.submit.setAttribute("disabled", "disabled")

          try {
            const response = await axios.post(
              "{{ route('admin.api_keys.update') }}",
              formData
            )

            if (response.data.status == "success") {
              swal.fire("Save", response.data.message, "success");
            } else {
              swal.fire("Error", response.data.message, "error")
            }
          } catch (exp) {
            swal.fire("Error", exp.message, "error")
          } finally {
            form.submit.removeAttribute("disabled")
          }
        }
    </script>

@endsection