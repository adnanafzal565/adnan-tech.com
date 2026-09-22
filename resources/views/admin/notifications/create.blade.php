@extends ("admin/layouts/app")
@section ("title", "Send Notification")

@section ("main")

  <div class="pagetitle">
    <h1>Send Notification</h1>
    
    <nav class="mt-3">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.notifications.index') }}">Notifications</a></li>
        <li class="breadcrumb-item active">Send</li>
      </ol>
    </nav>
  </div>

  <div id="send_notification_app"></div>

  <script type="text/babel">
    function SendNotification() {

        const [user_search, set_user_search] = React.useState("");
        const [users, set_users] = React.useState([]);
        const [selected_user, set_selected_user] = React.useState(null);

        const [notification, set_notification] = React.useState({
            title: "",
            content: "",
            type: "new_message",
            table_id: "",
            is_read: false
        });

        const [custom_type, set_custom_type] = React.useState("");
        const [saving, set_saving] = React.useState(false);

        const search_timer = React.useRef(null);

        const style = {
            userResults: {
                position: "absolute",
                zIndex: 1000,
                width: "100%"
            }
        };

        React.useEffect(() => {

            clearTimeout(search_timer.current);

            if (user_search.trim().length < 2 || selected_user) {
                set_users([]);
                return;
            }

            search_timer.current = setTimeout(() => {
                search_users();
            }, 500);

            return () => {
                clearTimeout(search_timer.current);
            };

        }, [user_search]);

        const search_users = async () => {

            try {

                const response = await axios.get(
                    baseUrl + "/admin/users/search",
                    {
                        params: {
                            search: user_search
                        },
                        headers: {
                            Authorization:
                                "Bearer " +
                                localStorage.getItem(accessTokenKey)
                        }
                    }
                );

                if (response.data.status === "success") {
                    set_users(response.data.users);
                } else {
                    set_users([]);
                }

            } catch (error) {
                set_users([]);
            }
        };

        const select_user = (user_item) => {

            set_selected_user(user_item);
            set_user_search(user_item.name);
            set_users([]);
        };

        const remove_selected_user = () => {

            set_selected_user(null);
            set_user_search("");
        };

        const handle_change = (event) => {

            const { name, value, type, checked } = event.target;

            set_notification((previous) => ({
                ...previous,
                [name]: type === "checkbox" ? checked : value
            }));
        };

        const create_notification = async (event) => {

            event.preventDefault();

            if (!selected_user) {

                swal.fire(
                    "Error",
                    "Please select a user.",
                    "error"
                );

                return;
            }

            set_saving(true);

            try {

                const form_data = new FormData();

                form_data.append(
                    "user_id",
                    selected_user.id
                );

                form_data.append(
                    "title",
                    notification.title
                );

                form_data.append(
                    "content",
                    notification.content
                );

                form_data.append(
                    "type",
                    custom_type.trim() || notification.type
                );

                form_data.append(
                    "table_id",
                    notification.table_id
                );

                form_data.append(
                    "is_read",
                    notification.is_read ? 1 : 0
                );

                const response = await axios.post(
                    baseUrl + "/admin/notifications/create",
                    form_data,
                    {
                        headers: {
                            Authorization:
                                "Bearer " +
                                localStorage.getItem(accessTokenKey)
                        }
                    }
                );

                if (response.data.status === "success") {

                    swal.fire(
                        "Success",
                        response.data.message,
                        "success"
                    );

                    set_notification({
                        title: "",
                        content: "",
                        type: "new_message",
                        table_id: "",
                        is_read: false
                    });

                    set_custom_type("");
                    set_user_search("");
                    set_selected_user(null);

                } else {

                    swal.fire(
                        "Error",
                        response.data.message,
                        "error"
                    );
                }

            } catch (error) {

                swal.fire(
                    "Error",
                    error?.response?.data?.message ||
                    "Something went wrong.",
                    "error"
                );

            } finally {
                set_saving(false);
            }
        };

        return (
            <section className="section">
              <div className="row">
                <div className="col-12">
                  <div className="card">
                    <div className="card-body">
                      <form onSubmit={create_notification}>

                        <div className="row mt-3 mb-3">
                            <label className="col-sm-2 col-form-label">
                                User
                            </label>

                            <div className="col-sm-10 position-relative">

                                <input
                                    type="text"
                                    className="form-control"
                                    value={user_search}
                                    onChange={(event) => {
                                        set_user_search(event.target.value);
                                        set_selected_user(null);
                                    }}
                                    placeholder="Enter user name or email"
                                    autoComplete="off"
                                    required
                                />

                                {users.length > 0 && (
                                    <div
                                        className="list-group"
                                        style={style.userResults}
                                    >

                                        {users.map((user_item) => (
                                            <button
                                                type="button"
                                                className="list-group-item list-group-item-action"
                                                key={user_item.id}
                                                onClick={() => select_user(user_item)}
                                            >

                                                <span>
                                                    {user_item.name}
                                                </span>

                                                <small className="text-muted ms-2">
                                                    {user_item.email}
                                                </small>

                                            </button>
                                        ))}

                                    </div>
                                )}

                                {selected_user && (
                                    <div className="mt-2">

                                        <span className="badge bg-primary">
                                            {selected_user.name}
                                            {" - "}
                                            {selected_user.email}
                                        </span>

                                        <button
                                            type="button"
                                            className="btn btn-sm btn-danger ms-2"
                                            onClick={remove_selected_user}
                                        >
                                            Remove
                                        </button>

                                    </div>
                                )}

                            </div>
                        </div>


                        <div className="row mb-3">
                            <label className="col-sm-2 col-form-label">
                                Title
                            </label>

                            <div className="col-sm-10">

                                <input
                                    type="text"
                                    className="form-control"
                                    name="title"
                                    value={notification.title}
                                    onChange={handle_change}
                                    required
                                />

                            </div>
                        </div>


                        <div className="row mb-3">
                            <label className="col-sm-2 col-form-label">
                                Content
                            </label>

                            <div className="col-sm-10">

                                <textarea
                                    className="form-control"
                                    name="content"
                                    rows="5"
                                    value={notification.content}
                                    onChange={handle_change}
                                    required
                                />

                            </div>
                        </div>


                        <div className="row mb-3">
                            <label className="col-sm-2 col-form-label">
                                Type
                            </label>

                            <div className="col-sm-10">

                                <select
                                    className="form-control"
                                    name="type"
                                    value={notification.type}
                                    onChange={handle_change}
                                >
                                    <option value="new_message">
                                        new_message
                                    </option>
                                </select>

                            </div>
                        </div>


                        <div className="row mb-3">
                            <label className="col-sm-2 col-form-label">
                                Custom Type
                            </label>

                            <div className="col-sm-10">

                                <input
                                    type="text"
                                    className="form-control"
                                    value={custom_type}
                                    onChange={(event) =>
                                        set_custom_type(event.target.value)
                                    }
                                    placeholder="Optional custom type"
                                />

                            </div>
                        </div>


                        <div className="row mb-3">
                            <label className="col-sm-2 col-form-label">
                                Table
                            </label>

                            <div className="col-sm-10">

                                <select
                                    className="form-control"
                                    name="table_id"
                                    value={notification.table_id}
                                    onChange={handle_change}
                                >
                                    <option value="">
                                        Select table
                                    </option>
                                </select>

                            </div>
                        </div>


                        <div className="row mb-3">
                            <label className="col-sm-2 col-form-label">
                                Read
                            </label>

                            <div className="col-sm-10">

                                <div className="form-check">

                                    <input
                                        type="checkbox"
                                        className="form-check-input"
                                        id="is_read"
                                        name="is_read"
                                        checked={notification.is_read}
                                        onChange={handle_change}
                                    />

                                    <label
                                        className="form-check-label"
                                        htmlFor="is_read"
                                    >
                                        Mark as read
                                    </label>

                                </div>

                            </div>
                        </div>


                        <div className="row">
                            <div className="col-sm-10 offset-sm-2">

                                <button
                                    type="submit"
                                    className="btn btn-primary"
                                    disabled={saving}
                                >
                                    {saving ? "Saving..." : "Save Notification"}
                                </button>

                            </div>
                        </div>

                    </form>
                    </div>
                  </div>
                </div>
              </div>
            </section>
        );
    }

    ReactDOM.createRoot(
      document.getElementById("send_notification_app")
    ).render(<SendNotification />);
  </script>

@endsection