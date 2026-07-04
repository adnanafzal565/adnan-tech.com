@extends ("admin/layouts/app")
@section ("title", "File Manager")

@section ("main")

  @php
    $can_delete = auth()->user()->has_route_access(\App\Helpers\Constants::FILES_DELETE);
  @endphp

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>File Manager</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route(\App\Helpers\Constants::DASHBOARD) }}">Dashboard</a></li>
        <li class="breadcrumb-item active">File Manager</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12">

        <form method="POST" enctype="multipart/form-data"
          onsubmit="uploadFile(event, function () { window.location.reload(); })">

          <label for="file">Choose File</label>
          <input type="file" name="file" id="file" required>

          <label for="name">File Name</label>
          <input type="text" name="name" id="name" placeholder="my-image-{{ now()->year }}">

          <label for="alt">Alt Text</label>
          <input type="text" name="alt" id="alt" placeholder="A beautiful sunset">

          <label for="caption">Caption</label>
          <input type="text" name="caption" id="caption" placeholder="Sunset in Hunza Valley">

          <label for="description">Description</label>
          <textarea name="description" id="description" rows="3" placeholder="Describe the image or video..."></textarea>

          <label for="type">Type</label>
          <select name="type" id="type" required>
            <option value="public">Public</option>
            <option value="private">Private</option>
          </select>

          <button type="submit" name="submit">Upload</button>
        </form>

        <form method="GET" action="{{ route(\App\Helpers\Constants::FILES_INDEX) }}">
            <div class="form-group mt-5">
                <input type="search" name="search" placeholder="Search here..." class="form-control" value="{{ $search }}" />
            </div>
        </form>

        <table class="mt-5">
          <thead>
            <tr>
              <th>Preview</th>
              <th>Name</th>
              <th>Caption</th>
              <th>Alt</th>
              <th>Description</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($files as $m)

              @php
                $url = asset('storage/' . $m->file_path);
                $ext = pathinfo($m->file_path, PATHINFO_EXTENSION);
                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                $isVideo = in_array(strtolower($ext), ['mp4', 'webm', 'ogg']);
              @endphp

              <tr id="media-{{ $m->id }}">
                <td>
                  <div class="preview-box">
                    @if ($isImage)
                      <img src="{{ $url }}" alt="{{ $m->alt }}">
                    @elseif ($isVideo)
                      <video src="{{ $url }}" controls muted></video>
                    @else
                      <div class="file-icon">📄</div>
                    @endif
                  </div>
                </td>
                <td>{{ $m->name }}</td>
                <td>{{ $m->caption }}</td>
                <td>{{ $m->alt }}</td>
                <td>{{ $m->description }}</td>
                <td>
                  <button type="button" class="btn btn-primary mt-0" onclick="copyToClipboard('{{ $url }}', {{ $m->id }})">Copy Link</button>
                  <div class="copied-msg" id="copied-msg-{{ $m->id }}" style="display: none;">Copied!</div>

                  @if ($can_delete)
                  <button type="button" class="btn btn-danger mt-0" onclick="deleteMedia(event, {{ $m->id }})">Delete</button>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div class="pagination">
          {{ $files->links() }}
        </div>
      </div>
    </div>
  </section>

  <script>

    function copyToClipboard(text, id) {
      navigator.clipboard.writeText(text)
        .then(() => {
          const msg = document.getElementById('copied-msg-' + id);
          msg.style.display = 'block';
          // setTimeout(() => msg.style.display = 'none', 2000);
        })
        .catch(() => alert('Failed to copy'));
    }

    function deleteMedia(event, id) {
      const node = event.currentTarget;

      swal.fire({
        title: "Delete file",
        text: "Are you sure you want to delete his file ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, do it!"
      }).then(async function (result) {
        if (result.isConfirmed) {
          node.setAttribute("disabled", "disabled");

          const formData = new FormData();
          formData.append("id", id);

          try {
            const response = await axios.post(
              baseUrl + "/admin/files/delete",
              formData
            );

            if (response.data.status == "success") {
              document.getElementById('media-' + id).remove();
            } else {
              swal.fire("Error", response.data.message, "error");
            }
          } catch (exp) {
            swal.fire("Error", exp.message, "error");
          } finally {
            node.removeAttribute("disabled");
          }
        }
      })
    }
  </script>

  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }

    th, td {
      padding: 0.8rem;
      border: 1px solid #ddd;
    }

    th {
      background-color: #f8f9fa;
      text-align: left;
    }

    .preview-box {
      width: 120px;
      height: 80px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      border: 1px solid #ccc;
      background: #fafafa;
    }

    .preview-box img,
    .preview-box video {
      max-width: 100%;
      max-height: 100%;
    }

    .file-icon {
      font-size: 2rem;
      color: #999;
    }

    .btn {
      padding: 5px 10px;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 0.9rem;
      border-radius: 4px;
    }

    .copy-btn {
      background-color: #007bff;
    }

    .delete-btn {
      background-color: #dc3545;
    }

    .copied-msg {
      font-size: 0.75rem;
      color: green;
      margin-top: 2px;
    }

    .pagination {
      margin-top: 1.5rem;
    }

    .pagination a {
      padding: 6px 10px;
      margin: 0 2px;
      border: 1px solid #ccc;
      text-decoration: none;
      color: #007bff;
      background: white;
    }

    .pagination .active span {
      font-weight: bold;
      padding: 6px 10px;
      background: #007bff;
      color: white;
      border-radius: 3px;
    }

    h2 {
      margin-bottom: 1rem;
    }

    label {
      display: block;
      margin-top: 1rem;
      font-weight: bold;
    }

    input[type="text"],
    textarea,
    select,
    input[type="file"] {
      width: 100%;
      padding: 0.6rem;
      margin-top: 0.3rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 1rem;
    }

    button {
      margin-top: 1.5rem;
      padding: 0.8rem 1.2rem;
      background-color: #2d89ef;
      border: none;
      color: white;
      border-radius: 5px;
      font-size: 1rem;
      cursor: pointer;
    }
  </style>

@endsection
