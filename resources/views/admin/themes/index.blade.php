@extends ("admin/layouts/app")
@section ("title", "Themes")

@section ("main")

  @php
    $can_update = auth()->user()->has_route_access('admin.themes.update');
  @endphp

  <div class="pagetitle">
    <div style="display: flex;">
      <h1>Themes</h1>
    </div>

    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Themes</li>
      </ol>
    </nav>
  </div>

  <section class="section">
    <div class="row">
      <div class="col-12">
        <div class="themes-grid">
          @foreach ($themes as $theme)
            <div class="theme-card {{ $theme === $active_theme ? 'active' : '' }}">
              <div class="theme-preview">
                <img src="{{ asset('themes/' . $theme . '/preview.jpg') }}"
                  alt="{{ $theme }} Preview"
                  style="width: 100%;
                    height: 150px;
                    object-fit: cover;"
                  onerror="this.src = baseUrl + '/img/user-placeholder.png';" />
              </div>

              <div class="theme-info">
                <h3>{{ $theme }}</h3>
                @if ($theme === $active_theme)
                  <span class="badge">Active</span>
                @elseif ($can_update)
                  <form method="POST" action="{{ route('admin.themes.update') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="theme" value="{{ $theme }}">
                    <button type="submit" class="btn-activate">Activate</button>
                  </form>
                @endif
              </div>
            </div>
          @endforeach
        </div>

      </div>
    </div>
  </section>

  <style>
    .themes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .theme-card {
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        transition: box-shadow 0.2s;
        position: relative;
    }

    .theme-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .theme-preview img {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .theme-info {
        padding: 15px;
        text-align: center;
    }

    .theme-info h3 {
        font-size: 1.1rem;
        margin-bottom: 10px;
    }

    .btn-activate {
        background-color: #1e88e5;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.2s;
    }

    .btn-activate:hover {
        background-color: #1565c0;
        color: white;
    }

    .badge {
        background-color: #43a047;
        color: white;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
  </style>

@endsection