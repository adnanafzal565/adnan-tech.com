<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>@yield("title", site_title())</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @hasSection("meta_description")
      <meta name="description" content="@yield('meta_description')" />
    @endif
    @hasSection("meta_keywords")
      <meta name="keywords" content="@yield('meta_keywords')" />
    @endif
    <!-- Open Graph for social sharing -->
    @hasSection("title")
      <meta property="og:title" content="@yield('title', site_title())" />
    @endif
    @hasSection("meta_description")
      <meta property="og:description" content="@yield('meta_description')" />
    @endif
    <meta property="og:url" content="{{ url()->current() }}" />
    @hasSection("type")
      <meta property="og:type" content="@yield('type')" />
    @endif
    <link rel="canonical" href="{{ url()->current() }}" />
    <link href="{{ asset('themes/' . active_theme() . '/css/style.css') }}" rel="stylesheet" />
  </head>
  <body>
    <input type="hidden" id="base-url" value="{{ url('/') }}" />
    <script>
      const baseUrl = document.getElementById("base-url").value || "";
    </script>

    <!-- Header -->
    <header class="site-header">
      <table>
        <tr>
          <td>
            <h1>{{ site_title() }}</h1>
          </td>

          {{--
          <td align="right">
            <form method="GET" action="{{ url('/search') }}">
              <input type="text" name="q" placeholder="Search" value="{{ request('q') }}" />
              <button type="submit">Go</button>
            </form>
          </td>
          --}}

        </tr>
      </table>
      <nav>
        @foreach (menu_items("Main menu") as $menu_item)
          <a href="{{ $menu_item->url ?? '' }}">{{ $menu_item->title ?? "" }}</a> |
        @endforeach
      </nav>
    </header>

    <hr />

    <main>
      @yield ("main")
    </main>

    <hr />

    <!-- Footer -->
    <footer class="site-footer">
      <p>
        &copy; {{ date("Y") }}
        <a href="{{ url('/') }}" target="_blank">{{ site_title() }}</a>.
        All rights reserved.
      </p>
    </footer>
  </body>
</html>