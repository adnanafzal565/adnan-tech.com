@extends ("theme::layouts/app")
@section ("title", "API Keys")

@section ("main")

    <div class="container py-5">
        <div id="api_keys_app">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="spinner-border"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/babel">

        function ApiKeysApp() {
            const [submitting, set_submitting] = React.useState(false);
            const [loading, set_loading] = React.useState(true);
            const [api_keys, set_api_keys] = React.useState([]);
            const [copied_key, set_copied_key] = React.useState(null);

            const [pagination, setPagination] = React.useState({
                current_page: 1,
                last_page: 1,
                total: 0,
            });

            async function fetch_api_keys(page = 1) {

                set_loading(true);

                const form_data = new FormData();
                form_data.append("page", page);

                await ajax("/api/api_keys", form_data, function (response) {
                    set_api_keys(response.data.data);

                    setPagination({
                        current_page: response.data.current_page,
                        last_page: response.data.last_page,
                        total: response.data.total,
                    });
                });

                set_loading(false);
            }

            async function create_api_key(event) {

                event.preventDefault();

                const form = event.target;
                const form_data = new FormData(form);

                set_submitting(true);

                await ajax("/api/api_keys/store", form_data, function (response) {
                    swal.fire('API Key', response.message, 'success');

                    const data = response.data;

                    const temp = [ ...api_keys ];

                    temp.unshift(data);

                    set_api_keys(temp);
                });

                set_submitting(false);
            }

            function copy_api_key(api_key) {

                navigator.clipboard.writeText(api_key)
                    .then(function () {
                        // alert("API key copied.");

                        set_copied_key(api_key);

                        setTimeout(function () {
                            // set_copied_key(null);
                        }, 2000);
                    })
                    .catch(function () {
                        alert("Failed to copy API key.");
                    });

            }

            async function toggle_api_key_status(api_key_id) {

                const temp = api_keys.map(function (api_key) {

                    if (api_key.id === api_key_id) {
                        return {
                            ...api_key,
                            status_loading: true,
                        };
                    }

                    return api_key;
                });

                set_api_keys(temp);


                try {

                    const form_data = new FormData();

                    form_data.append("id", api_key_id);

                    const response = await ajaxPromise(
                        "/api/api_keys/toggle_status",
                        form_data
                    );


                    if (response.status === "success") {

                        set_api_keys(function (previous) {

                            return previous.map(function (api_key) {

                                if (api_key.id === api_key_id) {
                                    return {
                                        ...api_key,
                                        status: response.key_status,
                                        status_loading: false,
                                    };
                                }

                                return api_key;

                            });

                        });

                    }

                } catch (error) {

                    set_api_keys(function (previous) {

                        return previous.map(function (api_key) {

                            if (api_key.id === api_key_id) {
                                return {
                                    ...api_key,
                                    status_loading: false,
                                };
                            }

                            return api_key;

                        });

                    });

                }

            }

            React.useEffect(() => {
                fetch_api_keys();
            }, []);

            const styles = {
                table: {
                    tableLayout: "fixed",
                    width: "100%",
                },

                key_column: {
                    width: "35%",
                },

                key: {
                    display: "block",
                    overflow: "hidden",
                    textOverflow: "ellipsis",
                    whiteSpace: "nowrap",
                    fontFamily: "monospace",
                    maxWidth: "100%",
                },

                copy_button: {
                    width: "36px",
                    height: "36px",
                    padding: "0",
                    fontSize: "22px",
                    lineHeight: "1",
                    display: "flex",
                    alignItems: "center",
                    justifyContent: "center",
                    cursor: "pointer",
                },
            };

            return (
                <>

                    <div className="row justify-content-center mt-5">
                        <div className="col-lg-6 col-md-8 col-12">

                            <div className="card shadow-sm border-0">

                                <div className="card-header bg-white py-3">
                                    <h4 className="mb-0">
                                        Create API Key
                                    </h4>
                                </div>

                                <div className="card-body">

                                    <p className="text-muted mb-4">
                                        Generate a secure API key to access the API.
                                    </p>

                                    <form onSubmit={create_api_key}>

                                        <div className="mb-3">
                                            <label className="form-label">
                                                API Key Name
                                            </label>

                                            <input
                                                type="text"
                                                name="name"
                                                className="form-control"
                                                placeholder="e.g. Production Server"
                                                maxLength="100"
                                                required
                                            />
                                        </div>

                                        <div className="d-grid">
                                            <button
                                                type="submit"
                                                className="btn btn-dark"
                                                disabled={submitting}
                                            >
                                                {
                                                    submitting
                                                        ? "Creating..."
                                                        : "Create API Key"
                                                }
                                            </button>
                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>

                    <div className="row justify-content-center mt-4">
                        <div className="col-12">

                            <div className="card shadow-sm border-0 mb-5">

                                <div className="card-header bg-white py-3 d-flex justify-content-between align-items-center">

                                    <h4 className="mb-0">
                                        My API Keys
                                    </h4>

                                    <span className="badge bg-secondary">
                                        {pagination.total} {pagination.total === 1 ? "Key" : "Keys"}
                                    </span>

                                </div>

                                <div className="card-body">

                                    {
                                        loading && (
                                            <div className="text-center py-5">
                                                <div className="spinner-border text-dark" role="status"></div>
                                                <p className="mt-3 mb-0 text-muted">
                                                    Loading API keys...
                                                </p>
                                            </div>
                                        )
                                    }

                                    {
                                        !loading && api_keys.length === 0 && (
                                            <div className="text-center py-5">
                                                <h5 className="mb-2">
                                                    No API Key Found
                                                </h5>

                                                <p className="text-muted mb-0">
                                                    Create your first API key using the form above.
                                                </p>
                                            </div>
                                        )
                                    }

                                    {
                                        !loading && api_keys.length > 0 && (

                                            <div className="table-responsive">

                                                <table
                                                    className="table table-hover align-middle mb-0"
                                                    style={styles.table}
                                                >

                                                    <thead className="table-light">

                                                        <tr>
                                                            <th>
                                                                Name
                                                            </th>

                                                            <th style={styles.key_column}>
                                                                API Key
                                                            </th>

                                                            <th>
                                                                Status
                                                            </th>

                                                            <th>
                                                                Remaining Requests
                                                            </th>

                                                            <th>
                                                                Last Used
                                                            </th>

                                                            <th>
                                                                Actions
                                                            </th>
                                                        </tr>

                                                    </thead>


                                                    <tbody>

                                                        {
                                                            api_keys.map(function (api_key, index) {

                                                                return (

                                                                    <tr key={index}>

                                                                        <td>
                                                                            { api_key.name }
                                                                        </td>

                                                                        <td style={styles.key_column}>

                                                                            <div className="d-flex align-items-center gap-2">

                                                                                <code
                                                                                    style={styles.key}
                                                                                    title={api_key.key}
                                                                                >
                                                                                    {api_key.key}
                                                                                </code>


                                                                                <button
                                                                                    type="button"
                                                                                    className="btn btn-sm btn-light flex-shrink-0"
                                                                                    title="Copy API key"
                                                                                    onClick={() => copy_api_key(api_key.key)}
                                                                                    style={styles.copy_button}
                                                                                >

                                                                                    {
                                                                                        copied_key === api_key.key
                                                                                            ? "✓"
                                                                                            : "⧉"
                                                                                    }

                                                                                </button>

                                                                            </div>

                                                                        </td>


                                                                        <td>

                                                                            <button
                                                                                type="button"
                                                                                className={
                                                                                    api_key.status
                                                                                        ? "btn btn-sm btn-success"
                                                                                        : "btn btn-sm btn-secondary"
                                                                                }
                                                                                disabled={api_key.status_loading}
                                                                                onClick={() => toggle_api_key_status(api_key.id)}
                                                                            >
                                                                                {
                                                                                    api_key.status
                                                                                        ? "Active"
                                                                                        : "Disabled"
                                                                                }
                                                                            </button>

                                                                        </td>


                                                                        <td>
                                                                            {api_key.remaining.toLocaleString()}
                                                                        </td>


                                                                        <td>
                                                                            {api_key.last_used_at ? (new Date(api_key.last_used_at).toLocaleString()) : "Never"}
                                                                        </td>

                                                                        <td>
                                                                            { api_key.last_used_at && (
                                                                                <a className="btn btn-dark btn-sm"
                                                                                    href={ `${ baseUrl }/api_keys/${ api_key.id }/history` }>History</a>
                                                                            ) }
                                                                        </td>

                                                                    </tr>

                                                                );

                                                            })
                                                        }

                                                    </tbody>

                                                </table>

                                            </div>

                                        )
                                    }

                                </div>

                                <div className="card-footer bg-white d-flex justify-content-between align-items-center">

                                    <div>

                                        {/*
                                        Total: {pagination.total}
                                        */}

                                    </div>

                                    <nav>

                                        <ul className="pagination mb-0">

                                            <li className={`page-item ${pagination.current_page === 1 ? "disabled" : ""}`}>

                                                <button
                                                    className="page-link"
                                                    onClick={() => fetch_api_keys(pagination.current_page - 1)}>

                                                    Previous

                                                </button>

                                            </li>

                                            {

                                                [...Array(pagination.last_page)].map((_, index) => {

                                                    const page = index + 1;

                                                    return (

                                                        <li
                                                            key={page}
                                                            className={`page-item ${page === pagination.current_page ? "active" : ""}`}>

                                                            <button
                                                                className="page-link"
                                                                onClick={() => fetch_api_keys(page)}>

                                                                {page}

                                                            </button>

                                                        </li>

                                                    );

                                                })

                                            }

                                            <li className={`page-item ${pagination.current_page === pagination.last_page ? "disabled" : ""}`}>

                                                <button
                                                    className="page-link"
                                                    onClick={() => fetch_api_keys(pagination.current_page + 1)}>

                                                    Next

                                                </button>

                                            </li>

                                        </ul>

                                    </nav>

                                </div>

                            </div>

                        </div>
                    </div>

                </>
            );
        }

        ReactDOM.createRoot(
            document.getElementById("api_keys_app")
        ).render(<ApiKeysApp />)
    </script>

@endsection