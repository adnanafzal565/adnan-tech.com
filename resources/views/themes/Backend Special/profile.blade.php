@extends ("theme::layouts/app")
@section ("title", "Profile")

@section ("main")

    <div class="container">
        <table>
          <tr>
            <td style="width: 200px; vertical-align: top;">
              @include ("theme::layouts/profile_left_menu")
            </td>
            <td style="vertical-align: top;" id="profile_app">
              <p>Loading...</p>
            </td>
          </tr>
        </table>
    </div>

    <script type="text/babel">
        function ProfileApp() {

            const [state, set_state] = React.useState(globalState.state);
            const [submitting, set_submitting] = React.useState(false);
            const [profile_image, set_profile_image] = React.useState(null);
            const [profile_image_preview, set_profile_image_preview] = React.useState(
                state.user?.profile_image_absolute
                    ? state.user.profile_image_absolute
                    : `${baseUrl}/img/user-placeholder.png`
            );

            const [name, set_name] = React.useState(state.user?.name || "");

            const on_change_profile_image = (event) => {

                const file = event.target.files[0];

                if (!file) {
                    return;
                }

                set_profile_image(file);
                set_profile_image_preview(URL.createObjectURL(file));
            };

            async function save_profile(event) {
                event.preventDefault();

                try {
                    set_submitting(true);

                    const form_data = new FormData()

                    form_data.append("name", name);

                    if (profile_image) {
                        form_data.append("profile_image", profile_image);
                    }

                    await ajax('/api/profile', form_data, function (response) {
                        swal.fire("Profile", response.message, "success");
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

            React.useEffect(() => {
                globalState.listen((new_state, updated_state) => {
                    set_state(new_state);

                    if (new_state.user) {
                        set_name(new_state.user.name);
                        set_profile_image_preview(new_state.user.profile_image_absolute
                            ? new_state.user.profile_image_absolute
                            : `${baseUrl}/img/user-placeholder.png`);
                    }
                });
            }, []);

            const styles = {
                image: {
                    width: "100px",
                    height: "100px",
                    objectFit: "cover",
                    borderRadius: "50%",
                    marginBottom: "20px",
                    position: "relative",
                    left: "50%",
                    transform: "translateX(-50%)"
                }
            };

            return (
                <form onSubmit={save_profile} encType="multipart/form-data">

                    <div className="row mb-5">
                        <div className="offset-4 col-3">

                            <img
                                style={ styles.image }
                                src={profile_image_preview}
                                onError={(event) => {
                                    event.target.src = `${baseUrl}/img/user-placeholder.png`;
                                }}
                                alt="Profile"
                            />

                            <input
                                type="file"
                                accept="image/*"
                                onChange={on_change_profile_image}
                            />

                        </div>
                    </div>

                    <div className="form-group">
                        <label className="form-label">
                            Name
                        </label>

                        <input
                            type="text"
                            className="form-control"
                            required
                            value={name}
                            onChange={(event) => set_name(event.target.value)}
                        />
                    </div>

                    <div className="form-group mt-3 mb-3">
                        <label className="form-label">
                            Username
                        </label>

                        <input
                            type="text"
                            className="form-control"
                            value={state.user?.username || ""}
                            disabled
                        />
                    </div>

                    <div className="form-group mt-3 mb-3">
                        <label className="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            className="form-control"
                            value={state.user?.email || ""}
                            disabled
                        />
                    </div>

                    <input
                        type="submit"
                        className="btn btn-outline-primary btn-sm"
                        value="Save"
                        disabled={ submitting }
                    />

                </form>
            );
        }

        ReactDOM.createRoot(
            document.getElementById('profile_app')
        ).render(<ProfileApp />);
    </script>

@endsection