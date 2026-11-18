@extends ("admin/layouts/app")
@section ("title", "Menus")

@section ("main")

  @php
    $selected_menu_name = "";
    $can_create = auth()->user()->has_route_access('admin.menus.create');
    $can_create_item = auth()->user()->has_route_access('admin.menus.items.create');
    $can_update_item = auth()->user()->has_route_access('admin.menus.items.update');
    $can_delete_item = auth()->user()->has_route_access('admin.menus.items.destroy');
    $can_reorder_item = auth()->user()->has_route_access('admin.menus.items.reorder');
  @endphp

  <!-- <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script> -->
  <script src="{{ asset('/js/Sortable.min.js') }}"></script>

  <style>
    #menuItems .sub-menu { min-height: 12px; padding-left: 1.5rem; margin-top: .5rem; }
    #menuItems .drag-handle { cursor: grab; user-select: none; }
  </style>

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

                      <select id="input-custom-link-parent" class="form-select mt-2">
                        <option value="">Top level</option>
                      </select>
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
    const parentSelect = document.getElementById('input-custom-link-parent');

    function escapeHtml(s) {
      return String(s ?? '').replace(/[&<>"']/g, c => ({
        '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
      }[c]));
    }

    // Direct-child lookups, so nested items never match their parent's fields
    function subList(li) { return li.querySelector(':scope > ul.sub-menu'); }
    function itemForm(li) { return li.querySelector(':scope > .collapse-form'); }

    function initSortable(ul) {
      if (!can_reorder_item || ul.dataset.sortable) return;
      ul.dataset.sortable = "1";

      new Sortable(ul, {
        group: 'menu-items',      // same group = items can move between lists
        animation: 150,
        handle: '.drag-handle',
        fallbackOnBody: true,
        swapThreshold: 0.65,
        onEnd: refreshParentOptions
      });
    }

    function refreshParentOptions() {
      if (!parentSelect) return;

      const current = parentSelect.value;
      parentSelect.innerHTML = '<option value="">Top level</option>';

      (function walk(ul, depth) {
        [...ul.children].forEach(li => {
          if (!li.dataset.id) return;
          const title = itemForm(li).querySelector('[name="title"]').value;
          const opt = document.createElement('option');
          opt.value = li.dataset.id;
          opt.textContent = '— '.repeat(depth) + title;
          parentSelect.appendChild(opt);
          walk(subList(li), depth + 1);
        });
      })(menuList, 0);

      parentSelect.value = current;
    }

    function appendMenuItem(item, container) {
      container = container || menuList;

      const li = document.createElement('li');
      li.classList.add('list-group-item');
      li.setAttribute('data-id', item.id);

      let html = `
        <div class="d-flex align-items-center">
          ${can_reorder_item ? '<span class="drag-handle me-2" title="Drag to reorder">☰</span>' : ''}
          <button type="button" class="btn btn-sm btn-link toggle-collapse no-underline">▶ &nbsp;${escapeHtml(item.title)}</button>
        </div>

        <div class="collapse-form mt-2" style="display: none;">
          <label class="form-label">Enter Title</label>
          <input type="text" class="form-control mb-2" name="title" value="${escapeHtml(item.title)}" placeholder="Title">

          <label class="form-label">Enter URL</label>
          <input type="text" class="form-control mb-2" name="url" value="${escapeHtml(item.url)}" placeholder="URL">`;

      if (can_update_item) {
        html += `<button type="button" class="btn btn-sm btn-primary save-btn"
          onclick="saveMenuItem(event, ${parseInt(item.id)});">Save</button>`;
      }

      if (can_delete_item) {
        html += `<button type="button" class="btn btn-sm btn-link" style="color: red;"
          onclick="deleteMenuItem(event, ${parseInt(item.id)});">Delete</button>`;
      }

      html += `</div>
        <ul class="list-group sub-menu"></ul>`;

      li.innerHTML = html;
      container.appendChild(li);

      const sub = subList(li);
      initSortable(sub);

      (item.children || []).forEach(child => appendMenuItem(child, sub));

      return li;
    }

    async function addMenuItem(event) {
      const node = event.currentTarget;

      if (menuId <= 0) {
        swal.fire("Error", "Please select a menu first.", "error");
        return;
      }

      const link = document.getElementById("input-custom-link").value || "";
      const linkTitle = document.getElementById("input-custom-link-title").value || "";
      const parentId = parentSelect ? parentSelect.value : "";

      node.setAttribute("disabled", "disabled");

      try {
        const formData = new FormData();
        formData.append("id", menuId);
        formData.append("title", linkTitle);
        formData.append("url", link);
        if (parentId) formData.append("parent_id", parentId);

        const response = await axios.post(baseUrl + "/admin/menus/items/add", formData);

        if (response.data.status == "success") {
          const menuItem = response.data.menu_item;

          let container = menuList;
          if (parentId) {
            const parentLi = menuList.querySelector(`li[data-id='${parentId}']`);
            if (parentLi) container = subList(parentLi);
          }

          appendMenuItem(menuItem, container);
          refreshParentOptions();

          document.getElementById("input-custom-link").value = "";
          document.getElementById("input-custom-link-title").value = "";
        } else {
          swal.fire("Error", response.data.message, "error");
        }
      } catch (exp) {
        swal.fire("Error", exp.message, "error");
      } finally {
        node.removeAttribute("disabled");
      }
    }

    function deleteMenuItem(event, id) {
      const node = event.currentTarget;

      const li = menuList.querySelector("li[data-id='" + id + "']");
      if (li == null) return;

      const hasChildren = subList(li).children.length > 0;

      swal.fire({
        title: "Delete menu item ?",
        text: hasChildren ? "Its sub-items will be deleted as well." : "",
        showCancelButton: true,
        confirmButtonText: "Do it"
      }).then(async function (result) {
        if (!result.isConfirmed) return;

        node.setAttribute("disabled", "disabled");

        try {
          const formData = new FormData();
          formData.append("id", id);

          const response = await axios.post(baseUrl + "/admin/menus/items/delete", formData);

          if (response.data.status == "success") {
            li.remove();
            refreshParentOptions();
          } else {
            swal.fire("Error", response.data.message, "error");
          }
        } catch (exp) {
          swal.fire("Error", exp.message, "error");
        } finally {
          node.removeAttribute("disabled");
        }
      });
    }

    async function saveMenuItem(event, id) {
      const node = event.currentTarget;

      const li = menuList.querySelector("li[data-id='" + id + "']");
      if (li == null) return;

      const form = itemForm(li);
      const title = form.querySelector("[name='title']").value || "";
      const url = form.querySelector("[name='url']").value || "";

      node.setAttribute("disabled", "disabled");

      try {
        const formData = new FormData();
        formData.append("id", id);
        formData.append("title", title);
        formData.append("url", url);

        const response = await axios.post(baseUrl + "/admin/menus/items/update", formData);

        if (response.data.status == "success") {
          li.querySelector(':scope > div > .toggle-collapse').innerHTML = "▶ &nbsp;" + escapeHtml(title);
          refreshParentOptions();
          swal.fire("Menu Item Updated", response.data.message, "success");
        } else {
          swal.fire("Error", response.data.message, "error");
        }
      } catch (exp) {
        swal.fire("Error", exp.message, "error");
      } finally {
        node.removeAttribute("disabled");
      }
    }

    function serializeTree(ul) {
      return [...ul.children]
        .filter(li => li.dataset.id)
        .map(li => ({
          id: parseInt(li.dataset.id),
          children: serializeTree(subList(li))
        }));
    }

    // One delegated listener handles toggling for every item, present and future
    menuList.addEventListener('click', function (e) {
      const btn = e.target.closest('.toggle-collapse');
      if (!btn) return;

      const form = itemForm(btn.closest('li'));
      form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    document.addEventListener('DOMContentLoaded', async function () {
      if (menuId <= 0) return;

      initSortable(menuList);

      // Save order (button only exists when the user has reorder permission)
      const saveBtn = document.getElementById('saveOrderBtn');
      if (saveBtn) {
        saveBtn.addEventListener('click', async function (event) {
          const node = event.currentTarget;
          node.setAttribute("disabled", "disabled");

          try {
            const formData = new FormData();
            formData.append("id", menuId);
            formData.append("order", JSON.stringify(serializeTree(menuList)));

            const response = await axios.post(baseUrl + "/admin/menus/items/reorder", formData);

            if (response.data.status == "success") {
              swal.fire("Updated", response.data.message, "success");
            } else {
              swal.fire("Error", response.data.message, "error");
            }
          } catch (exp) {
            swal.fire("Error", exp.message, "error");
          } finally {
            node.removeAttribute("disabled");
          }
        });
      }

      try {
        const formData = new FormData();
        formData.append("id", menuId);

        const response = await axios.post(baseUrl + "/admin/menus/items/fetch", formData);

        if (response.data.status == "success") {
          menuList.innerHTML = '';
          response.data.items.forEach(item => appendMenuItem(item, menuList));
          refreshParentOptions();
        } else {
          swal.fire("Error", response.data.message, "error");
        }
      } catch (exp) {
        swal.fire("Error", exp.message, "error");
      }
    });
  </script>

@endsection