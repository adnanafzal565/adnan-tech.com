@extends ("theme::layouts/app")
@section ("title", "Change Password")

@section ("main")

    <div class="container py-5">
        <div class="row">
            <div class="col-12 col-lg-4 mb-3">
                @include ("theme::layouts/profile-left-menu")
            </div>

            <div class="col-12 col-lg-8" id="change_password_app">
                <div class="spinner-border"></div>
            </div>
        </div>
    </div>

    <script type="text/babel">
        function ChangePasswordApp() {

            const [submitting, set_submitting] = React.useState(false);

            const [current_password, set_current_password] = React.useState("");
            const [new_password, set_new_password] = React.useState("");
            
            async function change_password(event) {
                event.preventDefault();

                try {
                    set_submitting(true);

                    const form_data = new FormData()

                    form_data.append("current_password", current_password);
                    form_data.append("new_password", new_password);

                    await ajax('/api/change_password', form_data, function (response) {
                        swal.fire("Change password", response.message, "success");
                    });
                } catch (exp) {
                    if (exp.response?.status === 401) {
                        window.location.href = baseUrl + "/login?redirect=" + window.location.href
                    } else {
                        swal.fire("Error", exp.message, "error")
                    }
                } finally {
                    set_submitting(false);
                }
            }

            return (
                <form onSubmit={change_password} encType="multipart/form-data">

                    <div className="form-group">
                        <label className="form-label">
                            Current Password
                        </label>

                        <input
                            type="password"
                            className="form-control"
                            required
                            value={current_password}
                            onChange={(event) => set_current_password(event.target.value)}
                        />
                    </div>

                    <div className="form-group mt-3">
                        <label className="form-label">
                            New Password
                        </label>

                        <input
                            type="password"
                            className="form-control"
                            required
                            value={new_password}
                            onChange={(event) => set_new_password(event.target.value)}
                        />
                    </div>

                    <input
                        type="submit"
                        className="btn btn-outline-primary btn-sm mt-3"
                        value="Save"
                        disabled={ submitting }
                    />

                </form>
            );
        }

        ReactDOM.createRoot(
            document.getElementById('change_password_app')
        ).render(<ChangePasswordApp />);
    </script>

@endsection