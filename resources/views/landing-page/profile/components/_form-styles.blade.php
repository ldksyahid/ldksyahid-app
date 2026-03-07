@verbatim
<style>
/* ============================================================
   PRF — Profile Form Styles (create & update)
   prefix: prf-
   ============================================================ */

/* --- Section Shell --- */
.prf-form-section {
    padding: 6.5rem 0 5rem;
    min-height: 100vh;
    background: transparent;
    position: relative;
}

/* --- Two-col layout --- */
.prf-form-layout {
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 3rem;
    align-items: start;
    max-width: 1020px;
    margin: 0 auto;
    padding: 0 1.5rem;
}

/* ============================================================
   LEFT DECORATIVE COLUMN
   ============================================================ */
.prf-form-deco {
    position: sticky;
    top: 7rem;
}

.prf-form-deco-label {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #00b8ad;
    margin-bottom: 0.5rem;
}

.prf-form-deco-title {
    font-size: 2rem;
    font-weight: 800;
    color: #0d3d3c;
    line-height: 1.15;
    margin-bottom: 0;
}

.prf-form-deco-bar {
    width: 48px;
    height: 4px;
    background: linear-gradient(90deg, #00b8ad 0%, #006D6D 100%);
    border-radius: 50rem;
    margin: 1.1rem 0 1.5rem;
}

.prf-form-deco-quote {
    background: linear-gradient(135deg, #f2fbfa 0%, #e8f8f6 100%);
    border-radius: 20px;
    padding: 1.5rem 1.75rem;
    position: relative;
    z-index: 1;
    overflow: hidden;
}

.prf-form-deco-quote::before {
    content: '\201C';
    position: absolute;
    top: -10px;
    left: 12px;
    font-size: 6rem;
    line-height: 1;
    color: rgba(0, 184, 173, 0.12);
    font-family: Georgia, serif;
    pointer-events: none;
}

.prf-form-deco-quote p {
    font-size: 0.88rem;
    line-height: 1.8;
    color: #374151;
    text-align: justify;
    margin-bottom: 0.85rem;
    position: relative;
    z-index: 1;
}

.prf-form-deco-quote span {
    font-size: 0.75rem;
    font-weight: 700;
    color: #00b8ad;
    display: block;
    text-align: right;
    position: relative;
    z-index: 1;
}

/* Mobile-only title (inside form card) */
.prf-mobile-form-title {
    display: none;
    margin-bottom: 1.75rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
}

/* ============================================================
   FORM CARD
   ============================================================ */
.prf-form-card {
    background: #fff;
    border-radius: 24px;
    padding: 2.25rem 2.5rem;
    box-shadow: 0 10px 40px rgba(0, 120, 116, 0.1);
    position: relative;
    z-index: 1;
}

/* --- Section titles within form --- */
.prf-form-group-title {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #00b8ad;
    margin-bottom: 0.85rem;
    margin-top: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.prf-form-group-title:first-child {
    margin-top: 0;
}

/* --- Fields Grid --- */
.prf-fields-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.85rem;
    margin-bottom: 0.25rem;
}

.prf-fields-grid .prf-field--full {
    grid-column: 1 / -1;
}

/* --- Input Fields --- */
.prf-field {
    position: relative;
}

.prf-field .form-floating > .form-control {
    border-radius: 14px;
    background: #f6f8fa;
    border: 2px solid transparent;
    padding: 0.85rem 1rem 0.35rem;
    font-size: 0.875rem;
    color: #1f2937;
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    height: auto;
    min-height: 3.25rem;
}

.prf-field .form-floating > .form-control:focus {
    border-color: #00b8ad;
    box-shadow: 0 0 0 4px rgba(0, 184, 173, 0.1);
    background: #fff;
    outline: none;
}

.prf-field .form-floating > .form-control:disabled {
    background: #f0f0f0;
    color: #9ca3af;
    cursor: not-allowed;
    border-color: transparent;
}

.prf-field .form-floating > label {
    font-size: 0.8rem;
    color: #9ca3af;
    padding: 0.9rem 1rem;
}

.prf-field .form-floating > .form-control:focus ~ label,
.prf-field .form-floating > .form-control:not(:placeholder-shown) ~ label {
    color: #00b8ad;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

/* Textarea */
.prf-field .form-floating > textarea.form-control {
    border-radius: 16px;
    min-height: 100px;
    resize: vertical;
    padding-top: 1.25rem;
}

/* File Input — custom label style, native input hidden */
.prf-file-wrap {
    margin-bottom: 0.25rem;
}

/* Hide native input, label handles click */
.prf-file-input {
    position: absolute;
    width: 0;
    height: 0;
    opacity: 0;
    pointer-events: none;
}

/* Styled clickable label */
.prf-file-label {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    padding: 0.75rem 1rem 0.75rem 0.75rem;
    background: #f6f8fa;
    border-radius: 14px;
    border: 2px dashed #d1d5db;
    cursor: pointer;
    transition: border-color 0.22s ease, background 0.22s ease;
    overflow: hidden;
    width: 100%;
}

.prf-file-label:hover {
    border-color: #00b8ad;
    background: #f2fbfa;
}

/* Teal icon box */
.prf-file-icon {
    width: 38px;
    height: 38px;
    min-width: 38px;
    background: linear-gradient(135deg, #00b8ad 0%, #006D6D 100%);
    color: #fff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    flex-shrink: 0;
}

/* "Pilih Foto" text */
.prf-file-btn-text {
    font-size: 0.8rem;
    font-weight: 700;
    color: #00b8ad;
    white-space: nowrap;
    flex-shrink: 0;
}

/* Separator */
.prf-file-sep {
    color: #d1d5db;
    font-size: 1.1rem;
    font-weight: 300;
    flex-shrink: 0;
}

/* Filename display */
.prf-file-name-display {
    font-size: 0.78rem;
    color: #9ca3af;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    flex: 1;
}

.prf-file-name-display--set {
    color: #059669;
}

.prf-file-hint {
    font-size: 0.7rem;
    color: #9ca3af;
    margin-top: 0.4rem;
    margin-left: 0.25rem;
}

/* --- Form Action Buttons --- */
.prf-form-actions {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 0.85rem;
    margin-top: 2rem;
}

/* Base button */
.prf-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.85rem 1.25rem;
    border-radius: 50rem;
    font-size: 0.875rem;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    white-space: nowrap;
    line-height: 1;
}

.prf-btn:hover {
    transform: translateY(-3px);
    text-decoration: none;
}

.prf-btn-back {
    background: #f3f4f6;
    color: #374151;
}
.prf-btn-back:hover {
    background: #e5e7eb;
    color: #111827;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.09);
}

.prf-btn-submit {
    background: linear-gradient(135deg, #00b8ad 0%, #006D6D 100%);
    color: #fff;
    box-shadow: 0 4px 16px rgba(0, 184, 173, 0.28);
}
.prf-btn-submit:hover {
    box-shadow: 0 10px 28px rgba(0, 184, 173, 0.38);
    color: #fff;
}

/* Bootstrap validation feedback */
.prf-field .invalid-feedback {
    font-size: 0.75rem;
    padding-left: 0.5rem;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */

/* --- Tablet --- */
@media (max-width: 991.98px) {
    .prf-form-section {
        padding: 5.5rem 0 4rem;
    }

    .prf-form-layout {
        grid-template-columns: 1fr 1.5fr;
        gap: 2rem;
    }

    .prf-form-deco-title {
        font-size: 1.65rem;
    }

    .prf-form-card {
        padding: 1.75rem 2rem;
    }
}

/* --- Mobile --- */
@media (max-width: 767.98px) {
    .prf-form-section {
        padding: 4.5rem 0 3.5rem;
    }

    .prf-form-layout {
        grid-template-columns: 1fr;
        padding: 0 1rem;
    }

    .prf-form-deco {
        display: none;
    }

    .prf-mobile-form-title {
        display: block;
    }

    .prf-form-card {
        padding: 1.5rem 1.25rem;
    }

    .prf-fields-grid {
        grid-template-columns: 1fr;
    }

    .prf-field--full {
        grid-column: auto;
    }

    .prf-form-actions {
        grid-template-columns: 1fr;
    }
}
</style>
@endverbatim
