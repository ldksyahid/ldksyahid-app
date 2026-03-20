<style>
    /* ===== EMAIL VERIFIED POPUP ===== */
    .evp-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        z-index: 10060;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        animation: evpFadeIn 0.35s ease;
        transform: translateZ(0);
        will-change: transform;
    }

    @keyframes evpFadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @keyframes evpFadeOut {
        to { opacity: 0; }
    }

    .evp-box {
        position: relative;
        background: white;
        border-radius: 28px;
        padding: 2.5rem 2rem 1.75rem;
        max-width: 440px;
        width: 100%;
        text-align: center;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.16), 0 8px 30px rgba(0,167,157,0.14);

        animation: evpSlideIn 0.45s cubic-bezier(0.34, 1.56, 0.64, 1);
        overflow: hidden;
    }

    @keyframes evpSlideIn {
        from { opacity: 0; transform: translateY(40px) scale(0.92); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }


    /* Close */
    .evp-close {
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
        .evp-close:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: scale(1.1) rotate(90deg);
        }
    }

    /* Icon */
    .evp-icon-wrap {
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    .evp-icon {
        position: relative;
        z-index: 2;
        width: 80px; height: 80px;
        background: var(--primary-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        box-shadow: var(--shadow-primary);
        animation: evpCheckPop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.3s both;
    }

    @keyframes evpCheckPop {
        from { transform: scale(0) rotate(-30deg); }
        to   { transform: scale(1) rotate(0deg); }
    }

    .evp-ring {
        position: absolute;
        border-radius: 50%;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        border: 2px solid rgba(0,167,157,0.15);
        animation: evpRingPulse 3s ease-out infinite;
    }
    .evp-ring-1 { width: 110px; height: 110px; animation-delay: 0.2s; }
    .evp-ring-2 { width: 145px; height: 145px; animation-delay: 0.7s; }
    .evp-ring-3 { width: 180px; height: 180px; animation-delay: 1.2s; }

    @keyframes evpRingPulse {
        0%   { opacity: 0.8; transform: translate(-50%,-50%) scale(0.85); }
        100% { opacity: 0;   transform: translate(-50%,-50%) scale(1.1); }
    }

    /* Confetti */
    .evp-confetti {
        position: absolute;
        inset: 0;
        pointer-events: none;
        overflow: hidden;
    }
    .evp-confetti span {
        position: absolute;
        width: 8px; height: 8px;
        border-radius: 2px;
        animation: evpConfettiFall 2.5s ease-in both;
    }
    .evp-confetti span:nth-child(1)  { left:10%; top:-10%; background:#00a79d; animation-delay:0.4s; transform:rotate(20deg); }
    .evp-confetti span:nth-child(2)  { left:25%; top:-10%; background:#f59e0b; animation-delay:0.6s; border-radius:50%; width:6px; height:6px; }
    .evp-confetti span:nth-child(3)  { left:45%; top:-10%; background:#ec4899; animation-delay:0.2s; transform:rotate(-15deg); }
    .evp-confetti span:nth-child(4)  { left:65%; top:-10%; background:#48bb78; animation-delay:0.8s; border-radius:50%; width:10px; height:10px; }
    .evp-confetti span:nth-child(5)  { left:80%; top:-10%; background:#00a79d; animation-delay:0.5s; transform:rotate(40deg); }
    .evp-confetti span:nth-child(6)  { left:15%; top:-10%; background:#a78bfa; animation-delay:1s;  border-radius:50%; width:7px; height:7px; }
    .evp-confetti span:nth-child(7)  { left:55%; top:-10%; background:#f59e0b; animation-delay:0.3s; transform:rotate(-30deg); }
    .evp-confetti span:nth-child(8)  { left:90%; top:-10%; background:#ec4899; animation-delay:0.7s; border-radius:50%; }

    @keyframes evpConfettiFall {
        from { transform: translateY(0) rotate(0deg); opacity: 1; }
        to   { transform: translateY(380px) rotate(360deg); opacity: 0; }
    }

    /* Text */
    .evp-title {
        font-family: var(--font-primary);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .evp-subtitle {
        color: var(--secondary);
        font-size: 0.88rem;
        line-height: 1.65;
        margin-bottom: 1.5rem;
    }

    /* Features */
    .evp-features {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }

    .evp-feature {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        background: var(--primary-light);
        border: 1px solid rgba(0,167,157,0.15);
        border-radius: 50px;
        padding: 0.35rem 0.85rem;
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--primary-dark, #007a72);
    }

    .evp-feature-icon { font-size: 0.9rem; }

    /* CTA Button */
    .evp-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.75rem 2rem;
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: var(--shadow-primary);
        transition: var(--transition-bounce);
        position: relative;
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .evp-btn-shine {
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
        transition: left 0.6s ease;
    }

    @media (hover: hover) {
        .evp-btn:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 12px 28px rgba(0,167,157,0.3);
        }
        .evp-btn:hover .evp-btn-shine { left: 100%; }
    }


    /* Responsive */
    @media (max-width: 575.98px) {
        .evp-box { padding: 2rem 1.25rem 1.5rem; border-radius: 22px; }
        .evp-title { font-size: 1.3rem; }
        .evp-icon { width: 68px; height: 68px; font-size: 1.7rem; }
    }

    /* ── Dark Mode ── */
    [data-theme="dark"] .evp-box { background: #1a1f2e; }
    [data-theme="dark"] .evp-title { color: #e2e8f0; }
    [data-theme="dark"] .evp-subtitle { color: #9ca3af; }
    [data-theme="dark"] .evp-close { background: #252b3b; color: #9ca3af; }
    [data-theme="dark"] .evp-close:hover { background: rgba(0,167,157,.15); color: #4dd9cf; }
    [data-theme="dark"] .evp-feature { background: rgba(0,167,157,.1); border-color: rgba(0,167,157,.25); color: #4dd9cf; }
</style>
