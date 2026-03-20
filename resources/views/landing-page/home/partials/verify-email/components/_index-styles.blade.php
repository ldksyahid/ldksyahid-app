<style>
    /* ===== VERIFY EMAIL POPUP MODAL ===== */
    .vepm-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.55);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        z-index: 10050;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        animation: vepmFadeIn 0.35s ease;
        transform: translateZ(0);
        will-change: transform;
    }

    @keyframes vepmFadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    .vepm-box {
        position: relative;
        background: white;
        border-radius: 28px;
        padding: 2.5rem 2rem 2rem;
        max-width: 540px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        text-align: center;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.18), 0 8px 30px rgba(0,167,157,0.12);
        border: 1px solid rgba(0,167,157,0.1);
        animation: vepmSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        scrollbar-width: thin;
        scrollbar-color: rgba(0,167,157,0.2) transparent;
    }

    .vepm-box::before {
        content: '';
        position: absolute;
        top: 0; left: 10%; right: 10%;
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, rgba(0,167,157,0.4) 30%, rgba(0,167,157,0.4) 70%, transparent 100%);
        filter: blur(1px);
    }

    @keyframes vepmSlideIn {
        from { opacity: 0; transform: translateY(40px) scale(0.94); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Close */
    .vepm-close {
        position: absolute;
        top: 1rem; right: 1rem;
        width: 34px; height: 34px;
        background: #f5f5f5;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--secondary);
        font-size: 0.85rem;
        transition: var(--transition-bounce);
        z-index: 10;
    }

    @media (hover: hover) {
        .vepm-close:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: scale(1.1) rotate(90deg);
        }
    }

    /* Badge */
    .vepm-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        border: 1px solid rgba(0,167,157,0.2);
        border-radius: 50px;
        padding: 0.4rem 1.1rem;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--primary);
    }

    .vepm-pulse {
        width: 7px; height: 7px;
        background: var(--primary);
        border-radius: 50%;
        animation: badgePulse 2s ease-in-out infinite;
    }

    /* Icon */
    .vepm-icon-wrap {
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    .vepm-icon {
        width: 80px; height: 80px;
        background: var(--primary-gradient);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        box-shadow: var(--shadow-primary);
        position: relative;
        z-index: 2;
        animation: veIconBounce 3s ease-in-out infinite;
    }

    .vepm-ring {
        position: absolute;
        border-radius: 50%;
        border: 2px solid rgba(0,167,157,0.12);
        top: 50%; left: 50%;
        animation: veRingExpand 3s ease-out infinite;
    }
    .vepm-ring-1 { width: 120px; height: 120px; animation-delay: 0s; }
    .vepm-ring-2 { width: 155px; height: 155px; animation-delay: 0.9s; }

    /* Orbit dots */
    .vepm-icon-orbit {
        position: absolute;
        inset: -20px;
        animation: orbitSpin 14s linear infinite;
        z-index: 3;
    }
    .vepm-orbit-dot {
        position: absolute;
        font-size: 0.9rem;
        animation: orbitDotPulse 3s ease-in-out infinite;
        animation-delay: var(--d);
    }
    .vepm-orbit-dot:nth-child(1) { top: 0; left: 50%; transform: translateX(-50%); }
    .vepm-orbit-dot:nth-child(2) { bottom: 4px; left: 0; }
    .vepm-orbit-dot:nth-child(3) { bottom: 4px; right: 0; }

    /* Text */
    .vepm-title {
        font-family: var(--font-primary);
        font-size: 1.45rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.4rem;
    }

    .vepm-subtitle {
        color: var(--secondary);
        font-size: 0.9rem;
        margin-bottom: 0.65rem;
    }

    .vepm-email-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        background: var(--primary-light);
        border: 1px solid rgba(0,167,157,0.2);
        border-radius: 50px;
        padding: 0.45rem 1.1rem;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.88rem;
        margin-bottom: 0.6rem;
        word-break: break-all;
    }
    .vepm-email-chip i { color: var(--primary); font-size: 0.8rem; }

    .vepm-hint {
        color: var(--secondary);
        font-size: 0.85rem;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    /* Steps */
    .vepm-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .vepm-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.35rem;
    }
    .vepm-step-icon {
        width: 46px; height: 46px;
        background: var(--primary-light);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        border: 1px solid rgba(0,167,157,0.12);
        transition: var(--transition-bounce);
    }
    .vepm-step:hover .vepm-step-icon {
        transform: translateY(-4px);
        box-shadow: 0 6px 16px rgba(0,167,157,0.14);
    }
    .vepm-step span {
        font-size: 0.68rem;
        font-weight: 600;
        color: var(--secondary);
    }
    .vepm-step-arrow {
        color: rgba(0,167,157,0.35);
        font-size: 0.75rem;
        margin-top: -12px;
    }

    /* Divider */
    .vepm-divider {
        width: 100%; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(0,167,157,0.15), transparent);
        margin: 0 0 1.25rem;
    }

    /* Resend */
    .vepm-resend-label {
        color: var(--secondary);
        font-size: 0.85rem;
        margin-bottom: 0.65rem;
    }

    .vepm-resend-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.7rem 1.75rem;
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 0.92rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: var(--shadow-primary);
        transition: var(--transition-bounce);
        position: relative;
        overflow: hidden;
    }

    .vepm-btn-icon {
        width: 26px; height: 26px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        transition: var(--transition);
    }

    .vepm-btn-shine {
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s ease;
    }

    @media (hover: hover) {
        .vepm-resend-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 28px rgba(0,167,157,0.3);
        }
        .vepm-resend-btn:hover .vepm-btn-icon { transform: rotate(-20deg) scale(1.1); }
        .vepm-resend-btn:hover .vepm-btn-shine { left: 100%; }
    }

    /* Success */
    .vepm-success {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        background: linear-gradient(135deg, #e8fdf5, #d0faf0);
        border: 1px solid rgba(0,167,157,0.2);
        border-radius: 12px;
        padding: 0.85rem 1rem;
        margin-top: 1rem;
        text-align: left;
        font-size: 0.85rem;
        color: var(--dark);
        animation: veSuccessIn 0.4s cubic-bezier(0.4,0,0.2,1);
    }
    .vepm-success span { font-size: 1.4rem; flex-shrink: 0; }

    /* Note */
    .vepm-note {
        display: flex;
        align-items: flex-start;
        gap: 0.45rem;
        margin-top: 1.25rem;
        padding: 0.75rem 0.9rem;
        background: #f8f9fa;
        border-radius: 10px;
        font-size: 0.77rem;
        color: var(--secondary);
        text-align: left;
        line-height: 1.5;
    }
    .vepm-note i { color: var(--primary); margin-top: 2px; flex-shrink: 0; }

    /* Message Alert */
    .vepm-message {
        margin-top: 1rem;
        padding: 0.85rem 1rem;
        border-radius: 12px;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.65rem;
        animation: veSuccessIn 0.4s cubic-bezier(0.4,0,0.2,1);
        text-align: left;
    }
    .vepm-message.success {
        background: linear-gradient(135deg, #e8fdf5, #d0faf0);
        border: 1px solid rgba(0,167,157,0.2);
        color: var(--dark);
    }
    .vepm-message.error {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        border: 1px solid rgba(239,68,68,0.2);
        color: #991b1b;
    }
    .vepm-message-icon {
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    /* Responsive */
    @media (max-width: 575.98px) {
        .vepm-box { padding: 2rem 1.25rem 1.75rem; border-radius: 22px; }
        .vepm-title { font-size: 1.25rem; }
        .vepm-icon { width: 68px; height: 68px; font-size: 1.7rem; }
        .vepm-steps { gap: 0.4rem; }
        .vepm-step-icon { width: 40px; height: 40px; font-size: 1.15rem; }
        .vepm-ring-1 { width: 65px; height: 65px; animation-delay: 0s; }
        .vepm-ring-2 { width: 100px; height: 100px; animation-delay: 0.9s; }
    }

    /* ── Dark Mode ── */
    [data-theme="dark"] .vepm-box { background: #1a1f2e; }
    [data-theme="dark"] .vepm-title { color: #e2e8f0; }
    [data-theme="dark"] .vepm-desc { color: #9ca3af; }
    [data-theme="dark"] .vepm-step-label { color: #9ca3af; }
    [data-theme="dark"] .vepm-email-chip { background: #252b3b; color: #4dd9cf; border-color: rgba(0,167,157,.3); }
    [data-theme="dark"] .vepm-note { background: #1e2d2c; color: #9ca3af; border-color: rgba(0,167,157,.2); }
    [data-theme="dark"] .vepm-close { background: #252b3b; color: #9ca3af; }
    [data-theme="dark"] .vepm-close:hover { background: rgba(0,167,157,.15); color: #4dd9cf; }
</style>

<style>
    /* Suppress back-to-top while modal is visible */
    .back-to-top.vepm-suppressed {
        opacity: 0 !important;
        visibility: hidden !important;
        transform: translateY(8px) scale(0.85) !important;
        transition: opacity 0.35s ease, visibility 0.35s ease, transform 0.35s ease !important;
        pointer-events: none !important;
    }
    @keyframes vepmFadeOut { to { opacity: 0; } }

    @keyframes veSuccessIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
