<style>
/* ================================================================
   DONATE-NOW PAGE VARIABLES
   ================================================================ */
:root {
    --dn-primary:     #00a79d;
    --dn-primary-dk:  #008a82;
    --dn-primary-lt:  #e0f7f5;
    --dn-dark:        #1a2332;
    --dn-gray:        #6b7280;
    --dn-gray-100:    #f8f9fa;
    --dn-gray-200:    #e9ecef;
    --dn-white:       #ffffff;
    --dn-radius:      14px;
    --dn-radius-lg:   20px;
    --dn-shadow:      0 4px 20px rgba(0,0,0,.07);
    --dn-transition:  all .25s cubic-bezier(.4,0,.2,1);
}

/* ── Page wrapper ── */
.dn-page { min-height: 100vh; position: relative; z-index: 1; }

/* ================================================================
   CAMPAIGN CONTEXT HEADER
   ================================================================ */
.dn-context-wrap {
    background: var(--dn-white);
    border-radius: var(--dn-radius-lg);
    box-shadow: var(--dn-shadow);
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.dn-context-img-col { padding: 0; }
.dn-context-img-wrap {
    height: 100%; min-height: 200px;
    overflow: hidden;
}
.dn-context-img {
    width: 100%; height: 100%; object-fit: cover; display: block;
}
.dn-context-info {
    padding: 1.5rem 1.75rem;
    display: flex; flex-direction: column;
    justify-content: center; gap: .875rem;
}
.dn-context-label {
    font-size: .75rem; font-weight: 700;
    color: var(--dn-primary); letter-spacing: .04em; text-transform: uppercase;
}
.dn-context-title {
    font-size: 1.15rem; font-weight: 800;
    color: var(--dn-dark); line-height: 1.35; margin: 0;
}
.dn-context-org {
    display: flex; align-items: center; gap: .5rem;
}
.dn-context-org-logo {
    width: 28px; height: 28px; border-radius: 50%; object-fit: cover;
}
.dn-context-org-name {
    font-size: .82rem; font-weight: 600; color: var(--dn-gray);
    text-decoration: none;
}
.dn-context-org-name:hover { color: var(--dn-primary); }


/* ================================================================
   FORM SECTIONS
   ================================================================ */
.dn-section {
    background: var(--dn-white);
    border-radius: var(--dn-radius-lg);
    box-shadow: var(--dn-shadow);
    padding: 1.75rem;
    margin-bottom: 1.25rem;
}
.dn-section-title {
    font-size: 1rem; font-weight: 800; color: var(--dn-dark);
    margin: 0 0 1.25rem; padding-bottom: .75rem;
    border-bottom: 2px solid var(--dn-gray-200);
    display: flex; align-items: center; gap: .5rem;
}
.dn-section-title i { color: var(--dn-primary); }


/* ── Amount input ── */
.dn-amount-input-wrap {
    position: relative; margin-bottom: 1rem;
}
.dn-amount-prefix {
    position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
    font-size: 1rem; font-weight: 700; color: var(--dn-gray);
    pointer-events: none;
}
.dn-amount-input {
    width: 100%;
    padding: .875rem 1rem .875rem 3rem;
    font-size: 1.25rem; font-weight: 700; color: var(--dn-dark);
    background: var(--dn-gray-100);
    border: 2px solid var(--dn-gray-200);
    border-radius: var(--dn-radius);
    outline: none; transition: var(--dn-transition);
}
.dn-amount-input:focus {
    border-color: var(--dn-primary);
    background: var(--dn-white);
    box-shadow: 0 0 0 4px rgba(0,167,157,.1);
}
.dn-amount-input.is-invalid { border-color: #dc3545; }
.dn-amount-input::placeholder { font-weight: 500; color: #adb5bd; }

/* Preset buttons */
.dn-presets {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: .5rem;
    margin-bottom: .5rem;
}
@media (max-width: 575.98px) {
    .dn-presets { grid-template-columns: repeat(2, 1fr); }
}
.dn-preset-btn {
    background: var(--dn-gray-100); border: 2px solid var(--dn-gray-200);
    border-radius: var(--dn-radius); color: var(--dn-dark);
    font-size: .85rem; font-weight: 700;
    padding: .65rem .5rem; cursor: pointer;
    transition: var(--dn-transition); text-align: center;
}
.dn-preset-btn:hover,
.dn-preset-btn.active {
    background: var(--dn-primary-lt);
    border-color: var(--dn-primary);
    color: var(--dn-primary);
}


/* ── Form fields ── */
.dn-field { margin-bottom: 1rem; }
.dn-label {
    display: block; font-size: .8rem; font-weight: 700;
    color: var(--dn-gray); margin-bottom: .375rem;
}
.dn-input,
.dn-select {
    width: 100%;
    padding: .75rem 1rem;
    font-size: .9rem; color: var(--dn-dark);
    background: var(--dn-gray-100);
    border: 2px solid var(--dn-gray-200);
    border-radius: var(--dn-radius);
    outline: none; transition: var(--dn-transition);
    appearance: none; -webkit-appearance: none;
}
.dn-input:focus,
.dn-select:focus {
    border-color: var(--dn-primary);
    background: var(--dn-white);
    box-shadow: 0 0 0 4px rgba(0,167,157,.1);
}
.dn-input.is-invalid,
.dn-select.is-invalid { border-color: #dc3545; }
.dn-invalid-msg {
    font-size: .75rem; color: #dc3545;
    margin-top: .25rem; display: none;
}
.was-validated .dn-input:invalid ~ .dn-invalid-msg,
.was-validated .dn-select:invalid ~ .dn-invalid-msg,
.dn-input.is-invalid ~ .dn-invalid-msg,
.dn-select.is-invalid ~ .dn-invalid-msg { display: block; }

/* Select arrow */
.dn-select-wrap { position: relative; }
.dn-select-wrap::after {
    content: '\f078'; font-family: 'Font Awesome 5 Free'; font-weight: 900;
    position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);
    color: var(--dn-gray); pointer-events: none; font-size: .75rem;
}
.dn-select { padding-right: 2.5rem; }

/* Textarea */
.dn-textarea {
    width: 100%; min-height: 110px; resize: vertical;
    padding: .75rem 1rem;
    font-size: .9rem; color: var(--dn-dark);
    background: var(--dn-gray-100);
    border: 2px solid var(--dn-gray-200);
    border-radius: var(--dn-radius);
    outline: none; transition: var(--dn-transition);
}
.dn-textarea:focus {
    border-color: var(--dn-primary);
    background: var(--dn-white);
    box-shadow: 0 0 0 4px rgba(0,167,157,.1);
}

/* Anonymous toggle */
.dn-anon-row {
    display: flex; align-items: center; gap: .625rem;
    padding: .75rem 1rem;
    background: var(--dn-gray-100); border-radius: var(--dn-radius);
    cursor: pointer; margin-top: .5rem;
}
.dn-anon-check {
    width: 18px; height: 18px; cursor: pointer;
    accent-color: var(--dn-primary); flex-shrink: 0;
}
.dn-anon-label {
    font-size: .85rem; font-weight: 600; color: var(--dn-dark);
    cursor: pointer; margin: 0;
}


/* ── Total row ── */
.dn-total-row {
    display: flex; align-items: center; gap: .75rem;
    padding: 1rem 1.25rem;
    background: var(--dn-primary-lt); border-radius: var(--dn-radius);
    margin-bottom: 1.25rem;
}
.dn-total-label {
    font-size: .85rem; font-weight: 700;
    color: var(--dn-primary); flex: 1;
    text-transform: uppercase; letter-spacing: .04em;
}
.dn-total-value {
    font-size: 1.35rem; font-weight: 800; color: var(--dn-primary);
}


/* ── Submit button ── */
.dn-submit-btn {
    display: flex; align-items: center; justify-content: center; gap: .625rem;
    width: 100%; padding: 1rem 1.5rem;
    background: var(--dn-primary); color: #fff;
    font-size: 1rem; font-weight: 800; letter-spacing: .03em;
    border: none; border-radius: 30px; cursor: pointer;
    transition: var(--dn-transition);
    box-shadow: 0 4px 18px rgba(0,167,157,.3);
}
.dn-submit-btn:hover { filter: brightness(.9); transform: translateY(-1px); }
.dn-submit-btn:active { transform: translateY(0); }


/* ── Back link ── */
.dn-back-link {
    display: inline-flex; align-items: center; gap: .5rem;
    color: var(--dn-gray); text-decoration: none;
    font-size: .85rem; font-weight: 600;
    padding: .5rem .875rem;
    background: var(--dn-gray-100); border-radius: 30px;
    transition: var(--dn-transition); margin-bottom: 1.5rem;
}
.dn-back-link:hover { background: var(--dn-primary-lt); color: var(--dn-primary); }


/* ================================================================
   RESPONSIVE
   ================================================================ */
@media (max-width: 991.98px) {
    .dn-context-img-wrap { min-height: 200px; max-height: 260px; }
    .dn-context-info { padding: 1.25rem; }
}
@media (max-width: 575.98px) {
    .dn-section { padding: 1.25rem 1rem; }
    .dn-amount-input { font-size: 1.1rem; }
    .dn-total-value { font-size: 1.15rem; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
/* Campaign context */
[data-theme="dark"] .dn-context-wrap  { background: #1a1f2e; }
[data-theme="dark"] .dn-context-title { color: #e2e8f0; }
/* Form sections */
[data-theme="dark"] .dn-section       { background: #1a1f2e; }
[data-theme="dark"] .dn-section-title { color: #e2e8f0; border-bottom-color: rgba(0,167,157,.2); }
/* Amount */
[data-theme="dark"] .dn-amount-prefix { color: #9ca3af; }
[data-theme="dark"] .dn-amount-input  { background: #1e2535; border-color: rgba(0,167,157,.25); color: #e2e8f0; }
[data-theme="dark"] .dn-amount-input:focus { background: #252b3b; border-color: #00a79d; }
/* Preset buttons */
[data-theme="dark"] .dn-preset-btn    { background: #252b3b; border-color: rgba(0,167,157,.2); color: #e2e8f0; }
[data-theme="dark"] .dn-preset-btn:hover,
[data-theme="dark"] .dn-preset-btn.active { background: rgba(0,167,157,.15); border-color: #00a79d; color: #4dd9cf; }
/* Form fields */
[data-theme="dark"] .dn-label         { color: #9ca3af; }
[data-theme="dark"] .dn-input,
[data-theme="dark"] .dn-select        { background: #1e2535; border-color: rgba(0,167,157,.25); color: #e2e8f0; }
[data-theme="dark"] .dn-input:focus,
[data-theme="dark"] .dn-select:focus  { background: #252b3b; border-color: #00a79d; }
[data-theme="dark"] .dn-textarea      { background: #1e2535; border-color: rgba(0,167,157,.25); color: #e2e8f0; }
[data-theme="dark"] .dn-textarea:focus { background: #252b3b; border-color: #00a79d; }
/* Anonymous toggle */
[data-theme="dark"] .dn-anon-row      { background: #252b3b; }
[data-theme="dark"] .dn-anon-label    { color: #e2e8f0; }
/* Total */
[data-theme="dark"] .dn-total-row     { background: rgba(0,167,157,.12); }
[data-theme="dark"] .dn-total-label   { color: #4dd9cf; }
[data-theme="dark"] .dn-total-value   { color: #4dd9cf; }
/* Back link */
[data-theme="dark"] .dn-back-link     { background: #252b3b; color: #9ca3af; }
</style>
