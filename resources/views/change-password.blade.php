@extends ("layouts/app")
@section ("title", "Profile")

@section ("main")

    <div class="container" style="margin-top: 30px; margin-bottom: 30px;">
        <div class="row">
            <div class="col-4">
                @include ("layouts/profile-left-menu")
            </div>

            <div class="col-8" id="change-password-app">
                <form onsubmit="changePassword(event);">
                    <div class="form-group">
                        <label class="form-label">Current password</label>
                        <input type="password" name="current_password" class="form-control" />
                    </div>

                    <div class="form-group mt-3 mb-3">
                        <label class="form-label">New password</label>
                        <input type="password" name="new_password" class="form-control" />
                    </div>

                    <input type="submit" name="submit" class="btn btn-outline-primary btn-sm"
                        value="Change" />
                </form>
            </div>
        </div>
    </div>

    <script>
        async function changePassword(event) {
            event.preventDefault()
            const form = event.currentTarget;

            try {
                form.submit.setAttribute("disabled", "disabled");

                const formData = new FormData(form)
                const response = await axios.post(
                    baseUrl + "/change-password",
                    formData
                )

                if (response.data.status == "success") {
                    swal.fire("Change password", response.data.message, "success")
                } else {
                    swal.fire("Error", response.data.message, "error")
                }
            } catch (exp) {
                swal.fire("Error", exp.message, "error")
            } finally {
                form.removeAttribute("disabled");
            }
        }
    </script>

@endsection