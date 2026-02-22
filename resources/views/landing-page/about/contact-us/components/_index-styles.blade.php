<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">

<style>
/* ================================================
   CONTACT-US PAGE — cu- prefixed styles
   ================================================ */

/* ------------------------------------------------
   HERO / JUMBOTRON
   ------------------------------------------------ */
.cu-hero {
    position: relative;
    background: transparent;
    padding-top: 80px;
    overflow: visible;
}

.cu-hero-wrap {
    position: relative;
    margin: 1rem;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
}

@media (min-width: 992px) {
    .cu-hero-wrap {
        margin: 1.5rem 2.5rem;
        border-radius: 32px;
    }
}

.cu-hero-img-box {
    position: relative;
    width: 100%;
}

.cu-hero-img {
    width: 100%;
    display: block;
    object-fit: cover;
}

@media (min-width: 992px) {
    .cu-hero-img-box { height: 480px; }
    .cu-hero-img     { height: 480px; object-fit: cover; }
}

@media (max-width: 991.98px) {
    .cu-hero-img { height: 210px; object-fit: cover; }
    .cu-hero { padding-top: 65px; }
    .cu-hero-wrap { margin: 0; border-radius: 0; box-shadow: none; }
}

.cu-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg,
        rgba(0,0,0,0.68) 0%,
        rgba(0,0,0,0.30) 55%,
        rgba(0,0,0,0.52) 100%);
}

/* Desktop content overlay */
.cu-hero-content {
    position: absolute;
    inset: 0;
    z-index: 5;
    align-items: center;
}

.cu-hero-box {
    padding: 3rem;
    color: white;
}

.cu-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.25);
    border-radius: 50px;
    padding: 0.5rem 1.25rem;
    color: white;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
}

.cu-hero-title {
    font-size: 2.8rem;
    font-weight: 800;
    color: white;
    line-height: 1.2;
    margin-bottom: 2rem;
    text-shadow: 2px 4px 20px rgba(0,0,0,0.3);
}

.cu-hero-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    padding: 0.875rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition-smooth);
}

.cu-hero-btn:hover {
    background: rgba(255,255,255,0.35);
    color: white;
    transform: translateY(-2px);
}

/* ------------------------------------------------
   DESKTOP HADITH SECTION
   ------------------------------------------------ */
.cu-hadith-wrap {
    background: white;
    padding: 0 2.5rem 2.5rem;
    margin: 0 2.5rem;
    border-radius: 0 0 32px 32px;
    position: relative;
    overflow: visible;
}

.cu-hadith-divider {
    position: absolute;
    top: -38px;
    left: -10px;
    width: calc(100% + 20px);
    height: 58px;
    background: white;
    border-radius: 50% 50% 0 0;
    z-index: 10;
}

.cu-hadith-card {
    max-width: 860px;
    margin: 0 auto;
    text-align: center;
    padding-top: 22px;
    position: relative;
    z-index: 15;
}

.cu-hadith-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 50px;
    padding: 0.4rem 1rem;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.cu-hadith-body {
    max-height: 145px;
    overflow: hidden;
    position: relative;
    transition: max-height 0.5s ease;
    margin-bottom: 0.75rem;
}

.cu-hadith-body.cu-expanded { max-height: 3000px; }

.cu-hadith-body:not(.cu-expanded)::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 100%; height: 50px;
    background: linear-gradient(to bottom, transparent, white);
    pointer-events: none;
}

.cu-hadith-arab {
    font-family: 'Amiri', 'Traditional Arabic', serif;
    font-size: 1.35rem;
    line-height: 2.1;
    color: var(--dark);
    margin-bottom: 0.75rem;
    direction: rtl;
}

.cu-hadith-text {
    font-size: 0.85rem;
    color: var(--gray);
    line-height: 1.65;
    font-style: italic;
    margin-bottom: 0.35rem;
}

.cu-hadith-num {
    display: block;
    font-size: 0.7rem;
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.cu-hadith-footer {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    margin-top: 0.75rem;
}

.cu-toggle {
    background: none;
    border: 1px solid var(--primary-light);
    color: var(--primary);
    padding: 0.4rem 1.25rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    outline: none;
}

.cu-toggle:hover,
.cu-toggle:focus,
.cu-toggle:active {
    background: transparent;
    border-color: var(--primary);
    color: var(--primary);
    box-shadow: none;
    outline: none;
}

.cu-toggle i {
    font-size: 0.7rem;
    transition: transform 0.3s ease;
}

.cu-toggle.cu-expanded i { transform: rotate(180deg); }

.cu-countdown {
    background: rgba(0,0,0,0.06);
    color: var(--gray);
    padding: 0.35rem 0.9rem;
    border-radius: 50px;
    font-size: 0.72rem;
}

.cu-countdown-num {
    font-weight: 700;
    color: var(--primary);
    margin: 0 2px;
}

/* ------------------------------------------------
   MOBILE HERO
   ------------------------------------------------ */
.cu-mobile-hero {
    background: white;
    padding: 1.25rem 1.25rem 1rem;
    text-align: center;
    position: relative;
    z-index: 5;
}

.cu-mobile-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 50px;
    padding: 0.3rem 0.85rem;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.cu-mobile-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.35;
    margin-bottom: 1rem;
}

.cu-mobile-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-gradient);
    color: white;
    padding: 0.6rem 1.5rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition-smooth);
    box-shadow: var(--shadow-primary);
}

.cu-mobile-btn:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-primary-lg);
}

/* ------------------------------------------------
   MOBILE HADITH SECTION
   ------------------------------------------------ */
.cu-hadith-wrap-mobile {
    background: white;
    padding: 0 1rem 1.5rem;
    position: relative;
}

.cu-hadith-divider-mobile {
    position: absolute;
    top: -28px;
    left: -5px;
    width: calc(100% + 10px);
    height: 42px;
    background: white;
    border-radius: 50% 50% 0 0;
    z-index: 10;
}

.cu-hadith-card-mobile {
    text-align: center;
    padding-top: 16px;
    position: relative;
    z-index: 15;
}

.cu-hadith-badge-mobile {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 50px;
    padding: 0.3rem 0.85rem;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.cu-hadith-body-mobile {
    max-height: 130px;
    overflow: hidden;
    position: relative;
    transition: max-height 0.4s ease;
    margin-bottom: 0.75rem;
}

.cu-hadith-body-mobile.cu-expanded { max-height: 3000px; }

.cu-hadith-body-mobile:not(.cu-expanded)::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 100%; height: 40px;
    background: linear-gradient(to bottom, transparent, white);
    pointer-events: none;
}

.cu-hadith-text-mobile {
    font-size: 0.82rem;
    color: var(--gray);
    line-height: 1.55;
    font-style: italic;
    margin-bottom: 0.35rem;
}

.cu-hadith-footer-mobile {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 0.25rem;
    margin-top: 0.25rem;
}

.cu-toggle-mobile {
    background: none;
    border: 1px solid var(--primary-light);
    color: var(--primary);
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    padding: 0.35rem 1rem;
    outline: none;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    border-radius: 50px;
    transition: var(--transition);
}

.cu-toggle-mobile:focus,
.cu-toggle-mobile:active {
    background: transparent;
    box-shadow: none;
    outline: none;
}

.cu-toggle-mobile i {
    font-size: 0.6rem;
    transition: transform 0.3s ease;
}

.cu-toggle-mobile.cu-expanded i { transform: rotate(180deg); }

.cu-countdown-mobile {
    background: rgba(0,0,0,0.06);
    color: var(--gray);
    padding: 0.3rem 0.75rem;
    border-radius: 50px;
    font-size: 0.65rem;
    white-space: nowrap;
}

/* Hadith fade transitions */
.cu-fade-text {
    transition: opacity 0.45s ease;
    opacity: 1;
}

.cu-fade-text.cu-fading { opacity: 0; }

/* Loading dots */
.cu-dot {
    display: inline-block;
    animation: cuDotBounce 1.4s infinite;
    font-size: 1.1rem;
    line-height: 1;
}

.cu-dot:nth-child(2) { animation-delay: 0.2s; }
.cu-dot:nth-child(3) { animation-delay: 0.4s; }

@keyframes cuDotBounce {
    0%, 60%, 100% { transform: translateY(0); opacity: 0.3; }
    30%            { transform: translateY(-5px); opacity: 1; }
}

/* ------------------------------------------------
   SECTION COMMON
   ------------------------------------------------ */
.cu-section-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-light);
    border: 1px solid rgba(0,167,157,0.2);
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
    color: var(--secondary);
    font-size: 1rem;
    line-height: 1.7;
    margin: 0;
}

/* ------------------------------------------------
   INFO CARDS
   ------------------------------------------------ */
.cu-info-section { background: transparent; }

/* Desktop / Tablet Grid */
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
    .cu-info-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* Card Base */
.cu-info-card {
    position: relative;
    border-radius: 20px;
    padding: 1.75rem 1.5rem;
    min-height: 240px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: transform 0.35s cubic-bezier(0.4,0,0.2,1),
                box-shadow 0.35s cubic-bezier(0.4,0,0.2,1);
    cursor: default;
}

.cu-mobile-card { cursor: pointer; }

/* Color variants */
.cu-card--primary { background: linear-gradient(135deg, #00a79d 0%, #00c4b8 100%); color: white; }
.cu-card--green   { background: linear-gradient(135deg, #00b894 0%, #00a79d 100%); color: white; }
.cu-card--teal    { background: linear-gradient(135deg, #20c997 0%, #00a79d 100%); color: white; }
.cu-card--info    { background: linear-gradient(135deg, #0dcaf0 0%, #17a2b8 100%); color: white; }

.cu-info-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

/* Animated growing number bullet */
.cu-card-num {
    position: absolute;
    bottom: -12px;
    right: -4px;
    font-size: 5rem;
    font-weight: 900;
    color: rgba(255,255,255,0.12);
    line-height: 1;
    pointer-events: none;
    user-select: none;
    transition: transform 0.4s ease, color 0.4s ease;
}

.cu-info-card:hover .cu-card-num {
    transform: scale(1.18);
    color: rgba(255,255,255,0.22);
}

.cu-card-icon {
    font-size: 2.25rem;
    margin-bottom: 0.75rem;
    display: block;
    transition: transform 0.3s ease;
}

.cu-info-card:hover .cu-card-icon {
    transform: scale(1.1) rotate(6deg);
}

.cu-card-title {
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 0.625rem;
    color: rgba(255,255,255,0.95);
}

.cu-card-value {
    font-size: 0.88rem;
    color: rgba(255,255,255,0.9);
    line-height: 1.65;
    text-decoration: none;
    flex: 1;
    transition: var(--transition);
    word-break: break-word;
}

a.cu-card-value:hover {
    color: white;
    text-decoration: underline;
}

p.cu-card-value { margin: 0; }

.cu-card-sub {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.7);
    margin-top: 0.35rem;
    display: block;
}

/* Social links */
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
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    font-size: 0.85rem;
    transition: var(--transition);
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

/* Tap hint for mobile cards */
.cu-tap-hint {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    margin-top: auto;
    padding-top: 0.75rem;
    font-size: 0.72rem;
    color: rgba(255,255,255,0.65);
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
    background: rgba(0,167,157,0.25);
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

.cu-map-wrap {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    height: 420px;
    transition: box-shadow 0.3s ease;
}

.cu-map-wrap:hover { box-shadow: var(--shadow-xl); }

.cu-map-wrap iframe {
    width: 100%;
    height: 100%;
    display: block;
}

/* Form Card */
.cu-form-card {
    background: linear-gradient(135deg,
        rgba(0,167,157,0.04) 0%,
        rgba(255,255,255,0.88) 100%);
    border: 2px solid rgba(0,167,157,0.15);
    border-radius: 24px;
    padding: 2.25rem;
    box-shadow: 0 20px 60px rgba(0,167,157,0.08);
    transition: var(--transition-smooth);
}

.cu-form-card:hover {
    border-color: rgba(0,167,157,0.25);
    box-shadow: 0 25px 70px rgba(0,167,157,0.12);
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
    border: 2px solid rgba(0,167,157,0.2);
    border-radius: 14px;
    font-size: 0.9rem;
    font-family: inherit;
    transition: var(--transition-smooth);
    background: rgba(255,255,255,0.9);
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
    box-shadow: 0 0 0 4px rgba(0,167,157,0.1);
    background: white;
    transform: translateY(-2px);
}

.cu-form-input::placeholder,
.cu-form-textarea::placeholder { color: rgba(0,0,0,0.35); }

.cu-form-textarea {
    resize: vertical;
    min-height: 130px;
    height: auto;
    line-height: 1.6;
}

/* Validation states */
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
    background: rgba(239,68,68,0.04);
}

.cu-form-input.cu-invalid:focus,
.cu-form-textarea.cu-invalid:focus {
    border-color: #ef4444;
    box-shadow: 0 0 0 4px rgba(239,68,68,0.1);
    transform: none;
}

.cu-form-group.cu-has-error .cu-form-error { display: block; }

.cu-form-input.cu-valid,
.cu-form-textarea.cu-valid { border-color: #10b981; }

/* Submit button */
.cu-form-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    width: 100%;
    background: var(--primary-gradient);
    color: white;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: var(--transition-smooth);
    box-shadow: var(--shadow-primary);
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
.cu-form-submit:hover         { transform: translateY(-3px); box-shadow: var(--shadow-primary-lg); }
.cu-form-submit:active        { transform: translateY(-1px); }
.cu-form-submit > *           { position: relative; z-index: 1; }

/* ------------------------------------------------
   BOTTOM SHEET (Mobile Card Detail)
   ------------------------------------------------ */
.cu-bs-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
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
    transition: transform 0.4s cubic-bezier(0.32,0.72,0,1);
    max-height: 80vh;
    overflow-y: auto;
    overscroll-behavior: contain;
    box-shadow: 0 -8px 40px rgba(0,0,0,0.15);
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
    transition: var(--transition);
    z-index: 5;
}

.cu-bs-close:hover {
    background: var(--gray-200);
    color: var(--dark);
}

/* Bottom sheet content styles */
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
    transition: var(--transition);
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
    background: var(--primary-gradient);
    color: white;
    padding: 0.8rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    font-size: 0.9rem;
    margin-top: 1rem;
    transition: var(--transition-smooth);
    box-shadow: var(--shadow-primary);
}

.cu-bs-content .cu-bs-link-btn:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-primary-lg);
}

/* body scroll lock */
body.cu-no-scroll { overflow: hidden; }

/* Back-to-top hide when sheet is open */
.back-to-top.cu-hide-btt {
    opacity: 0 !important;
    pointer-events: none !important;
    transform: translateY(10px) !important;
    transition: opacity 0.3s ease, transform 0.3s ease !important;
}

/* ------------------------------------------------
   CUSTOM TOAST
   ------------------------------------------------ */
.cu-toast-container {
    position: fixed;
    top: 88px;   /* below navbar */
    right: 1rem;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    pointer-events: none;
    max-width: 360px;
    width: calc(100vw - 2rem);
}

.cu-toast {
    background: white;
    border-radius: 14px;
    padding: 0.875rem 1rem 0.875rem 1.125rem;
    box-shadow: 0 8px 30px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    pointer-events: auto;
    transform: translateX(calc(100% + 1rem));
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border-left: 4px solid transparent;
    position: relative;
    overflow: hidden;
}

.cu-toast.cu-toast-show { transform: translateX(0); }

.cu-toast--success { border-left-color: #10b981; }
.cu-toast--error   { border-left-color: #ef4444; }
.cu-toast--warning { border-left-color: #f59e0b; }

.cu-toast__ico { font-size: 1.35rem; flex-shrink: 0; }

.cu-toast__msg {
    font-size: 0.88rem;
    font-weight: 500;
    color: var(--dark);
    flex: 1;
    line-height: 1.4;
}

.cu-toast__bar {
    position: absolute;
    bottom: 0; left: 0;
    height: 3px;
    border-radius: 0;
    animation: cuToastBar 3.5s linear forwards;
}

.cu-toast--success .cu-toast__bar { background: #10b981; }
.cu-toast--error   .cu-toast__bar { background: #ef4444; }
.cu-toast--warning .cu-toast__bar { background: #f59e0b; }

@keyframes cuToastBar {
    from { width: 100%; }
    to   { width: 0; }
}

/* ------------------------------------------------
   RESPONSIVE
   ------------------------------------------------ */
@media (max-width: 991.98px) {
    .cu-section-title { font-size: 1.65rem; }
    .cu-form-row { grid-template-columns: 1fr; }
    .cu-form-card { padding: 1.75rem; }
    .cu-map-wrap { height: 300px; }
    .cu-hadith-wrap {
        margin: 0 0.75rem;
        padding: 0 1rem 2rem;
    }
    .cu-hero-title { font-size: 2.2rem; }
}

@media (max-width: 767.98px) {
    .cu-section-title { font-size: 1.4rem; }
    .cu-section-sub { font-size: 0.95rem; }
    .cu-form-card { padding: 1.25rem; }
    .cu-map-wrap { height: 250px; }
    .cu-toast-container { right: 0.75rem; top: 80px; }
}

@media (max-width: 480px) {
    .cu-hadith-footer-mobile {
        flex-direction: column;
        gap: 0.6rem;
        align-items: flex-start;
    }
    .cu-countdown-mobile { align-self: flex-end; }
}
</style>
