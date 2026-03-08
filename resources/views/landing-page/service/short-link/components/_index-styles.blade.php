<style>
/* ╔══════════════════════════════════════════════════════════
   SHORT-LINK PAGE  ·  prefix: sl-
   ══════════════════════════════════════════════════════════╗ */

/* ── Page Shell ─────────────────────────────────────────── */
.sl-page-section {
    padding-top: 6rem;
    padding-bottom: 5rem;
    position: relative;
    z-index: 1;
}

/* ── Section Header ─────────────────────────────────────── */
.sl-section-badge {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: rgba(0, 167, 157, .08);
    border: 1px solid rgba(0, 167, 157, .22);
    border-radius: 99px;
    padding: .35rem 1rem .35rem .7rem;
    font-size: .78rem;
    font-weight: 600;
    color: #007a73;
    letter-spacing: .04em;
    text-transform: uppercase;
}
.sl-badge-pulse {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #00a79d;
    animation: slBadgePulse 2s infinite;
}
@keyframes slBadgePulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,167,157,.5); }
    70%      { box-shadow: 0 0 0 7px rgba(0,167,157,0); }
}
.sl-section-title {
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    font-weight: 700;
    color: #1a1a2e;
    line-height: 1.2;
}
.sl-section-sub {
    color: #64748b;
    max-width: 560px;
    margin: .75rem auto 0;
    font-size: .95rem;
    line-height: 1.7;
}

/* ── Content Layout (no Bootstrap row) ─────────────────── */
.sl-content-wrap {
    display: flex;
    gap: 2rem;
    align-items: flex-start;
    margin-top: 2.5rem;
}
.sl-info-col { flex: 0 0 310px; }
.sl-form-col { flex: 1; min-width: 0; }

@media (max-width: 991.98px) {
    .sl-content-wrap { flex-direction: column; }
    .sl-info-col,
    .sl-form-col     { flex: none; width: 100%; }
}

/* ── Info Cards ─────────────────────────────────────────── */
.sl-info-card {
    background: rgba(0, 167, 157, .05);
    border: 1px solid rgba(0, 167, 157, .14);
    border-radius: 1rem;
    padding: 1.35rem 1.5rem;
    margin-bottom: 1rem;
}
.sl-info-title {
    font-size: .875rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: .75rem;
    display: flex;
    align-items: center;
    gap: .45rem;
}
.sl-info-title i { color: #00a79d; }
.sl-info-list {
    list-style: none;
    padding: 0; margin: 0;
}
.sl-info-list li {
    display: flex;
    align-items: flex-start;
    gap: .6rem;
    padding: .38rem 0;
    font-size: .82rem;
    color: #475569;
    line-height: 1.55;
    border-bottom: 1px dashed rgba(203,213,225,.6);
}
.sl-info-list li:last-child { border-bottom: none; }
.sl-info-list li::before {
    content: '';
    flex-shrink: 0;
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #00a79d;
    margin-top: .5rem;
}
.sl-info-list code {
    background: rgba(0, 167, 157, .1);
    color: #007a73;
    border-radius: .3rem;
    padding: .05em .35em;
    font-size: .8em;
}

/* ── Contact Card ───────────────────────────────────────── */
.sl-contact-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    padding: 1.35rem 1.5rem;
}
.sl-contact-title {
    font-size: .72rem;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-bottom: 1rem;
}
.sl-contact-person {
    display: flex;
    align-items: center;
    gap: .85rem;
    margin-bottom: 1rem;
}
.sl-contact-avatar {
    width: 44px; height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00a79d, #008f86);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.sl-contact-avatar i { color: #fff; font-size: 1rem; }
.sl-contact-name {
    font-weight: 700;
    color: #1a1a2e;
    font-size: .9rem;
    margin: 0 0 .1rem;
}
.sl-contact-num {
    font-size: .78rem;
    color: #64748b;
    margin: 0;
}
.sl-contact-wa-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    background: #25D366;
    color: #fff;
    border: none;
    border-radius: .75rem;
    padding: .6rem 1rem;
    font-size: .82rem;
    font-weight: 600;
    text-decoration: none;
    transition: background .2s, transform .15s;
    width: 100%;
}
.sl-contact-wa-btn:hover {
    background: #1da851;
    color: #fff;
    transform: translateY(-1px);
}
.sl-contact-note {
    font-size: .75rem;
    color: #94a3b8;
    margin: .75rem 0 0;
    line-height: 1.5;
}

/* ── Form Card ──────────────────────────────────────────── */
.sl-form-card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 1.25rem;
    padding: 2rem;
    box-shadow: 0 4px 28px rgba(0,0,0,.06);
}
.sl-form-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: .6rem;
}
.sl-form-icon {
    width: 32px; height: 32px;
    border-radius: .6rem;
    background: rgba(0, 167, 157, .1);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.sl-form-icon i { color: #00a79d; font-size: .875rem; }

/* ── Form Grid (no Bootstrap row) ──────────────────────── */
.sl-form-rows {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.sl-form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    align-items: start; /* prevent grid stretch so label centering stays correct */
}
@media (max-width: 575.98px) {
    .sl-form-row-2 { grid-template-columns: 1fr; }
}

/* ── Floating Label Fields ──────────────────────────────── */
.sl-field {
    position: relative;
}
.sl-field input,
.sl-field textarea {
    width: 100%;
    display: block;
    border: 1.5px solid #e2e8f0;
    border-radius: .75rem;
    padding: 1.5rem 1rem .5rem;
    font-size: .9rem;
    color: #1a1a2e;
    background: #f8fafc;
    outline: none;
    transition: border-color .2s, box-shadow .2s, background .2s;
    resize: none;
    font-family: inherit;
    appearance: none;
    -webkit-appearance: none;
}
/* Explicit height so label centering (top: 1.75rem) is predictable */
.sl-field input {
    height: 3.5rem;
}
.sl-field textarea {
    height: 110px;
    padding-top: 1.75rem;
}
.sl-field label {
    position: absolute;
    left: 1rem;
    /* 1.75rem = half of 3.5rem input height → always centers in input regardless of field container size */
    top: 1.75rem;
    transform: translateY(-50%);
    font-size: .875rem;
    color: #94a3b8;
    pointer-events: none;
    transition: top .18s ease, font-size .18s ease, color .18s ease, transform .18s ease;
    z-index: 1;
    margin: 0;
    padding: 0;
    white-space: nowrap;
    line-height: 1;
}
/* Textarea label sits at top */
.sl-field.sl-textarea label {
    top: 1.2rem;
    transform: none;
}
/* Floated (focus or has value) */
.sl-field input:focus ~ label,
.sl-field input:not(:placeholder-shown) ~ label {
    top: .55rem;
    transform: none;
    font-size: .7rem;
    color: #00a79d;
    font-weight: 600;
}
.sl-field textarea:focus ~ label,
.sl-field textarea:not(:placeholder-shown) ~ label {
    top: .45rem;
    font-size: .7rem;
    color: #00a79d;
    font-weight: 600;
}
/* Focus ring */
.sl-field input:focus,
.sl-field textarea:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 3px rgba(0,167,157,.12);
    background: #fff;
}
/* Validation */
.sl-field.sl-valid input,
.sl-field.sl-valid textarea {
    border-color: #10b981;
}
.sl-field.sl-invalid input,
.sl-field.sl-invalid textarea {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239,68,68,.08);
}
.sl-field.sl-invalid input:focus ~ label,
.sl-field.sl-invalid textarea:focus ~ label,
.sl-field.sl-invalid input:not(:placeholder-shown) ~ label,
.sl-field.sl-invalid textarea:not(:placeholder-shown) ~ label {
    color: #ef4444;
}
/* Error & hint */
.sl-field-error {
    display: none;
    font-size: .72rem;
    color: #ef4444;
    margin-top: .3rem;
    padding-left: .2rem;
}
.sl-field.sl-invalid .sl-field-error { display: block; }
.sl-field-hint {
    font-size: .72rem;
    color: #94a3b8;
    margin-top: .3rem;
    line-height: 1.4;
    padding-left: .2rem;
}

/* ── Submit Button ──────────────────────────────────────── */
.sl-submit-btn {
    width: 100%;
    padding: .9rem;
    background: var(--primary-gradient, linear-gradient(135deg, #00a79d 0%, #008f86 100%));
    border: none;
    border-radius: .75rem;
    color: #fff;
    font-weight: 700;
    font-size: .95rem;
    letter-spacing: .02em;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    transition: opacity .2s, transform .15s, box-shadow .2s;
    margin-top: .25rem;
    font-family: inherit;
}
.sl-submit-btn:hover:not(:disabled) {
    opacity: .9;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(0,167,157,.35);
}
.sl-submit-btn:disabled {
    opacity: .65;
    cursor: not-allowed;
    transform: none;
}
.sl-spinner {
    display: none;
    width: 16px; height: 16px;
    border: 2px solid rgba(255,255,255,.35);
    border-top-color: #fff;
    border-radius: 50%;
    animation: slSpin .7s linear infinite;
}
.sl-submit-btn.sl-loading .sl-spinner { display: block; }
.sl-submit-btn.sl-loading .sl-btn-text { display: none; }
@keyframes slSpin { to { transform: rotate(360deg); } }

/* ── Success Panel ──────────────────────────────────────── */
.sl-form-success {
    display: none;
    text-align: center;
    padding: 1.5rem;
    animation: slFadeUp .4s ease both;
}
.sl-form-success.sl-visible { display: block; }
.sl-success-icon {
    width: 66px; height: 66px;
    border-radius: 50%;
    background: rgba(16,185,129,.1);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.1rem;
}
.sl-success-icon i { color: #10b981; font-size: 1.8rem; }
.sl-success-title {
    font-weight: 700;
    color: #1a1a2e;
    font-size: 1.15rem;
    margin-bottom: .5rem;
}
.sl-success-sub {
    color: #64748b;
    font-size: .875rem;
    line-height: 1.65;
    max-width: 380px;
    margin: 0 auto 1.25rem;
}
.sl-send-again-btn {
    background: transparent;
    border: 1.5px solid #e2e8f0;
    border-radius: .75rem;
    padding: .55rem 1.35rem;
    font-size: .875rem;
    color: #475569;
    cursor: pointer;
    transition: border-color .2s, color .2s, background .2s;
    font-family: inherit;
}
/* Fix #5 — hover bright/teal, not dark */
.sl-send-again-btn:hover {
    border-color: #00a79d;
    color: #00a79d;
    background: rgba(0, 167, 157, .06);
}

/* ── Toast below navbar (Fix #4) ────────────────────────── */
.sl-swal-below-nav {
    padding-top: 72px !important;
}

/* ── Entrance Animations ────────────────────────────────── */
@keyframes slFadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Mobile tweaks ──────────────────────────────────────── */
@media (max-width: 767.98px) {
    .sl-page-section { padding-top: 5rem; padding-bottom: 3rem; }
    .sl-form-card    { padding: 1.35rem; border-radius: 1rem; }
    .sl-info-col     { order: 2; } /* form first on mobile */
    .sl-form-col     { order: 1; }
}
</style>
