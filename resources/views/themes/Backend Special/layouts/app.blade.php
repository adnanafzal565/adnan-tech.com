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
    <script>
      // Minimal dropdown toggle — no Bootstrap. Works with the same
      // data-bs-toggle="dropdown" / dropdown-menu class names so the
      // existing HeaderUserViewApp React component works unmodified.
      /*document.addEventListener("click", function (event) {
        const toggle = event.target.closest('[data-bs-toggle="dropdown"]');
 
        document.querySelectorAll(".dropdown-menu.show").forEach(function (menu) {
          if (!toggle || menu !== toggle.nextElementSibling) {
            menu.classList.remove("show");
          }
        });
 
        if (toggle) {
          event.preventDefault();
          const menu = toggle.nextElementSibling;
          if (menu && menu.classList.contains("dropdown-menu")) {
            menu.classList.toggle("show");
          }
        }
      });*/
    </script>

    <input type="hidden" id="route_login" value="{{ route('login') }}" />
    <input type="hidden" id="route_register" value="{{ route('register') }}" />
    <input type="hidden" id="route_profile" value="{{ route('pages.show', ['slug' => 'profile']) }}" />
    <input type="hidden" id="route_admin_dashboard" value="{{ route('admin.dashboard') }}" />
    
    <script>
        const route_login = document.getElementById('route_login').value;
        const route_register = document.getElementById('route_register').value;
        const route_profile = document.getElementById('route_profile').value;
        const route_admin_dashboard = document.getElementById('route_admin_dashboard').value;
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
          <a href="{{ $menu_item->url ?? '' }}">{{ $menu_item->title ?? "" }}</a>|
        @endforeach

        <span class="dropdown" id="header_user_view_app"></span>
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

    <script src="{{ asset('/js/react.development.js') }}"></script>
    <script src="{{ asset('/js/react-dom.development.js') }}"></script>
    <script src="{{ asset('/js/babel.min.js') }}"></script>
    <script src="{{ asset('/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('/js/axios.min.js') }}"></script>
    <script src="{{ asset('/js/fontawesome.js') }}"></script>
    <script src="{{ asset('/js/script.js?v=' . time()) }}"></script>

    <script type="text/babel">
        function HeaderUserViewApp() {

            const [state, set_state] = React.useState(globalState.state);
            const [logging_out, set_logging_out] = React.useState(false);

            async function onInit() {
                if (!localStorage.getItem(accessTokenKey)) {
                    return;
                }

                await ajax('/api/me', null, function (response) {
                    window.user = response.user;
                    const unread_notifications = response.unread_notifications;

                    if (unread_notifications > 0 && document.getElementById("name-notifications-count")) {
                        document.getElementById("name-notifications-count").innerHTML = `(${unread_notifications})`;
                    }

                    // for non-React
                    if (typeof on_user_fetch !== "undefined") {
                        on_user_fetch();
                    }

                    // for React
                    globalState.setState({
                        user: response.user
                    });
                });
            }

            async function do_logout(event) {
                event.preventDefault();
                
                set_logging_out(true);
                await ajax('/api/logout', null);
                localStorage.removeItem(accessTokenKey);
                set_logging_out(false);
                window.location.href = baseUrl;
            }

            React.useEffect(() => {
                globalState.listen((new_state, updated_state) => {
                    set_state(new_state);
                });

                onInit();
            }, []);

            return (
                <>

                  { state.user ? (
                    <>
                      <a
                          className="nav-link"
                          href="#"
                          role="button"
                      >
                        { state.user?.name || "" }
                      </a>

                      |

                      { ["admin", "super_admin"].includes(state.user.type) && (
                        <>
                          <a href={ route_admin_dashboard }>
                              Admin Panel
                          </a>|&nbsp;
                        </>
                      ) }

                      <a href={ route_profile }>
                          Profile
                      </a>|&nbsp;

                      <a href="#"
                          onClick={ do_logout }
                      >
                          { logging_out ? 'Logging out...' : 'Logout' }
                      </a>
                    </>
                  ) : (
                    <>
                      <a href={ route_login }>Login</a>|&nbsp;

                      <a href={ route_register }>Sign Up</a>
                    </>
                  ) }

                  {/*
                    <a
                        className="nav-link dropdown-toggle"
                        href="#"
                        id="navbarDropdown"
                        role="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        {(state.user?.name || "") || "Account"}
                    </a>

                    <ul className="dropdown-menu" aria-labelledby="navbarDropdown">
                        { state.user ? (
                            <>
                                { ["admin", "super_admin"].includes(state.user.type) && (
                                    <li>
                                        <a className="dropdown-item"
                                            href={ route_admin_dashboard }>
                                            Admin Panel
                                        </a>
                                    </li>
                                ) }

                                <li>
                                    <a className="dropdown-item"
                                        href={ route_profile }>
                                        Profile
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                        className="dropdown-item"
                                        onClick={ do_logout }
                                    >
                                        { logging_out ? 'Logging out...' : 'Logout' }
                                    </a>
                                </li>
                            </>
                        ) : (
                            <>
                                <li>
                                    <a href={ route_login }
                                        className="dropdown-item">Login</a>
                                </li>

                                <li>
                                    <a href={ route_register }
                                        className="dropdown-item">Sign Up</a>
                                </li>
                            </>
                        ) }
                    </ul>
                  */}
                </>
            );
        }

        ReactDOM.createRoot(
            document.getElementById('header_user_view_app')
        ).render(<HeaderUserViewApp />);
    </script>
  </body>
</html>