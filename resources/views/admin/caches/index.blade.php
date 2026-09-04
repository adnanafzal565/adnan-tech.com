{{--
    Admin: Cache manager
    ---------------------------------------------------------
    Assumes an admin layout with @section('content'). Swap
    @extends() for your actual admin layout name.

    Routes expected (add alongside your other admin routes,
    inside the same Admin/CheckRoutePermission middleware group):

        Route::get("/admin/caches", [CacheController::class, "index"])
            ->name("admin.caches.index");

        Route::post("/admin/caches/forget", [CacheController::class, "forget"])
            ->name("admin.caches.forget");

        Route::post("/admin/caches/clear", [CacheController::class, "clear"])
            ->name("admin.caches.clear");
--}}

@extends('admin.layouts.app')

@section('main')

<div class="container-fluid py-4">

    <div class="pagetitle">
        <div style="display: flex;">
          <h1>Cache Manager</h1>
        </div>

        <nav class="mt-3">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Cache Manager</li>
          </ol>
        </nav>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <p class="text-muted mb-0">
                {{ $caches->count() }} {{ Str::plural('entry', $caches->count()) }}
                &middot; {{ number_format($totalSize / 1024, 1) }} KB total
            </p>
        </div>

        <form action="{{ route('admin.caches.clear') }}" method="POST"
              onsubmit="return confirm('Clear ALL cached data? This cannot be undone.');">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-trash3"></i> Clear all
            </button>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <form action="{{ route('admin.caches.index') }}" method="GET" class="d-flex gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    class="form-control form-control-sm"
                    placeholder="Search by key name..."
                    style="max-width: 280px;"
                >
                <button type="submit" class="btn btn-sm btn-outline-secondary">Search</button>
                @if ($search)
                    <a href="{{ route('admin.caches.index') }}" class="btn btn-sm btn-link text-muted">Clear filter</a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Key</th>
                        <th>Size</th>
                        <th>Expires</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($caches as $cache)
                        <tr>
                            <td><code>{{ $cache->key }}</code></td>
                            <td class="text-muted">{{ number_format($cache->size_bytes / 1024, 2) }} KB</td>
                            <td>
                                @if ($cache->expires_at->diffInYears(now()) >= 3)
                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                        Long-term ({{ $cache->expires_at->format('M j, Y') }})
                                    </span>
                                @elseif ($cache->expires_at->isPast())
                                    <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle">
                                        Expired
                                    </span>
                                @else
                                    <span class="text-muted small">{{ $cache->expires_at->diffForHumans() }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <form
                                    action="{{ route('admin.caches.forget') }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Clear cache key \'{{ $cache->key }}\'?');"
                                >
                                    @csrf
                                    <input type="hidden" name="key" value="{{ $cache->key }}">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-x-circle"></i> Forget
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No cache entries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection