@extends ("admin/layouts/app")
@section ("title", "Edit Page")

@section ("main")

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Edit Page</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/pages') }}">Pages</a></li>
        <li class="breadcrumb-item">Edit Page</li>
        <li class="breadcrumb-item active">{{ $page->title }}</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12 edit-post">
        <form method="POST" enctype="multipart/form-data"
          onsubmit="updateData(event);">
          <input type="hidden" name="id" value="{{ $page->id }}" />

          <label for="title">Title</label>
          <input type="text" id="title" name="title" required onkeyup="generateSlug()"
            value="{{ $page->title }}" />

          <label for="slug">Slug</label>
          <div class="slug-wrapper">
            <input type="text" id="slug" name="slug" required
              value="{{ $page->slug }}" />
            <button type="button" onclick="generateSlug();">↻</button>
          </div>

          <label>Meta Keywords</label>
          <input type="text" name="keywords" value="{{ $page->keywords }}" />

          <label>Excerpt</label>
          <textarea name="excerpt">{{ $page->excerpt }}</textarea>

          <label for="content">Content</label>
          <textarea id="content" name="content">{{ $page->content ?? "" }}</textarea>

          <div class="switch">
            <input type="checkbox" id="is_active" {{ $page->is_active == 1 ? "checked" : "" }} />
            <label for="is_active" style="margin-top: 0px;">Is Active</label>
          </div>

          <button type="submit" name="submit" class="mt-3">Update Page</button>
        </form>
      </div>
    </div>
  </section>

  <script>
    async function updateData(event) {
      event.preventDefault();

      const form = event.currentTarget;
      form.submit.setAttribute("disabled", "disabled");

      // document.getElementById("html_content").value = document.getElementById("editor").innerHTML;

      try {
        const formData = new FormData(form);

        const isActive = document.getElementById("is_active").checked;
        formData.append("active", isActive ? 1 : 0);
        // formData.append("content", $("#content").trumbowyg("html"));

        const response = await axios.post(
          baseUrl + "/admin/pages/update",
          formData
        )

        if (response.data.status == "success") {
          swal.fire("Update Page", response.data.message, "success")
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
      // $("textarea[name='content']").richText();
    //   $("#content").trumbowyg(trumbowyg_config);
    });
  </script>

@endsection