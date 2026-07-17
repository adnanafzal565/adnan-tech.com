@extends ("admin/layouts/app")
@section ("title", "Products")

@section ("main")

  @php
    $can_add = auth()->user()->has_route_access('admin.products.create');
    $can_edit = auth()->user()->has_route_access('admin.products.edit');
    $can_delete = auth()->user()->has_route_access('admin.products.destroy');
    $can_see_trash = auth()->user()->has_route_access('admin.products.trash');
  @endphp

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Products</h1>

      @if ($can_add)
      <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary btn-sm ms-3">Add product</a>
      @endif

      @if ($can_see_trash)
      <a href="{{ route('admin.products.trash') }}" class="btn btn-outline-primary btn-sm ms-2">Trash</a>
      @endif
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Products</li>
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
            @foreach ($products as $product)
              <tr data-id="{{ $product->id }}">
                <td>
                  <a href="{{ route('pages.show', ['slug' => $product->slug ?? '']) }}" target="_blank">
                    {{ $product->title }}
                  </a>
                </td>

                <td>
                  @foreach ($product->categories_array as $category)
                    {{ $category }}
                  @endforeach
                </td>

                <td>
                  @foreach ($product->tags_array as $tag)
                    {{ $tag }}
                  @endforeach
                </td>

                <td>{{ $product->is_active == 1 ? "Active" : "Inactive" }}</td>
                <td>{{ $product->is_featured == 1 ? "Featured" : "" }}</td>
                <td>
                  @if ($product->user?->username)
                  <a href="{{ route('author', ['username' => $product->user->username]) }}">
                    {{ $product->user->name ?? "" }}
                  </a>
                  @endif
                </td>
                <td>{{ date("d F, Y", strtotime($product->updated_at . " UTC")) }}</td>
                
                @if ($can_edit || $can_delete)
                <td>
                  @if ($can_edit)
                  <a href="{{ route('admin.products.edit', ['id' => $product->id]) }}" class="btn btn-warning">Edit</a>
                  @endif

                  @if ($can_delete)
                  <button type="button" class="btn btn-danger"
                    onclick="deleteData(event, '{{ $product->id }}');">Delete</button>
                  @endif
                </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>

        {{ $products->links("pagination::bootstrap-5") }}
      </div>
    </div>
  </section>

  <script>
    function deleteData(event, id) {
      const node = event.currentTarget;

      swal.fire({
        title: "Delete product: #" + id,
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
              baseUrl + "/admin/products/delete",
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