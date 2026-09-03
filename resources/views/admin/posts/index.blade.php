@extends ("admin/layouts/app")
@section ("title", "Posts")

@section ("main")

  @php
    $can_add = auth()->user()->has_route_access('admin.posts.create');
    $can_edit = auth()->user()->has_route_access('admin.posts.edit');
    $can_delete = auth()->user()->has_route_access('admin.posts.destroy');
    $can_see_trash = auth()->user()->has_route_access('admin.posts.trash');
  @endphp

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Posts</h1>

      @if ($can_add)
      <a href="{{ route('admin.posts.create') }}" class="btn btn-outline-primary btn-sm ms-3">Add post</a>
      @endif

      @if ($can_see_trash)
      <a href="{{ route('admin.posts.trash') }}" class="btn btn-outline-primary btn-sm ms-2">Trash</a>
      @endif
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Posts</li>
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

              @if ($can_edit || $can_delete)
              <th>Actions</th>
              @endif
            </tr>
          </thead>

          <tbody>
            @foreach ($posts as $post)
              <tr data-id="{{ $post->id }}">
                <td>
                  <a href="{{ route('pages.show', ['slug' => $post->slug ?? '']) }}" target="_blank">
                    {{ $post->title }}
                  </a>
                </td>

                <td>
                  @foreach ($post->categories as $category)
                    {{ $category }}
                  @endforeach
                </td>

                <td>
                  @foreach ($post->tags as $tag)
                    {{ $tag }}
                  @endforeach
                </td>

                <td>{{ $post->is_active == 1 ? "Active" : "Inactive" }}</td>
                <td>{{ $post->is_featured == 1 ? "Featured" : "" }}</td>
                <td>
                  @if ($post->user?->username)
                  <a href="{{ route('author', ['username' => $post->user->username]) }}">
                    {{ $post->user->name ?? "" }}
                  </a>
                  @endif
                </td>
                <td>{{ date("d F, Y", strtotime($post->updated_at . " UTC")) }}</td>
                
                @if ($can_edit || $can_delete)
                <td>
                  @if ($can_edit)
                  <a href="{{ route('admin.posts.edit', ['id' => $post->id]) }}" class="btn btn-warning">Edit</a>
                  @endif

                  @if ($can_delete)
                  <button type="button" class="btn btn-danger"
                    onclick="deleteData(event, '{{ $post->id }}');">Delete</button>
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
              baseUrl + "/admin/posts/delete",
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