/* public/js/tools/project-management.jsx
 * One React app, two modes (set by window.PM_CONFIG.mode):
 *   "admin"  - full CRUD + comments + share links (super admin only, enforced by the server)
 *   "shared" - read-only view of one project's tasks and comments (client link)
 */
const { useState, useEffect, useMemo } = React;

const CFG = window.PM_CONFIG;
const IS_ADMIN = CFG.mode === 'admin';

const STATUSES = {
  pending: { label: 'Pending', badge: 'bg-secondary' },
  in_progress: { label: 'In Progress', badge: 'bg-primary' },
  done: { label: 'Done', badge: 'bg-success' },
};

/* ------------------------------ helpers ------------------------------ */

function todayStr() {
  const d = new Date();
  return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
}

function fmtDate(v) {
  if (!v) return '—';
  const d = new Date(String(v).slice(0, 10) + 'T00:00:00');
  return isNaN(d) ? '—' : d.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' });
}

// Timestamps are stored in UTC ("YYYY-MM-DD HH:MM:SS"); show them in the viewer's timezone
function fmtDateTime(v) {
  if (!v) return '';
  const d = new Date(String(v).replace(' ', 'T') + 'Z');
  return isNaN(d) ? String(v) : d.toLocaleString();
}

function fmtMoney(price, currency) {
  if (price === null || price === undefined || price === '') return '—';
  try {
    return new Intl.NumberFormat(undefined, { style: 'currency', currency: currency }).format(Number(price));
  } catch (e) {
    return currency + ' ' + price;
  }
}

async function request(method, url, body) {
  const headers = { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
  if (IS_ADMIN) headers['X-CSRF-TOKEN'] = CFG.csrf;
  if (body !== undefined) headers['Content-Type'] = 'application/json';

  const res = await fetch(url, {
    method: method,
    headers: headers,
    credentials: 'same-origin',
    body: body !== undefined ? JSON.stringify(body) : undefined,
  });

  let json = null;
  try { json = await res.json(); } catch (e) { /* not JSON */ }

  if (!json) throw new Error('Unexpected server response (' + res.status + ').');
  if (!res.ok || json.status !== 'success') throw new Error(json.message || 'Request failed.');

  return json;
}

const api = (method, path, body) => request(method, CFG.apiBase + path, body);

/* ---------------------------- small pieces ---------------------------- */

function StatusBadge({ status }) {
  const s = STATUSES[status] || STATUSES.pending;
  return <span className={'badge ' + s.badge}>{s.label}</span>;
}

function Modal({ title, onClose, footer, children, closeOnBackdrop = true }) {
  useEffect(() => {
    const onKey = (e) => { if (e.key === 'Escape') onClose(); };
    document.addEventListener('keydown', onKey);
    document.body.classList.add('modal-open');
    return () => {
      document.removeEventListener('keydown', onKey);
      document.body.classList.remove('modal-open');
    };
  }, []);

  return (
    <>
      <div className="modal-backdrop fade show"></div>
      <div
        className="modal fade show d-block"
        tabIndex="-1"
        role="dialog"
        onMouseDown={(e) => { if (closeOnBackdrop && e.target === e.currentTarget) onClose(); }}
      >
        <div className="modal-dialog modal-lg modal-dialog-scrollable">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title">{title}</h5>
              <button type="button" className="btn-close" aria-label="Close" onClick={onClose}></button>
            </div>
            <div className="modal-body">{children}</div>
            {footer && <div className="modal-footer">{footer}</div>}
          </div>
        </div>
      </div>
    </>
  );
}

/* ------------------------------ task form ------------------------------ */

function TaskForm({ task, clients, projects, onSaved, onCancel }) {
  const editing = !!task;

  const [f, setF] = useState(() => ({
    title: task ? task.title : '',
    description: task && task.description ? task.description : '',
    client_id: task ? String(task.client_id) : '',
    new_client_name: '',
    client_email: task && task.client_email ? task.client_email : '',
    project_id: task ? String(task.project_id) : '',
    new_project_name: '',
    status: task ? task.status : 'pending',
    start_date: task && task.start_date ? String(task.start_date).slice(0, 10) : '',
    end_date: task && task.end_date ? String(task.end_date).slice(0, 10) : '',
    deadline: task && task.deadline ? String(task.deadline).slice(0, 10) : '',
    price: task && task.price !== null ? task.price : '',
    currency: task ? task.currency : CFG.currencies[0],
  }));
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState('');

  const set = (key) => (e) => {
    const value = e.target.value;
    setF((prev) => ({ ...prev, [key]: value }));
  };

  const emailOf = (clientId) => {
    const c = clients.find((x) => String(x.id) === String(clientId));
    return c && c.email ? c.email : '';
  };

  // Picking an existing client loads that client's saved email
  const onClientSelect = (e) => {
    const id = e.target.value;
    setF((prev) => ({ ...prev, client_id: id, client_email: emailOf(id) }));
  };

  // Typing a new client name clears the email field (it would belong to the previously
  // selected client); clearing the name again restores the selected client's email.
  const onNewClientName = (e) => {
    const value = e.target.value;

    setF((prev) => {
      const had = prev.new_client_name.trim() !== '';
      const has = value.trim() !== '';
      let email = prev.client_email;

      if (!had && has) email = '';
      if (had && !has) email = emailOf(prev.client_id);

      return { ...prev, new_client_name: value, client_email: email };
    });
  };

  const hasNewClient = f.new_client_name.trim() !== '';
  const hasNewProject = f.new_project_name.trim() !== '';

  const submit = async (e) => {
    e.preventDefault();
    setSaving(true);
    setError('');

    try {
      const json = editing
        ? await api('PUT', '/tasks/' + task.id, f)
        : await api('POST', '/tasks', f);
      onSaved(json.data, json);
    } catch (err) {
      setError(err.message);
      setSaving(false);
    }
  };

  return (
    <Modal
      title={editing ? 'Edit Task' : 'New Task'}
      onClose={onCancel}
      closeOnBackdrop={false}
      footer={
        <>
          <button type="button" className="btn btn-outline-secondary" onClick={onCancel} disabled={saving}>Cancel</button>
          <button type="submit" form="pm-task-form" className="btn btn-primary" disabled={saving}>
            {saving ? 'Saving…' : 'Save Task'}
          </button>
        </>
      }
    >
      <form id="pm-task-form" onSubmit={submit}>
        {error && <div className="alert alert-danger">{error}</div>}

        <div className="row g-3">
          <div className="col-12">
            <label className="form-label">Title</label>
            <input type="text" className="form-control" value={f.title} onChange={set('title')} required />
          </div>

          <div className="col-12">
            <label className="form-label">Description</label>
            <textarea className="form-control" rows="3" value={f.description} onChange={set('description')}></textarea>
          </div>

          <div className="col-md-6">
            <label className="form-label">Client</label>
            <select className="form-select" value={f.client_id} onChange={onClientSelect} disabled={hasNewClient}>
              <option value="">Select client…</option>
              {clients.map((c) => <option key={c.id} value={c.id}>{c.name}</option>)}
            </select>
            <input
              type="text"
              className="form-control mt-2"
              placeholder="Or add a new client (name)"
              value={f.new_client_name}
              onChange={onNewClientName}
            />
            <input
              type="email"
              className="form-control mt-2"
              placeholder="Client email address"
              value={f.client_email}
              onChange={set('client_email')}
            />
            <div className="form-text">
              Saved on the client (all of their tasks). They are emailed whenever you post a comment on a task.
            </div>
          </div>

          <div className="col-md-6">
            <label className="form-label">Project</label>
            <select className="form-select" value={f.project_id} onChange={set('project_id')} disabled={hasNewProject}>
              <option value="">Select project…</option>
              {projects.map((p) => <option key={p.id} value={p.id}>{p.name}</option>)}
            </select>
            <input
              type="text"
              className="form-control mt-2"
              placeholder="Or add a new project (name)"
              value={f.new_project_name}
              onChange={set('new_project_name')}
            />
          </div>

          <div className="col-md-4">
            <label className="form-label">Status</label>
            <select className="form-select" value={f.status} onChange={set('status')}>
              {Object.keys(STATUSES).map((k) => <option key={k} value={k}>{STATUSES[k].label}</option>)}
            </select>
          </div>

          <div className="col-md-5">
            <label className="form-label">Price</label>
            <input type="number" step="0.01" min="0" className="form-control" value={f.price} onChange={set('price')} />
          </div>

          <div className="col-md-3">
            <label className="form-label">Currency</label>
            <select className="form-select" value={f.currency} onChange={set('currency')}>
              {CFG.currencies.map((c) => <option key={c} value={c}>{c}</option>)}
            </select>
          </div>

          <div className="col-md-4">
            <label className="form-label">Start date</label>
            <input type="date" className="form-control" value={f.start_date} onChange={set('start_date')} />
          </div>

          <div className="col-md-4">
            <label className="form-label">End date</label>
            <input type="date" className="form-control" value={f.end_date} onChange={set('end_date')} />
          </div>

          <div className="col-md-4">
            <label className="form-label">Deadline</label>
            <input type="date" className="form-control" value={f.deadline} onChange={set('deadline')} />
          </div>
        </div>
      </form>
    </Modal>
  );
}

/* ------------------------------ task view ------------------------------ */

function TaskView({ task, onClose, onEdit, onDelete, onData }) {
  // Shared mode: comments come embedded in the task. Admin mode: fetched on open.
  const [comments, setComments] = useState(task.comments || null);
  const [body, setBody] = useState('');
  const [posting, setPosting] = useState(false);
  const [error, setError] = useState('');
  const [notice, setNotice] = useState(null); // { type: 'success' | 'info' | 'warning', text }

  useEffect(() => {
    if (!IS_ADMIN) return;

    api('GET', '/tasks/' + task.id + '/comments')
      .then((json) => setComments(json.comments))
      .catch((e) => setError(e.message));
  }, [task.id]);

  const postComment = async (e) => {
    e.preventDefault();
    if (body.trim() === '') return;

    setPosting(true);
    setError('');
    setNotice(null);

    try {
      const json = await api('POST', '/tasks/' + task.id + '/comments', { body: body });
      setComments(json.comments);
      onData(json.data);
      setBody('');

      if (json.email_status === 'sent') {
        setNotice({ type: 'success', text: 'Comment posted and emailed to ' + json.email_to + '.' });
      } else if (json.email_status === 'no_email') {
        setNotice({ type: 'info', text: 'Comment posted. No email was sent because this client has no email address.' });
      } else {
        setNotice({ type: 'warning', text: 'Comment posted, but the email to ' + json.email_to + ' could not be sent. Check your mail settings.' });
      }
    } catch (err) {
      setError(err.message);
    } finally {
      setPosting(false);
    }
  };

  return (
    <Modal
      title={task.title}
      onClose={onClose}
      footer={
        <>
          {IS_ADMIN && <button type="button" className="btn btn-outline-danger me-auto" onClick={() => onDelete(task)}>Delete</button>}
          {IS_ADMIN && <button type="button" className="btn btn-outline-primary" onClick={() => onEdit(task)}>Edit</button>}
          <button type="button" className="btn btn-secondary" onClick={onClose}>Close</button>
        </>
      }
    >
      <dl className="row mb-4">
        <dt className="col-sm-3">Status</dt>
        <dd className="col-sm-9"><StatusBadge status={task.status} /></dd>

        <dt className="col-sm-3">Client</dt>
        <dd className="col-sm-9">{task.client_name}</dd>

        {IS_ADMIN && (
          <>
            <dt className="col-sm-3">Client email</dt>
            <dd className="col-sm-9">{task.client_email || '—'}</dd>

            <dt className="col-sm-3">Project</dt>
            <dd className="col-sm-9">{task.project_name}</dd>
          </>
        )}

        <dt className="col-sm-3">Start date</dt>
        <dd className="col-sm-9">{fmtDate(task.start_date)}</dd>

        <dt className="col-sm-3">End date</dt>
        <dd className="col-sm-9">{fmtDate(task.end_date)}</dd>

        <dt className="col-sm-3">Deadline</dt>
        <dd className="col-sm-9">{fmtDate(task.deadline)}</dd>

        {task.price !== null && task.price !== undefined && (
          <>
            <dt className="col-sm-3">Price</dt>
            <dd className="col-sm-9">{fmtMoney(task.price, task.currency)}</dd>
          </>
        )}

        <dt className="col-sm-3">Description</dt>
        <dd className="col-sm-9" style={{ whiteSpace: 'pre-wrap' }}>{HTMLReactParser(task.description || '—')}</dd>
      </dl>

      <h6 className="border-top pt-3">Progress updates</h6>

      {IS_ADMIN && (
        <form onSubmit={postComment} className="mb-3">
          <textarea
            className="form-control mb-2"
            rows="2"
            placeholder="Write a progress update…"
            value={body}
            onChange={(e) => setBody(e.target.value)}
          ></textarea>

          <div className="d-flex align-items-center gap-3">
            <button type="submit" className="btn btn-sm btn-primary" disabled={posting || body.trim() === ''}>
              {posting ? 'Posting…' : 'Post comment'}
            </button>

            <span className="small text-muted">
              {task.client_email
                ? 'The client will be emailed at ' + task.client_email + '.'
                : 'No client email on file, so no email will be sent. Add one by editing the task.'}
            </span>
          </div>
        </form>
      )}

      {notice && <div className={'alert alert-' + notice.type}>{notice.text}</div>}
      {error && <div className="alert alert-danger">{error}</div>}

      {comments === null && !error && <p className="text-muted">Loading…</p>}
      {comments !== null && comments.length === 0 && <p className="text-muted">No updates yet.</p>}

      {(comments || []).map((c) => (
        <div key={c.id} className="border rounded p-2 mb-2">
          <div className="small text-muted mb-1">
            <strong>{c.author_name || 'Admin'}</strong> · {fmtDateTime(c.created_at)}
          </div>
          <div style={{ whiteSpace: 'pre-wrap' }}>{HTMLReactParser(c.body || "")}</div>
        </div>
      ))}
    </Modal>
  );
}

/* ----------------------------- share manager ----------------------------- */

function ShareManager({ projects, tasks, onData }) {
  const [open, setOpen] = useState(false);
  const [busy, setBusy] = useState(null);
  const [copied, setCopied] = useState(null);
  const [error, setError] = useState('');

  const run = async (project, method) => {
    if (method === 'DELETE' && !window.confirm('Revoke this link? Anyone who has it will lose access.')) return;

    setBusy(project.id);
    setError('');

    try {
      const json = await api(method, '/projects/' + project.id + '/share');
      onData(json.data);
    } catch (e) {
      setError(e.message);
    } finally {
      setBusy(null);
    }
  };

  const copy = async (project) => {
    try {
      await navigator.clipboard.writeText(project.share_url);
      setCopied(project.id);
      setTimeout(() => setCopied(null), 1500);
    } catch (e) {
      window.prompt('Copy this link:', project.share_url);
    }
  };

  if (projects.length === 0) return null;

  return (
    <div className="card mb-4">
      <div className="card-header d-flex justify-content-between align-items-center">
        <span>Share a project with a client</span>
        <button type="button" className="btn btn-sm btn-outline-secondary" onClick={() => setOpen(!open)}>
          {open ? 'Hide' : 'Show'}
        </button>
      </div>

      {open && (
        <div className="card-body">
          <p className="text-muted small">
            Anyone with a project's link can view that project's tasks and progress updates (read-only).
            Revoke the link to stop access.
          </p>

          {error && <div className="alert alert-danger">{error}</div>}

          {projects.map((p) => (
            <div key={p.id} className="row g-2 align-items-center mb-2">
              <div className="col-md-3">
                <strong>{p.name}</strong>
                <span className="text-muted small"> ({tasks.filter((t) => t.project_id === p.id).length} tasks)</span>
              </div>

              {p.share_url ? (
                <>
                  <div className="col-md-6">
                    <input type="text" className="form-control form-control-sm" value={p.share_url} readOnly onFocus={(e) => e.target.select()} />
                  </div>
                  <div className="col-md-3 d-flex gap-2">
                    <button type="button" className="btn btn-sm btn-outline-primary" onClick={() => copy(p)}>
                      {copied === p.id ? 'Copied!' : 'Copy'}
                    </button>
                    <button type="button" className="btn btn-sm btn-outline-danger" disabled={busy === p.id} onClick={() => run(p, 'DELETE')}>
                      Revoke
                    </button>
                  </div>
                </>
              ) : (
                <div className="col-md-9">
                  <button type="button" className="btn btn-sm btn-outline-primary" disabled={busy === p.id} onClick={() => run(p, 'POST')}>
                    {busy === p.id ? 'Creating…' : 'Create share link'}
                  </button>
                </div>
              )}
            </div>
          ))}
        </div>
      )}
    </div>
  );
}

/* ---------------------------------- app ---------------------------------- */

function ProjectManagement() {
  const [data, setData] = useState({ clients: [], projects: [], tasks: [] });
  const [sharedProject, setSharedProject] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [modal, setModal] = useState(null); // { type: 'form' | 'view', id: taskId | null }
  const [filters, setFilters] = useState({ q: '', status: '', project_id: '', client_id: '' });

  const [notice, setNotice] = useState(null);

  const onTaskSaved = (newData, json) => {
    setData(newData);
    setModal(null);

    if (json.status_email === 'sent') {
      setNotice({ type: 'success', text: 'Task saved. The client was emailed about the status change (' + json.status_email_to + ').' });
    } else if (json.status_email === 'no_email') {
      setNotice({ type: 'info', text: 'Task saved. The status changed, but no email was sent because this client has no email address.' });
    } else if (json.status_email === 'failed') {
      setNotice({ type: 'warning', text: 'Task saved, but the status-change email to ' + json.status_email_to + ' could not be sent. Check your mail settings.' });
    } else {
      setNotice(null);
    }
  };

  useEffect(() => {
    (async () => {
      try {
        if (IS_ADMIN) {
          const json = await api('GET', '/data');
          setData(json.data);
        } else {
          const json = await request('GET', CFG.dataUrl);
          setSharedProject(json.project);
          setData({ clients: [], projects: [], tasks: json.tasks });
        }
      } catch (e) {
        setError(e.message);
      } finally {
        setLoading(false);
      }
    })();
  }, []);

  const today = todayStr();

  const tasks = useMemo(() => {
    const q = filters.q.trim().toLowerCase();

    return data.tasks.filter((t) => {
      if (filters.status && t.status !== filters.status) return false;
      if (filters.project_id && String(t.project_id) !== filters.project_id) return false;
      if (filters.client_id && String(t.client_id) !== filters.client_id) return false;
      if (q && !(t.title.toLowerCase().includes(q) || (t.description || '').toLowerCase().includes(q))) return false;
      return true;
    });
  }, [data.tasks, filters]);

  const setFilter = (key) => (e) => {
    const value = e.target.value;
    setFilters((prev) => ({ ...prev, [key]: value }));
  };

  const remove = async (task) => {
    if (!window.confirm('Delete "' + task.title + '"? Its comments will be deleted too.')) return;

    try {
      const json = await api('DELETE', '/tasks/' + task.id);
      setData(json.data);
      setModal(null);
    } catch (e) {
      setError(e.message);
    }
  };

  const activeTask = modal && modal.id ? data.tasks.find((t) => t.id === modal.id) : null;

  if (loading) return <p className="text-muted">Loading…</p>;

  return (
    <div>
      {!IS_ADMIN && sharedProject && (
        <div className="mb-4">
          <h2 className="mb-1">{sharedProject.name}</h2>
          <p className="text-muted mb-0">Task progress for this project (read-only).</p>
        </div>
      )}

      {error && <div className="alert alert-danger">{error}</div>}

      {notice && (
        <div className={'alert alert-dismissible alert-' + notice.type}>
          {notice.text}
          <button type="button" className="btn-close" aria-label="Close" onClick={() => setNotice(null)}></button>
        </div>
      )}

      {IS_ADMIN && <ShareManager projects={data.projects} tasks={data.tasks} onData={setData} />}

      <div className="row g-2 align-items-end mb-3">
        <div className="col-md-3">
          <input type="search" className="form-control" placeholder="Search tasks…" value={filters.q} onChange={setFilter('q')} />
        </div>

        <div className="col-md-2">
          <select className="form-select" value={filters.status} onChange={setFilter('status')}>
            <option value="">All statuses</option>
            {Object.keys(STATUSES).map((k) => <option key={k} value={k}>{STATUSES[k].label}</option>)}
          </select>
        </div>

        {IS_ADMIN && (
          <>
            <div className="col-md-2">
              <select className="form-select" value={filters.project_id} onChange={setFilter('project_id')}>
                <option value="">All projects</option>
                {data.projects.map((p) => <option key={p.id} value={p.id}>{p.name}</option>)}
              </select>
            </div>

            <div className="col-md-2">
              <select className="form-select" value={filters.client_id} onChange={setFilter('client_id')}>
                <option value="">All clients</option>
                {data.clients.map((c) => <option key={c.id} value={c.id}>{c.name}</option>)}
              </select>
            </div>

            <div className="col-md-3 text-md-end">
              <button type="button" className="btn btn-primary" onClick={() => setModal({ type: 'form', id: null })}>
                + New Task
              </button>
            </div>
          </>
        )}
      </div>

      <div className="table-responsive">
        <table className="table table-hover align-middle">
          <thead>
            <tr>
              <th>Task</th>
              <th>Client</th>
              {IS_ADMIN && <th>Project</th>}
              <th>Status</th>
              <th>Start</th>
              <th>End</th>
              <th>Deadline</th>
              <th>Price</th>
              <th className="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            {tasks.length === 0 && (
              <tr>
                <td colSpan={IS_ADMIN ? 9 : 8} className="text-center text-muted py-4">
                  {data.tasks.length === 0 ? 'No tasks yet.' : 'No tasks match your filters.'}
                </td>
              </tr>
            )}

            {tasks.map((t) => {
              const overdue = t.deadline && t.status !== 'done' && String(t.deadline).slice(0, 10) < today;

              return (
                <tr key={t.id}>
                  <td>
                    <a href="#" onClick={(e) => { e.preventDefault(); setModal({ type: 'view', id: t.id }); }}>{t.title}</a>
                    {IS_ADMIN && t.comments_count > 0 && <span className="badge bg-light text-dark ms-2">{t.comments_count} 💬</span>}
                    {!IS_ADMIN && t.comments && t.comments.length > 0 && <span className="badge bg-light text-dark ms-2">{t.comments.length} 💬</span>}
                  </td>
                  <td>{t.client_name}</td>
                  {IS_ADMIN && <td>{t.project_name}</td>}
                  <td><StatusBadge status={t.status} /></td>
                  <td>{fmtDate(t.start_date)}</td>
                  <td>{fmtDate(t.end_date)}</td>
                  <td className={overdue ? 'text-danger fw-semibold' : ''}>{fmtDate(t.deadline)}</td>
                  <td>{fmtMoney(t.price, t.currency)}</td>
                  <td className="text-end text-nowrap">
                    <button type="button" className="btn btn-sm btn-outline-secondary me-1" onClick={() => setModal({ type: 'view', id: t.id })}>View</button>
                    {IS_ADMIN && (
                      <>
                        <button type="button" className="btn btn-sm btn-outline-primary me-1" onClick={() => setModal({ type: 'form', id: t.id })}>Edit</button>
                        <button type="button" className="btn btn-sm btn-outline-danger" onClick={() => remove(t)}>Delete</button>
                      </>
                    )}
                  </td>
                </tr>
              );
            })}
          </tbody>
        </table>
      </div>

      {modal && modal.type === 'form' && (
        <TaskForm
          task={activeTask}
          clients={data.clients}
          projects={data.projects}
          onCancel={() => setModal(null)}
          onSaved={onTaskSaved}
        />
      )}

      {modal && modal.type === 'view' && activeTask && (
        <TaskView
          task={activeTask}
          onClose={() => setModal(null)}
          onEdit={(t) => setModal({ type: 'form', id: t.id })}
          onDelete={remove}
          onData={setData}
        />
      )}
    </div>
  );
}