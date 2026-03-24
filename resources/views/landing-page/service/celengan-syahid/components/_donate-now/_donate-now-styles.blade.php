<link rel="stylesheet" href="{{ asset('assets/external/css/select2.min.css') }}">
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

/* Select wrap */
.dn-select-wrap { position: relative; }

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

/* ── Action row (back + submit) ── */
.dn-action-row {
    display: flex; gap: .75rem; align-items: stretch;
}
.dn-action-row .dn-submit-btn { flex: 1; width: auto; }
.dn-back-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
    padding: 1rem 1.35rem;
    background: transparent;
    border: 2px solid var(--dn-gray-200);
    border-radius: 30px;
    color: var(--dn-gray); font-size: .9rem; font-weight: 700;
    text-decoration: none; white-space: nowrap; flex-shrink: 0;
    transition: var(--dn-transition);
}
.dn-back-btn:hover {
    background: var(--dn-gray-100); border-color: var(--dn-gray);
    color: var(--dn-dark);
}


/* ── Back link ── */
.dn-back-link {
    display: inline-flex; align-items: center; gap: .625rem;
    color: var(--dn-gray); text-decoration: none;
    font-size: .85rem; font-weight: 700;
    padding: .5rem 1.1rem .5rem .75rem;
    background: var(--dn-white);
    border: 1.5px solid var(--dn-gray-200);
    border-radius: 30px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    transition: var(--dn-transition); margin-bottom: 1.5rem;
}
.dn-back-link i {
    width: 22px; height: 22px;
    display: inline-flex; align-items: center; justify-content: center;
    background: var(--dn-gray-100); border-radius: 50%;
    font-size: .68rem; flex-shrink: 0;
    transition: var(--dn-transition);
}
.dn-back-link:hover {
    background: var(--dn-primary-lt); border-color: rgba(0,167,157,.3);
    color: var(--dn-primary);
    box-shadow: 0 4px 16px rgba(0,167,157,.15);
    transform: translateX(-2px);
}
.dn-back-link:hover i { background: rgba(0,167,157,.15); }


/* ── Select2 Single ─────────────────────────────────────── */
.select2-container--default .select2-selection--single {
    height: auto;
    padding: .72rem 2.5rem .72rem 1rem;
    font-size: .9rem; color: var(--dn-dark);
    background: var(--dn-gray-100);
    border: 2px solid var(--dn-gray-200);
    border-radius: var(--dn-radius);
    outline: none; transition: var(--dn-transition);
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: var(--dn-dark); font-size: .9rem; padding: 0; line-height: 1.5;
}
.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #adb5bd; font-weight: 400;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100%; top: 0; right: .875rem; width: 20px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: var(--dn-gray) transparent transparent transparent;
    border-width: 5px 4px 0 4px;
}
.select2-container--default.select2-container--open .select2-selection--single,
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: var(--dn-primary); background: var(--dn-white);
    box-shadow: 0 0 0 4px rgba(0,167,157,.1); outline: none;
}
.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
    border-color: transparent transparent var(--dn-primary) transparent;
    border-width: 0 4px 5px 4px;
}
.dn-select-wrap.is-invalid .select2-container--default .select2-selection--single {
    border-color: #dc3545;
}

/* Select2 Dropdown */
.select2-container--default .select2-dropdown {
    border: 1.5px solid rgba(0,167,157,.25) !important;
    border-radius: var(--dn-radius) !important;
    overflow: hidden !important;
    box-shadow: 0 8px 28px rgba(0,167,157,.12), 0 2px 8px rgba(0,0,0,.06) !important;
    background: #fff !important; margin-top: 4px !important;
    animation: dnDropIn .15s ease forwards;
}
@keyframes dnDropIn {
    from { opacity: 0; transform: translateY(-5px); }
    to   { opacity: 1; transform: translateY(0); }
}
.select2-container--default .select2-search--dropdown {
    padding: 8px 8px 6px !important;
    border-bottom: 1px solid #edf7f6 !important;
}
.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1.5px solid #e0f2ef !important; border-radius: 8px !important;
    padding: 6px 10px !important; font-size: .85rem !important;
    outline: none !important; width: 100% !important;
    transition: border-color .2s, box-shadow .2s;
}
.select2-container--default .select2-search--dropdown .select2-search__field:focus {
    border-color: #00a79d !important;
    box-shadow: 0 0 0 3px rgba(0,167,157,.1) !important;
}
.select2-container--default .select2-results > .select2-results__options {
    max-height: 200px !important; overflow-y: auto !important; padding: 5px !important;
    scrollbar-width: thin; scrollbar-color: rgba(0,167,157,.3) transparent;
}
.select2-container--default .select2-results > .select2-results__options::-webkit-scrollbar { width: 4px; }
.select2-container--default .select2-results > .select2-results__options::-webkit-scrollbar-thumb {
    background: rgba(0,167,157,.35); border-radius: 4px;
}
.select2-container--default .select2-results__option {
    padding: 8px 12px !important; cursor: pointer !important;
    border-radius: 8px !important; transition: background .15s, color .15s !important;
    font-size: .875rem !important; color: #333 !important;
}
.select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
    background: rgba(0,167,157,.09) !important; color: #005f58 !important;
}
.select2-container--default .select2-results__option[aria-selected="true"] {
    background: rgba(0,167,157,.08) !important;
    color: #00a79d !important; font-weight: 600 !important;
}
.select2-container--default .select2-results__option--highlighted.select2-results__option--selectable[aria-selected="true"] {
    background: rgba(0,167,157,.16) !important; color: #005f58 !important;
}


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
/* Back link & back btn */
[data-theme="dark"] .dn-back-link       { background: #1a1f2e; border-color: rgba(0,167,157,.2); color: #9ca3af; }
[data-theme="dark"] .dn-back-btn        { border-color: rgba(255,255,255,.12); color: #9ca3af; }
[data-theme="dark"] .dn-back-btn:hover  { background: #252b3b; border-color: #4b5563; color: #e2e8f0; }
[data-theme="dark"] .dn-back-link i     { background: #252b3b; }
[data-theme="dark"] .dn-back-link:hover { background: rgba(0,167,157,.1); border-color: rgba(0,167,157,.35); color: #4dd9cf; }
[data-theme="dark"] .dn-back-link:hover i { background: rgba(0,167,157,.2); color: #4dd9cf; }
/* Select2 dark */
[data-theme="dark"] .select2-container--default .select2-selection--single {
    background: #1e2535; border-color: rgba(0,167,157,.25);
}
[data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__rendered { color: #e2e8f0; }
[data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__placeholder { color: #6b7280; }
[data-theme="dark"] .select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: #9ca3af transparent transparent transparent;
}
[data-theme="dark"] .select2-container--default.select2-container--open .select2-selection--single,
[data-theme="dark"] .select2-container--default.select2-container--focus .select2-selection--single {
    background: #252b3b; border-color: #00a79d;
}
[data-theme="dark"] .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
    border-color: transparent transparent #4dd9cf transparent;
}
[data-theme="dark"] .select2-container--default .select2-dropdown {
    background: #1a1f2e !important; border-color: rgba(0,167,157,.25) !important;
}
[data-theme="dark"] .select2-container--default .select2-search--dropdown { border-bottom-color: rgba(0,167,157,.1) !important; }
[data-theme="dark"] .select2-container--default .select2-search--dropdown .select2-search__field {
    background: #252b3b !important; border-color: #374151 !important; color: #e2e8f0 !important;
}
[data-theme="dark"] .select2-container--default .select2-results__option { color: #cbd5e0 !important; }
[data-theme="dark"] .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
    background: rgba(0,167,157,.15) !important; color: #4dd9cf !important;
}
[data-theme="dark"] .select2-container--default .select2-results__option--selected,
[data-theme="dark"] .select2-container--default .select2-results__option[aria-selected="true"] {
    background: #1e2b3a !important;
    background-color: #1e2b3a !important;
    color: #4dd9cf !important;
}
[data-theme="dark"] .select2-container--default .select2-results > .select2-results__options {
    scrollbar-color: rgba(0,167,157,.3) transparent;
}
</style>
