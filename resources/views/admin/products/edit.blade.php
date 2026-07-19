@extends ("admin/layouts/app")
@section ("title", "Edit Product")

@section ("main")

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Edit Product</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
        <li class="breadcrumb-item active">Edit</li>
        <li class="breadcrumb-item">{{ $product->title }}</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12 edit-post">
        <form id="postForm" method="POST" enctype="multipart/form-data"
          onsubmit="updateProduct(event);">
          <input type="hidden" name="id" value="{{ $product->id ?? 0 }}" />

          <label>SKU</label>
          <input type="text" value="{{ $product->sku ?? '' }}" disabled />

          <label for="title">Title</label>
          <input type="text" id="title" name="title" required value="{{ $product->title ?? '' }}" />

          <label for="slug">Slug</label>
          <div class="slug-wrapper">
            <input type="text" id="slug" name="slug" required value="{{ $product->slug ?? '' }}" />
          </div>

          <label for="price">Price ({{ env("CURRENCY_CODE") }})</label>
          <input type="number" id="price" name="price" required step="0.01" min="0" value="{{ $product->price ?? 0 }}" />

          <label>Excerpt</label>
          <textarea name="excerpt">{{ $product->excerpt ?? "" }}</textarea>

          <label for="content">Content</label>
          <textarea name="content">{{ $product->content ?? "" }}</textarea>

          <label for="image">Featured Image</label>
          <button type="button" class="btn no-hover" onclick="fileManager.openMediaModal()">📁 Select Media</button>

          <div>
            @if ($product->image)
              <img id="preview" class="img-preview"
                src="{{ $product->image->file_path_absolute ?? '' }}" />

              <button type="button" class="btn btn-danger"
                id="btn-remove-featured-image"
                style="background-color: #d00404;"
                onclick="fileManager.removeFeaturedImage();">
                <i class="fa fa-close"></i>
              </button>
            @else
              <img id="preview" class="img-preview" hidden />

              <button type="button" class="btn btn-danger"
                id="btn-remove-featured-image"
                style="display: none;
                  background-color: #d00404;"
                onclick="fileManager.removeFeaturedImage();">
                <i class="fa fa-close"></i>
              </button>
            @endif

          </div>

          <label for="categories">Categories</label>
          <select name="categories[]" id="categories" multiple>
            @foreach ($categories as $cat)
              <option value="{{ $cat }}"
                {{ in_array($cat, $product->categories) ? "selected" : "" }}>{{ $cat }}</option>
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
              <input type="text" id="tagInput" class="tag-input" placeholder="Add tags..." />
            </div>
            <div class="suggestions" id="suggestions" hidden></div>
          </div>

          <input type="hidden" name="tags" id="tagsHidden" value="{{ implode(',', $product->tags) }}" />

          <div class="sections-wrapper">

            <div class="sections-header">
                <h4>Sections</h4>

                <button
                    type="button"
                    class="btn-add-section"
                    onclick="addSection();"
                >
                    + Add Section
                </button>
            </div>

            <div id="sections-container"></div>

        </div>

        <template id="section-template">
            <div class="section-card">

                <div class="section-top">
                    <h5 class="section-title"></h5>

                    <button
                        type="button"
                        class="btn-remove"
                        onclick="removeSection(this);"
                    >
                        Remove
                    </button>
                </div>

                <div class="section-grid">

                    <div class="form-group">
                        <label>Title</label>

                        <input
                            type="text"
                            name="sections[][title]"
                            class="form-control"
                        >
                    </div>

                    <div class="form-group">
                        <label>Type</label>

                        <select
                            name="sections[][type]"
                            class="form-control section-type"
                            onchange="toggleUrl(this);"
                            style="min-height: auto !important;"
                        >
                            <option value="text">Text</option>
                            <option value="text_with_image">Text with Image</option>
                            <option value="text_with_video" selected>Text with Video</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Description</label>

                        <textarea
                            rows="5"
                            name="sections[][description]"
                            class="form-control"
                        ></textarea>
                    </div>

                    <div class="form-group url-group">
                        <label class="url-label">Video URL</label>

                        <input
                            type="text"
                            name="sections[][url]"
                            class="form-control"
                        >
                    </div>

                </div>

            </div>
        </template>

          <div class="switch">
            <input type="checkbox" id="is_active" {{ $product->is_active == 1 ? "checked" : "" }} />
            <label for="is_active" style="margin-top: 0px;">Is Active</label>
          </div>

          <button type="submit" name="submit" class="mt-3">Update Product</button>
        </form>
      </div>
    </div>
  </section>

  <input type="hidden" id="available-tags" value="{{ json_encode($tags) }}" />
  <input type="hidden" id="product-tags" value="{{ json_encode($product->tags) }}" />
  <input type="hidden" id="product-image-id" value="{{ $product->image_id ?? 0 }}" />
  <input type="hidden" id="product-file-path" value="{{ $product->file_path ?? '' }}" />

  <script>
    const availableTags = JSON.parse(document.getElementById("available-tags").value);
    const productTags = JSON.parse(document.getElementById("product-tags").value);
    const productImageId = document.getElementById("product-image-id").value || 0;
    const productFilePath = document.getElementById("product-file-path").value || "";

    async function updateProduct(event) {
      event.preventDefault();

      const form = event.currentTarget;
      form.submit.setAttribute("disabled", "disabled");

      try {
        const formData = new FormData(form);
        formData.append("featured_image", fileManager.selected?.id || 0);

        const isActive = document.getElementById("is_active").checked;

        formData.append("active", isActive ? 1 : 0)

        const response = await axios.post(
          baseUrl + "/admin/products/update",
          formData
        )

        if (response.data.status == "success") {
          swal.fire("Update Product", response.data.message, "success")
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
      tags.selectedTags = productTags;
      tags.render();
      fileManager.init();

      if (productImageId > 0) {
        fileManager.selected = {
          id: productImageId,
          filePath: productFilePath
        };
      }

      // First empty row
      // addSection();
    });

    const sections = @json($product->sections);

    if (sections.length) {

        document.getElementById("sections-container").innerHTML = "";

        sections.forEach(function(section){
            addSection(section);
        });

        // setTimeout(() => $("textarea[name='sections[][description]']").richText(), 1000);   

    }
  </script>

@endsection
