@extends ("admin/layouts/app")
@section ("title", "Edit Post")

@section ("main")

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Edit Post</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/posts') }}">Posts</a></li>
        <li class="breadcrumb-item active">Edit</li>
        <li class="breadcrumb-item">{{ $post->title }}</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12 edit-post">
        <form id="postForm" method="POST" enctype="multipart/form-data"
          onsubmit="updatePost(event);">
          <input type="hidden" name="id" value="{{ $post->id ?? 0 }}" />
          <label for="title">Title</label>
          <input type="text" id="title" name="title" required value="{{ $post->title ?? '' }}" />

          <label for="slug">Slug</label>
          <div class="slug-wrapper">
            <input type="text" id="slug" name="slug" required value="{{ $post->slug ?? '' }}" />
          </div>

          <label>Excerpt</label>
          <textarea name="excerpt">{{ $post->excerpt ?? "" }}</textarea>

          <label for="content">Content</label>
          <textarea name="content">{{ $post->content ?? "" }}</textarea>

          <label for="image">Featured Image</label>
          <button type="button" class="btn no-hover" onclick="fileManager.openMediaModal()">📁 Select Media</button>

          <div>
            @if (isset($post->image_id) && $post->image_id > 0)
              <img id="preview" class="img-preview"
                src="{{ $post->file_path ?? '' }}" />

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
                {{ in_array($cat, $post->categories) ? "selected" : "" }}>{{ $cat }}</option>
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

          <input type="hidden" name="tags" id="tagsHidden" value="{{ implode(',', $post->tags) }}" />

          <div class="switch">
            <input type="checkbox" id="is_active" {{ $post->is_active == 1 ? "checked" : "" }} />
            <label for="is_active" style="margin-top: 0px;">Is Active</label>
          </div>

          <div class="switch">
            <input type="checkbox" id="is_featured" {{ $post->is_featured == 1 ? "checked" : "" }} />
            <label for="is_featured" style="margin-top: 0px;">Is Featured</label>
          </div>

          <button type="submit" name="submit" class="mt-3">Update Post</button>
        </form>
      </div>
    </div>
  </section>

  <input type="hidden" id="available-tags" value="{{ json_encode($tags) }}" />
  <input type="hidden" id="post-tags" value="{{ json_encode($post->tags) }}" />
  <input type="hidden" id="post-image-id" value="{{ $post->image_id ?? 0 }}" />
  <input type="hidden" id="post-file-path" value="{{ $post->file_path ?? '' }}" />

  <script>
    const availableTags = JSON.parse(document.getElementById("available-tags").value);
    const postTags = JSON.parse(document.getElementById("post-tags").value);
    const postImageId = document.getElementById("post-image-id").value || 0;
    const postFilePath = document.getElementById("post-file-path").value || "";

    async function updatePost(event) {
      event.preventDefault();

      const form = event.currentTarget;
      form.submit.setAttribute("disabled", "disabled");

      try {
        const formData = new FormData(form);
        formData.append("featured_image", fileManager.selected?.id || 0);

        const isActive = document.getElementById("is_active").checked;
        const isFeatured = document.getElementById("is_featured").checked;

        formData.append("active", isActive ? 1 : 0)
        formData.append("featured", isFeatured ? 1 : 0)

        const response = await axios.post(
          baseUrl + "/admin/posts/update",
          formData
        )

        if (response.data.status == "success") {
          swal.fire("Update Post", response.data.message, "success")
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
      tags.selectedTags = postTags;
      tags.render();
      fileManager.init();

      if (postImageId > 0) {
        fileManager.selected = {
          id: postImageId,
          filePath: postFilePath
        };
      }
    });
  </script>

@endsection
