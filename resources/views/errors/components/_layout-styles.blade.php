<style>
    :root {
        --err-primary: #00a79d;
        --err-primary-dark: #008f86;
        --err-primary-light: #e0f7f5;
        --err-primary-glow: rgba(0, 167, 157, 0.15);
        --err-accent: #f59e0b;
        --err-accent-pink: #ec4899;
        --err-bg: #f0faf9;
        --err-text: #1a2332;
        --err-muted: #6b7280;
    }

    body {
        font-family: 'Inter', sans-serif !important;
        background: var(--err-bg) !important;
        height: 100vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        margin: 0;
    }

    /* ========== Animated Background ========== */
    .error-scene {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 0;
        overflow: hidden;
    }

    /* Gradient mesh */
    .error-scene::before {
        content: '';
        position: absolute;
        width: 150%;
        height: 150%;
        top: -25%;
        left: -25%;
        background:
            radial-gradient(ellipse at 20% 50%, rgba(0, 167, 157, 0.08) 0%, transparent 50%),
            radial-gradient(ellipse at 80% 20%, rgba(245, 158, 11, 0.06) 0%, transparent 50%),
            radial-gradient(ellipse at 60% 80%, rgba(236, 72, 153, 0.05) 0%, transparent 50%);
        animation: meshDrift 20s ease-in-out infinite;
    }

    @keyframes meshDrift {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(2%, -2%) rotate(1deg); }
        66% { transform: translate(-2%, 1%) rotate(-1deg); }
    }

    /* Floating blobs */
    .blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(40px);
        opacity: 0.07;
    }

    .blob-1 {
        width: 350px; height: 350px;
        background: var(--err-primary);
        top: -80px; right: -60px;
        animation: blobMove1 12s ease-in-out infinite;
    }

    .blob-2 {
        width: 280px; height: 280px;
        background: var(--err-accent);
        bottom: -60px; left: -40px;
        animation: blobMove2 15s ease-in-out infinite;
    }

    .blob-3 {
        width: 200px; height: 200px;
        background: var(--err-accent-pink);
        top: 40%; left: 60%;
        animation: blobMove3 18s ease-in-out infinite;
    }

    @keyframes blobMove1 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(-30px, 20px) scale(1.1); }
        50% { transform: translate(10px, 40px) scale(0.95); }
        75% { transform: translate(-20px, -10px) scale(1.05); }
    }

    @keyframes blobMove2 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(20px, -30px) scale(1.08); }
        50% { transform: translate(-10px, -20px) scale(0.92); }
        75% { transform: translate(30px, 10px) scale(1.05); }
    }

    @keyframes blobMove3 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(-40px, 20px) scale(1.15); }
        66% { transform: translate(20px, -30px) scale(0.9); }
    }

    /* Floating particles */
    .particle {
        position: absolute;
        border-radius: 50%;
        opacity: 0;
        animation: particleFloat linear infinite;
    }

    .particle-1 { width: 6px; height: 6px; background: var(--err-primary); left: 10%; animation-duration: 8s; animation-delay: 0s; }
    .particle-2 { width: 4px; height: 4px; background: var(--err-accent); left: 25%; animation-duration: 12s; animation-delay: 2s; }
    .particle-3 { width: 5px; height: 5px; background: var(--err-accent-pink); left: 45%; animation-duration: 10s; animation-delay: 4s; }
    .particle-4 { width: 3px; height: 3px; background: var(--err-primary); left: 65%; animation-duration: 9s; animation-delay: 1s; }
    .particle-5 { width: 5px; height: 5px; background: var(--err-accent); left: 80%; animation-duration: 11s; animation-delay: 3s; }
    .particle-6 { width: 4px; height: 4px; background: var(--err-accent-pink); left: 90%; animation-duration: 13s; animation-delay: 5s; }

    @keyframes particleFloat {
        0% { bottom: -10px; opacity: 0; transform: translateX(0); }
        10% { opacity: 0.4; }
        90% { opacity: 0.4; }
        100% { bottom: 110%; opacity: 0; transform: translateX(30px); }
    }

    /* Floating icons in background */
    .bg-icon {
        position: absolute;
        font-size: 1.2rem;
        opacity: 0.06;
        color: var(--err-primary);
        animation: iconDrift 20s ease-in-out infinite;
    }

    .bg-icon-1 { top: 15%; left: 8%; animation-delay: 0s; }
    .bg-icon-2 { top: 25%; right: 12%; animation-delay: -3s; color: var(--err-accent); }
    .bg-icon-3 { bottom: 30%; left: 15%; animation-delay: -7s; color: var(--err-accent-pink); }
    .bg-icon-4 { bottom: 20%; right: 8%; animation-delay: -11s; }
    .bg-icon-5 { top: 60%; left: 5%; animation-delay: -5s; color: var(--err-accent); }

    @keyframes iconDrift {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        25% { transform: translateY(-15px) rotate(5deg); }
        50% { transform: translateY(5px) rotate(-3deg); }
        75% { transform: translateY(-8px) rotate(2deg); }
    }

    /* ========== Navbar ========== */
    .error-navbar {
        padding: 0.75rem 2rem;
        position: relative;
        z-index: 2;
        flex-shrink: 0;
    }

    .error-navbar a {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none !important;
        transition: transform 0.3s ease;
    }

    .error-navbar a:hover { transform: scale(1.03); }

    .error-navbar img {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 167, 157, 0.15);
    }

    .error-navbar .brand-name {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--err-text);
    }

    .error-navbar .brand-tagline {
        font-size: 0.72rem;
        color: var(--err-muted);
        display: block;
        letter-spacing: 0.02em;
    }

    /* ========== Main Content ========== */
    .error-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 1;
        padding: 0.5rem 1rem;
        min-height: 0;
    }

    /* Gradient border wrapper */
    .error-card-glow {
        max-width: 520px;
        width: 100%;
        padding: 2px;
        border-radius: 30px;
        background: linear-gradient(135deg, var(--err-primary), var(--err-accent), var(--err-accent-pink), var(--err-primary));
        background-size: 300% 300%;
        animation: cardAppear 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards, glowBorder 6s ease infinite;
        opacity: 0;
        transform: translateY(30px);
        box-shadow:
            0 25px 70px rgba(0, 167, 157, 0.1),
            0 8px 30px rgba(0, 0, 0, 0.04);
    }

    @keyframes glowBorder {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .error-card {
        background: #fff;
        border-radius: 28px;
        padding: 2rem 2.5rem 1.75rem;
        width: 100%;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    @keyframes cardAppear {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Shimmer effect */
    .error-card::after {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 60%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        animation: shimmer 5s ease-in-out infinite;
        pointer-events: none;
    }

    @keyframes shimmer {
        0%, 100% { left: -100%; }
        50% { left: 150%; }
    }

    /* ========== Icon ========== */
    .error-icon-wrap {
        width: 100px;
        height: 100px;
        margin: 0 auto 1rem;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .error-icon-bg {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--err-primary-light), rgba(0, 167, 157, 0.05));
        animation: iconBreathe 4s ease-in-out infinite;
    }

    .error-icon-bg::before {
        content: '';
        position: absolute;
        inset: -8px;
        border-radius: 50%;
        border: 2px solid transparent;
        border-top-color: var(--err-primary);
        border-right-color: var(--err-accent);
        opacity: 0.3;
        animation: orbitSpin 8s linear infinite;
    }

    .error-icon-bg::after {
        content: '';
        position: absolute;
        inset: -16px;
        border-radius: 50%;
        border: 1.5px solid transparent;
        border-bottom-color: var(--err-accent-pink);
        border-left-color: var(--err-primary);
        opacity: 0.2;
        animation: orbitSpin 12s linear infinite reverse;
    }

    @keyframes iconBreathe {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 var(--err-primary-glow); }
        50% { transform: scale(1.05); box-shadow: 0 0 30px 5px var(--err-primary-glow); }
    }

    @keyframes orbitSpin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Orbiting dots */
    .orbit-dot {
        position: absolute;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        top: 50%;
        left: 50%;
    }

    .orbit-dot-1 {
        background: var(--err-primary);
        animation: orbitDot 6s linear infinite;
        box-shadow: 0 0 6px var(--err-primary);
    }

    .orbit-dot-2 {
        background: var(--err-accent);
        animation: orbitDot 6s linear infinite;
        animation-delay: -2s;
        box-shadow: 0 0 6px var(--err-accent);
    }

    .orbit-dot-3 {
        background: var(--err-accent-pink);
        animation: orbitDot 6s linear infinite;
        animation-delay: -4s;
        box-shadow: 0 0 6px var(--err-accent-pink);
    }

    @keyframes orbitDot {
        from { transform: rotate(0deg) translateX(60px) rotate(0deg) scale(0.8); }
        50% { transform: rotate(180deg) translateX(60px) rotate(-180deg) scale(1.2); }
        to { transform: rotate(360deg) translateX(60px) rotate(-360deg) scale(0.8); }
    }

    .error-icon-wrap i {
        font-size: 2.5rem;
        position: relative;
        z-index: 1;
        background: linear-gradient(135deg, var(--err-primary), var(--err-primary-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        filter: drop-shadow(0 2px 8px var(--err-primary-glow));
    }

    /* ========== Error Code ========== */
    .error-code {
        font-size: 4.5rem;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 0.25rem;
        letter-spacing: -3px;
        position: relative;
        display: inline-block;
    }

    .error-code-text {
        background: linear-gradient(135deg, var(--err-primary) 0%, var(--err-primary-dark) 50%, var(--err-primary) 100%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: codeShine 3s ease-in-out infinite;
    }

    @keyframes codeShine {
        0% { background-position: 0% center; }
        50% { background-position: 100% center; }
        100% { background-position: 0% center; }
    }

    .error-code-shadow {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--err-primary), var(--err-primary-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        filter: blur(15px);
        opacity: 0.2;
        z-index: -1;
    }

    /* ========== Text ========== */
    .error-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--err-text);
        margin-bottom: 0.5rem;
        animation: textSlide 0.5s ease 0.2s both;
    }

    .error-message {
        font-size: 0.9rem;
        color: var(--err-muted);
        line-height: 1.6;
        margin-bottom: 1.5rem;
        animation: textSlide 0.5s ease 0.3s both;
    }

    @keyframes textSlide {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ========== Buttons ========== */
    .error-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
        flex-wrap: wrap;
        animation: textSlide 0.5s ease 0.4s both;
    }

    .btn-err-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.75rem;
        background: linear-gradient(135deg, var(--err-primary), var(--err-primary-dark));
        color: #fff !important;
        border: none;
        border-radius: 14px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none !important;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-err-primary::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .btn-err-primary:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 30px rgba(0, 167, 157, 0.4);
    }

    .btn-err-primary:hover::before { opacity: 1; }

    .btn-err-primary:active {
        transform: translateY(-1px) scale(0.98);
    }

    .btn-err-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.75rem;
        background: rgba(0, 167, 157, 0.05);
        color: var(--err-primary) !important;
        border: 2px solid rgba(0, 167, 157, 0.25);
        border-radius: 14px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none !important;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-err-secondary:hover {
        background: var(--err-primary-light);
        border-color: var(--err-primary);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.15);
    }

    .btn-err-secondary:active {
        transform: translateY(-1px) scale(0.98);
    }

    /* ========== Emoji hint ========== */
    .error-emoji {
        font-size: 1.3rem;
        margin-bottom: 0.25rem;
        animation: emojiWave 2s ease-in-out infinite;
        display: inline-block;
    }

    @keyframes emojiWave {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(15deg); }
        75% { transform: rotate(-15deg); }
    }

    /* ========== Footer ========== */
    .error-footer {
        text-align: center;
        padding: 0.75rem;
        color: var(--err-muted);
        font-size: 0.78rem;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
        letter-spacing: 0.01em;
    }

    .error-footer a {
        color: var(--err-primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .error-footer a:hover { color: var(--err-primary-dark); }

    /* ========== Responsive ========== */
    @media (max-width: 576px) {
        .error-card-glow { border-radius: 22px; }
        .error-card { padding: 1.5rem 1.25rem 1.25rem; border-radius: 20px; }
        .error-code { font-size: 3.5rem; letter-spacing: -2px; }
        .error-title { font-size: 1.05rem; }
        .error-message { font-size: 0.82rem; margin-bottom: 1rem; }
        .error-icon-wrap { width: 80px; height: 80px; margin-bottom: 0.75rem; }
        .error-icon-wrap i { font-size: 2rem; }
        .error-navbar { padding: 0.6rem 1rem; }
        .error-navbar img { width: 34px; height: 34px; }
        .error-navbar .brand-name { font-size: 0.95rem; }
        .error-emoji { font-size: 1.1rem; }
        .btn-err-primary, .btn-err-secondary { padding: 0.65rem 1.25rem; font-size: 0.82rem; border-radius: 12px; }
        .orbit-dot { width: 5px; height: 5px; }
        @keyframes orbitDot {
            from { transform: rotate(0deg) translateX(48px) rotate(0deg); }
            50% { transform: rotate(180deg) translateX(48px) rotate(-180deg); }
            to { transform: rotate(360deg) translateX(48px) rotate(-360deg); }
        }
        .bg-icon { display: none; }
        .error-footer { padding: 0.5rem; font-size: 0.72rem; }
    }

    /* ========== Navbar flex + Dark Toggle Button ========== */
    .error-navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .error-dark-toggle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: none;
        background: rgba(0, 167, 157, 0.1);
        color: var(--err-primary);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: background 0.3s ease, transform 0.3s ease;
        flex-shrink: 0;
    }

    .error-dark-toggle:hover {
        background: rgba(0, 167, 157, 0.2);
        transform: scale(1.1) rotate(20deg);
    }

    /* ========== Dark Mode ========== */
    [data-theme="dark"] body {
        background: #0f1623 !important;
    }

    [data-theme="dark"] .error-card {
        background: #1a2235;
    }

    [data-theme="dark"] .error-card::after {
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.03), transparent);
    }

    [data-theme="dark"] .error-navbar .brand-name {
        color: #e2e8f0;
    }

    [data-theme="dark"] .error-navbar .brand-tagline {
        color: #9ca3af;
    }

    [data-theme="dark"] .error-title {
        color: #e2e8f0;
    }

    [data-theme="dark"] .error-message {
        color: #9ca3af;
    }

    [data-theme="dark"] .btn-err-secondary {
        background: rgba(0, 167, 157, 0.1);
        border-color: rgba(0, 167, 157, 0.3);
        color: #4dd9cf !important;
    }

    [data-theme="dark"] .btn-err-secondary:hover {
        background: rgba(0, 167, 157, 0.2);
        border-color: rgba(0, 167, 157, 0.6);
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.2);
    }

    [data-theme="dark"] .error-card-glow {
        box-shadow: 0 25px 70px rgba(0, 167, 157, 0.15), 0 8px 30px rgba(0, 0, 0, 0.4);
    }

    [data-theme="dark"] .error-icon-bg {
        background: linear-gradient(135deg, rgba(0,167,157,.2), rgba(0,167,157,.05));
    }

    [data-theme="dark"] .error-footer {
        color: #9ca3af;
    }

    [data-theme="dark"] .error-footer a {
        color: #4dd9cf;
    }

    [data-theme="dark"] .error-footer a:hover {
        color: #00a79d;
    }

    [data-theme="dark"] .error-dark-toggle {
        background: rgba(0, 167, 157, 0.15);
        color: #4dd9cf;
    }

    [data-theme="dark"] .error-dark-toggle:hover {
        background: rgba(0, 167, 157, 0.25);
    }

    /* Text selection */
    ::selection         { background: rgba(0,167,157,.25); color: inherit; }
    ::-moz-selection    { background: rgba(0,167,157,.25); color: inherit; }
    [data-theme="dark"] ::selection      { background: rgba(0,167,157,.4); color: #fff; }
    [data-theme="dark"] ::-moz-selection { background: rgba(0,167,157,.4); color: #fff; }
</style>
