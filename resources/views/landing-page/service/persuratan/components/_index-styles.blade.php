@verbatim
<style>
/* ================================================================
   PERSURATAN LANDING PAGE — Modern Redesign
   Palette: #0ea5e9 (Sky/Ocean Blue) / #0284c7 (Dark Sky Blue) / #0369a1
   Prefix: prs-
   ================================================================ */

:root {
    --prs-primary:       #0ea5e9;
    --prs-primary-dark:  #0284c7;
    --prs-primary-deep:  #0369a1;
    --prs-primary-light: #e0f2fe;
    --prs-primary-glow:  rgba(14, 165, 233, 0.15);
    --prs-dark:          #0f172a;
    --prs-dark-soft:     #1e293b;
    --prs-gray:          #64748b;
    --prs-gray-light:    #f8fafc;
    --prs-gray-border:   #e2e8f0;
    --prs-success:       #10b981;
    --prs-warning:       #f59e0b;
    --prs-danger:        #ef4444;
}

/* ── Section Shell ───────────────────────────────────────── */
.prs-section {
    padding: 6.5rem 0 5rem;
    min-height: 100vh;
    background: transparent;
    position: relative;
}

/* ── Two-Column Layout (CSS Grid) ────────────────────────── */
.prs-layout {
    display: grid;
    grid-template-columns: 5fr 7fr;
    gap: 2.5rem;
    align-items: start;
}

@media (max-width: 991.98px) {
    .prs-layout {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

/* ============================================================
   LEFT COLUMN — INFO & DECORATIVE
   ============================================================ */
.prs-col-info {
    position: sticky;
    top: 7rem;
}

@media (max-width: 991.98px) {
    .prs-col-info {
        position: static;
    }
}

.prs-deco-label {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--prs-primary-dark);
    margin-bottom: 0.5rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.prs-deco-label i {
    font-size: 0.85rem;
}

.prs-deco-title {
    font-size: 2.15rem;
    font-weight: 800;
    color: var(--prs-dark);
    line-height: 1.2;
    margin-bottom: 0;
}

.prs-deco-bar {
    width: 52px;
    height: 4px;
    background: linear-gradient(90deg, var(--prs-primary) 0%, var(--prs-primary-deep) 100%);
    border-radius: 50rem;
    margin: 1.1rem 0 1.5rem;
}

/* Quote Box */
.prs-deco-quote {
    background: linear-gradient(135deg, rgba(14, 165, 233, 0.05) 0%, rgba(255, 255, 255, 0.9) 100%);
    backdrop-filter: blur(12px);
    border: 1.5px solid rgba(14, 165, 233, 0.15);
    border-radius: 20px;
    padding: 1.35rem 1.6rem;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.35rem;
    box-shadow: 0 4px 20px rgba(14, 165, 233, 0.04);
}
.prs-deco-quote::before {
    content: '\201C';
    position: absolute;
    top: -12px;
    left: 14px;
    font-size: 6rem;
    line-height: 1;
    color: rgba(14, 165, 233, 0.12);
    font-family: Georgia, serif;
    pointer-events: none;
}
.prs-quran-arabic {
    font-size: 1.05rem;
    line-height: 2;
    text-align: right;
    direction: rtl;
    color: var(--prs-dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}
.prs-deco-quote p {
    font-size: 0.86rem;
    line-height: 1.75;
    color: #334155;
    text-align: justify;
    margin-bottom: 0.6rem;
    position: relative;
    z-index: 1;
}
.prs-deco-quote p.prs-quran-arabic { margin-bottom: 0.5rem; }
.prs-deco-quote span {
    font-size: 0.76rem;
    font-weight: 700;
    color: var(--prs-primary-dark);
    display: block;
    text-align: right;
    position: relative;
    z-index: 1;
}

/* How-To Card */
.prs-how-card {
    background: linear-gradient(135deg, rgba(14, 165, 233, 0.04) 0%, rgba(255, 255, 255, 0.95) 100%);
    backdrop-filter: blur(20px);
    border: 1.5px solid rgba(14, 165, 233, 0.15);
    border-radius: 20px;
    padding: 1.35rem 1.6rem;
    margin-bottom: 1.35rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.03);
}
.prs-how-title {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--prs-primary-dark);
    margin-bottom: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.45rem;
}
.prs-how-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
}
.prs-how-list li {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    font-size: 0.84rem;
    color: #334155;
    line-height: 1.5;
}
.prs-how-bullet {
    width: 8px;
    height: 8px;
    min-width: 8px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--prs-primary) 0%, #38bdf8 100%);
    margin-top: 0.4rem;
    box-shadow: 0 0 0 2px rgba(14, 165, 233, 0.25);
}

/* SLA & Info Card */
.prs-method-card {
    background: white;
    border: 1.5px solid var(--prs-gray-border);
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.35rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.02);
}
.prs-method-title {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--prs-dark-soft);
    margin-bottom: 0.6rem;
    display: flex;
    align-items: center;
    gap: 0.45rem;
}
.prs-method-body {
    font-size: 0.83rem;
    color: var(--prs-gray);
    line-height: 1.6;
    margin: 0;
}

/* Narahubung / WhatsApp Card */
.prs-contact-card {
    background: white;
    border: 1.5px solid var(--prs-gray-border);
    border-radius: 20px;
    padding: 1.35rem 1.5rem;
    margin-bottom: 1.35rem;
    box-shadow: 0 4px 18px rgba(0,0,0,0.03);
}
.prs-contact-title {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--prs-primary-dark);
    margin-bottom: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.45rem;
}
.prs-contact-grid {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}
.prs-contact-item {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    padding: 0.75rem 0.95rem;
    background: var(--prs-gray-light);
    border: 1.5px solid var(--prs-gray-border);
    border-radius: 14px;
    text-decoration: none;
    transition: all 0.25s cubic-bezier(.4,0,.2,1);
    color: inherit;
}
.prs-contact-item:hover {
    background: #f0fdf4;
    border-color: #86efac;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(34, 197, 94, 0.12);
    color: inherit;
}
.prs-contact-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #25d366;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    flex-shrink: 0;
}
.prs-contact-info {
    flex-grow: 1;
    min-width: 0;
}
.prs-contact-name {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--prs-dark);
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.prs-contact-role {
    font-size: 0.74rem;
    color: var(--prs-gray);
    margin: 0.1rem 0 0;
}
.prs-contact-arrow {
    color: #22c55e;
    font-size: 0.85rem;
    transition: transform 0.2s;
}
.prs-contact-item:hover .prs-contact-arrow {
    transform: translateX(3px);
}

/* FAQ Accordion */
.prs-faq-card {
    background: white;
    border: 1.5px solid var(--prs-gray-border);
    border-radius: 20px;
    padding: 1.35rem 1.5rem;
}
.prs-faq-title {
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--prs-primary-dark);
    margin-bottom: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.45rem;
}
.prs-faq-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}
.prs-faq-item {
    border: 1px solid var(--prs-gray-border);
    border-radius: 12px;
    overflow: hidden;
    transition: border-color 0.2s;
}
.prs-faq-item.active {
    border-color: var(--prs-primary);
}
.prs-faq-question {
    width: 100%;
    background: var(--prs-gray-light);
    border: none;
    padding: 0.75rem 0.95rem;
    font-size: 0.83rem;
    font-weight: 600;
    color: var(--prs-dark);
    text-align: left;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    cursor: pointer;
    transition: background 0.2s;
}
.prs-faq-question:hover {
    background: var(--prs-primary-light);
    color: var(--prs-primary-deep);
}
.prs-faq-item.active .prs-faq-question {
    background: var(--prs-primary-light);
    color: var(--prs-primary-deep);
}
.prs-faq-question i {
    font-size: 0.75rem;
    transition: transform 0.25s ease;
    color: var(--prs-gray);
}
.prs-faq-item.active .prs-faq-question i {
    transform: rotate(180deg);
    color: var(--prs-primary-dark);
}
.prs-faq-answer {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
    background: white;
}
.prs-faq-answer-inner {
    padding: 0.85rem 0.95rem;
    font-size: 0.81rem;
    color: #475569;
    line-height: 1.6;
}

/* ============================================================
   RIGHT COLUMN — FORM & RECENT HISTORY
   ============================================================ */
.prs-col-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Form Card */
.prs-form-card {
    background: white;
    border-radius: 24px;
    border: 1.5px solid var(--prs-gray-border);
    box-shadow: 0 8px 30px rgba(0,0,0,0.04);
    padding: 2rem 2.25rem;
    position: relative;
    overflow: hidden;
}

@media (max-width: 575.98px) {
    .prs-form-card {
        padding: 1.5rem 1.25rem;
        border-radius: 20px;
    }
}

.prs-form-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.75rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid var(--prs-gray-border);
}

.prs-form-icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    background: linear-gradient(135deg, var(--prs-primary) 0%, var(--prs-primary-deep) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.35rem;
    box-shadow: 0 6px 18px rgba(14, 165, 233, 0.3);
    flex-shrink: 0;
}

.prs-form-header-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--prs-dark);
    margin: 0;
}

.prs-form-header-sub {
    font-size: 0.82rem;
    color: var(--prs-gray);
    margin: 0.2rem 0 0;
}

/* Alerts */
.prs-alert {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    border-radius: 16px;
    padding: 1rem 1.2rem;
    margin-bottom: 1.5rem;
    font-size: 0.88rem;
    animation: prsFadeIn 0.3s ease both;
}
.prs-alert i {
    font-size: 1.1rem;
    margin-top: 0.1rem;
    flex-shrink: 0;
}
.prs-alert-success {
    background: #ecfdf5;
    color: #065f46;
    border: 1.5px solid #a7f3d0;
}
.prs-alert-danger {
    background: #fef2f2;
    color: #991b1b;
    border: 1.5px solid #fecaca;
}

/* Form Groups & Inputs */
.prs-form-group {
    margin-bottom: 1.35rem;
    position: relative;
    animation: prsFadeIn 0.35s ease both;
}

.prs-form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.86rem;
    font-weight: 700;
    color: var(--prs-dark-soft);
    margin-bottom: 0.55rem;
}

.prs-form-label i {
    color: var(--prs-primary);
    font-size: 0.85rem;
    width: 16px;
    text-align: center;
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
    font-size: 0.9rem;
    pointer-events: none;
    z-index: 2;
    transition: color 0.2s;
}

.prs-form-input,
.prs-form-select,
.prs-form-textarea {
    width: 100%;
    border: 1.5px solid var(--prs-gray-border);
    border-radius: 14px;
    padding: 0.8rem 1rem 0.8rem 2.6rem;
    font-size: 0.9rem;
    color: var(--prs-dark);
    background: white;
    transition: all 0.2s ease;
    font-family: inherit;
}

.prs-form-select {
    cursor: pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1.15em;
    padding-right: 2.5rem;
    appearance: none;
    -webkit-appearance: none;
}

.prs-form-input:focus,
.prs-form-select:focus,
.prs-form-textarea:focus {
    outline: none;
    border-color: var(--prs-primary);
    box-shadow: 0 0 0 3px var(--prs-primary-glow);
    background: white;
}

.prs-input-group:focus-within .prs-input-prefix-icon {
    color: var(--prs-primary);
}

.prs-form-textarea {
    padding: 0.85rem 1rem 0.85rem 2.6rem;
    resize: vertical;
    min-height: 100px;
}

.prs-form-hint {
    font-size: 0.76rem;
    color: var(--prs-gray);
    margin-top: 0.4rem;
    display: block;
}

.prs-error-text {
    color: var(--prs-danger);
    font-size: 0.78rem;
    font-weight: 600;
    margin-top: 0.4rem;
}

/* ── Interactive Date Toggle & UI ── */
.prs-date-toggle-wrap {
    display: inline-flex;
    background: var(--prs-gray-light);
    border: 1px solid var(--prs-gray-border);
    border-radius: 10px;
    padding: 2px;
    gap: 2px;
}
.prs-date-toggle-btn {
    border: none;
    background: transparent;
    color: var(--prs-gray);
    font-size: 0.72rem;
    font-weight: 700;
    padding: 0.25rem 0.65rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}
.prs-date-toggle-btn.active {
    background: var(--prs-primary);
    color: white;
    box-shadow: 0 2px 6px rgba(14, 165, 233, 0.3);
}

/* ── Interactive Time UI ── */
.prs-time-box {
    background: var(--prs-gray-light);
    border: 1.5px solid var(--prs-gray-border);
    border-radius: 16px;
    padding: 1rem 1.15rem;
}
.prs-time-picker {
    cursor: pointer !important;
}

/* Description / Type Box */
.prs-desc-box {
    background: linear-gradient(135deg, rgba(14, 165, 233, 0.06) 0%, rgba(224, 242, 254, 0.3) 100%);
    border-left: 4px solid var(--prs-primary);
    border-radius: 0 14px 14px 0;
    padding: 0.95rem 1.15rem;
    margin-bottom: 1.4rem;
    font-size: 0.84rem;
    color: #334155;
    line-height: 1.6;
    animation: prsFadeIn 0.3s ease both;
}

/* Submit Button */
.prs-btn-submit {
    width: 100%;
    background: linear-gradient(135deg, var(--prs-primary) 0%, var(--prs-primary-deep) 100%);
    color: white;
    border: none;
    border-radius: 16px;
    padding: 1rem 1.5rem;
    font-size: 0.98rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.65rem;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
    transition: all 0.3s cubic-bezier(.4,0,.2,1);
    position: relative;
    overflow: hidden;
}

.prs-btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(14, 165, 233, 0.4);
    color: white;
}

.prs-btn-submit:active {
    transform: translateY(0);
}

.prs-btn-submit:disabled {
    opacity: 0.65;
    cursor: not-allowed;
    transform: none;
}

/* ── Riwayat Singkat Card ────────────────────────────────── */
.prs-history-card {
    background: white;
    border-radius: 24px;
    border: 1.5px solid var(--prs-gray-border);
    box-shadow: 0 8px 30px rgba(0,0,0,0.04);
    padding: 1.75rem 2rem;
}

@media (max-width: 575.98px) {
    .prs-history-card {
        padding: 1.35rem 1.15rem;
        border-radius: 20px;
    }
}

.prs-history-head {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    margin-bottom: 1.25rem;
    padding-bottom: 0.95rem;
    border-bottom: 1px solid var(--prs-gray-border);
}

.prs-history-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--prs-primary-light);
    color: var(--prs-primary-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.prs-history-head-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--prs-dark);
    margin: 0;
}

.prs-history-head-sub {
    font-size: 0.78rem;
    color: var(--prs-gray);
    margin: 0.1rem 0 0;
}

.prs-link-all {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--prs-primary-dark);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    margin-left: auto;
    padding: 0.4rem 0.85rem;
    background: var(--prs-primary-light);
    border-radius: 50rem;
    transition: all 0.2s;
    white-space: nowrap;
}

.prs-link-all:hover {
    background: var(--prs-primary);
    color: white;
    transform: translateX(2px);
}

.prs-history-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.prs-history-item {
    display: flex;
    align-items: center;
    gap: 0.95rem;
    padding: 0.95rem 1.15rem;
    border-radius: 16px;
    border: 1.5px solid var(--prs-gray-border);
    background: var(--prs-gray-light);
    transition: all 0.25s;
    animation: prsFadeIn 0.3s ease both;
}

.prs-history-item:hover {
    background: white;
    border-color: rgba(14, 165, 233, 0.4);
    box-shadow: 0 6px 18px rgba(0,0,0,0.04);
}

.prs-history-status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}
.prs-history-status-dot.approved { background: var(--prs-success); box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2); }
.prs-history-status-dot.pending  { background: var(--prs-warning); box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2); }
.prs-history-status-dot.rejected { background: var(--prs-danger); box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2); }

.prs-history-content {
    flex-grow: 1;
    min-width: 0;
}

.prs-history-title {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--prs-dark);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.prs-history-meta {
    font-size: 0.76rem;
    color: var(--prs-gray);
    margin-top: 0.2rem;
}

.prs-history-action {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    flex-shrink: 0;
}

.prs-badge {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 0.3rem 0.65rem;
    border-radius: 8px;
    letter-spacing: 0.02em;
    text-transform: uppercase;
}
.prs-badge-success { background: #d1fae5; color: #065f46; }
.prs-badge-warning { background: #fef3c7; color: #92400e; }
.prs-badge-danger  { background: #fee2e2; color: #991b1b; }

.prs-btn-download {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: var(--prs-primary-light);
    color: var(--prs-primary-deep);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.2s;
}
.prs-btn-download:hover {
    background: var(--prs-primary);
    color: white;
    transform: scale(1.08);
}

.prs-empty-box {
    text-align: center;
    padding: 2.5rem 1rem;
    color: var(--prs-gray);
}
.prs-empty-box i {
    font-size: 2.5rem;
    color: #cbd5e1;
    margin-bottom: 0.85rem;
    display: block;
}
.prs-empty-box p {
    font-size: 0.88rem;
    margin: 0;
}

@keyframes prsFadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: none; }
}
</style>