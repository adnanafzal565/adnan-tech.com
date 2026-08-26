function WebhookSecret ({
    webhook_secret_generated_at = null,
}) {
    const [is_loading, set_is_loading] = React.useState(false);
    const [is_delete_loading, set_is_delete_loading] = React.useState(false);
    const [secret, set_secret] = React.useState(null);
    const [show_dialog, set_show_dialog] = React.useState(false);
    const [error_message, set_error_message] = React.useState("");
    const [is_copied, set_is_copied] = React.useState(false);

    const generate_secret = async () => {
        set_is_loading(true);
        set_error_message("");

        try {
            await ajax("/api/webhooks/generate", null, (response) => {
                set_secret(response.secret);
                set_show_dialog(true);
            });
        } catch (error) {
            set_error_message(error.message);
        } finally {
            set_is_loading(false);
        }
    };

    const delete_secret = () => {

        swal.fire({
          title: "Delete Webhook Secret?",
          text: "Are you sure you want to delete your webhook secret?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "var(--color-primary)",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!"
        }).then(async (result) => {
            if (result.isConfirmed) {
                set_is_delete_loading(true);
                set_error_message("");

                try {
                    await ajax("/api/webhooks/delete", null, (response) => {
                        window.location.reload();
                    });
                } catch (error) {
                    set_error_message(error.message);
                } finally {
                    set_is_delete_loading(false);
                }
            }
        });

    };

    const style = {
        secret_box: {
            backgroundColor: "#f8f9fa",
            border: "1px solid #dee2e6",
            borderRadius: "6px",
            padding: "12px",
            wordBreak: "break-all",
            fontFamily: "monospace",
        },
        warning: {
            fontSize: "14px",
            color: "#856404",
            backgroundColor: "#fff3cd",
            border: "1px solid #ffeeba",
            borderRadius: "6px",
            padding: "12px",
        },
    };

    return (
        <>
            <div className="card">
                <div className="card-body">
                    <h5 className="card-title mb-2">Webhook Secret</h5>

                    <p className="text-muted mb-3">
                        Your webhook secret is used to verify webhook requests.
                    </p>

                    {error_message && (
                        <div className="alert alert-danger">
                            {error_message}
                        </div>
                    )}

                    {webhook_secret_generated_at ? (
                        <button
                            type="button"
                            className="btn btn-danger"
                            onClick={delete_secret}
                            disabled={is_delete_loading}
                        >
                            {is_delete_loading ? (
                                <>
                                    <span
                                        className="spinner-border spinner-border-sm me-2"
                                        role="status"
                                    />
                                    Deleting...
                                </>
                            ) : (
                                "Delete Webhook Secret"
                            )}
                        </button>
                    ) : (
                        <button
                            type="button"
                            className="btn btn-primary"
                            onClick={generate_secret}
                            disabled={is_loading}
                        >
                            {is_loading ? (
                                <>
                                    <span
                                        className="spinner-border spinner-border-sm me-2"
                                        role="status"
                                    />
                                    Generating...
                                </>
                            ) : (
                                "Generate Webhook Secret"
                            )}
                        </button>
                    )}
                </div>
            </div>

            {show_dialog && secret && (
                <div
                    className="modal fade show d-block"
                    tabIndex="-1"
                    role="dialog"
                    style={{ backgroundColor: "rgba(0, 0, 0, 0.5)" }}
                >
                    <div className="modal-dialog modal-dialog-centered modal-lg">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title">
                                    Webhook Secret Generated
                                </h5>

                                <button
                                    type="button"
                                    className="btn-close"
                                    onClick={() => set_show_dialog(false)}
                                />
                            </div>

                            <div className="modal-body">
                                <div style={style.warning} className="mb-3">
                                    <strong>Important:</strong> You will not be able
                                    to see this secret again. Copy and store it
                                    somewhere secure (e.g., in your .env file) before closing this dialog.
                                </div>

                                <label className="form-label fw-semibold">
                                    Your Webhook Secret
                                </label>

                                <div style={style.secret_box}>
                                    {secret}
                                </div>

                                <button
                                    type="button"
                                    className="btn btn-outline-primary mt-3"
                                    onClick={() => {
                                        navigator.clipboard.writeText(secret);
                                        set_is_copied(true);
                                    } }
                                >
                                    {is_copied ? "Copied ✓" : "Copy Secret"}
                                </button>
                            </div>

                            <div className="modal-footer">
                                <button
                                    type="button"
                                    className="btn btn-secondary"
                                    onClick={() => set_show_dialog(false)}
                                >
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
}