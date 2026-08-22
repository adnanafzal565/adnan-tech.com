@extends ("theme::layouts/app")
@section ("title", "Email Verification")

@section ("main")

    <div class="container py-5">
        <div class="row">
            <div class="offset-lg-4 col-12 col-lg-4">
                <h2>Email Verification</h2>

                <form onsubmit="verifyEmail()">

                    <input type="hidden" name="email" value="{{ $email }}" />

                    <div class="form-group mt-3">
                        <label class="form-label">Enter Code</label>
                        <input type="text" name="code" class="form-control" required />
                    </div>

                    <input type="submit" name="submit" class="btn btn-outline-primary btn-sm mt-3" value="Verify" />
                </form>
            </div>
        </div>
    </div>

    <script>
        async function verifyEmail() {
            event.preventDefault()
            const form = event.target

            try {
                const formData = new FormData(form)
                form.submit.setAttribute("disabled", "disabled")

                await ajax('/api/verify_email', formData, function (response) {
                    swal.fire("Verify Email", response.message, "success")
                        .then(function () {
                            const urlSearchParams = new URLSearchParams(window.location.search)
                            const redirect = urlSearchParams.get("redirect") || ""

                            if (redirect == "") {
                                window.location.href = baseUrl + '/login';
                            } else {
                                window.location.href = redirect
                            }
                        });
                });
            } catch (exp) {
                swal.fire("Error", exp.message, "error")
            } finally {
                form.submit.removeAttribute("disabled")
            }
        }
    </script>

@endsection