<style>
/* ============================================================
   MANAGEMENT STRUCTURE — Redesign v2
   ============================================================ */

/* Section */
.ms-section { padding: 8rem 0 4rem; }

/* Animated badge */
.ms-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-light);
    border: 1px solid rgba(0,167,157,0.2);
    border-radius: var(--radius-pill);
    padding: 0.45rem 1.2rem;
    margin-bottom: 1rem;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--primary);
}

.ms-badge-pulse {
    width: 7px; height: 7px;
    background: var(--primary);
    border-radius: 50%;
    animation: authBadgePulse 2s ease-in-out infinite;
}

/* Scroll reveal */
.ms-reveal {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.65s cubic-bezier(0.4,0,0.2,1),
                transform 0.65s cubic-bezier(0.4,0,0.2,1);
}
.ms-reveal.visible { opacity: 1; transform: translateY(0); }
.ms-d1 { transition-delay: 0.05s; }
.ms-d2 { transition-delay: 0.18s; }
.ms-d3 { transition-delay: 0.3s; }

/* ============================================================
   DESKTOP INLINE — konten sheet ditampilkan langsung di halaman
   ============================================================ */
.ms-desktop-inline {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.ms-di-card {
    display: flex;
    flex-direction: column;
    background: var(--white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow);
    border: 1px solid rgba(0,167,157,0.08);
    overflow: hidden;
    transition: transform 0.38s cubic-bezier(0.4,0,0.2,1),
                box-shadow 0.38s cubic-bezier(0.4,0,0.2,1);
}

.ms-di-card:hover {
    transform: scale(1.003);
    box-shadow: 0 16px 48px rgba(0,0,0,0.1), 0 4px 16px rgba(0,167,157,0.1);
}

/* ── ATAS: gradient hero — foto kiri, info+deskripsi kanan ── */
.ms-di-left {
    position: relative;
    background: linear-gradient(135deg, var(--primary) 0%, #006b65 60%, #004d49 100%);
    overflow: hidden;
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    padding: 1.75rem 2rem;
    gap: 1.75rem;
    flex-shrink: 0;
}

.ms-di-left::before {
    content: '';
    position: absolute;
    top: -50px; right: -50px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
    pointer-events: none;
}

.ms-di-left::after {
    content: '';
    position: absolute;
    bottom: -25px; left: 40%;
    width: 90px; height: 90px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    pointer-events: none;
}

/* Watermark angka batch */
.ms-di-batch-wm {
    position: absolute;
    right: 1rem; bottom: -22px;
    font-size: 7.5rem;
    font-weight: 900;
    color: rgba(255,255,255,0.07);
    line-height: 1;
    pointer-events: none;
    user-select: none;
    letter-spacing: -4px;
}

/* Foto: frame di kiri, center vertikal */
.ms-di-photo-wrap {
    position: relative;
    z-index: 1;
    width: 160px;
    min-width: 160px;
    align-self: center;
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: 0 8px 28px rgba(0,0,0,0.3),
                0 0 0 3px rgba(255,255,255,0.2);
    background: linear-gradient(135deg, #e4faf6, #edf6ff, #fce8ff);
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 140px;
    flex-shrink: 0;
    transition: transform 0.38s ease, box-shadow 0.38s ease;
}

.ms-di-card:hover .ms-di-photo-wrap {
    transform: translateY(-3px);
    box-shadow: 0 14px 40px rgba(0,0,0,0.34),
                0 0 0 3px rgba(255,255,255,0.28);
}

.ms-di-photo-wrap img {
    width: 100%;
    height: auto;
    max-height: 170px;
    object-fit: contain;
    display: block;
    padding: 0.75rem;
}

/* Info + deskripsi: kanan foto */
.ms-di-info {
    position: relative;
    z-index: 1;
    text-align: left;
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 0.35rem;
    min-width: 0;
}

.ms-di-period-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    background: rgba(255,255,255,0.14);
    border: 1px solid rgba(255,255,255,0.22);
    color: rgba(255,255,255,0.92);
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.22rem 0.7rem;
    border-radius: var(--radius-pill);
}

/* Separator tipis antara badges dan deskripsi */
.ms-di-separator {
    width: 100%;
    height: 1px;
    background: rgba(255,255,255,0.15);
    margin: 0.5rem 0 0.3rem;
    flex-shrink: 0;
}

/* Deskripsi di dalam gradient */
.ms-di-desc {
    font-size: 0.82rem;
    color: rgba(255,255,255,0.82);
    line-height: 1.75;
    margin: 0;
    text-align: justify;
}

/* ── BAWAH: bagan full width (collapsible) ── */
.ms-di-right {
    display: flex;
    flex-direction: column;
    border-top: 3px solid rgba(0,167,157,0.18);
    background: var(--white);
}

.ms-di-right-accent,
.ms-di-right-body,
.ms-di-desc-wrap { display: none; }

.ms-di-chart-section {
    padding: 0;
}

/* Toggle button */
.ms-di-chart-toggle {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 2rem;
    background: transparent;
    border: none;
    cursor: pointer;
    text-align: left;
    outline: none;
    -webkit-tap-highlight-color: transparent;
}
.ms-di-chart-toggle:hover,
.ms-di-chart-toggle:focus,
.ms-di-chart-toggle:active,
.ms-di-chart-toggle:focus-visible {
    background: transparent;
    outline: none;
    box-shadow: none;
}

.ms-di-chart-toggle-label {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    font-size: 0.65rem;
    font-weight: 700;
    color: var(--secondary);
    text-transform: uppercase;
    letter-spacing: 1.5px;
}

.ms-di-chart-toggle-icon {
    width: 28px; height: 28px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    background: var(--primary-light);
    color: var(--primary);
    font-size: 0.72rem;
    flex-shrink: 0;
    transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
}

.ms-di-chart-section.ms-cs-open .ms-di-chart-toggle-icon {
    transform: rotate(180deg);
}

/* Collapsible body */
.ms-di-chart-body {
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.45s cubic-bezier(0.4,0,0.2,1),
                padding 0.35s ease;
    padding: 0 2rem;
}

.ms-di-chart-section.ms-cs-open .ms-di-chart-body {
    max-height: 3000px;
    padding: 0 2rem 1.75rem;
}

.ms-di-chart-body > img {
    width: 100%;
    height: auto;
    border-radius: var(--radius-lg);
    display: block;
    box-shadow: var(--shadow-sm);
}

/* Medium screen */
@media (max-width: 1199.98px) {
    .ms-di-photo-wrap { width: 135px; min-width: 135px; }
    .ms-di-left { padding: 1.5rem 1.5rem; gap: 1.25rem; }
}

/* ============================================================
   LIGHTBOX
   ============================================================ */
.ms-lightbox {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    align-items: center;
    justify-content: center;
}

.ms-lightbox.ms-lb-active { display: flex; }

.ms-lb-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(10,12,14,0.82);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    animation: msLbBgIn 0.3s ease forwards;
}

@keyframes msLbBgIn  { from { opacity:0 } to { opacity:1 } }

.ms-lightbox.ms-lb-closing .ms-lb-backdrop {
    animation: msLbBgOut 0.3s ease forwards;
}

@keyframes msLbBgOut { from { opacity:1 } to { opacity:0 } }

.ms-lb-content {
    position: relative;
    z-index: 1;
    max-width: 92vw;
    max-height: 92vh;
    background: var(--white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    animation: msLbIn 0.38s cubic-bezier(0.4,0,0.2,1) forwards;
}

@keyframes msLbIn {
    from { opacity:0; transform: scale(0.88) translateY(24px); }
    to   { opacity:1; transform: scale(1) translateY(0); }
}

.ms-lightbox.ms-lb-closing .ms-lb-content {
    animation: msLbOut 0.3s cubic-bezier(0.4,0,0.2,1) forwards;
}

@keyframes msLbOut {
    from { opacity:1; transform: scale(1) translateY(0); }
    to   { opacity:0; transform: scale(0.9) translateY(16px); }
}

.ms-lb-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    flex-shrink: 0;
    gap: 1rem;
}

.ms-lb-title {
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--secondary);
    text-transform: uppercase;
    letter-spacing: 1px;
    flex: 1;
}

.ms-lb-close {
    width: 34px; height: 34px; min-width: 34px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    border: 1px solid var(--gray-200);
    background: transparent;
    color: var(--secondary);
    cursor: pointer;
    transition: var(--transition);
    font-size: 0.9rem;
}

.ms-lb-close:hover {
    background: var(--danger);
    border-color: var(--danger);
    color: var(--white);
    transform: rotate(90deg);
}

.ms-lb-body {
    overflow: auto;
    padding: 1.5rem;
    flex: 1;
    display: flex;
    align-items: flex-start;
    justify-content: center;
}

.ms-lb-body img {
    max-width: 100%;
    height: auto;
    border-radius: var(--radius-lg);
    display: block;
}

/* ============================================================
   MOBILE CAROUSEL
   ============================================================ */

/* Carousel wrapper
   — overflow:visible agar box-shadow card atas tidak terpotong
   — Owl .owl-stage-outer sudah punya overflow:hidden sendiri utk slide */
.ms-mob-wrap {
    overflow: visible;
    width: 100%;
    padding-top: 6px;   /* ruang untuk box-shadow atas card */
}

/* Card */
.ms-mobile-card {
    background: var(--white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow);
    border: 1px solid rgba(0,167,157,0.08);
    overflow: hidden;
    width: 100%;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
}

/* --- Gradient Hero Header --- */
.ms-mob-hero {
    background: linear-gradient(130deg, var(--primary) 0%, #007f78 55%, #005e58 100%);
    padding: 1.1rem 1.25rem 1rem;
    position: relative;
    overflow: hidden;
}

.ms-mob-hero::before {
    content: '';
    position: absolute;
    top: -25px; right: -25px;
    width: 90px; height: 90px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
    pointer-events: none;
}

.ms-mob-hero-row {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 0.75rem;
}

.ms-mob-eyebrow {
    font-size: 0.65rem;
    font-weight: 700;
    color: rgba(255,255,255,0.72);
    text-transform: uppercase;
    letter-spacing: 1.8px;
    margin-bottom: 0.2rem;
}

.ms-mob-hname {
    font-size: 0.92rem;
    font-weight: 700;
    color: var(--white);
    line-height: 1.3;
    margin: 0;
}

/* "Terkini" — inside hero, no overflow */
.ms-mob-current {
    display: inline-flex;
    align-items: center;
    gap: 0.28rem;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #fff;
    font-size: 0.63rem;
    font-weight: 700;
    padding: 0.22rem 0.65rem;
    border-radius: var(--radius-pill);
    text-transform: uppercase;
    letter-spacing: 0.3px;
    white-space: nowrap;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(245,158,11,0.4);
}

/* --- Photo Area — full contain, no cropping --- */
.ms-mob-photo-area {
    background: linear-gradient(135deg, #e4faf6 0%, #edf6ff 55%, #fce8ff 100%);
    padding: 1.5rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 190px;
}

.ms-mob-photo-area img {
    max-width: 100%;
    max-height: 170px;
    width: auto;
    height: auto;
    object-fit: contain;    /* ← FULL IMAGE, no cropping */
    border-radius: var(--radius-lg);
    filter: drop-shadow(0 4px 14px rgba(0,0,0,0.13));
    display: block;
}

/* --- Info Area --- */
.ms-mob-info {
    padding: 1.1rem 1.25rem 1rem;
    border-top: 1px solid rgba(0,0,0,0.04);
    flex: 1;
}

.ms-mob-period {
    font-size: 0.72rem;
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.ms-mob-desc {
    font-size: 0.78rem;
    color: var(--secondary);
    line-height: 1.65;
    margin: 0;
}

/* --- View Chart Button --- */
.ms-view-chart-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0.8rem;
    background: var(--primary-light);
    color: var(--primary);
    border: none;
    border-top: 1px solid rgba(0,167,157,0.1);
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition-smooth);
}

.ms-view-chart-btn:hover,
.ms-view-chart-btn:active {
    background: var(--primary-gradient);
    color: var(--white);
}

/* --- Stage-outer — sama persis dengan artikel carousel --- */
.ms-carousel.owl-carousel .owl-stage-outer {
    overflow: hidden;
    padding: 8px 0 16px;
}

/* --- Sembunyikan Owl default nav & dots (diganti custom) --- */
.ms-carousel .owl-nav,
.ms-carousel .owl-dots { display: none !important; }

/* ─── Custom Navigation Bar ─── */
.ms-mob-nav {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    padding: 1.1rem 0 0.25rem;
}

/* Prev / Next button */
.ms-mob-nav-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--white);
    border: 2px solid var(--primary);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition-smooth);
    box-shadow: var(--shadow-sm);
    font-size: 0.85rem;
    flex-shrink: 0;
}

.ms-mob-nav-btn:hover,
.ms-mob-nav-btn:active {
    background: var(--primary-gradient);
    color: var(--white);
    box-shadow: var(--shadow-primary);
    transform: scale(1.08);
}

.ms-mob-nav-btn:disabled {
    opacity: 0.35;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* Dot track */
.ms-mob-dots {
    display: flex;
    align-items: center;
    gap: 6px;
}

.ms-mob-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--gray-300);
    border: none;
    cursor: pointer;
    transition: var(--transition-smooth);
    padding: 0;
    flex-shrink: 0;
}

.ms-mob-dot.active {
    width: 26px;
    border-radius: var(--radius-pill);
    background: var(--primary-gradient);
    box-shadow: 0 2px 8px rgba(0,167,157,0.35);
}

/* ============================================================
   DETAIL POPUP — Bottom Sheet (Mobile)
   ============================================================ */
.ms-detail-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    align-items: flex-end;
    justify-content: center;
}

.ms-detail-modal.ms-dm-active { display: flex; }

.ms-dm-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(10,12,14,0.72);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    animation: msLbBgIn 0.3s ease forwards;
}

.ms-dm-sheet {
    position: relative;
    z-index: 1;
    width: 100%;
    max-height: 90vh;
    background: var(--white);
    border-radius: var(--radius-xl) var(--radius-xl) 0 0;
    box-shadow: 0 -8px 40px rgba(0,0,0,0.18);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    animation: msDmSheetIn 0.38s cubic-bezier(0.4,0,0.2,1) forwards;
}

@keyframes msDmSheetIn {
    from { transform: translateY(100%); opacity: 0.6; }
    to   { transform: translateY(0);    opacity: 1; }
}

.ms-detail-modal.ms-dm-closing .ms-dm-backdrop {
    animation: msLbBgOut 0.3s ease forwards;
}

.ms-detail-modal.ms-dm-closing .ms-dm-sheet {
    animation: msDmSheetOut 0.3s cubic-bezier(0.4,0,0.2,1) forwards;
}

@keyframes msDmSheetOut {
    from { transform: translateY(0);    opacity: 1; }
    to   { transform: translateY(100%); opacity: 0.4; }
}

/* Handle bar */
.ms-dm-handle {
    width: 40px; height: 4px;
    background: rgba(255,255,255,0.4);
    border-radius: 2px;
    margin: 0.65rem auto 0;
    flex-shrink: 0;
    position: absolute;
    top: 0; left: 50%;
    transform: translateX(-50%);
    z-index: 10;
}

/* Gradient header */
.ms-dm-header {
    background: linear-gradient(130deg, var(--primary) 0%, #007f78 55%, #005e58 100%);
    padding: 1.1rem 1.25rem 1rem;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 0.75rem;
    flex-shrink: 0;
    position: relative;
    overflow: hidden;
}

.ms-dm-header::before {
    content: '';
    position: absolute;
    top: -25px; right: -25px;
    width: 90px; height: 90px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
    pointer-events: none;
}

.ms-dm-header-info { position: relative; z-index: 1; flex: 1; }

.ms-dm-eyebrow {
    font-size: 0.65rem;
    font-weight: 700;
    color: rgba(255,255,255,0.72);
    text-transform: uppercase;
    letter-spacing: 1.8px;
    margin-bottom: 0.2rem;
}

.ms-dm-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--white);
    line-height: 1.3;
    margin: 0 0 0.5rem;
}

.ms-dm-period-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    background: rgba(255,255,255,0.14);
    border: 1px solid rgba(255,255,255,0.22);
    color: rgba(255,255,255,0.92);
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.22rem 0.7rem;
    border-radius: var(--radius-pill);
}

.ms-dm-close {
    width: 32px; height: 32px; min-width: 32px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.3);
    background: rgba(255,255,255,0.12);
    color: var(--white);
    cursor: pointer;
    transition: var(--transition);
    font-size: 0.85rem;
    flex-shrink: 0;
    position: relative; z-index: 1;
    margin-top: 0.1rem;
}

.ms-dm-close:hover { background: rgba(255,255,255,0.28); }

/* Scrollable body */
.ms-dm-body {
    overflow-y: auto;
    flex: 1;
    -webkit-overflow-scrolling: touch;
}

/* Photo area */
.ms-dm-photo-wrap {
    background: linear-gradient(135deg, #e4faf6 0%, #edf6ff 55%, #fce8ff 100%);
    padding: 1.5rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 160px;
}

.ms-dm-photo-wrap img {
    max-width: 100%;
    max-height: 220px;
    width: auto;
    height: auto;
    object-fit: contain;
    border-radius: var(--radius-lg);
    filter: drop-shadow(0 4px 14px rgba(0,0,0,0.13));
    display: block;
}

/* Description */
.ms-dm-desc-wrap {
    padding: 1.1rem 1.25rem 0.5rem;
    border-top: 1px solid rgba(0,0,0,0.05);
}

.ms-dm-desc-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: var(--secondary);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 0.6rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.ms-dm-desc-wrap p {
    font-size: 0.82rem;
    color: var(--secondary-dark);
    line-height: 1.8;
    margin: 0;
    text-align: justify;
}

/* Chart section */
.ms-dm-chart-section {
    padding: 1rem 1.25rem 1.5rem;
    border-top: 1px solid rgba(0,0,0,0.05);
}

.ms-dm-chart-label {
    font-size: 0.65rem;
    font-weight: 700;
    color: var(--secondary);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.ms-dm-chart-section > img {
    width: 100%;
    height: auto;
    border-radius: var(--radius-lg);
    display: block;
    box-shadow: var(--shadow-sm);
}

/* ============================================================
   EMPTY STATE
   ============================================================ */
.ms-empty { text-align: center; padding: 5rem 2rem; }

.ms-empty-icon {
    width: 80px; height: 80px;
    background: var(--primary-light);
    border-radius: var(--radius-xl);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
    color: var(--primary);
    animation: float 3s ease-in-out infinite;
}

/* ============================================================
   SCROLL LOCK + BACK-TO-TOP HIDE
   ============================================================ */
body.ms-modal-open { overflow: hidden; }

body.ms-modal-open .back-to-top {
    opacity: 0 !important;
    pointer-events: none !important;
    transform: scale(0.7) translateY(10px) !important;
    transition: opacity 0.3s ease, transform 0.3s ease !important;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 991.98px) {
    .ms-section   { padding: 6rem 0 2.5rem; }
    .ms-body      { padding: 1.75rem 1.25rem; }
    .ms-chart     { padding: 1.5rem 1.25rem 1.75rem; }
    .ms-hero      { padding: 1.5rem 1.25rem; }
    .ms-hero-title { font-size: 1.2rem; }
    .ms-lb-content { max-width: 96vw; max-height: 88vh; }
    .ms-photo-frame { min-height: 220px; }
    .ms-photo-frame img { max-height: 210px; }
}

@media (max-width: 575.98px) {
    .ms-section  { padding: 6rem 0 2rem; }
    .ms-lb-body  { padding: 1rem; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
[data-theme="dark"] .ms-lb-overlay  { background: rgba(0,0,0,.88); }
[data-theme="dark"] .ms-lb-content  { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .ms-lb-header   { background: #1a1f2e; border-bottom-color: rgba(0,167,157,.15); }
[data-theme="dark"] .ms-lb-name     { color: #e2e8f0; }
[data-theme="dark"] .ms-lb-position { color: #9ca3af; }
[data-theme="dark"] .ms-lb-body     { background: #1a1f2e; }
[data-theme="dark"] .ms-photo-frame { background: #252b3b; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .ms-card        { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .ms-card-name   { color: #e2e8f0; }
[data-theme="dark"] .ms-card-pos      { color: #9ca3af; }
[data-theme="dark"] .ms-section-title { color: #e2e8f0; }
[data-theme="dark"] .ms-mob-hname     { color: #e2e8f0; }
[data-theme="dark"] .ms-dm-name       { color: #e2e8f0; }
[data-theme="dark"] .ms-di-chart-toggle-label       { color: #e2e8f0; }
[data-theme="dark"] .ms-lb-close      { color: #e2e8f0; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .ms-dm-sheet      { background: #1a1f2e; }
[data-theme="dark"] .ms-dm-photo-wrap { background: linear-gradient(135deg, rgba(0,167,157,.08) 0%, rgba(26,31,46,.6) 100%); }
[data-theme="dark"] .ms-dm-desc-wrap  { border-top-color: rgba(0,167,157,.1); }
[data-theme="dark"] .ms-dm-desc-label { color: #9ca3af; }
[data-theme="dark"] .ms-dm-desc-wrap p { color: #cbd5e0; }
[data-theme="dark"] .ms-dm-chart-section { border-top-color: rgba(0,167,157,.1); }
[data-theme="dark"] .ms-dm-chart-label { color: #9ca3af; }

</style>
