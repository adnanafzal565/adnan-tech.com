@extends ("admin/layouts/app")
@section ("title", "Trash")

@section ("main")

  @php
    $can_restore = auth()->user()->has_route_access(\App\Helpers\Constants::POSTS_RESTORE);
    $can_delete = auth()->user()->has_route_access(\App\Helpers\Constants::POSTS_FORCE_DELETE);
  @endphp

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Trash</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route(\App\Helpers\Constants::DASHBOARD) }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route(\App\Helpers\Constants::POSTS_INDEX) }}">Posts</a></li>
        <li class="breadcrumb-item active">Trash</li>
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
              <th>Categories</th>
              <th>Tags</th>
              <th>Active</th>
              <th>Featured</th>
              <th>Author</th>
              <th>Last Updated</th>

              @if ($can_restore || $can_delete)
              <th>Actions</th>
              @endif
            </tr>
          </thead>

          <tbody>
            @foreach ($posts as $post)
              <tr data-id="{{ $post->id }}">
                <td>
                  <a href="{{ url('/' . $post->slug ?? '') }}" target="_blank">
                    {{ $post->title ?? "" }}
                  </a>
                </td>

                <td>
                  @foreach (json_decode($post->categories ?? "[]") as $category)
                    {{ $category }}
                  @endforeach
                </td>

                <td>
                  @foreach (json_decode($post->tags ?? "[]") as $tag)
                    {{ $tag }}
                  @endforeach
                </td>

                <td>{{ $post->is_active == 1 ? "Active" : "Inactive" }}</td>
                <td>{{ $post->is_featured == 1 ? "Featured" : "" }}</td>
                <td>
                  <a href="{{ url('/author/' . $post->username) }}">
                    {{ $post->user_name }}
                  </a>
                </td>
                <td>{{ date("d F, Y", strtotime($post->updated_at . " UTC")) }}</td>

                @if ($can_restore || $can_delete)
                <td>
                  @if ($can_restore)
                  <button type="button" class="btn btn-warning"
                    onclick="restoreData(event, '{{ $post->id }}');">Restore</button>
                  @endif

                  @if ($can_delete)
                  <button type="button" class="btn btn-danger"
                    onclick="deleteData(event, '{{ $post->id }}');">Delete Permanently</button>
                  @endif
                </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>

        {{ $posts->links("pagination::bootstrap-5") }}
      </div>
    </div>
  </section>

  <script>
    function deleteData(event, id) {
      const node = event.currentTarget;

      swal.fire({
        title: "Delete post: #" + id,
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
              baseUrl + "/admin/posts/delete-permanently",
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

    function restoreData(event, id) {
      const node = event.currentTarget;

      swal.fire({
        title: "Restore post: #" + id,
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
              baseUrl + "/admin/posts/restore",
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