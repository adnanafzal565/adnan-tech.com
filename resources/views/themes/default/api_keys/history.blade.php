@extends ("theme::layouts/app")
@section ("title", "API Keys")

@section ("main")

    <input type="hidden" id="id" value="{{ $id }}" />

    <div id="api_key_history_app"></div>

    <script type="text/babel">

        const id = parseInt(document.getElementById("id").value);

        function ApiKeyHistoryApp() {
            const [submitting, set_submitting] = React.useState(false);
            const [loading, set_loading] = React.useState(true);
            const [api_key, set_api_key] = React.useState(null);
            const [history, set_history] = React.useState([]);

            const [pagination, setPagination] = React.useState({
                current_page: 1,
                last_page: 1,
                total: 0,
            });

            async function fetch_history(page = 1) {

                set_loading(true);

                const form_data = new FormData();
                form_data.append("id", id);
                form_data.append("page", page);

                await ajax("/api/api_keys/history", form_data, function (response) {
                    set_api_key(response.api_key);
                    set_history(response.history.data);

                    setPagination({
                        current_page: response.history.current_page,
                        last_page: response.history.last_page,
                        total: response.history.total,
                    });
                });

                set_loading(false);
            }

            React.useEffect(() => {
                fetch_history();
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
            };

            return (
                <div className="container">

                    <div className="row justify-content-center mt-4">
                        <div className="col-12">

                            <div className="card shadow-sm border-0 mb-5">

                                <div className="card-header bg-white py-3 d-flex justify-content-between align-items-center">

                                    <h4 className="mb-0">
                                        API Key '{ api_key?.name }' history
                                    </h4>

                                </div>

                                <div className="card-body">

                                    {
                                        loading && (
                                            <div className="text-center py-5">
                                                <div className="spinner-border text-dark" role="status"></div>
                                                <p className="mt-3 mb-0 text-muted">
                                                    Loading history...
                                                </p>
                                            </div>
                                        )
                                    }

                                    {
                                        !loading && history.length === 0 && (
                                            <div className="text-center py-5">
                                                <h5 className="mb-2">
                                                    Un-used.
                                                </h5>

                                                <p className="text-muted mb-0">
                                                    This API key hasn't used since created.
                                                </p>
                                            </div>
                                        )
                                    }

                                    {
                                        !loading && history.length > 0 && (

                                            <div className="table-responsive">

                                                <table
                                                    className="table table-hover align-middle mb-0"
                                                    style={styles.table}
                                                >

                                                    <thead className="table-light">

                                                        <tr>
                                                            <th>
                                                                Title
                                                            </th>

                                                            <th>
                                                                Content
                                                            </th>

                                                            <th>
                                                                Device
                                                            </th>

                                                            <th>
                                                                IP
                                                            </th>

                                                            <th>
                                                                Remaining Requests
                                                            </th>

                                                            <th>
                                                                Used At
                                                            </th>
                                                        </tr>

                                                    </thead>


                                                    <tbody>

                                                        {
                                                            history.map(function (h, index) {

                                                                return (

                                                                    <tr key={index}>

                                                                        <td>
                                                                            { h.title }
                                                                        </td>

                                                                        <td>
                                                                            <span className="ellipsis">{ h.content }</span>
                                                                        </td>

                                                                        <td>
                                                                            {
                                                                                Object.entries(h.device || {})
                                                                                    .filter(([key, value]) => value !== false && value !== null && value !== "")
                                                                                    .map(([key, value]) => (
                                                                                        <div key={key}>
                                                                                            <strong>{key.replaceAll("_", " ")}:</strong> {String(value)}
                                                                                        </div>
                                                                                    ))
                                                                            }
                                                                        </td>

                                                                        <td>
                                                                            { h.ip }
                                                                        </td>


                                                                        <td>
                                                                            {h.remaining.toLocaleString()}
                                                                        </td>


                                                                        <td>
                                                                            { (new Date(h.created_at).toLocaleString()) }
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

                                        Total: {pagination.total}

                                    </div>

                                    <nav>

                                        <ul className="pagination mb-0">

                                            <li className={`page-item ${pagination.current_page === 1 ? "disabled" : ""}`}>

                                                <button
                                                    className="page-link"
                                                    onClick={() => fetch_history(pagination.current_page - 1)}>

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
                                                                onClick={() => fetch_history(page)}>

                                                                {page}

                                                            </button>

                                                        </li>

                                                    );

                                                })

                                            }

                                            <li className={`page-item ${pagination.current_page === pagination.last_page ? "disabled" : ""}`}>

                                                <button
                                                    className="page-link"
                                                    onClick={() => fetch_history(pagination.current_page + 1)}>

                                                    Next

                                                </button>

                                            </li>

                                        </ul>

                                    </nav>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            );
        }

        ReactDOM.createRoot(
            document.getElementById("api_key_history_app")
        ).render(<ApiKeyHistoryApp />)
    </script>

@endsection