@verbatim
<style>
/* ================================================================
   FORM LANDING PAGE  —  prefix: gf-
   Primary: #00a79d  (follows global --primary)
   Style reference: Google Forms aesthetic, custom teal theme
   ================================================================ */

:root {
    --gf-primary:        #00a79d;
    --gf-primary-dark:   #008f86;
    --gf-primary-light:  #e0f7f5;
    --gf-danger:         #d93025;
    --gf-border:         #e0e0e0;
    --gf-bg:             #f0f4f8;
    --gf-card-bg:        #ffffff;
    --gf-text:           #202124;
    --gf-text-muted:     #5f6368;
    --gf-radius:         8px;
    --gf-shadow:         0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.04);
    --gf-transition:     all .18s ease;
}

/* ─── Page ─────────────────────────────────────────────────────── */
.gf-page {
    min-height: 100vh;
    padding: 5rem 0 4rem;
    position: relative;
    z-index: 2;
}

.gf-wrap {
    max-width: 640px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* ─── Header Card ──────────────────────────────────────────────── */
.gf-header-card {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    box-shadow: var(--gf-shadow);
    border: 1px solid var(--gf-border);
    border-top: 8px solid var(--gf-primary);
    padding: 24px;
    margin-bottom: 12px;
}

.gf-form-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--gf-text);
    margin: 0 0 .5rem;
    line-height: 1.3;
}

.gf-form-desc {
    font-size: .9375rem;
    color: var(--gf-text-muted);
    line-height: 1.7;
    margin: 0;
    white-space: pre-line;
}

/* ─── Error Card ───────────────────────────────────────────────── */
.gf-error-card {
    background: #fff;
    border: 1px solid #fca5a5;
    border-left: 4px solid var(--gf-danger);
    border-radius: var(--gf-radius);
    padding: 16px 20px;
    margin-bottom: 12px;
    font-size: .875rem;
    color: #7f1d1d;
}

/* ─── Field Card ───────────────────────────────────────────────── */
.gf-card {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    border: 1px solid var(--gf-border);
    box-shadow: var(--gf-shadow);
    padding: 24px;
    margin-bottom: 12px;
    transition: border-color .18s, box-shadow .18s;
}

.gf-card:focus-within {
    border-color: rgba(0,167,157,.45);
    box-shadow: var(--gf-shadow), 0 0 0 2px rgba(0,167,157,.08);
}

/* ─── Label ────────────────────────────────────────────────────── */
.gf-label {
    font-size: .9375rem;
    font-weight: 500;
    color: var(--gf-text);
    margin-bottom: 14px;
    display: block;
    line-height: 1.55;
}

.gf-required {
    color: var(--gf-danger);
    margin-left: 3px;
}

/* ─── Help text ────────────────────────────────────────────────── */
.gf-help {
    font-size: .72rem;
    color: var(--gf-text-muted);
    margin-top: 3px;
    margin-bottom: 8px;
    line-height: 1.5;
}

/* ─── Text inputs (underline style) ────────────────────────────── */
.gf-input,
.gf-textarea {
    display: block;
    width: 100%;
    background: var(--gf-card-bg);
    border: none;
    border-bottom: 1px solid #9aa0a6;
    border-radius: 0;
    padding: 8px 0 6px;
    font-size: .9375rem;
    color: var(--gf-text);
    transition: border-color .15s, box-shadow .15s;
    outline: none;
    -webkit-appearance: none;
    appearance: none;
    font-family: inherit;
}

.gf-input:focus,
.gf-textarea:focus {
    border-bottom: 2px solid var(--gf-primary);
    box-shadow: none;
    outline: none;
    padding-bottom: 5px;
}

.gf-input.is-invalid,
.gf-textarea.is-invalid {
    border-bottom-color: var(--gf-danger) !important;
}

.gf-input-readonly {
    background: transparent;
    cursor: default;
    color: var(--gf-text-muted);
    opacity: .85;
}

.gf-input::placeholder,
.gf-textarea::placeholder {
    color: #9aa0a6;
}

.gf-textarea {
    resize: vertical;
    min-height: 96px;
    line-height: 1.6;
}

/* ─── Select (Dropdown) ────────────────────────────────────────── */
.gf-select-wrap {
    position: relative;
    display: block;
}

.gf-select {
    display: block;
    width: 100%;
    padding: 8px 32px 6px 0;
    font-size: .9375rem;
    color: var(--gf-text);
    background: var(--gf-card-bg);
    border: none;
    border-bottom: 1px solid #9aa0a6;
    border-radius: 0;
    appearance: none;
    -webkit-appearance: none;
    cursor: pointer;
    outline: none;
    transition: border-color .15s;
    font-family: inherit;
}

.gf-select:focus {
    border-bottom: 2px solid var(--gf-primary);
    padding-bottom: 5px;
    outline: none;
}

.gf-select.is-invalid { border-bottom-color: var(--gf-danger) !important; }

.gf-select-icon {
    position: absolute;
    right: 6px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gf-text-muted);
    font-size: .75rem;
    pointer-events: none;
}

/* ─── Date / Time / Datetime ───────────────────────────────────── */
.gf-date-wrap {
    position: relative;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #9aa0a6;
    transition: border-color .15s;
}

.gf-date-wrap:focus-within {
    border-bottom: 2px solid var(--gf-primary);
}

.gf-date-wrap .gf-input {
    border: none;
    flex: 1;
    padding-right: 0;
}

.gf-date-wrap .gf-input:focus {
    border: none;
    box-shadow: none;
    padding-bottom: 6px;
}

.gf-date-icon {
    color: var(--gf-text-muted);
    font-size: .85rem;
    padding: 0 4px 6px;
    pointer-events: none;
    flex-shrink: 0;
}

/* ─── Radio / Checkbox ─────────────────────────────────────────── */
.gf-options {
    display: flex;
    flex-direction: column;
    gap: 0;
    margin-top: 4px;
}

.gf-option {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 10px 8px;
    border-radius: 6px;
    cursor: pointer;
    transition: background .15s;
    position: relative;
    margin: 0 -8px;
}

.gf-option:hover {
    background: rgba(0,167,157,.06);
}

/* Custom radio & checkbox using accent-color */
.gf-option-input[type="radio"],
.gf-option-input[type="checkbox"] {
    width: 20px;
    height: 20px;
    min-width: 20px;
    cursor: pointer;
    accent-color: var(--gf-primary);
    margin: 0;
}

.gf-option-label {
    font-size: .9375rem;
    color: var(--gf-text);
    cursor: pointer;
    user-select: none;
    flex: 1;
    line-height: 1.45;
}

/* ─── File Upload ──────────────────────────────────────────────── */
.gf-file-drop {
    border: 2px dashed var(--gf-border);
    border-radius: 10px;
    padding: 2rem 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: var(--gf-transition);
    background: #fafafa;
    margin-top: 4px;
}

.gf-file-drop:hover,
.gf-file-drop.dragover {
    border-color: var(--gf-primary);
    background: var(--gf-primary-light);
}

.gf-file-drop input[type="file"] {
    display: none;
}

.gf-file-upload-icon {
    font-size: 1.85rem;
    color: var(--gf-primary);
    margin-bottom: .5rem;
    display: block;
}

.gf-file-hint {
    font-size: .875rem;
    font-weight: 600;
    color: var(--gf-text);
    margin-bottom: .25rem;
}

.gf-file-meta {
    font-size: .75rem;
    color: var(--gf-text-muted);
    line-height: 1.6;
}

.gf-file-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    margin-top: .85rem;
    font-size: .8rem;
    color: var(--gf-primary);
    font-weight: 600;
    background: var(--gf-primary-light);
    padding: .28rem .85rem;
    border-radius: 20px;
    transition: var(--gf-transition);
}

/* ─── Section Break Card ───────────────────────────────────────── */
.gf-section-card {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    border: 1px solid var(--gf-border);
    border-left: 5px solid var(--gf-primary);
    box-shadow: var(--gf-shadow);
    padding: 18px 22px;
    margin-bottom: 12px;
}

.gf-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--gf-text);
    margin: 0 0 .3rem;
}

.gf-section-desc {
    font-size: .875rem;
    color: var(--gf-text-muted);
    margin: 0;
    line-height: 1.6;
}

/* ─── Paragraph Card ───────────────────────────────────────────── */
.gf-para-card {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    border: 1px solid var(--gf-border);
    box-shadow: var(--gf-shadow);
    padding: 20px 24px;
    margin-bottom: 12px;
}

.gf-para-text {
    font-size: .9375rem;
    color: var(--gf-text);
    margin: 0;
    line-height: 1.7;
    white-space: pre-line;
}

/* ─── Submit Area ──────────────────────────────────────────────── */
.gf-submit-area {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: .85rem;
    margin-top: 4px;
    padding: 4px 0;
}

.gf-submit-btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .7rem 2rem;
    background: var(--gf-primary);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: .9rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--gf-transition);
    box-shadow: 0 2px 10px rgba(0,167,157,.28);
    letter-spacing: .01em;
}

.gf-submit-btn:hover {
    background: var(--gf-primary-dark);
    box-shadow: 0 4px 16px rgba(0,167,157,.38);
    transform: translateY(-1px);
}

.gf-submit-btn:disabled {
    opacity: .65;
    cursor: default;
    transform: none;
    box-shadow: none;
}

.gf-privacy-note {
    font-size: .75rem;
    color: var(--gf-text-muted);
    margin: 0;
}

/* ─── Meta Footer ──────────────────────────────────────────────── */
.gf-meta-footer {
    text-align: center;
    margin-top: 1rem;
    font-size: .75rem;
    color: #9ca3af;
    padding-bottom: .5rem;
}

/* ─── Invalid message ──────────────────────────────────────────── */
.gf-invalid {
    font-size: .8rem;
    color: var(--gf-danger);
    margin-top: 5px;
    display: block;
}

/* ─── Card-per-field state (required border highlight) ─────────── */
.gf-card.has-error {
    border-color: rgba(217,48,37,.35);
    box-shadow: var(--gf-shadow), 0 0 0 2px rgba(217,48,37,.06);
}

/* ─── Thank You / Closed State Cards ──────────────────────────── */
.gf-state-page {
    min-height: 100vh;
    display: flex;
    align-items: flex-start;
    padding: 5rem 0 3rem;
    position: relative;
    z-index: 2;
}

.gf-state-card {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    border: 1px solid var(--gf-border);
    border-top: 10px solid var(--gf-primary);
    box-shadow: 0 2px 6px rgba(0,0,0,.06);
    padding: 1.75rem 1.75rem 2rem;
    text-align: left;
    max-width: 640px;
    margin: 0 auto;
}

.gf-state-form-title {
    font-size: 1.75rem;
    font-weight: 400;
    color: var(--gf-text);
    margin: 0 0 1rem;
    padding-bottom: .85rem;
    border-bottom: 1px solid var(--gf-border);
}

.gf-state-body {
    font-size: .9375rem;
    color: var(--gf-text);
    line-height: 1.65;
    margin-bottom: .5rem;
}

.gf-state-link {
    display: inline-block;
    margin-top: .75rem;
    font-size: .875rem;
    color: var(--gf-primary);
    font-weight: 500;
    text-decoration: none;
}

.gf-state-link:hover {
    text-decoration: underline;
    color: var(--gf-primary-dark);
}

.gf-state-link + .gf-state-link {
    margin-left: 1.25rem;
}

/* Keep legacy alias so JS-generated cards still work */
.gf-again-link {
    display: inline-block;
    margin-top: .75rem;
    font-size: .875rem;
    color: var(--gf-primary);
    font-weight: 500;
    text-decoration: none;
}

.gf-again-link:hover {
    text-decoration: underline;
    color: var(--gf-primary-dark);
}

/* ─── Responsive ───────────────────────────────────────────────── */
@media (max-width: 575.98px) {
    .gf-page { padding: 4.5rem 0 3rem; }
    .gf-header-card,
    .gf-card,
    .gf-section-card,
    .gf-para-card { padding: 18px 16px; }
    .gf-form-title { font-size: 1.35rem; }
    .gf-submit-area { flex-direction: column; align-items: flex-start; }
    .gf-submit-btn { width: 100%; justify-content: center; }
    .gf-state-card { padding: 2rem 1.25rem; }
}

/* ─── Dark Mode ────────────────────────────────────────────────── */
[data-theme="dark"] {
    --gf-bg:         #111317;
    --gf-card-bg:    #1e2025;
    --gf-text:       #e4e6eb;
    --gf-text-muted: #9ca3af;
    --gf-border:     #2d3139;
}

[data-theme="dark"] .gf-input,
[data-theme="dark"] .gf-textarea {
    color: var(--gf-text);
    background: var(--gf-card-bg);
    border-bottom-color: #4b5563;
}

[data-theme="dark"] .gf-input::placeholder,
[data-theme="dark"] .gf-textarea::placeholder {
    color: #6b7280;
}

/* Fix: email placeholder in dark mode hidden to avoid collision */
[data-theme="dark"] .gf-input[type="email"]::placeholder {
    color: transparent;
}

[data-theme="dark"] .gf-input:focus,
[data-theme="dark"] .gf-textarea:focus {
    border-bottom-color: var(--gf-primary);
}

[data-theme="dark"] .gf-date-wrap {
    border-bottom-color: #4b5563;
}
[data-theme="dark"] .gf-date-wrap:focus-within {
    border-bottom-color: var(--gf-primary);
}

[data-theme="dark"] .gf-select {
    color: var(--gf-text);
    border-bottom-color: #4b5563;
}
[data-theme="dark"] .gf-select:focus { border-bottom-color: var(--gf-primary); }

/* Date/time native picker dark */
[data-theme="dark"] .gf-input[type="date"],
[data-theme="dark"] .gf-input[type="time"],
[data-theme="dark"] .gf-input[type="datetime-local"] {
    color-scheme: dark;
    color: var(--gf-text);
}

[data-theme="dark"] .gf-option:hover { background: rgba(0,167,157,.08); }
[data-theme="dark"] .gf-option-label { color: var(--gf-text); }

[data-theme="dark"] .gf-file-drop {
    background: #252830;
    border-color: #374151;
}
[data-theme="dark"] .gf-file-drop:hover,
[data-theme="dark"] .gf-file-drop.dragover {
    background: rgba(0,167,157,.07);
    border-color: var(--gf-primary);
}
[data-theme="dark"] .gf-file-hint { color: var(--gf-text); }
[data-theme="dark"] .gf-select-icon  { color: #6b7280; }

[data-theme="dark"] .gf-error-card {
    background: #2a1a1a;
    border-color: #4b1c1c;
    border-left-color: var(--gf-danger);
    color: #f87171;
}
</style>
@endverbatim
