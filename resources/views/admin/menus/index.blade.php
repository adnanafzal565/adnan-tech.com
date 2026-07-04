@extends ("admin/layouts/app")
@section ("title", "Menus")

@section ("main")

  @php
    $selected_menu_name = "";
    $can_create = auth()->user()->has_route_access(\App\Helpers\Constants::MENUS_CREATE);
    $can_create_item = auth()->user()->has_route_access(\App\Helpers\Constants::MENUS_ITEMS_CREATE);
    $can_update_item = auth()->user()->has_route_access(\App\Helpers\Constants::MENUS_ITEMS_UPDATE);
    $can_delete_item = auth()->user()->has_route_access(\App\Helpers\Constants::MENUS_ITEMS_DELETE);
    $can_reorder_item = auth()->user()->has_route_access(\App\Helpers\Constants::MENUS_ITEMS_REORDER);
  @endphp

  <!-- <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script> -->
  <script src="{{ asset('/js/Sortable.min.js') }}"></script>

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Menus</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Menus</li>
      </ol>
    </nav>
  </div>

  <section class="section">

    @if ($can_create)
    <div class="row">
      <div class="offset-md-3 col-md-6">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title text-center">Add New Menu</h2>
          </div>

          <div class="card-body">

            @if ($errors->has('error'))
              <div class="alert alert-danger">
                {{ $errors->first('error') }}
              </div>
            @endif

            @if (session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif

            <form method="POST" action="{{ route('admin.menus.create') }}">
              {{ csrf_field() }}

              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="name" required />
                </div>
              </div>

              <input type="submit" name="submit" class="btn btn-outline-primary" value="Add" />
            </form>
          </div>
        </div>
      </div>
    </div>
    @endif

    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Select Menu</h2>
          </div>

          <div class="card-body">
            <form method="GET" class="form-inline d-flex align-items-center gap-2"
              action="{{ url('/admin/menus') }}">
              
              <select name="menu" class="form-select">
                <option value="">Select Menu</option>
                @foreach ($menus as $menu)

                  @if ($menu->id == $menu_id)
                    @php
                      $selected_menu_name = $menu->name ?? "";
                    @endphp
                  @endif

                  <option value="{{ $menu->id ?? 0 }}"
                    {{ $menu->id == $menu_id ? "selected" : "" }}>{{ $menu->name ?? "" }}</option>
                @endforeach
              </select>

              <input type="submit" class="btn btn-primary btn-sm ms-2" value="Select Menu" />
            </form>
          </div>
        </div>
      </div>

      @if ($can_create_item)
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Menu Items</h2>
          </div>

          <div class="card-body">
            <ul class="list-group">
              <li class="list-group-item">
                <!-- Toggle Button -->
                <button class="btn btn-outline-secondary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#customLinks" aria-expanded="false" aria-controls="customLinks">
                  + Custom Links
                </button>

                <!-- Collapsible Form -->
                <div class="collapse" id="customLinks">
                  <div class="row">
                    <div class="col-sm-8">
                      <input type="text" id="input-custom-link-title" class="form-control" placeholder="Enter Title" />
                      <input type="text" id="input-custom-link" class="form-control mt-2" placeholder="Enter URL" />
                    </div>

                    <div class="col-sm-4">
                      <button type="button" class="btn btn-primary"
                        onclick="addMenuItem(event);">Add</button>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      @endif

      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h2 class="card-title">
              Order of Menu Items
              @if (!empty($selected_menu_name))
                ({{ $selected_menu_name }})
              @endif
            </h2>
          </div>

          <div class="card-body">
            <ul id="menuItems" class="list-group">
              <!-- Menu items will be populated here via JS -->
            </ul>

            @if ($can_reorder_item)
            <button id="saveOrderBtn" class="btn btn-success mt-5">Save Order</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  <input type="hidden" id="menu-id" value="{{ $menu_id }}" />
  <input type="hidden" id="can_update_item" value="{{ $can_update_item ? 1 : 0 }}" />
  <input type="hidden" id="can_delete_item" value="{{ $can_delete_item ? 1 : 0 }}" />
  <input type="hidden" id="can_reorder_item" value="{{ $can_reorder_item ? 1 : 0 }}" />

  <script>
    const can_update_item = parseInt(document.getElementById("can_update_item").value || "0") || 0;
    const can_delete_item = parseInt(document.getElementById("can_delete_item").value || "0") || 0;
    const can_reorder_item = parseInt(document.getElementById("can_reorder_item").value || "0") || 0;
    const menuId = parseInt(document.getElementById("menu-id").value || "0") || 0;
    const menuList = document.getElementById('menuItems');

    async function addMenuItem(event) {
      const node = event.currentTarget;

      if (menuId <= 0) {
        swal.fire("Error", "Please select a menu first.", "error");
        return;
      }

      const link = document.getElementById("input-custom-link").value || "";
      const linkTitle = document.getElementById("input-custom-link-title").value || "";
      node.setAttribute("disabled", "disabled")

      try {
        const formData = new FormData();
        formData.append("id", menuId);
        formData.append("title", linkTitle);
        formData.append("url", link);

        const response = await axios.post(
          baseUrl + "/admin/menus/items/add",
          formData
        )

        if (response.data.status == "success") {
          const menuItem = response.data.menu_item;

          appendMenuItem(menuItem);
          attachListeners();

          if (can_reorder_item) {
            // Enable sorting
            new Sortable(menuList, {
                animation: 150
            });
          }
        } else {
          swal.fire("Error", response.data.message, "error")
        }
      } catch (exp) {
        swal.fire("Error", exp.message, "error")
      } finally {
        node.removeAttribute("disabled")
      }
    }

    function deleteMenuItem(event, id) {
      const node = event.currentTarget;

      const div = document.querySelector("#menuItems [data-id='" + id + "']");
      if (div == null) {
        return;
      }

      swal.fire({
        title: "Delete menu item ?",
        showCancelButton: true,
        confirmButtonText: "Do it"
      }).then(async function (result) {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          node.setAttribute("disabled", "disabled")

          try {
            const formData = new FormData();
            formData.append("id", id);

            const response = await axios.post(
              baseUrl + "/admin/menus/items/delete",
              formData
            )

            if (response.data.status == "success") {
              div.remove();
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

    async function saveMenuItem(event, id) {
      const node = event.currentTarget;

      const div = document.querySelector("#menuItems [data-id='" + id + "']");
      if (div == null) {
        return;
      }

      const title = div.querySelector("[name='title']").value || "";
      const url = div.querySelector("[name='url']").value || "";

      node.setAttribute("disabled", "disabled")

      try {
        const formData = new FormData();
        formData.append("id", id);
        formData.append("title", title);
        formData.append("url", url);

        const response = await axios.post(
          baseUrl + "/admin/menus/items/update",
          formData
        )

        if (response.data.status == "success") {
          swal.fire("Menu Item Updated", response.data.message, "success");
        } else {
          swal.fire("Error", response.data.message, "error")
        }
      } catch (exp) {
        swal.fire("Error", exp.message, "error")
      } finally {
        node.removeAttribute("disabled")
      }
    }

    function attachListeners() {
      setTimeout(function () {
        // Toggle collapsible
        menuList.querySelectorAll('.toggle-collapse').forEach(btn => {
            btn.addEventListener('click', function () {
                const form = this.closest('div').querySelector('.collapse-form');
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });
        });
      }, 500);
    }

    function appendMenuItem(item) {
      const li = document.createElement('li');
      li.classList.add('list-group-item');
      li.setAttribute('data-id', item.id);
      li.textContent = item.title;

      let html = ``;
      html += `<div data-id="${item.id}">
        <button type="button" class="btn btn-sm btn-link toggle-collapse no-underline">▶ &nbsp;${item.title}</button>
        
        <div class="collapse-form mt-2" style="display: none;">
          <label class="form-label">Enter Title</label>
          <input type="text" class="form-control mb-2" name="title" value="${item.title}" placeholder="Title">
          
          <label class="form-label">Enter URL</label>
          <input type="text" class="form-control mb-2" name="url" value="${item.url}" placeholder="URL">`;

      if (can_update_item) {
        html += `<button type="button" class="btn btn-sm btn-primary save-btn"
          onclick="saveMenuItem(event, '` + item.id + `');">Save</button>`;
      }

      if (can_delete_item) {
        html += `<button type="button" class="btn btn-sm btn-link"
          style="color: red;"
          onclick="deleteMenuItem(event, '` + item.id + `');">Delete</button>`
      }

      html += `</div>
        </div>`;

      li.innerHTML = html;

      menuList.appendChild(li);
    }

    document.addEventListener('DOMContentLoaded', async function () {
      if (menuId <= 0) {
        return;
      }

      try {
        const formData = new FormData();
        formData.append("id", menuId);

        const response = await axios.post(
          baseUrl + "/admin/menus/items/fetch",
          formData
        )

        if (response.data.status == "success") {
          const items = response.data.items;
          menuList.innerHTML = '';
          items.forEach(item => {
              appendMenuItem(item);
          });

          attachListeners();

          if (can_reorder_item) {
            // Enable sorting
            new Sortable(menuList, {
                animation: 150
            });
          }
        } else {
          swal.fire("Error", response.data.message, "error")
        }
      } catch (exp) {
        swal.fire("Error", exp.message, "error")
      }

      // Save order
      document.getElementById('saveOrderBtn').addEventListener('click', async function (event) {
        const node = event.currentTarget;
        const orderedIds = [...menuList.children].map(li => parseInt(li.getAttribute('data-id')));

        node.setAttribute("disabled", "disabled");

        try {
          const formData = new FormData();
          formData.append("id", menuId);
          formData.append("order", JSON.stringify(orderedIds));

          const response = await axios.post(
            baseUrl + "/admin/menus/items/reorder",
            formData
          )

          if (response.data.status == "success") {
            swal.fire("Updated", response.data.message, "success")
          } else {
            swal.fire("Error", response.data.message, "error")
          }
        } catch (exp) {
          swal.fire("Error", exp.message, "error")
        } finally {
          node.removeAttribute("disabled");
        }
      });
    });
  </script>

@endsection