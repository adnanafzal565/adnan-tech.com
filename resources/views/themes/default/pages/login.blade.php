@extends ("theme::layouts/app")
@section ("title", $page->title)
@section ("meta_keywords", $page->keywords)
@section ("meta_description", $page->excerpt)

@section ("main")

    <div class="container mt-4 mb-4">
        <div class="row">
            <div class="offset-4 col-4">
                <h2>Login</h2>

                <form onsubmit="doLogin()">
                    <div class="form-group mt-4">
                        <label class="form-label">Enter username/email</label>
                        <input type="text" name="username" class="form-control" required />
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Enter password</label>
                        <input type="password" name="password" class="form-control" required />
                    </div>

                    <input type="submit" name="submit" class="btn btn-outline-primary btn-sm mt-3" value="Login" />
                </form>

                <p class="mt-4">
                    <a href="{{ route(\App\Helpers\Constants::PASSWORD_REQUEST) }}">Forgot password ?</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        async function doLogin() {
            event.preventDefault()
            const form = event.target

            try {
                const formData = new FormData(form)
                form.submit.setAttribute("disabled", "disabled")

                const response = await axios.post(
                    baseUrl + "/login",
                    formData
                )

                if (response.data.status == "success") {
                    const accessToken = response.data.access_token
                    localStorage.setItem(accessTokenKey, accessToken)

                    const urlSearchParams = new URLSearchParams(window.location.search)
                    const redirect = urlSearchParams.get("redirect") || ""
                    if (redirect == "") {
                        window.location.href = baseUrl
                    } else {
                        window.location.href = redirect
                    }
                } else {
                    swal.fire("Error", response.data.message, "error")
                }
            } catch (exp) {
                swal.fire("Error", exp.message, "error")
            } finally {
                form.submit.removeAttribute("disabled")
            }
        }
    </script>

@endsection