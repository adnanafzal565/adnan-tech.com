@php
  $pm_user = auth()->user();
  $pm_is_admin = $pm_user != null && $pm_user->is_super_admin();
@endphp

@if (!$pm_is_admin)

  <div class="alert alert-warning">
    This tool is available to administrators only.
    @guest
      <a href="{{ route('login') }}">Login</a> to continue.
    @endguest
  </div>

@else

  <div id="pm-root">
    <p class="text-muted">Loading…</p>
  </div>

  @php
    $config = [
      "mode" => "admin",
      "apiBase" => url("/tools/project-management/api"),
      "csrf" => csrf_token(),
      "currencies" => \App\Http\Controllers\ProjectManagementController::CURRENCIES,
    ];
  @endphp

  <input type="hidden" id="pm-config" value="{{ json_encode($config) }}" />

  <script>
    window.PM_CONFIG = JSON.parse(document.getElementById("pm-config").value);
  </script>

  <script type="text/babel" src="{{ asset('components/ProjectManagement.js') }}"></script>

  <script type="text/babel">
    ReactDOM.createRoot(document.getElementById('pm-root')).render(<ProjectManagement />);
  </script>

@endif