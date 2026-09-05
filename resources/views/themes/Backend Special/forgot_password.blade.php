@extends ("theme::layouts/app")
@section ("title", "Forgot Password")

@section ("main")

    <div class="container">
        <h2>Forget password</h2>
     
        <form onsubmit="sendResetLink()">
          <div class="form-group">
            <label>Enter email</label>
            <input type="email" name="email" required>
          </div>
     
          <button type="submit" name="submit">Send reset link</button>
        </form>
    </div>


    <script>
        async function sendResetLink() {
            event.preventDefault()
            const form = event.target

            try {
                const formData = new FormData(form)
                form.submit.setAttribute("disabled", "disabled")

                const response = await axios.post(
                    baseUrl + "/api/send_password_reset_link",
                    formData
                )

                if (response.data.status == "success") {
                    swal.fire("Reset password", response.data.message, "success")
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