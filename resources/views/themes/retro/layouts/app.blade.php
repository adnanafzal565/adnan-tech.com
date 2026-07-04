<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
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

    <link rel="canonical" href="{{ url()->current() }}" / >

    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/themes/' . active_theme() . '/css/style.css') }}" />
  </head>
  <body>

    <input type="hidden" id="base-url" value="{{ url('/') }}" />

    <script>
      const baseUrl = document.getElementById("base-url").value || "";
    </script>

    <!-- Header -->
    <header class="retro-header">
      <div class="container">
        <h1>@yield("title", site_title())</h1>
        <nav>
          @foreach (menu_items("Main menu") as $menu_item)
            <a href="{{ $menu_item->url ?? '' }}">{{ $menu_item->title ?? "" }}</a>
          @endforeach
        </nav>
      </div>
    </header>

    <main style="margin-top: 50px; margin-bottom: 50px;">
      @yield("main")
    </main>

    <!-- Footer -->
    <footer class="retro-footer">
      <div class="container">
        <p>&copy; {{ date("Y") }}
          <a href="https://adnan-tech.com/" style="color: white;
              text-decoration: none;"
              target="_blank">Adnan Afzal</a>
            | Made with <span style="font-size: 30px;">❤️</span> and 8-bit pixels.</p>
      </div>
    </footer>

  </body>
</html>