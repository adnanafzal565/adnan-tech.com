@extends ("theme::layouts/app")
@section ("title", "Login")

@section ("main")

    <div class="container">
        <h2>Login</h2>
     
        <form onsubmit="doLogin()">
          <div class="form-group">
            <label>Enter Email</label>
            <input type="email" name="email" required>
          </div>
     
          <div class="form-group">
            <label>Enter Password</label>
            <input type="password" name="password" required>
          </div>
     
          <button type="submit" name="submit">Login</button>
        </form>
     
        <p>
          Don't have an account?
          <a href="{{ route('register') }}">Register</a>
        </p>
     
        <p>
          <a href="{{ route('password.request') }}">Forgot Password?</a>
        </p>
    </div>

    <script>
        async function doLogin() {
            event.preventDefault()
            const form = event.target

            try {
                const formData = new FormData(form)
                form.submit.setAttribute("disabled", "disabled")

                await ajax('/api/login', formData, function (response) {
                    const accessToken = response.access_token
                    localStorage.setItem(accessTokenKey, accessToken)

                    const urlSearchParams = new URLSearchParams(window.location.search)
                    const redirect = urlSearchParams.get("redirect") || ""
                    if (redirect == "") {
                        window.location.href = baseUrl
                    } else {
                        window.location.href = redirect
                    }
                });
            } catch (exp) {
                swal.fire("Error", exp.message, "error")
            } finally {
                form.submit.removeAttribute("disabled")
            }
        }
    </script>

@endsection