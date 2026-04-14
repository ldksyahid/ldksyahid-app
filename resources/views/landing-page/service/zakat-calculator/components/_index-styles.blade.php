{{-- FILE: resources/views/landing-page/service/zakat-calculator/components/_index-styles.blade.php --}}
<style>
    /* ==========================================================
       1. MAIN LAYOUT
       ========================================================== */
    #zakat-calculator {
        padding-top: 6rem;
        padding-bottom: 5rem;
        min-height: 100vh;
        position: relative;
        z-index: 1;
    }

    /* ==========================================================
       2. BADGE HARGA EMAS
       ========================================================== */
    .sl-gold-badge {
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
        margin-bottom: 1.5rem;
    }
    .sl-gold-badge-pulse {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #00a79d;
        animation: slBadgePulse 2s infinite;
    }
    @keyframes slBadgePulse {
        0%, 100% { transform: scale(1);   opacity: 1; }
        50%       { transform: scale(1.5); opacity: .5; }
    }

    /* ==========================================================
       3. SECTION TITLE / SUB
       ========================================================== */
    .sl-zakat-title {
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        font-weight: 700;
        color: #1a1a2e;
        line-height: 1.2;
    }
    .sl-zakat-sub {
        color: #64748b;
        max-width: 560px;
        margin: .75rem auto 0;
        font-size: .95rem;
        line-height: 1.7;
    }

    /* ==========================================================
       4. KARTU
       ========================================================== */
    .sl-zakat-card {
        background: linear-gradient(135deg, rgba(0,167,157,.05) 0%, rgba(255,255,255,.8) 100%);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(0, 167, 157, .15);
        border-radius: 28px;
        padding: 2.5rem;
        box-shadow: 0 20px 60px rgba(0, 167, 157, .08);
        transition: border-color .3s, box-shadow .3s;
    }
    .sl-zakat-card:hover {
        border-color: rgba(0, 167, 157, .25);
        box-shadow: 0 25px 70px rgba(0, 167, 157, .12);
    }
    .sl-zakat-card.sl-warning {
        background: #fffbeb;
        border: 1px solid #fde68a;
        box-shadow: none;
    }
    .sl-zakat-card.sl-warning:hover {
        border-color: #fbbf24;
        box-shadow: none;
    }

    /* ==========================================================
       5. TYPE PILLS
       ========================================================== */
    .sl-pill-wrap {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 10px;
        margin-bottom: 25px;
    }
    .sl-pill {
        padding: 10px 20px;
        background: rgba(0, 167, 157, .06);
        border: 1px solid rgba(0, 167, 157, .14);
        border-radius: 12px;
        cursor: pointer;
        white-space: nowrap;
        font-weight: 600;
        color: #475569;
        transition: all 0.3s;
        user-select: none;
    }
    .sl-pill.active {
        background: #00a79d;
        border-color: #00a79d;
        color: #ffffff;
    }

    /* ==========================================================
       6. FORM LABEL
       ========================================================== */
    .sl-zakat-label {
        display: flex;
        align-items: center;
        gap: .4rem;
        margin-bottom: .5rem;
        font-weight: 600;
        color: #2c3e50;
        font-size: .9rem;
    }

    /* ==========================================================
       7. INPUT
       ========================================================== */
    .sl-zakat-input {
        width: 100%;
        height: 50px;
        padding: .875rem 1.125rem;
        border: 2px solid rgba(0, 167, 157, .2);
        border-radius: 14px;
        background: rgba(255, 255, 255, .9);
        color: #2c3e50;
        font-family: inherit;
        font-size: .9rem;
        font-weight: 600;
        transition: border-color .3s, box-shadow .3s, transform .3s, background .3s;
        outline: none;
        box-sizing: border-box;
        display: block;
    }
    .sl-zakat-input:focus {
        border-color: #00a79d;
        box-shadow: 0 0 0 4px rgba(0, 167, 157, .1);
        background: #fff;
        transform: translateY(-2px);
    }
    .sl-zakat-input::placeholder { color: rgba(0,0,0,.35); }

    .sl-input-prefix {
        height: 50px;
        padding: .875rem 1.125rem;
        border: 2px solid rgba(0, 167, 157, .2);
        border-right: none;
        border-radius: 14px 0 0 14px;
        background: rgba(0, 167, 157, .05);
        color: #007a73;
        font-weight: 700;
        display: flex;
        align-items: center;
        font-size: .9rem;
        flex-shrink: 0;
    }
    .sl-input-with-prefix  { border-radius: 0 14px 14px 0 !important; }

    /* Saat mode emas — prefix disembunyikan */
    .sl-input-prefix.hidden { display: none; }
    .sl-zakat-input.no-prefix { border-radius: 14px !important; }

    /* ==========================================================
       8. HINT TEXT
       ========================================================== */
    .sl-zakat-hint {
        font-size: .72rem;
        color: #94a3b8;
        margin-top: .3rem;
        line-height: 1.4;
    }

    /* ==========================================================
       9. RESULT BOX
       ========================================================== */
    .sl-res-box {
        margin-top: 30px;
        padding: 25px;
        border-radius: 20px;
        text-align: center;
        background: rgba(0, 167, 157, .05);
        border: 2px dashed #00a79d;
        display: none;
    }
    .sl-res-amount {
        font-size: 2.5rem;
        font-weight: 800;
        color: #00a79d;
    }

    /* ==========================================================
       10. ACCORDION
       ========================================================== */
    .sl-accordion .accordion-item {
        border: 1px solid rgba(0, 167, 157, .14);
        border-radius: 16px !important;
        margin-bottom: 10px;
        overflow: hidden;
        background: transparent;
    }
    .sl-accordion .accordion-button {
        font-weight: 600;
        box-shadow: none !important;
        background: transparent;
        color: #2c3e50;
        padding: 1rem 1.25rem;
    }
    .sl-accordion .accordion-button:not(.collapsed) {
        color: #00a79d;
        background: rgba(0, 167, 157, .05);
    }
    .sl-accordion .accordion-body {
        font-size: .82rem;
        color: #475569;
        line-height: 1.6;
    }

    /* ==========================================================
       11. DARK MODE
       ========================================================== */
    [data-theme="dark"] #zakat-calculator { background-color: transparent; }

    [data-theme="dark"] .sl-gold-badge {
        background: rgba(0,167,157,.1);
        border-color: rgba(0,167,157,.25);
        color: #4ade80;
    }
    [data-theme="dark"] .sl-zakat-title { color: #e2e8f0; }
    [data-theme="dark"] .sl-zakat-sub   { color: #9ca3af; }

    [data-theme="dark"] .sl-zakat-card {
        background: linear-gradient(135deg, rgba(0,167,157,.08) 0%, rgba(26,29,36,.9) 100%);
        border-color: rgba(0,167,157,.2);
        box-shadow: 0 10px 40px rgba(0,0,0,.4);
        color: #e4e6eb;
    }
    [data-theme="dark"] .sl-zakat-card.sl-warning {
        background: rgba(245,158,11,.05);
        border-color: rgba(245,158,11,.2);
    }

    [data-theme="dark"] .sl-pill {
        background: rgba(0,167,157,.06);
        border-color: rgba(0,167,157,.18);
        color: #9ca3af;
    }
    [data-theme="dark"] .sl-pill.active { background: #00a79d; color: #fff; }

    [data-theme="dark"] .sl-zakat-label { color: #cbd5e0; }

    [data-theme="dark"] .sl-zakat-input {
        background: #1e2535;
        border-color: rgba(0,167,157,.25);
        color: #e2e8f0;
    }
    [data-theme="dark"] .sl-zakat-input:focus {
        background: #252b3b;
        border-color: #00a79d;
    }
    [data-theme="dark"] .sl-zakat-input::placeholder { color: rgba(226,232,240,.35); }
    [data-theme="dark"] .sl-input-prefix {
        background: rgba(0,167,157,.1);
        border-color: rgba(0,167,157,.25);
        color: #4ade80;
    }

    [data-theme="dark"] .sl-zakat-hint  { color: #9ca3af; }
    [data-theme="dark"] .sl-res-box     { background: rgba(0,167,157,.1); }

    [data-theme="dark"] .sl-accordion .accordion-item  { border-color: rgba(0,167,157,.2); }
    [data-theme="dark"] .sl-accordion .accordion-button {
        background-color: #1a1d24;
        color: #e4e6eb;
    }
    [data-theme="dark"] .sl-accordion .accordion-button:not(.collapsed) {
        background-color: rgba(0,167,157,.1);
        color: #4ade80;
    }
    [data-theme="dark"] .sl-accordion .accordion-body { color: #9ca3af; }
</style>