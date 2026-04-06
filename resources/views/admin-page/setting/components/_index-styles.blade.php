<style>
    /* ── Page Title ── */
    .page-title {
        font-size: 1.65rem; font-weight: 600; text-align: center;
        color: #00a79d; margin: .75rem 0 1.5rem; position: relative; display: inline-block;
    }
    .page-title::after {
        content: ''; display: block; height: 4px; width: 120px;
        margin: .35rem auto 0; border-radius: 3px;
        background: linear-gradient(90deg, #00a79d 0%, #008b84 100%);
    }
    /* ── Section Title ── */
    .section-title {
        font-size: 1.05rem; font-weight: 600; color: #00a79d;
        padding-bottom: 0.5rem; border-bottom: 2px solid #e0f7f5;
    }
    /* ── Button ── */
    .btn-custom-primary {
        color: #fff; background-color: #00a79d; border: 1px solid #00a79d; transition: all 0.3s ease;
    }
    .btn-custom-primary:hover  { background-color: #008b84; border-color: #008b84; color: #fff; }
    .btn-custom-primary:disabled { opacity: 0.7; cursor: not-allowed; }
    /* ── Card ── */
    .card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    /* ── Input Focus ── */
    .form-control:focus {
        border-color: #00a79d; box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25);
    }
    /* ── Saved Badge ── */
    .setting-saved-badge {
        display: none; align-items: center; gap: 0.3rem;
        font-size: 0.78rem; font-weight: 600; color: #059669; white-space: nowrap;
    }
    /* ── Setting Row ── */
    .setting-row {
        display: grid;
        grid-template-columns: minmax(160px, 200px) 1fr 1fr auto auto;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem 0;
        border-bottom: 1px solid #f1f3f5;
    }
    .setting-row:last-child  { border-bottom: none; padding-bottom: 0; }
    .setting-row:first-child { padding-top: 0; }
    @media (max-width: 767.98px) {
        .setting-row {
            grid-template-columns: 1fr 1fr;
            grid-template-areas: "label label" "v1 v2" "btn saved";
        }
        .setting-row .setting-label        { grid-area: label; }
        .setting-row .inp-value1           { grid-area: v1; }
        .setting-row .inp-value2           { grid-area: v2; }
        .setting-row .btn-save-row         { grid-area: btn; }
        .setting-row .setting-saved-badge  { grid-area: saved; justify-self: start; }
    }
    @media (max-width: 575.98px) {
        .setting-row {
            grid-template-columns: 1fr;
            grid-template-areas: "label" "v1" "v2" "btn" "saved";
        }
        .setting-row .btn-save-row         { width: 100%; justify-content: center; }
        .setting-row .setting-saved-badge  { justify-self: center; }
    }
    /* ── Dark Mode ── */
    html.dark-mode .card {
        background: #2b2f33 !important; border-color: #373b3e !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
    }
    html.dark-mode .section-title { color: #00a79d; border-bottom-color: #373b3e; }
    html.dark-mode .form-control {
        background-color: #1a1d21; border-color: #373b3e; color: #e4e6eb;
    }
    html.dark-mode .form-control:focus {
        background-color: #1a1d21; border-color: #00a79d; color: #e4e6eb;
        box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25);
    }
    html.dark-mode .form-control::placeholder { color: #6c757d; }
    html.dark-mode .form-label  { color: #e4e6eb; }
    html.dark-mode .setting-row { border-color: #373b3e; }
    html.dark-mode .bg-light    { background-color: #23272b !important; }
</style>
