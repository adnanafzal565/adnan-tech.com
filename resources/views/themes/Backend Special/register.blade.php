@extends ("theme::layouts/app")
@section ("title", "Register")

@section ("main")

    <div class="container">
        <h2>Register</h2>
     
        <form onsubmit="doRegister()"
            style="width: 500px;">
          <input type="hidden" name="token" value="{{ $token }}">
     
          <div style="position: absolute; left: -10000px; width: 1px; height: 1px; overflow: hidden;">
            <label for="website">Website</label>
            <textarea name="website" rows="1"
                tabindex="-1"
                style="resize: none;
                    min-height: fit-content;
                    font-family: sans-serif;
                    font-size: 14px;"
                oninput="this.value = this.value.replace(/\n/g, '')"></textarea>
          </div>
     
          <div class="form-group">
            <label>Enter Name</label>
            <input type="text" name="name" required>
          </div>
     
          <div class="form-group">
            <label>Enter Email</label>
            <input type="email" name="email" required>
          </div>
     
          <div class="form-group">
            <label>Enter Password</label>
            <input type="password" name="password" id="password" required>
            <label style="margin-top: 10px;">
              <input type="checkbox" id="togglePassword">
              Show Password
            </label>
          </div>
     
          <button type="submit" name="submit">Register</button>
        </form>
    </div>

    <script>
        async function doRegister() {
            event.preventDefault()
            const form = event.target

            try {
                const formData = new FormData(form)
                form.submit.setAttribute("disabled", "disabled")

                await ajax('/api/register', formData, function (response) {
                    const verification = response.verification;
                    swal.fire("Register", response.message, "success")
                        .then(function () {
                            if (verification) {
                                window.location.href = baseUrl + "/email_verification/" + form.email.value;
                            } else {
                                window.location.href = baseUrl + "/login";
                            }
                        });
                });
            } catch (exp) {
                swal.fire("Error", exp.message, "error")
            } finally {
                form.submit.removeAttribute("disabled")
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.getElementById("password");
            const toggleCheckbox = document.getElementById("togglePassword");

            toggleCheckbox.addEventListener("change", function () {
                if (this.checked) {
                    passwordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                }
            });
        });
    </script>

@endsection