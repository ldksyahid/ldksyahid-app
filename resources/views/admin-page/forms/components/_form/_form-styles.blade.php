<style>
/* ===== PAGE TITLE ===== */
.page-title {
    font-size: 1.65rem;
    font-weight: 600;
    text-align: center;
    color: #00a79d;
    margin: .75rem 0 1.5rem;
    position: relative;
    display: inline-block;
}
.page-title .highlighted-text { color: #008b84; font-weight: 700; }
.page-title small { font-size: .75rem; color: #6c757d; font-weight: 400; }
.page-title::after {
    content: '';
    display: block;
    height: 4px;
    width: 120px;
    margin: .35rem auto 0;
    border-radius: 3px;
    background: linear-gradient(90deg, #00a79d 0%, #008b84 100%);
}

/* ===== SECTION TITLE (create / edit) ===== */
.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #00a79d;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e0f7f5;
    margin-bottom: 1.25rem;
}

/* ===== BUTTONS ===== */
.btn-custom-primary {
    color: #fff;
    background-color: #00a79d;
    border: 1px solid #00a79d;
    transition: all 0.3s ease;
}
.btn-custom-primary:hover {
    background-color: #008b84;
    border-color: #008b84;
    color: #fff;
}
.btn-custom-primary:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
}

/* ===== FORM CONTROLS (create / edit) ===== */
.card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}
.form-control:focus, .form-select:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
}
.form-text { font-size: 0.8rem; color: #6c757d; }
.invalid-feedback { font-size: 0.85rem; }

/* ===== VIEW MODE — detail cards ===== */
.detail-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    padding: 1.5rem;
    margin-bottom: 1.25rem;
}
.detail-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 2px solid #f3f4f6;
    padding-bottom: .85rem;
    margin-bottom: 1.25rem;
}
.detail-card-header h5 { font-weight: 700; margin: 0; }
.stat-box {
    text-align: center;
    padding: 1.25rem;
    background: #f9fafb;
    border-radius: 10px;
}
.stat-box .stat-num { font-size: 2rem; font-weight: 800; color: #00a79d; }
.stat-box .stat-lbl { font-size: .75rem; color: #6b7280; text-transform: uppercase; letter-spacing: .05em; }
.status-badge-lg { font-size: .9rem; padding: .45rem 1rem; border-radius: 50px; }
.field-pill {
    display: inline-flex; align-items: center; gap: .35rem;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 20px; padding: .25rem .75rem;
    font-size: .8rem; color: #166534; margin: .2rem;
}
.field-pill.system { background: #fef3c7; border-color: #fde68a; color: #92400e; }
.gdrive-link {
    display: flex; align-items: center; gap: .75rem;
    padding: .75rem 1rem; background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 8px; text-decoration: none; color: #166534;
    transition: all .2s; margin-bottom: .5rem;
}
.gdrive-link:hover { background: #dcfce7; color: #166534; text-decoration: none; }
.gdrive-link .gdrive-icon { font-size: 1.2rem; flex-shrink: 0; }
.gdrive-link .gdrive-text { flex: 1; }
.gdrive-link .gdrive-text strong { display: block; font-size: .875rem; font-weight: 600; }
.gdrive-link .gdrive-text small { font-size: .75rem; color: #6b7280; }
.gdrive-link .gdrive-ext { font-size: .7rem; opacity: .5; flex-shrink: 0; }
.copy-url-btn {
    background: none; border: 1px solid #d1d5db; border-radius: 6px;
    padding: .15rem .5rem; font-size: .75rem; color: #6b7280;
    cursor: pointer; transition: all .15s; line-height: 1.4;
    vertical-align: middle;
}
.copy-url-btn:hover { background: #00a79d; border-color: #00a79d; color: #fff; }

/* ===== DARK MODE ===== */
html.dark-mode .detail-card { background: #1a1d23; box-shadow: 0 2px 12px rgba(0,0,0,.25); }
html.dark-mode .detail-card-header { border-bottom-color: #2d3139; }
html.dark-mode .detail-card-header h5 { color: #e4e6eb; }
html.dark-mode .stat-box { background: #22252d; }
html.dark-mode .stat-box .stat-num { color: #2dd4bf; }
html.dark-mode .stat-box .stat-lbl { color: #9ca3af; }
html.dark-mode .field-pill { background: #1a2d1e; border-color: #2d4a30; color: #86efac; }
html.dark-mode .field-pill.system { background: #2d2510; border-color: #4a3a1a; color: #fbbf24; }
html.dark-mode .gdrive-link { background: #1a2d1e; border-color: #2d4a30; color: #86efac; }
html.dark-mode .gdrive-link:hover { background: #1f3524; color: #86efac; }
html.dark-mode .gdrive-link .gdrive-text small { color: #9ca3af; }
html.dark-mode .table-borderless td,
html.dark-mode .table-borderless th { color: #c8cdd3; }
html.dark-mode .copy-url-btn { border-color: #374151; color: #9ca3af; }
html.dark-mode .copy-url-btn:hover { background: #00a79d; border-color: #00a79d; color: #fff; }

@media (max-width: 768px) {
    .page-title { font-size: 1.35rem; }
    .card-body { padding: 1rem; }
    .section-title { font-size: 1rem; }
    .d-flex.justify-content-end.gap-2 { flex-direction: column; }
    .d-flex.justify-content-end.gap-2 .btn { width: 100%; }
}
</style>
