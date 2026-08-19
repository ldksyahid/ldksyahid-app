{{-- Path: resources/views/landing-page/service/persuratan/components/_index-styles.blade.php --}}
<style>
/* ================================================================
   PERSURATAN LANDING PAGE — Modern Redesign & Dark Mode Engine
   Palette: LDK Syahid Emerald (#009788 / #00a79d) & Sky Blue (#0ea5e9)
   Dark Mode: [data-theme="dark"], html.dark-mode, body.dark-mode
   Prefix: prs-
   ================================================================ */

:root {
    --prs-primary:       #009788;
    --prs-primary-dark:  #007a73;
    --prs-primary-deep:  #005a54;
    --prs-primary-light: #e6f7f5;
    --prs-primary-glow:  rgba(0, 167, 157, 0.15);
    --prs-dark:          #0f172a;
    --prs-dark-soft:     #1e293b;
    --prs-gray:          #64748b;
    --prs-gray-light:    #f8fafc;
    --prs-gray-border:   #e2e8f0;
    --prs-card-bg:       #ffffff;
    --prs-input-bg:      #ffffff;
    --prs-text:          #334155;
    --prs-heading:       #0f172a;
    --prs-success:       #10b981;
    --prs-warning:       #f59e0b;
    --prs-danger:        #ef4444;
}

[data-theme="dark"],
html.dark-mode,
body.dark-mode {
    --prs-primary-light: rgba(0, 167, 157, 0.15);
    --prs-primary-glow:  rgba(0, 167, 157, 0.25);
    --prs-dark:          #f8fafc;
    --prs-dark-soft:     #cbd5e1;
    --prs-gray:          #94a3b8;
    --prs-gray-light:    #1e2535;
    --prs-gray-border:   rgba(255, 255, 255, 0.08);
    --prs-card-bg:       #1a1f2e;
    --prs-input-bg:      #252b3b;
    --prs-text:          #cbd5e1;
    --prs-heading:       #f1f5f9;
}

/* ── 1. Page Shell & Section Header ────────────────────────── */
.prs-page-section {
    padding-top: 6rem;
    padding-bottom: 5rem;
    position: relative;
    z-index: 1;
}

.prs-section-badge {
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
[data-theme="dark"] .prs-section-badge,
html.dark-mode .prs-section-badge,
body.dark-mode .prs-section-badge {
    background: rgba(0, 167, 157, .15);
    border-color: rgba(0, 167, 157, .35);
    color: #2dd4bf;
}

.prs-badge-pulse {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #00a79d;
    animation: prsBadgePulse 2s infinite;
}
@keyframes prsBadgePulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,167,157,.5); }
    70%      { box-shadow: 0 0 0 7px rgba(0,167,157,0); }
}

.prs-section-title {
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    font-weight: 700;
    color: #1a1a2e;
    line-height: 1.2;
}
[data-theme="dark"] .prs-section-title,
html.dark-mode .prs-section-title,
body.dark-mode .prs-section-title {
    color: #f1f5f9;
}

.prs-section-sub {
    color: #64748b;
    max-width: 600px;
    margin: .75rem auto 0;
    font-size: .95rem;
    line-height: 1.7;
}
[data-theme="dark"] .prs-section-sub,
html.dark-mode .prs-section-sub,
body.dark-mode .prs-section-sub {
    color: #94a3b8;
}

/* ── 2. Content Layout (Two Columns) ───────────────────────── */
.prs-content-wrap {
    display: flex;
    gap: 2rem;
    align-items: flex-start;
    margin-top: 2.5rem;
}
.prs-info-col { flex: 0 0 320px; }
.prs-form-col { flex: 1; min-width: 0; }

@media (max-width: 991.98px) {
    .prs-content-wrap { flex-direction: column; }
    .prs-info-col,
    .prs-form-col     { flex: none; width: 100%; }
}

/* ── 3. Left Column Cards: Info, Contact, SideNav ──────────── */
.prs-info-card {
    background: rgba(0, 167, 157, .05);
    border: 1px solid rgba(0, 167, 157, .14);
    border-radius: 1rem;
    padding: 1.35rem 1.5rem;
    margin-bottom: 1rem;
}
[data-theme="dark"] .prs-info-card,
html.dark-mode .prs-info-card,
body.dark-mode .prs-info-card {
    background: rgba(0, 167, 157, .08);
    border-color: rgba(0, 167, 157, .2);
}

.prs-info-title {
    font-size: .875rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: .75rem;
    display: flex;
    align-items: center;
    gap: .45rem;
}
.prs-info-title i { color: #00a79d; }
[data-theme="dark"] .prs-info-title,
html.dark-mode .prs-info-title,
body.dark-mode .prs-info-title {
    color: #f1f5f9;
}

.prs-info-list {
    list-style: none;
    padding: 0; margin: 0;
}
.prs-info-list li {
    position: relative;
    padding: .35rem 0 .35rem 1.1rem;
    font-size: .82rem;
    color: #475569;
    line-height: 1.6;
    border-bottom: 1px dashed rgba(203,213,225,.6);
}
.prs-info-list li:last-child {
    border-bottom: none;
}
.prs-info-list li::before {
    content: "•";
    position: absolute;
    left: 0;
    top: .35rem;
    color: #00a79d;
    font-weight: bold;
}
[data-theme="dark"] .prs-info-list li,
html.dark-mode .prs-info-list li,
body.dark-mode .prs-info-list li {
    color: #94a3b8;
    border-bottom-color: rgba(255,255,255,.08);
}

/* Contact Card */
.prs-contact-card {
    background: #ffffff;
    border: 1px solid rgba(0, 167, 157, .16);
    border-radius: 1rem;
    padding: 1.35rem 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
}
[data-theme="dark"] .prs-contact-card,
html.dark-mode .prs-contact-card,
body.dark-mode .prs-contact-card {
    background: #1a1f2e;
    border-color: rgba(255, 255, 255, 0.08);
}

.prs-contact-title {
    font-size: .875rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 1rem;
}
[data-theme="dark"] .prs-contact-title,
html.dark-mode .prs-contact-title,
body.dark-mode .prs-contact-title {
    color: #f1f5f9;
}

.prs-contact-person {
    display: flex;
    align-items: center;
    gap: .85rem;
    margin-bottom: .85rem;
}

.prs-contact-avatar {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: rgba(0, 167, 157, .12);
    color: #00a79d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.prs-contact-avatar.sekjen {
    background: rgba(14, 165, 233, .12);
    color: #0284c7;
}

.prs-contact-role {
    font-size: .72rem;
    color: #64748b;
    margin: 0;
    line-height: 1.2;
}
.prs-contact-name {
    font-size: .85rem;
    font-weight: 700;
    color: #1a1a2e;
    margin: .15rem 0 0;
    line-height: 1.2;
}
[data-theme="dark"] .prs-contact-name,
html.dark-mode .prs-contact-name,
body.dark-mode .prs-contact-name {
    color: #f1f5f9;
}
.prs-contact-num {
    font-size: .75rem;
    color: #64748b;
    margin: .15rem 0 0;
}

.prs-contact-wa-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    width: 100%;
    padding: .65rem 1rem;
    border-radius: 12px;
    background: #25d366;
    color: #ffffff !important;
    font-size: .82rem;
    font-weight: 700;
    text-decoration: none;
    transition: all .2s ease;
    box-shadow: 0 4px 12px rgba(37, 211, 102, .25);
}
.prs-contact-wa-btn:hover {
    background: #1ebc59;
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 211, 102, .35);
}
.prs-contact-wa-btn.prs-sekjen-btn {
    background: #0284c7;
    box-shadow: 0 4px 12px rgba(2, 132, 199, .25);
}
.prs-contact-wa-btn.prs-sekjen-btn:hover {
    background: #0369a1;
    box-shadow: 0 6px 16px rgba(2, 132, 199, .35);
}

.prs-contact-divider {
    margin: 1rem 0;
    border: none;
    border-top: 1px dashed rgba(203, 213, 225, .8);
}
[data-theme="dark"] .prs-contact-divider,
html.dark-mode .prs-contact-divider,
body.dark-mode .prs-contact-divider {
    border-top-color: rgba(255, 255, 255, .08);
}

/* Side Nav Cards */
.prs-side-nav-card {
    background: #ffffff;
    border: 1px solid var(--prs-gray-border);
    border-radius: 1rem;
    padding: .6rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
}
[data-theme="dark"] .prs-side-nav-card,
html.dark-mode .prs-side-nav-card,
body.dark-mode .prs-side-nav-card {
    background: #1a1f2e;
    border-color: rgba(255, 255, 255, 0.08);
}

.prs-side-nav-link {
    display: flex;
    align-items: center;
    gap: .85rem;
    padding: .75rem .85rem;
    border-radius: 12px;
    text-decoration: none;
    color: #334155;
    transition: all .2s ease;
}
.prs-side-nav-link:hover {
    background: rgba(0, 167, 157, .06);
    color: #007a73;
}
[data-theme="dark"] .prs-side-nav-link {
    color: #cbd5e1;
}
[data-theme="dark"] .prs-side-nav-link:hover {
    background: rgba(0, 167, 157, .12);
    color: #2dd4bf;
}

.prs-side-nav-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .95rem;
    flex-shrink: 0;
}
.prs-side-nav-icon.history { background: rgba(14, 165, 233, .12); color: #0284c7; }
.prs-side-nav-icon.verify  { background: rgba(16, 185, 129, .12); color: #10b981; }

.prs-side-nav-title {
    font-size: .84rem;
    font-weight: 700;
    color: inherit;
    line-height: 1.2;
}
.prs-side-nav-sub {
    font-size: .72rem;
    color: #64748b;
    margin-top: .15rem;
}
.prs-side-nav-arrow {
    font-size: .75rem;
    color: #94a3b8;
    transition: transform .2s ease;
}
.prs-side-nav-link:hover .prs-side-nav-arrow {
    transform: translateX(3px);
    color: inherit;
}

/* ── 4. Step Process Flow ──────────────────────────────────── */
.prs-steps-wrapper {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

@media (max-width: 767.98px) {
    .prs-steps-wrapper {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
    }
}

.prs-step-item {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    background: var(--prs-card-bg);
    border: 1.5px solid var(--prs-gray-border);
    border-radius: 14px;
    padding: 0.75rem 0.85rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    transition: transform 0.2s ease, border-color 0.2s ease;
}

.prs-step-item:hover {
    transform: translateY(-2px);
    border-color: var(--prs-primary);
}

[data-theme="dark"] .prs-step-item,
html.dark-mode .prs-step-item,
body.dark-mode .prs-step-item {
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
}

.prs-step-num {
    width: 30px;
    height: 30px;
    min-width: 30px;
    border-radius: 8px;
    background: linear-gradient(135deg, var(--prs-primary) 0%, var(--prs-primary-dark) 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.82rem;
    font-weight: 800;
    box-shadow: 0 4px 10px rgba(0, 167, 157, 0.25);
}

.prs-step-label {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--prs-heading);
    line-height: 1.2;
}

.prs-step-sub {
    font-size: 0.68rem;
    color: var(--prs-gray);
    margin-top: 0.1rem;
}

/* ── 5. Main Form Card & FAQ Card ──────────────────────────── */
.prs-card,
.prs-form-card,
.prs-faq-card {
    background: var(--prs-card-bg);
    border: 1.5px solid var(--prs-gray-border);
    border-radius: 20px;
    box-shadow: 0 10px 32px rgba(0, 0, 0, 0.04);
    overflow: hidden;
    margin-bottom: 1.5rem;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}

[data-theme="dark"] .prs-card,
[data-theme="dark"] .prs-form-card,
[data-theme="dark"] .prs-faq-card,
html.dark-mode .prs-card,
html.dark-mode .prs-form-card,
html.dark-mode .prs-faq-card,
body.dark-mode .prs-card,
body.dark-mode .prs-form-card,
body.dark-mode .prs-faq-card {
    box-shadow: 0 12px 36px rgba(0, 0, 0, 0.35);
}

.prs-card-header,
.prs-form-card-header,
.prs-faq-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 1.75rem 1.15rem;
    border-bottom: 1px solid var(--prs-gray-border);
}

.prs-card-header-icon,
.prs-form-card-icon,
.prs-faq-header-icon {
    width: 44px;
    height: 44px;
    min-width: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--prs-primary) 0%, var(--prs-primary-dark) 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    box-shadow: 0 4px 14px rgba(0, 167, 157, 0.25);
    flex-shrink: 0;
}

.prs-faq-header-icon {
    background: rgba(14, 165, 233, 0.12);
    color: #0284c7;
    box-shadow: none;
}

.prs-card-title,
.prs-form-card-title,
.prs-faq-card-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--prs-heading);
    margin: 0;
    line-height: 1.25;
}

.prs-card-subtitle,
.prs-form-card-subtitle,
.prs-faq-card-subtitle {
    font-size: 0.82rem;
    color: var(--prs-gray);
    margin: 0.2rem 0 0;
}

.prs-card-body,
.prs-form-card-body,
.prs-faq-card-body {
    padding: 1.75rem;
}

@media (max-width: 575.98px) {
    .prs-card-header,
    .prs-form-card-header,
    .prs-faq-card-header {
        padding: 1.15rem 1rem 0.85rem;
        gap: 0.65rem;
    }
    .prs-card-header-icon,
    .prs-form-card-icon,
    .prs-faq-header-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        font-size: 1rem;
    }
    .prs-card-title,
    .prs-form-card-title,
    .prs-faq-card-title {
        font-size: 1rem;
    }
    .prs-card-body,
    .prs-form-card-body,
    .prs-faq-card-body {
        padding: 1.15rem 1rem;
    }
}

/* ── 5. Reapply Box & Alerts ───────────────────────────────── */
.prs-reapply-box {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.2rem 1.4rem;
    background: #f0f9ff;
    border: 1.5px solid #bae6fd;
    border-radius: 18px;
    margin-bottom: 1.5rem;
}

[data-theme="dark"] .prs-reapply-box,
html.dark-mode .prs-reapply-box,
body.dark-mode .prs-reapply-box {
    background: rgba(14, 165, 233, 0.12);
    border-color: rgba(14, 165, 233, 0.3);
}

.prs-reapply-icon {
    width: 38px;
    height: 38px;
    min-width: 38px;
    border-radius: 10px;
    background: #0ea5e9;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.prs-reapply-title {
    font-size: 0.92rem;
    font-weight: 800;
    color: #0369a1;
    margin-bottom: 0.2rem;
}

[data-theme="dark"] .prs-reapply-title,
html.dark-mode .prs-reapply-title,
body.dark-mode .prs-reapply-title {
    color: #38bdf8;
}

.prs-reapply-text {
    font-size: 0.84rem;
    color: #334155;
    line-height: 1.5;
}

[data-theme="dark"] .prs-reapply-text,
html.dark-mode .prs-reapply-text,
body.dark-mode .prs-reapply-text {
    color: #cbd5e1;
}

.prs-alert-success {
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    padding: 1rem 1.25rem;
    background: #ecfdf5;
    border: 1.5px solid #a7f3d0;
    border-radius: 16px;
    color: #065f46;
    margin-bottom: 1.5rem;
    font-size: 0.88rem;
    line-height: 1.5;
}

.prs-alert-danger {
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    padding: 1rem 1.25rem;
    background: #fef2f2;
    border: 1.5px solid #fecaca;
    border-radius: 16px;
    color: #991b1b;
    margin-bottom: 1.5rem;
    font-size: 0.88rem;
    line-height: 1.5;
}

[data-theme="dark"] .prs-alert-success,
html.dark-mode .prs-alert-success,
body.dark-mode .prs-alert-success {
    background: rgba(16, 185, 129, 0.15);
    border-color: rgba(16, 185, 129, 0.35);
    color: #6ee7b7;
}

[data-theme="dark"] .prs-alert-danger,
html.dark-mode .prs-alert-danger,
body.dark-mode .prs-alert-danger {
    background: rgba(239, 68, 68, 0.15);
    border-color: rgba(239, 68, 68, 0.35);
    color: #fca5a5;
}

/* ── 6. Letter & Dept Picker Cards (Trigger) ───────────────── */
.prs-picker-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: var(--prs-gray-light);
    border: 2px dashed var(--prs-gray-border);
    border-radius: 18px;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(.4,0,.2,1);
    position: relative;
}

.prs-picker-card:hover,
.prs-picker-card:focus {
    border-color: var(--prs-primary);
    background: var(--prs-primary-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(14, 165, 233, 0.15);
    outline: none;
}

.prs-picker-card.has-value {
    border-style: solid;
    border-color: var(--prs-primary);
    background: var(--prs-card-bg);
    box-shadow: 0 4px 16px rgba(14, 165, 233, 0.08);
}

[data-theme="dark"] .prs-picker-card,
html.dark-mode .prs-picker-card,
body.dark-mode .prs-picker-card {
    background: #1e2535;
    border-color: rgba(255, 255, 255, 0.12);
}

[data-theme="dark"] .prs-picker-card:hover,
html.dark-mode .prs-picker-card:hover,
body.dark-mode .prs-picker-card:hover {
    background: #252b3b;
    border-color: #38bdf8;
    box-shadow: 0 8px 24px rgba(0,0,0,0.3);
}

[data-theme="dark"] .prs-picker-card.has-value,
html.dark-mode .prs-picker-card.has-value,
body.dark-mode .prs-picker-card.has-value {
    background: #1e2535;
    border-color: rgba(14, 165, 233, 0.5);
}

.prs-picker-icon-wrap {
    width: 48px;
    height: 48px;
    min-width: 48px;
    border-radius: 14px;
    background: var(--prs-primary-light);
    color: var(--prs-primary-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: all 0.25s;
    flex-shrink: 0;
}

.prs-picker-card.has-value .prs-picker-icon-wrap {
    background: linear-gradient(135deg, var(--prs-primary) 0%, var(--prs-primary-deep) 100%);
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(14, 165, 233, 0.3);
}

[data-theme="dark"] .prs-picker-icon-wrap,
html.dark-mode .prs-picker-icon-wrap,
body.dark-mode .prs-picker-icon-wrap {
    background: rgba(14, 165, 233, 0.2);
    color: #38bdf8;
}

.prs-picker-content {
    flex-grow: 1;
    min-width: 0;
}

.prs-picker-title {
    font-size: 0.98rem;
    font-weight: 800;
    color: var(--prs-heading);
    line-height: 1.35;
}

.prs-picker-desc {
    font-size: 0.78rem;
    color: var(--prs-gray);
    margin-top: 0.2rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

[data-theme="dark"] .prs-picker-desc,
html.dark-mode .prs-picker-desc,
body.dark-mode .prs-picker-desc {
    color: #94a3b8;
}

.prs-picker-action {
    flex-shrink: 0;
}

.prs-picker-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: linear-gradient(135deg, var(--prs-primary) 0%, var(--prs-primary-dark) 100%);
    color: #ffffff !important;
    border: none;
    border-radius: 12px;
    padding: 0.55rem 1rem;
    font-size: 0.82rem;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
    transition: all 0.2s;
    pointer-events: none;
}

@media (max-width: 575.98px) {
    .prs-picker-card {
        padding: 0.9rem 1rem;
        gap: 0.75rem;
    }
    .prs-picker-icon-wrap {
        width: 40px;
        height: 40px;
        min-width: 40px;
        font-size: 1.1rem;
    }
    .prs-picker-title {
        font-size: 0.9rem;
    }
    .prs-picker-btn {
        padding: 0.45rem 0.75rem;
        font-size: 0.75rem;
    }
}

/* ── 7. Form Groups & Dynamic Inputs ───────────────────────── */
.prs-form-group {
    margin-bottom: 1.35rem;
}

.prs-form-label {
    display: block;
    font-size: 0.84rem;
    font-weight: 700;
    color: var(--prs-heading);
    margin-bottom: 0.5rem;
}

.prs-form-label i {
    color: var(--prs-primary);
    margin-right: 0.35rem;
}

.prs-input-group {
    position: relative;
    display: flex;
    align-items: center;
}

.prs-input-prefix-icon {
    position: absolute;
    left: 1rem;
    color: var(--prs-gray);
    font-size: 0.95rem;
    pointer-events: none;
    z-index: 2;
    transition: color 0.2s;
}

.prs-form-input,
.prs-form-select,
.prs-form-textarea {
    width: 100%;
    min-height: 48px;
    background: var(--prs-input-bg);
    border: 1.5px solid var(--prs-gray-border);
    border-radius: 14px;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    font-size: 0.9rem;
    color: var(--prs-heading);
    transition: all 0.25s ease;
    outline: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.prs-form-textarea {
    min-height: 100px;
    padding-top: 0.85rem;
    line-height: 1.6;
    resize: vertical;
}

.prs-form-input:focus,
.prs-form-select:focus,
.prs-form-textarea:focus {
    border-color: var(--prs-primary);
    box-shadow: 0 0 0 4px var(--prs-primary-glow);
    background: var(--prs-input-bg);
    color: var(--prs-heading);
}

.prs-form-input:focus ~ .prs-input-prefix-icon,
.prs-form-select:focus ~ .prs-input-prefix-icon,
.prs-form-textarea:focus ~ .prs-input-prefix-icon {
    color: var(--prs-primary);
}

.prs-form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 14px 10px;
    cursor: pointer;
}

[data-theme="dark"] .prs-form-select,
html.dark-mode .prs-form-select,
body.dark-mode .prs-form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
}

.prs-form-input::placeholder,
.prs-form-textarea::placeholder {
    color: #94a3b8;
    opacity: 1;
}

[data-theme="dark"] .prs-form-input::placeholder,
[data-theme="dark"] .prs-form-textarea::placeholder,
html.dark-mode .prs-form-input::placeholder,
html.dark-mode .prs-form-textarea::placeholder,
body.dark-mode .prs-form-input::placeholder,
body.dark-mode .prs-form-textarea::placeholder {
    color: #64748b;
}

.prs-form-hint {
    font-size: 0.76rem;
    color: var(--prs-gray);
    margin-top: 0.35rem;
    display: block;
}

/* ── 8. Interactive Date & Time Widgets ─────────────────────── */
.prs-date-toggle-wrap {
    display: inline-flex;
    background: var(--prs-gray-light);
    border: 1px solid var(--prs-gray-border);
    border-radius: 10px;
    padding: 2px;
    gap: 2px;
}

[data-theme="dark"] .prs-date-toggle-wrap,
html.dark-mode .prs-date-toggle-wrap,
body.dark-mode .prs-date-toggle-wrap {
    background: #1e2535;
    border-color: rgba(255, 255, 255, 0.1);
}

.prs-date-toggle-btn {
    border: none;
    background: transparent;
    font-size: 0.74rem;
    font-weight: 600;
    color: var(--prs-gray);
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.prs-date-toggle-btn.active {
    background: var(--prs-card-bg);
    color: var(--prs-primary-dark);
    font-weight: 700;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

[data-theme="dark"] .prs-date-toggle-btn,
html.dark-mode .prs-date-toggle-btn,
body.dark-mode .prs-date-toggle-btn {
    color: #94a3b8;
}

[data-theme="dark"] .prs-date-toggle-btn.active,
html.dark-mode .prs-date-toggle-btn.active,
body.dark-mode .prs-date-toggle-btn.active {
    background: #0ea5e9;
    color: #ffffff !important;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(14, 165, 233, 0.4);
}

.prs-time-box {
    background: var(--prs-gray-light);
    border: 1.5px solid var(--prs-gray-border);
    border-radius: 16px;
    padding: 1rem 1.15rem;
}

[data-theme="dark"] .prs-time-box,
html.dark-mode .prs-time-box,
body.dark-mode .prs-time-box {
    background: #1e2535;
    border-color: rgba(255,255,255,0.08);
}

[data-theme="dark"] .prs-time-box .text-muted,
[data-theme="dark"] .prs-time-box label,
[data-theme="dark"] .prs-time-box .form-check-label,
html.dark-mode .prs-time-box .text-muted,
html.dark-mode .prs-time-box label,
html.dark-mode .prs-time-box .form-check-label,
body.dark-mode .prs-time-box .text-muted,
body.dark-mode .prs-time-box label,
body.dark-mode .prs-time-box .form-check-label {
    color: #cbd5e1 !important;
}

/* ── 9. Submit Button ──────────────────────────────────────── */
.prs-btn-submit {
    width: 100%;
    min-height: 52px;
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    color: #ffffff !important;
    border: none;
    border-radius: 16px;
    padding: 0.95rem 1.5rem;
    font-size: 1rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.65rem;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(14, 165, 233, 0.35);
    transition: all 0.25s cubic-bezier(.4,0,.2,1);
}

.prs-btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(14, 165, 233, 0.45);
    color: #ffffff !important;
}

.prs-btn-submit:active {
    transform: translateY(0);
}

.prs-btn-submit:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none;
}

.prs-submit-hint {
    text-align: center;
    font-size: 0.8rem;
    color: var(--prs-gray);
    margin-top: 0.75rem;
    margin-bottom: 0;
}

/* ── 10. Quick Access Cards Grid (Riwayat & Verifikasi) ────── */
.prs-quick-cards-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.75rem;
}

@media (max-width: 767.98px) {
    .prs-quick-cards-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}

.prs-quick-card {
    display: flex;
    align-items: flex-start;
    gap: 1.15rem;
    background: var(--prs-card-bg);
    border: 1.5px solid var(--prs-gray-border);
    border-radius: 20px;
    padding: 1.5rem;
    text-decoration: none !important;
    color: inherit !important;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
    transition: all 0.25s cubic-bezier(.4,0,.2,1);
}

.prs-quick-card:hover {
    border-color: var(--prs-primary);
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(14, 165, 233, 0.15);
    color: inherit !important;
}

[data-theme="dark"] .prs-quick-card,
html.dark-mode .prs-quick-card,
body.dark-mode .prs-quick-card {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
}

.prs-quick-card-icon {
    width: 48px;
    height: 48px;
    min-width: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
    transition: transform 0.2s;
}

.prs-quick-card:hover .prs-quick-card-icon {
    transform: scale(1.08);
}

.prs-quick-card-icon.history { background: #e0f2fe; color: #0284c7; }
.prs-quick-card-icon.verify  { background: #d1fae5; color: #059669; }

[data-theme="dark"] .prs-quick-card-icon.history,
html.dark-mode .prs-quick-card-icon.history,
body.dark-mode .prs-quick-card-icon.history {
    background: rgba(14, 165, 233, 0.2);
    color: #38bdf8;
}

[data-theme="dark"] .prs-quick-card-icon.verify,
html.dark-mode .prs-quick-card-icon.verify,
body.dark-mode .prs-quick-card-icon.verify {
    background: rgba(16, 185, 129, 0.2);
    color: #34d399;
}

.prs-quick-card-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--prs-heading);
    margin: 0 0 0.3rem 0;
    line-height: 1.25;
}

.prs-quick-card-desc {
    font-size: 0.82rem;
    color: var(--prs-gray);
    margin: 0;
    line-height: 1.5;
}

/* ── 11. FAQ Accordion ─────────────────────────────────────── */
.prs-faq-item {
    border-bottom: 1px solid var(--prs-gray-border);
}

.prs-faq-item:last-child {
    border-bottom: none;
}

.prs-faq-question {
    width: 100%;
    background: transparent;
    border: none;
    padding: 1.1rem 0;
    font-size: 0.92rem;
    font-weight: 700;
    color: var(--prs-heading);
    text-align: left;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    cursor: pointer;
    transition: color 0.2s;
}

.prs-faq-question:hover {
    color: var(--prs-primary);
}

.prs-faq-question i {
    font-size: 0.8rem;
    color: var(--prs-gray);
    transition: transform 0.25s ease;
    flex-shrink: 0;
}

.prs-faq-item.active .prs-faq-question i {
    transform: rotate(180deg);
    color: var(--prs-primary);
}

.prs-faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
}

.prs-faq-answer-inner {
    padding-bottom: 1.1rem;
    font-size: 0.86rem;
    color: var(--prs-text);
    line-height: 1.65;
}

/* ── 12. Modal Choose Letter & Department Styles ────────────── */
.prs-modal .modal-dialog {
    max-width: 860px;
}

.prs-modal-content {
    background: #ffffff;
    border-radius: 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    overflow: hidden;
}

[data-theme="dark"] .prs-modal-content,
html.dark-mode .prs-modal-content,
body.dark-mode .prs-modal-content {
    background: #1a1f2e;
    border-color: rgba(255, 255, 255, 0.08);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}

.prs-modal-header {
    padding: 1.5rem 1.75rem 1rem;
    border-bottom: 1px solid #e2e8f0;
    background: #ffffff;
}

[data-theme="dark"] .prs-modal-header,
html.dark-mode .prs-modal-header,
body.dark-mode .prs-modal-header {
    background: #1e2535;
    border-bottom-color: rgba(255, 255, 255, 0.08);
}

.prs-modal-eyebrow {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--prs-primary-dark);
    display: block;
    margin-bottom: 0.2rem;
}

[data-theme="dark"] .prs-modal-eyebrow,
html.dark-mode .prs-modal-eyebrow,
body.dark-mode .prs-modal-eyebrow {
    color: #38bdf8;
}

.prs-modal-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--prs-heading);
    margin: 0;
}

.prs-modal-close {
    filter: none;
    opacity: 0.7;
    transition: opacity 0.2s;
}

[data-theme="dark"] .prs-modal-close,
html.dark-mode .prs-modal-close,
body.dark-mode .prs-modal-close {
    filter: invert(1) grayscale(100%) brightness(200%);
    opacity: 0.8;
}

.prs-modal-filter-wrap {
    padding: 1rem 1.75rem;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

[data-theme="dark"] .prs-modal-filter-wrap,
html.dark-mode .prs-modal-filter-wrap,
body.dark-mode .prs-modal-filter-wrap {
    background: #161b26;
    border-bottom-color: rgba(255, 255, 255, 0.06);
}

.prs-search-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
    margin-bottom: 0.85rem;
}

.prs-search-icon {
    position: absolute;
    left: 1.15rem;
    color: var(--prs-gray);
    font-size: 0.95rem;
    pointer-events: none;
}

.prs-search-input {
    width: 100%;
    min-height: 46px;
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    border-radius: 14px;
    padding: 0.65rem 2.75rem 0.65rem 2.85rem;
    font-size: 0.9rem;
    color: var(--prs-heading);
    outline: none;
    transition: all 0.2s;
}

.prs-search-input:focus {
    border-color: var(--prs-primary);
    box-shadow: 0 0 0 4px var(--prs-primary-glow);
}

[data-theme="dark"] .prs-search-input,
html.dark-mode .prs-search-input,
body.dark-mode .prs-search-input {
    background: #1e2535;
    border-color: rgba(255, 255, 255, 0.12);
    color: #f1f5f9;
}

[data-theme="dark"] .prs-search-input:focus,
html.dark-mode .prs-search-input:focus,
body.dark-mode .prs-search-input:focus {
    border-color: #38bdf8;
}

.prs-search-clear {
    position: absolute;
    right: 0.85rem;
    border: none;
    background: #e2e8f0;
    color: #475569;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.72rem;
    cursor: pointer;
}

[data-theme="dark"] .prs-search-clear,
html.dark-mode .prs-search-clear,
body.dark-mode .prs-search-clear {
    background: #252b3b;
    color: #cbd5e1;
}

.prs-cat-pills-wrap {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
    padding-bottom: 0.25rem;
    scrollbar-width: thin;
}

.prs-cat-pill {
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    border-radius: 50rem;
    padding: 0.35rem 0.85rem;
    font-size: 0.78rem;
    font-weight: 700;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.2s;
}

.prs-cat-pill:hover {
    background: var(--prs-primary-light);
    border-color: var(--prs-primary);
    color: var(--prs-primary-dark);
}

.prs-cat-pill.active {
    background: linear-gradient(135deg, var(--prs-primary) 0%, var(--prs-primary-deep) 100%);
    border-color: var(--prs-primary);
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
}

[data-theme="dark"] .prs-cat-pill,
html.dark-mode .prs-cat-pill,
body.dark-mode .prs-cat-pill {
    background: #1e2535;
    border-color: rgba(255, 255, 255, 0.1);
    color: #94a3b8;
}

[data-theme="dark"] .prs-cat-pill:hover,
html.dark-mode .prs-cat-pill:hover,
body.dark-mode .prs-cat-pill:hover {
    background: #252b3b;
    border-color: #38bdf8;
    color: #38bdf8;
}

[data-theme="dark"] .prs-cat-pill.active,
html.dark-mode .prs-cat-pill.active,
body.dark-mode .prs-cat-pill.active {
    background: linear-gradient(135deg, var(--prs-primary) 0%, var(--prs-primary-deep) 100%);
    color: #ffffff !important;
    border-color: var(--prs-primary);
}

.prs-modal-body {
    padding: 1.25rem 1.75rem;
    max-height: 480px;
    overflow-y: auto;
}

.prs-letters-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 0.85rem;
}

@media (max-width: 767.98px) {
    .prs-modal-header,
    .prs-modal-filter-wrap,
    .prs-modal-body,
    .prs-modal-footer {
        padding-left: 1.15rem;
        padding-right: 1.15rem;
    }
    .prs-letters-grid {
        grid-template-columns: 1fr;
        gap: 0.65rem;
    }
}

.prs-letter-card {
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    padding: 1rem 1.15rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(.4,0,.2,1);
    position: relative;
}

.prs-letter-card:hover {
    border-color: var(--prs-primary);
    background: #f0f9ff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(14, 165, 233, 0.12);
}

.prs-letter-card.selected {
    border-color: var(--prs-primary);
    background: var(--prs-primary-light);
    box-shadow: 0 4px 16px rgba(14, 165, 233, 0.18);
}

[data-theme="dark"] .prs-letter-card,
html.dark-mode .prs-letter-card,
body.dark-mode .prs-letter-card {
    background: #1e2535;
    border-color: rgba(255, 255, 255, 0.08);
}

[data-theme="dark"] .prs-letter-card:hover,
html.dark-mode .prs-letter-card:hover,
body.dark-mode .prs-letter-card:hover {
    background: #252b3b;
    border-color: #38bdf8;
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}

[data-theme="dark"] .prs-letter-card.selected,
html.dark-mode .prs-letter-card.selected,
body.dark-mode .prs-letter-card.selected {
    background: rgba(14, 165, 233, 0.15);
    border-color: #38bdf8;
}

.prs-letter-card-icon {
    width: 42px;
    height: 42px;
    min-width: 42px;
    border-radius: 12px;
    background: var(--prs-primary-light);
    color: var(--prs-primary-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    transition: all 0.2s;
    flex-shrink: 0;
}

.prs-letter-card.selected .prs-letter-card-icon,
.prs-letter-card:hover .prs-letter-card-icon {
    background: var(--prs-primary);
    color: #ffffff;
}

[data-theme="dark"] .prs-letter-card-icon,
html.dark-mode .prs-letter-card-icon,
body.dark-mode .prs-letter-card-icon {
    background: rgba(14, 165, 233, 0.2);
    color: #38bdf8;
}

.prs-letter-card-content {
    flex-grow: 1;
    min-width: 0;
}

.prs-letter-card-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    margin-bottom: 0.25rem;
}

.prs-letter-card-title {
    font-size: 0.92rem;
    font-weight: 800;
    color: var(--prs-heading);
    margin: 0;
    line-height: 1.3;
}

.prs-letter-card-badge {
    font-size: 0.68rem;
    font-weight: 800;
    font-family: monospace;
    background: #e2e8f0;
    color: #334155;
    padding: 0.15rem 0.45rem;
    border-radius: 6px;
    white-space: nowrap;
}

[data-theme="dark"] .prs-letter-card-badge,
html.dark-mode .prs-letter-card-badge,
body.dark-mode .prs-letter-card-badge {
    background: #252b3b;
    color: #cbd5e1;
}

.prs-letter-card-desc {
    font-size: 0.76rem;
    color: var(--prs-gray);
    line-height: 1.45;
    margin: 0;
}

[data-theme="dark"] .prs-letter-card-desc,
html.dark-mode .prs-letter-card-desc,
body.dark-mode .prs-letter-card-desc {
    color: #94a3b8;
}

.prs-letter-card-check {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: var(--prs-primary);
    color: #ffffff;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
}

.prs-letter-card.selected .prs-letter-card-check {
    display: flex;
}

.prs-modal-footer {
    padding: 0.95rem 1.75rem;
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
}

[data-theme="dark"] .prs-modal-footer,
html.dark-mode .prs-modal-footer,
body.dark-mode .prs-modal-footer {
    background: #1e2535;
    border-top-color: rgba(255, 255, 255, 0.08);
}

.prs-btn-close-modal {
    background: #ffffff;
    border: 1.5px solid #cbd5e1;
    color: #475569;
    border-radius: 12px;
    padding: 0.5rem 1.25rem;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}

.prs-btn-close-modal:hover {
    background: #f1f5f9;
    color: #0f172a;
}

[data-theme="dark"] .prs-btn-close-modal,
html.dark-mode .prs-btn-close-modal,
body.dark-mode .prs-btn-close-modal {
    background: #252b3b;
    border-color: rgba(255, 255, 255, 0.12);
    color: #cbd5e1;
}

[data-theme="dark"] .prs-btn-close-modal:hover,
html.dark-mode .prs-btn-close-modal:hover,
body.dark-mode .prs-btn-close-modal:hover {
    background: #1e2535;
    border-color: #38bdf8;
    color: #38bdf8;
}

/* ── 13. Flatpickr Universal Dark Mode Engine ──────────────── */
html.dark-mode .flatpickr-calendar,
body.dark-mode .flatpickr-calendar,
[data-theme="dark"] .flatpickr-calendar {
    background: #1e2535 !important;
    border: 1.5px solid rgba(255, 255, 255, 0.12) !important;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.45) !important;
    color: #f1f5f9 !important;
}

html.dark-mode .flatpickr-months,
body.dark-mode .flatpickr-months,
[data-theme="dark"] .flatpickr-months {
    background: #161b26 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    color: #f1f5f9 !important;
}

html.dark-mode .flatpickr-current-month .flatpickr-monthDropdown-months,
body.dark-mode .flatpickr-current-month .flatpickr-monthDropdown-months,
[data-theme="dark"] .flatpickr-current-month .flatpickr-monthDropdown-months {
    background: #161b26 !important;
    color: #f1f5f9 !important;
}

html.dark-mode .flatpickr-current-month input.cur-year,
body.dark-mode .flatpickr-current-month input.cur-year,
[data-theme="dark"] .flatpickr-current-month input.cur-year {
    color: #f1f5f9 !important;
}

html.dark-mode .flatpickr-day,
body.dark-mode .flatpickr-day,
[data-theme="dark"] .flatpickr-day {
    color: #e2e8f0 !important;
    border-color: transparent !important;
}

html.dark-mode .flatpickr-day:hover,
body.dark-mode .flatpickr-day:hover,
[data-theme="dark"] .flatpickr-day:hover {
    background: #252b3b !important;
    border-color: #38bdf8 !important;
    color: #38bdf8 !important;
}

html.dark-mode .flatpickr-day.selected,
html.dark-mode .flatpickr-day.startRange,
html.dark-mode .flatpickr-day.endRange,
body.dark-mode .flatpickr-day.selected,
body.dark-mode .flatpickr-day.startRange,
body.dark-mode .flatpickr-day.endRange,
[data-theme="dark"] .flatpickr-day.selected,
[data-theme="dark"] .flatpickr-day.startRange,
[data-theme="dark"] .flatpickr-day.endRange {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important;
    border-color: #0ea5e9 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.4) !important;
}

html.dark-mode .flatpickr-day.inRange,
body.dark-mode .flatpickr-day.inRange,
[data-theme="dark"] .flatpickr-day.inRange {
    background: rgba(14, 165, 233, 0.2) !important;
    border-color: transparent !important;
    color: #38bdf8 !important;
}

html.dark-mode .flatpickr-time,
body.dark-mode .flatpickr-time,
[data-theme="dark"] .flatpickr-time {
    background: #161b26 !important;
    border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
}

html.dark-mode .flatpickr-time input,
body.dark-mode .flatpickr-time input,
[data-theme="dark"] .flatpickr-time input {
    color: #f1f5f9 !important;
    background: transparent !important;
}

@keyframes prsFadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: none; }
}
</style>