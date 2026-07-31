@extends ("admin/layouts/app")
@section ("title", "Pages")

@section ("main")

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Pages</h1>
      <a href="{{ route('admin.pages.create') }}" class="btn btn-outline-primary btn-sm ms-3">Add page</a>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pages</li>
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
              <th>Keywords</th>
              <th>Description</th>
              <th>Active</th>
              <th>Last Updated</th>
              <th>Actions</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($pages as $page)
              <tr data-id="{{ $page->id }}">
                <td>
                  <a href="{{ $page->url }}" target="_blank">
                    {{ $page->title }}
                  </a>
                </td>

                <td>{{ $page->keywords }}</td>
                <td>{{ $page->excerpt }}</td>

                <td>{{ $page->is_active == 1 ? "Active" : "Inactive" }}</td>
                <td>{{ date("d F, Y", strtotime($page->updated_at . " UTC")) }}</td>
                <td>
                  <a href="{{ route('admin.pages.edit', [ 'id' => $page->id ]) }}" class="btn btn-warning">Edit</a>

                  <button type="button" class="btn btn-danger"
                    onclick="deleteData(event, '{{ $page->id }}');">Delete</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <script>
    function deleteData(event, id) {
      const node = event.currentTarget;

      swal.fire({
        title: "Delete page ?",
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
              baseUrl + "/admin/pages/delete",
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