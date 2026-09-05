@extends ("theme::layouts/app")
@section ("title", "Reset Password")

@section ("main")

    <div class="container">
        <h2>Reset password</h2>
     
        <form onsubmit="resetPassword()">
          <input type="hidden" name="email" value="{{ $email }}" />
          <input type="hidden" name="token" value="{{ $token }}" />
     
          <div class="form-group">
            <label>Enter password</label>
            <input type="password" name="password" required>
          </div>
     
          <div class="form-group">
            <label>Confirm password</label>
            <input type="password" name="password_confirmation" required>
          </div>
     
          <button type="submit" name="submit">Set Password</button>
        </form>
    </div>

    <script>
        async function resetPassword() {
            event.preventDefault()
            const form = event.target

            try {
                const formData = new FormData(form)
                form.submit.setAttribute("disabled", "disabled")

                const response = await axios.post(
                    baseUrl + "/api/reset_password",
                    formData
                )

                if (response.data.status == "success") {
                    swal.fire("Reset Password", response.data.message, "success")
                        .then(function () {
                            window.location.href = baseUrl + "/login"
                        })
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