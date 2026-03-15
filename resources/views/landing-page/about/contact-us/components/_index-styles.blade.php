{{-- ── Hero Jumbotron shared styles ── --}}
@include('components.hero-jumbotron.styles')

@verbatim
<style>
    /* ================================================================
       CONTACT-US PAGE STYLES
       ================================================================ */

    :root {
        --primary:       #00a79d;
        --primary-dark:  #008b82;
        --primary-light: #e0f7f5;
        --dark:          #2c3e50;
        --gray:          #7f8c8d;
        --gray-100:      #f3f4f6;
        --gray-200:      #e5e7eb;
        --gray-300:      #d1d5db;
    }

    @keyframes navBubble {
        0%   { transform: translate(-50%, -50%) scale(1);   opacity: 0.5; }
        100% { transform: translate(-50%, -50%) scale(2.8); opacity: 0; }
    }

    /* ================================================================
       CONTACT-US SPECIFIC ADDITIONS
       ================================================================ */

    /* Hadith badge in mobile — no extra top margin; justify-content:center handles vertical centering */
    .cu-hadith-badge-m {
        margin-top: 0;
    }

    /* SweetAlert toast position below navbar */
    .toast-below-navbar {
        margin-top: 80px !important;
    }


    /* ------------------------------------------------
       SECTION COMMON
       ------------------------------------------------ */
    .cu-section-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        border: 1px solid rgba(0, 167, 157, 0.2);
        border-radius: 50px;
        padding: 0.45rem 1.1rem;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--primary);
    }

    .cu-badge-pulse {
        width: 7px;
        height: 7px;
        background: var(--primary);
        border-radius: 50%;
        animation: cuBadgePulse 2s ease-in-out infinite;
        flex-shrink: 0;
    }

    @keyframes cuBadgePulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.4; transform: scale(1.5); }
    }

    .cu-section-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--dark);
        line-height: 1.2;
        margin-bottom: 0.75rem;
    }

    .cu-section-sub {
        color: var(--gray);
        font-size: 1rem;
        line-height: 1.7;
        margin: 0;
    }


    /* ------------------------------------------------
       INFO CARDS
       ------------------------------------------------ */
    .cu-info-section { background: transparent; }

    .cu-info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }

    .cu-desktop-only { display: grid; }
    .cu-mobile-only  { display: none; }

    @media (max-width: 767.98px) {
        .cu-desktop-only { display: none !important; }
        .cu-mobile-only  { display: block; }
    }

    @media (min-width: 768px) and (max-width: 1199.98px) {
        .cu-info-grid { grid-template-columns: repeat(2, 1fr); }
    }

    .cu-info-card {
        position: relative;
        border-radius: 20px;
        padding: 1.75rem 1.5rem;
        min-height: 240px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1),
                    box-shadow 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: default;
    }

    .cu-mobile-card { cursor: pointer; }

    .cu-card--primary { background: linear-gradient(135deg, #00a79d 0%, #00c4b8 100%); color: white; }
    .cu-card--green   { background: linear-gradient(135deg, #00b894 0%, #00a79d 100%); color: white; }
    .cu-card--teal    { background: linear-gradient(135deg, #20c997 0%, #00a79d 100%); color: white; }
    .cu-card--info    { background: linear-gradient(135deg, #0dcaf0 0%, #17a2b8 100%); color: white; }

    .cu-info-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
    }

    /* Animated growing number bullet */
    .cu-card-num {
        position: absolute;
        bottom: -12px;
        right: -4px;
        font-size: 5rem;
        font-weight: 900;
        color: rgba(255, 255, 255, 0.12);
        line-height: 1;
        pointer-events: none;
        user-select: none;
        transition: transform 0.4s ease, color 0.4s ease;
    }

    .cu-info-card:hover .cu-card-num {
        transform: scale(1.18);
        color: rgba(255, 255, 255, 0.22);
    }

    .cu-card-icon {
        font-size: 2.25rem;
        margin-bottom: 0.75rem;
        display: block;
        transition: transform 0.3s ease;
    }

    .cu-info-card:hover .cu-card-icon { transform: scale(1.1) rotate(6deg); }

    .cu-card-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 0.625rem;
        color: rgba(255, 255, 255, 0.95);
    }

    .cu-card-value {
        font-size: 0.88rem;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.65;
        text-decoration: none;
        flex: 1;
        transition: color 0.3s ease;
        word-break: break-word;
    }

    a.cu-card-value:hover {
        color: white;
        text-decoration: underline;
    }

    p.cu-card-value { margin: 0; }

    .cu-card-sub {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.7);
        margin-top: 0.35rem;
        display: block;
    }

    .cu-socials {
        display: flex;
        flex-direction: column;
        gap: 0.45rem;
        flex: 1;
    }

    .cu-social-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        position: relative;
        padding-bottom: 1px;
    }

    .cu-social-link::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0;
        width: 0; height: 1px;
        background: white;
        transition: width 0.3s ease;
    }

    .cu-social-link:hover {
        color: white;
        transform: translateX(4px);
    }

    .cu-social-link:hover::after { width: 100%; }

    .cu-tap-hint {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        margin-top: auto;
        padding-top: 0.75rem;
        font-size: 0.72rem;
        color: rgba(255, 255, 255, 0.65);
        font-style: italic;
    }

    /* Mobile Owl Carousel */
    .cu-owl { padding-bottom: 0.5rem; }

    .cu-owl-dots {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 1rem;
    }

    .cu-owl-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(0, 167, 157, 0.25);
        border: none;
        padding: 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .cu-owl-dot.cu-dot-active {
        width: 22px;
        border-radius: 50px;
        background: var(--primary);
    }


    /* ------------------------------------------------
       MAP + FORM SECTION
       ------------------------------------------------ */
    .cu-map-form { background: transparent; }

    /* Location chips row */
    .cu-loc-row {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .cu-loc-chip {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        border: 1.5px solid rgba(0, 167, 157, 0.15);
        border-radius: 14px;
        padding: 0.75rem 1rem;
        flex: 1;
        min-width: 0;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        z-index: 1;
    }

    .cu-loc-chip:hover {
        border-color: rgba(0, 167, 157, 0.3);
        box-shadow: 0 6px 20px rgba(0, 167, 157, 0.1);
        transform: translateY(-2px);
    }

    .cu-loc-ico {
        font-size: 1.6rem;
        flex-shrink: 0;
        line-height: 1;
    }

    .cu-loc-chip > div {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .cu-loc-label {
        font-size: 0.68rem;
        color: var(--gray);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 1px;
    }

    .cu-loc-val {
        font-size: 0.83rem;
        font-weight: 600;
        color: var(--dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Map wrapper */
    .cu-map-wrap {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        height: 340px;
        transition: box-shadow 0.3s ease;
        position: relative;
    }

    .cu-map-wrap:hover { box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15); }

    .cu-map-wrap iframe {
        width: 100%;
        height: 100%;
        display: block;
    }

    /* Floating "Buka di Google Maps" button */
    .cu-map-open-btn {
        position: absolute;
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%);
        background: white;
        color: var(--primary);
        border: 1.5px solid rgba(0, 167, 157, 0.25);
        border-radius: 50px;
        padding: 0.45rem 1.2rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
        transition: all 0.3s ease;
        white-space: nowrap;
        z-index: 5;
    }

    .cu-map-open-btn:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: translateX(-50%) translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 167, 157, 0.3);
    }

    .cu-form-card {
        background: linear-gradient(135deg, rgba(0, 167, 157, 0.05) 0%, rgba(255, 255, 255, 0.8) 100%);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(0, 167, 157, 0.15);
        border-radius: 28px;
        padding: 2.5rem;
        box-shadow: 0 20px 60px rgba(0, 167, 157, 0.08);
        transform: translateX(30px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .cu-form-card:hover {
        border-color: rgba(0, 167, 157, 0.25);
        box-shadow: 0 25px 70px rgba(0, 167, 157, 0.12);
    }

    .cu-form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.25rem;
    }

    .cu-form-group { margin-bottom: 1.25rem; }
    .cu-form-row .cu-form-group { margin-bottom: 0; }

    .cu-form-label {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.9rem;
    }

    .cu-req { color: #ef4444; font-weight: 700; margin-left: 1px; }

    .cu-form-input,
    .cu-form-textarea {
        width: 100%;
        padding: 0.875rem 1.125rem;
        border: 2px solid rgba(0, 167, 157, 0.2);
        border-radius: 14px;
        font-size: 0.9rem;
        font-family: inherit;
        transition: all 0.4s ease;
        background: rgba(255, 255, 255, 0.9);
        color: var(--dark);
        box-sizing: border-box;
        display: block;
        -webkit-appearance: none;
        appearance: none;
    }

    .cu-form-input { height: 50px; }

    .cu-form-input:focus,
    .cu-form-textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(0, 167, 157, 0.1);
        background: white;
        transform: translateY(-2px);
    }

    .cu-form-input::placeholder,
    .cu-form-textarea::placeholder { color: rgba(0, 0, 0, 0.35); }

    .cu-form-textarea {
        resize: vertical;
        min-height: 130px;
        height: auto;
        line-height: 1.6;
    }

    .cu-form-error {
        display: none;
        color: #ef4444;
        font-size: 0.78rem;
        margin-top: 0.35rem;
        font-weight: 500;
    }

    .cu-form-input.cu-invalid,
    .cu-form-textarea.cu-invalid {
        border-color: #ef4444;
        background: rgba(239, 68, 68, 0.04);
    }

    .cu-form-input.cu-invalid:focus,
    .cu-form-textarea.cu-invalid:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        transform: none;
    }

    .cu-form-group.cu-has-error .cu-form-error { display: block; }

    .cu-form-input.cu-valid,
    .cu-form-textarea.cu-valid { border-color: #10b981; }

    .cu-form-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        width: 100%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 1rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.4s ease;
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.35);
        position: relative;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .cu-form-submit::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, #00d4c4 0%, var(--primary) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
        border-radius: 50px;
    }

    .cu-form-submit:hover::before { opacity: 1; }
    .cu-form-submit:hover  { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0, 167, 157, 0.45); }
    .cu-form-submit:active { transform: translateY(-1px); }
    .cu-form-submit > *    { position: relative; z-index: 1; }


    /* ------------------------------------------------
       BOTTOM SHEET (Mobile Card Detail)
       ------------------------------------------------ */
    .cu-bs-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 1040;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.35s ease;
    }

    .cu-bs-backdrop.cu-bs-open {
        opacity: 1;
        pointer-events: auto;
    }

    .cu-bottom-sheet {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        border-radius: 24px 24px 0 0;
        z-index: 1050;
        padding: 1.5rem 1.5rem 2.5rem;
        transform: translateY(100%);
        transition: transform 0.4s cubic-bezier(0.32, 0.72, 0, 1);
        max-height: 80vh;
        overflow-y: auto;
        overscroll-behavior: contain;
        will-change: transform;
    }

    .cu-bottom-sheet.cu-bs-open {
        transform: translateY(0);
    }

    .cu-bs-handle {
        width: 40px;
        height: 4px;
        background: var(--gray-300);
        border-radius: 2px;
        margin: 0 auto 1.25rem;
        cursor: grab;
    }

    .cu-bs-close {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--gray-100);
        border: none;
        color: var(--gray);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        z-index: 5;
    }

    .cu-bs-close:hover {
        background: var(--gray-200);
        color: var(--dark);
    }

    .cu-bs-content .cu-bs-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-right: 2.5rem;
    }

    .cu-bs-content .cu-bs-icon {
        font-size: 2.5rem;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        flex-shrink: 0;
    }

    .cu-bs-content .cu-bs-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    .cu-bs-content .cu-bs-body {
        font-size: 0.95rem;
        color: var(--dark);
        line-height: 1.7;
    }

    .cu-bs-content .cu-bs-social-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .cu-bs-content .cu-bs-social-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        background: var(--gray-100);
        border-radius: 12px;
        text-decoration: none;
        color: var(--dark);
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .cu-bs-content .cu-bs-social-item:hover {
        background: var(--primary-light);
        color: var(--primary);
        transform: translateX(4px);
    }

    .cu-bs-content .cu-bs-social-item i {
        width: 20px;
        text-align: center;
        font-size: 1.1rem;
    }

    .cu-bs-content .cu-bs-link-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.9rem;
        margin-top: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
    }

    .cu-bs-content .cu-bs-link-btn:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 167, 157, 0.4);
    }


    /* ------------------------------------------------
       UTILITIES
       ------------------------------------------------ */
    body.cu-no-scroll { overflow: hidden; }

    .back-to-top.cu-hide-btt {
        opacity: 0 !important;
        pointer-events: none !important;
        transform: translateY(10px) !important;
        transition: opacity 0.3s ease, transform 0.3s ease !important;
    }


    /* ------------------------------------------------
       RESPONSIVE — contact-us sections
       ------------------------------------------------ */
    @media (max-width: 991.98px) {
        .cu-section-title { font-size: 1.65rem; }
        .cu-form-row      { grid-template-columns: 1fr; }
        .cu-form-card     { padding: 1.75rem; }
        .cu-map-wrap      { height: 280px; }
    }

    @media (max-width: 767.98px) {
        .cu-section-title { font-size: 1.4rem; }
        .cu-section-sub   { font-size: 0.95rem; }
        .cu-form-card     { padding: 1.25rem; transform: translateX(0); }
        .cu-map-wrap      { height: 240px; }
        .cu-loc-row       { gap: 0.5rem; }
        .cu-loc-chip      { padding: 0.6rem 0.75rem; border-radius: 12px; }
        .cu-loc-ico       { font-size: 1.3rem; }
    }

/* ── Dark Mode ──────────────────────────────────────────── */
[data-theme="dark"] .cu-section-title { color: #e2e8f0; }
[data-theme="dark"] .cu-section-sub   { color: #9ca3af; }
[data-theme="dark"] .cu-loc-chip {
    background: #1a1f2e;
    border-color: rgba(0,167,157,.25);
    color: #e2e8f0;
}
[data-theme="dark"] .cu-loc-ico { filter: brightness(1.3); }
[data-theme="dark"] .cu-map-open-btn {
    background: #1e2535;
    border-color: rgba(0,167,157,.3);
    color: #e2e8f0;
}
[data-theme="dark"] .cu-form-input,
[data-theme="dark"] .cu-form-textarea {
    background: #1e2535;
    border-color: rgba(0,167,157,.25);
    color: #e2e8f0;
}
[data-theme="dark"] .cu-form-input:focus,
[data-theme="dark"] .cu-form-textarea:focus {
    background: #252b3b;
    border-color: #00a79d;
}
[data-theme="dark"] .cu-form-input::placeholder,
[data-theme="dark"] .cu-form-textarea::placeholder { color: rgba(226,232,240,.35); }
[data-theme="dark"] .cu-bottom-sheet {
    background: #1a1f2e;
    border-color: rgba(0,167,157,.25);
}
[data-theme="dark"] .cu-form-card {
    background: #1a1f2e;
    border-color: rgba(0,167,157,.2);
}
</style>
@endverbatim
