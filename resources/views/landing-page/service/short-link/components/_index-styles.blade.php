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

/* List: padding-left bullet (no display:flex) to avoid code/strong wrapping issues */
.sl-info-list {
    list-style: none;
    padding: 0; margin: 0;
}
.sl-info-list li {
    position: relative;
    padding: .3rem 0 .3rem 1.1rem;
    font-size: .82rem;
    color: #475569;
    line-height: 1.6;
    border-bottom: 1px dashed rgba(203,213,225,.6);
}
.sl-info-list li:last-child { border-bottom: none; }
.sl-info-list li::before {
    content: '';
    position: absolute;
    left: 0;
    top: .72rem;
    width: 6px; height: 6px;
    border-radius: 50%;
    background: #00a79d;
    flex-shrink: 0;
}
.sl-info-list code {
    background: rgba(0, 167, 157, .1);
    color: #007a73;
    border-radius: .3rem;
    padding: .05em .35em;
    font-size: .8em;
    word-break: break-word;
    overflow-wrap: anywhere;
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
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.05) 0%, rgba(255, 255, 255, 0.8) 100%);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(0, 167, 157, 0.15);
    border-radius: 28px;
    padding: 2.5rem;
    box-shadow: 0 20px 60px rgba(0, 167, 157, 0.08);
    transition: border-color .3s, box-shadow .3s;
}
.sl-form-card:hover {
    border-color: rgba(0, 167, 157, 0.25);
    box-shadow: 0 25px 70px rgba(0, 167, 157, 0.12);
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
    gap: 1.25rem;
}
.sl-form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
    align-items: start;
}
@media (max-width: 575.98px) {
    .sl-form-row-2 { grid-template-columns: 1fr; }
}

/* ── Form Group / Label ─────────────────────────────────── */
.sl-form-group { display: flex; flex-direction: column; }
.sl-form-label {
    display: flex;
    align-items: center;
    gap: .4rem;
    margin-bottom: .5rem;
    font-weight: 600;
    color: #2c3e50;
    font-size: .9rem;
}
.sl-req { color: #ef4444; font-weight: 700; margin-left: 1px; }

/* ── Inputs ─────────────────────────────────────────────── */
.sl-form-input {
    width: 100%;
    height: 50px;
    padding: .875rem 1.125rem;
    border: 2px solid rgba(0, 167, 157, .2);
    border-radius: 14px;
    background: rgba(255, 255, 255, .9);
    color: #2c3e50;
    font-family: inherit;
    font-size: .9rem;
    transition: border-color .3s, box-shadow .3s, transform .3s, background .3s;
    appearance: none;
    -webkit-appearance: none;
    outline: none;
    box-sizing: border-box;
    display: block;
}
.sl-form-textarea {
    width: 100%;
    padding: .875rem 1.125rem;
    border: 2px solid rgba(0, 167, 157, .2);
    border-radius: 14px;
    background: rgba(255, 255, 255, .9);
    color: #2c3e50;
    font-family: inherit;
    font-size: .9rem;
    resize: vertical;
    min-height: 110px;
    line-height: 1.6;
    transition: border-color .3s, box-shadow .3s, transform .3s, background .3s;
    outline: none;
    box-sizing: border-box;
    display: block;
}
.sl-form-input:focus,
.sl-form-textarea:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 4px rgba(0, 167, 157, .1);
    background: #fff;
    transform: translateY(-2px);
}
.sl-form-input::placeholder,
.sl-form-textarea::placeholder { color: rgba(0, 0, 0, .35); }

/* ── Validation states ──────────────────────────────────── */
.sl-form-group.sl-invalid .sl-form-input,
.sl-form-group.sl-invalid .sl-form-textarea {
    border-color: #ef4444;
    background: rgba(239, 68, 68, .04);
}
.sl-form-group.sl-invalid .sl-form-input:focus,
.sl-form-group.sl-invalid .sl-form-textarea:focus {
    border-color: #ef4444;
    box-shadow: 0 0 0 4px rgba(239, 68, 68, .1);
    transform: none;
}
.sl-form-group.sl-valid .sl-form-input,
.sl-form-group.sl-valid .sl-form-textarea { border-color: #10b981; }

/* ── Error & hint ───────────────────────────────────────── */
.sl-field-error {
    display: none;
    font-size: .75rem;
    color: #ef4444;
    font-weight: 500;
    margin-top: .35rem;
}
.sl-form-group.sl-invalid .sl-field-error { display: block; }
.sl-field-hint {
    font-size: .72rem;
    color: #94a3b8;
    margin-top: .3rem;
    line-height: 1.4;
}

/* ── Submit Button ──────────────────────────────────────── */
.sl-form-submit {
    position: relative;
    overflow: hidden;
    width: 100%;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #00a79d, #008f86);
    border: none;
    border-radius: 50px;
    color: #fff;
    font-weight: 600;
    font-size: 1rem;
    letter-spacing: .02em;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .6rem;
    transition: transform .3s, box-shadow .3s;
    margin-top: .25rem;
    font-family: inherit;
    box-shadow: 0 4px 15px rgba(0, 167, 157, .35);
}
.sl-form-submit::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #00d4c4 0%, #00a79d 100%);
    opacity: 0;
    transition: opacity .3s;
    border-radius: 50px;
}
.sl-form-submit:hover:not(:disabled)::before { opacity: 1; }
.sl-form-submit:hover:not(:disabled) {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 167, 157, .45);
}
.sl-form-submit:active { transform: translateY(-1px); }
.sl-form-submit > * { position: relative; z-index: 1; }
.sl-form-submit:disabled {
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
.sl-form-submit.sl-loading .sl-spinner { display: block; }
.sl-form-submit.sl-loading .sl-btn-text { display: none; }
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
.sl-send-again-btn:hover {
    border-color: #00a79d;
    color: #00a79d;
    background: rgba(0, 167, 157, .06);
}

/* ── Toast below navbar ─────────────────────────────────── */
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
    .sl-form-card    { padding: 1.5rem; border-radius: 20px; }
    .sl-info-col     { order: 2; }
    .sl-form-col     { order: 1; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
[data-theme="dark"] .sl-section-title { color: #e2e8f0; }
[data-theme="dark"] .sl-section-sub   { color: #9ca3af; }
[data-theme="dark"] .sl-contact-card  { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .sl-contact-title { color: #9ca3af; }
[data-theme="dark"] .sl-contact-name  { color: #e2e8f0; }
[data-theme="dark"] .sl-contact-num   { color: #9ca3af; }
[data-theme="dark"] .sl-contact-note  { color: #9ca3af; }
[data-theme="dark"] .sl-info-card     { background: rgba(0,167,157,.08); border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .sl-info-title    { color: #e2e8f0; }
[data-theme="dark"] .sl-info-list li  { color: #9ca3af; }
[data-theme="dark"] .sl-form-card     { background: linear-gradient(135deg, rgba(0,167,157,.08) 0%, rgba(26,31,46,.8) 100%); border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .sl-form-title    { color: #e2e8f0; }
[data-theme="dark"] .sl-form-label    { color: #cbd5e0; }
[data-theme="dark"] .sl-form-input,
[data-theme="dark"] .sl-form-textarea {
    background: #1e2535;
    border-color: rgba(0,167,157,.25);
    color: #e2e8f0;
}
[data-theme="dark"] .sl-form-input:focus,
[data-theme="dark"] .sl-form-textarea:focus {
    background: #252b3b;
    border-color: #00a79d;
}
[data-theme="dark"] .sl-form-input::placeholder,
[data-theme="dark"] .sl-form-textarea::placeholder { color: rgba(226,232,240,.35); }
[data-theme="dark"] .sl-send-again-btn { background: #252b3b; border-color: rgba(0,167,157,.2); color: #e2e8f0; }
[data-theme="dark"] .sl-success-title  { color: #e2e8f0; }
[data-theme="dark"] .sl-success-sub    { color: #9ca3af; }
</style>
