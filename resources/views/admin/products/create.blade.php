@extends ("admin/layouts/app")
@section ("title", "Add Product")

@section ("main")

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Add Product</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
        <li class="breadcrumb-item active">Add Product</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12 edit-post">
        <form id="postForm" method="POST" enctype="multipart/form-data"
          onsubmit="addData(event);">
          <label for="title">Title</label>
          <input type="text" id="title" name="title" required onkeyup="generateSlug()" />

          <label for="slug">Slug</label>
          <div class="slug-wrapper">
            <input type="text" id="slug" name="slug" required>
            <button type="button" onclick="generateSlug();">↻</button>
          </div>

          <label for="price">Price ({{ env("CURRENCY_CODE") }})</label>
          <input type="number" id="price" name="price" required step="0.01" min="0" />

          <label>Excerpt</label>
          <textarea name="excerpt"></textarea>

          <label for="content">Content</label>
          <textarea name="content"></textarea>

          <label for="image">Featured Image</label>
          <button type="button" class="btn no-hover" onclick="fileManager.openMediaModal()">📁 Select Media</button>
          
          <div>
            <img id="preview" class="img-preview" hidden />

            <button type="button" class="btn btn-danger"
              id="btn-remove-featured-image"
              style="display: none;
                background-color: #d00404;"
              onclick="fileManager.removeFeaturedImage();">
              <i class="fa fa-close"></i>
            </button>
          </div>

          <label for="categories">Categories</label>
          <select name="categories[]" id="categories" multiple>
            @foreach ($categories as $cat)
              <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
          </select>

          <div class="add-category">
            <input type="text" id="newCategory" placeholder="Add new category">
            <button type="button" onclick="addCategory(event)">Add</button>
          </div>

          <label>Tags</label>

          <div style="position: relative;">
            <div class="tag-container" id="tagBox" onclick="tags.focusInput()">
              <!-- Tags will be inserted here -->
              <input type="text" id="tagInput" class="tag-input" placeholder="Add tags...">
            </div>
            <div class="suggestions" id="suggestions" hidden></div>
          </div>

          <input type="hidden" name="tags" id="tagsHidden">

          <div class="switch">
            <input type="checkbox" id="is_active" checked />
            <label for="is_active" style="margin-top: 0px;">Is Active</label>
          </div>

          <button type="submit" name="submit" class="mt-3">Create Post</button>
        </form>
      </div>
    </div>
  </section>

  <input type="hidden" id="available-tags" value="{{ json_encode($tags) }}" />

  <script>
    const availableTags = JSON.parse(document.getElementById("available-tags").value);

    async function addData(event) {
      event.preventDefault();

      const form = event.currentTarget;
      form.submit.setAttribute("disabled", "disabled");
      
      try {
        const formData = new FormData(form);
        formData.append("featured_image", fileManager.selected?.id || 0);

        const isActive = document.getElementById("is_active").checked;
        
        formData.append("active", isActive ? 1 : 0)
        
        const response = await axios.post(
          baseUrl + "/admin/products/create",
          formData
        )

        if (response.data.status == "success") {
          const id = response.data.id;
          window.location.href = baseUrl + "/admin/products/" + id + "/edit";
        } else {
          swal.fire("Error", response.data.message, "error")
        }
      } catch (exp) {
        swal.fire("Error", exp.message, "error")
      } finally {
        form.submit.removeAttribute("disabled")
      }
    }

    window.addEventListener("load", function () {
      $("textarea[name='content']").richText();
      tags.init();
      fileManager.init();
    });
  </script>

@endsection