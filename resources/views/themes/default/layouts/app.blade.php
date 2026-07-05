<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield("title", site_title())</title>

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
    <script src="{{ asset('themes/' . active_theme() . '/js/app.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}" />
    <script src="{{ asset('/js/jquery.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.bundle.js') }}"></script>

    <script src="{{ asset('/js/react.development.js') }}"></script>
    <script src="{{ asset('/js/react-dom.development.js') }}"></script>
    <script src="{{ asset('/js/babel.min.js') }}"></script>
    <script src="{{ asset('/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('/js/axios.min.js') }}"></script>
    <script src="{{ asset('/js/fontawesome.js') }}"></script>
    <script src="{{ asset('/js/script.js?v=' . time()) }}"></script>
</head>
<body>

    @php
        $user = null;
    @endphp

    @if (auth()->check())
        @php
            $user = auth()->user();
        @endphp

        <input type="hidden" id="user" value="{{ json_encode([
            'id' => $user->id ?? 0,
            'name' => $user->name ?? '',
            'email' => $user->email ?? '',
            'type' => $user->type ?? ''
        ]) }}" />
    @endif

    <input type="hidden" id="base-url" value="{{ url('/') }}" />

    <script>
        const baseUrl = document.getElementById("base-url").value || "";

        let user = null;

        if (document.getElementById("user") != null) {
            user = JSON.parse(document.getElementById("user").value);
        }
    </script>

    @php
        $title_parts = explode(" ", site_title());
    @endphp

    <!-- Header -->
    <header class="site-header">
        <div class="container header-inner">
            <div class="logo">
                <a href="{{ url('/') }}">
                    @if (count($title_parts) > 0)
                        {!! $title_parts[0] . ((count($title_parts) > 1) ? ("<span>" . $title_parts[1] . "</span>") : "") !!}
                    @endif
                </a>
            </div>

            <nav class="main-nav">
                <ul>
                    @foreach (menu_items("Main menu") as $menu_item)
                        <li>
                            <a href="{{ $menu_item->url ?? '' }}">{{ $menu_item->title ?? "" }}</a>
                        </li>
                    @endforeach

                    @if (auth()->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name ?? "" }}
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                                @if (auth()->user()->type === "admin")
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                                @endif

                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="return do_logout();">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li>
                            <a href="{{ url('/login') }}">Login</a>
                        </li>

                        <li>
                            <a href="{{ url('/register') }}">Sign Up</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </header>

    <main style="margin-top: 50px; margin-bottom: 50px;">
        @yield("main")
    </main>

    <footer>
        <div class="footer-container">

          <div class="footer-column">
            <h4>About Us</h4>
            <p style="color: #aaa;">
              We build modern web apps, CMS, and SaaS solutions for agencies and entrepreneurs.
            </p>
          </div>

          <div class="footer-column">
            <h4>Contact Us</h4>
            <ul>
              <li>Email: <a href="mailto:support@adnan-tech.com">support@adnan-tech.com</a></li>
              <li>WhatsApp: +923105461304</li>
            </ul>
          </div>

          <div class="footer-column">
            <h4>Follow Us</h4>
            <ul>
              <li><a href="https://web.facebook.com/ComputerProgrammingTutorial" target="_blank">Facebook</a></li>
              <li><a href="https://youtube.com/c/AdnanAfzal565" target="_blank">YouTube</a></li>
            </ul>
          </div>

        </div>

        <div class="footer-bottom">
          &copy; {{ date('Y') }} {{ site_title() }}. All rights reserved.
        </div>
    </footer>

    <div id="chat-app"></div>
    <script type="text/babel" src="{{ asset('/components/Chat.js?v=' . time()) }}"></script>
    <link rel="stylesheet" href="{{ asset('/css/chat.css') }}" />

    <script>
        function do_logout() {
            localStorage.removeItem(accessTokenKey);
            return true;
        }
    </script>

    <style>
        footer {
          background-color: #000;
          color: #ccc;
          padding: 40px 20px;
        }

        .footer-container {
          max-width: 1200px;
          margin: auto;
          display: flex;
          flex-wrap: wrap;
          justify-content: space-between;
          gap: 30px;
        }

        .footer-column {
          flex: 1;
          min-width: 200px;
        }

        .footer-column h4 {
          color: #fff;
          margin-bottom: 15px;
        }

        .footer-column ul {
          list-style: none;
          padding: 0;
        }

        .footer-column ul li {
          margin: 8px 0;
        }

        .footer-column ul li a {
          color: #ccc;
          text-decoration: none;
        }

        .footer-column ul li a:hover {
          color: #fff;
        }

        .footer-bottom {
          text-align: center;
          color: #777;
          padding-top: 20px;
          border-top: 1px solid #222;
          font-size: 14px;
          margin-top: 20px;
        }

        @media (max-width: 768px) {
          .footer-container {
            flex-direction: column;
            align-items: center;
          }
        }
    </style>

</body>
</html>