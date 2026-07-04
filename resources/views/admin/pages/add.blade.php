@extends ("admin/layouts/app")
@section ("title", "Add Page")

@section ("main")

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Add Page</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/pages') }}">Pages</a></li>
        <li class="breadcrumb-item active">Add Page</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12 edit-post">
        <form method="POST" enctype="multipart/form-data"
          onsubmit="addData(event);">

          <label for="title">Title</label>
          <input type="text" id="title" name="title" required onkeyup="generateSlug()" />

          <label for="slug">Slug</label>
          <div class="slug-wrapper">
            <input type="text" id="slug" name="slug" required>
            <button type="button" onclick="generateSlug();">↻</button>
          </div>

          <label>Meta Keywords</label>
          <input type="text" name="keywords" />

          <label>Excerpt</label>
          <textarea name="excerpt"></textarea>

          <label for="content">Content</label>
          <textarea name="content">{{ $page->content ?? "" }}</textarea>

            <!--
          <div id="toolbar">
            <button type="button" onclick="editor.format('bold')">Bold</button>
            <button type="button" onclick="editor.format('italic')">Italic</button>
            <button type="button" onclick="editor.format('underline')">Underline</button>
            <button type="button" onclick="editor.format('insertUnorderedList')">Unordered List</button>
            <button type="button" onclick="editor.format('insertOrderedList')">Ordered List</button>
            <button type="button" onclick="editor.insertHeading(1)">H1</button>
            <button type="button" onclick="editor.insertHeading(2)">H2</button>
            <button type="button" onclick="editor.insertHeading(3)">H3</button>
            <button type="button" onclick="editor.insertHeading(4)">H4</button>
            <button type="button" onclick="editor.insertHeading(5)">H5</button>
            <button type="button" onclick="editor.insertHeading(6)">H6</button>
            <button type="button" onclick="editor.insertParagraph()">P</button>
            <button type="button" onclick="editor.insertLink()">Link</button>
            <button type="button" onclick="editor.insertImage()">Image</button>
            <button type="button" onclick="editor.insertVideo()">Video</button>
            <button type="button" onclick="editor.insertColumns()">Columns</button>
            <button type="button" onclick="editor.insertSection()">Section</button>
          </div>

          <div id="editor" contenteditable="true"></div>
          <input type="hidden" name="content" id="html_content" />
          -->

          <div class="switch">
            <input type="checkbox" id="is_active" checked />
            <label for="is_active" style="margin-top: 0px;">Is Active</label>
          </div>

          <button type="submit" name="submit" class="mt-3">Create Page</button>
        </form>
      </div>
    </div>
  </section>

  <script>
    async function addData(event) {
      event.preventDefault();

      const form = event.currentTarget;
      form.submit.setAttribute("disabled", "disabled");

      // document.getElementById("html_content").value = document.getElementById("editor").innerHTML;

      try {
        const formData = new FormData(form);

        const isActive = document.getElementById("is_active").checked;
        formData.append("active", isActive ? 1 : 0)

        const response = await axios.post(
          baseUrl + "/admin/pages/add",
          formData
        )

        if (response.data.status == "success") {
          const id = response.data.id;
          window.location.href = baseUrl + "/admin/pages/" + id + "/edit";
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
    });
  </script>

@endsection
