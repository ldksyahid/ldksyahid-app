@extends('landing-page.template.body')

{{-- =====================================================
     HEAD — Page Styles
     ===================================================== --}}
@section('head')
<style>
/* ============================================================
   MANAGEMENT STRUCTURE — Redesign v2
   ============================================================ */

/* Section */
.ms-section { padding: 5rem 0 4rem; }

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
   DESKTOP CARD
   ============================================================ */
.ms-card {
    background: var(--white);
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow);
    border: 1px solid rgba(0,167,157,0.08);
    overflow: hidden;
    margin-bottom: 2.5rem;
    transition: box-shadow 0.35s ease, transform 0.35s ease;
}

.ms-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-4px);
}

/* === Gradient Hero Header === */
.ms-hero {
    background: linear-gradient(130deg, var(--primary) 0%, #007f78 55%, #005e58 100%);
    padding: 2rem 2.5rem;
    position: relative;
    overflow: hidden;
}

/* Decorative circles inside hero */
.ms-hero::before {
    content: '';
    position: absolute;
    top: -50px; right: -50px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.06);
    border-radius: 50%;
    pointer-events: none;
}

.ms-hero::after {
    content: '';
    position: absolute;
    bottom: -40px; left: 15%;
    width: 130px; height: 130px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
    pointer-events: none;
}

.ms-hero-inner {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}

.ms-hero-eyebrow {
    font-size: 0.7rem;
    font-weight: 700;
    color: rgba(255,255,255,0.7);
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 0.4rem;
}

.ms-hero-title {
    font-size: 1.45rem;
    font-weight: 700;
    color: var(--white);
    line-height: 1.25;
    margin: 0 0 0.6rem;
}

.ms-hero-period {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: rgba(255,255,255,0.14);
    border: 1px solid rgba(255,255,255,0.22);
    color: rgba(255,255,255,0.92);
    font-size: 0.78rem;
    font-weight: 600;
    padding: 0.28rem 0.85rem;
    border-radius: var(--radius-pill);
    backdrop-filter: blur(4px);
}

/* "Terkini" amber pill — stays inside hero box */
.ms-hero-current {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.28rem 0.85rem;
    border-radius: var(--radius-pill);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 14px rgba(245,158,11,0.45);
    white-space: nowrap;
    flex-shrink: 0;
}

/* === Card Body — Description + Photo === */
.ms-body {
    padding: 2.5rem;
}

.ms-description {
    color: var(--secondary-dark);
    font-size: 0.92rem;
    line-height: 1.8;
    text-align: justify;
    margin-bottom: 1.5rem;
}

/* Animated feature list */
.ms-feat-list {
    list-style: none;
    padding: 0; margin: 0;
}

.ms-feat-list li {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.45rem 0;
    font-size: 0.875rem;
    color: var(--secondary-dark);
    opacity: 0;
    transform: translateX(-14px);
}

.ms-feat-list li.ms-li-visible {
    animation: msFeatureIn 0.5s ease forwards;
}

@keyframes msFeatureIn {
    to { opacity: 1; transform: translateX(0); }
}

/* Animated growing bullet */
.ms-bullet {
    width: 10px; height: 10px; min-width: 10px;
    background: var(--primary-gradient);
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 0.35rem;
    box-shadow: 0 0 0 0 rgba(0,167,157,0.4);
    animation: msBulletGrow 2.2s ease-in-out infinite;
}

.ms-feat-list li:nth-child(2) .ms-bullet { animation-delay: 0.4s; }
.ms-feat-list li:nth-child(3) .ms-bullet { animation-delay: 0.8s; }

@keyframes msBulletGrow {
    0%,100% { transform: scale(1);    box-shadow: 0 0 0 0 rgba(0,167,157,0.4); }
    50%     { transform: scale(1.45); box-shadow: 0 0 0 7px rgba(0,167,157,0); }
}

/* === Profile Photo — full image, NO cropping === */
.ms-photo-frame {
    background: linear-gradient(135deg, #e4faf6 0%, #edf6ff 50%, #fce8ff 100%);
    border-radius: var(--radius-xl);
    border: 2px solid rgba(0,167,157,0.1);
    padding: 1.75rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 280px;
    transition: var(--transition-smooth);
    overflow: hidden;
}

.ms-card:hover .ms-photo-frame {
    border-color: rgba(0,167,157,0.28);
}

.ms-photo-frame img {
    max-width: 100%;
    max-height: 270px;
    width: auto;
    height: auto;
    object-fit: contain;      /* ← FULL IMAGE, no cropping */
    border-radius: var(--radius-lg);
    filter: drop-shadow(0 6px 20px rgba(0,0,0,0.13));
    transition: transform 0.4s ease, filter 0.4s ease;
    display: block;
}

.ms-card:hover .ms-photo-frame img {
    transform: scale(1.03) translateY(-3px);
    filter: drop-shadow(0 12px 28px rgba(0,0,0,0.18));
}

/* === Structure Chart — full width, full height === */
.ms-chart {
    border-top: 1px solid rgba(0,0,0,0.05);
    background: var(--gray-100);
    padding: 2rem 2.5rem 2.5rem;
}

.ms-chart-label {
    font-size: 0.74rem;
    font-weight: 700;
    color: var(--secondary);
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.ms-chart-wrap {
    position: relative;
    border-radius: var(--radius-lg);
    overflow: hidden;
    cursor: pointer;
    box-shadow: var(--shadow-sm);
    transition: box-shadow 0.3s ease;
    background: var(--white);
    display: block;
}

.ms-chart-wrap:hover     { box-shadow: var(--shadow-md); }
.ms-chart-wrap:focus-visible { outline: 3px solid var(--primary); outline-offset: 3px; }

.ms-chart-wrap > img {
    width: 100%;
    height: auto;        /* ← FULL IMAGE HEIGHT — no cropping */
    display: block;
    transition: transform 0.55s ease;
}

.ms-chart-wrap:hover > img { transform: scale(1.008); }

.ms-chart-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,167,157,0);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease;
}

.ms-chart-wrap:hover .ms-chart-overlay { background: rgba(0,167,157,0.06); }

.ms-expand-btn {
    background: rgba(255,255,255,0.97);
    color: var(--primary);
    border: 1px solid rgba(0,167,157,0.2);
    border-radius: var(--radius-pill);
    padding: 0.6rem 1.5rem;
    font-size: 0.82rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: var(--shadow);
    opacity: 0;
    transform: scale(0.8) translateY(8px);
    transition: var(--transition-smooth);
    cursor: pointer;
    pointer-events: none;
}

.ms-chart-wrap:hover .ms-expand-btn {
    opacity: 1;
    transform: scale(1) translateY(0);
    pointer-events: all;
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

/* --- Stage-outer vertical breathing room (like article carousel) --- */
.ms-carousel.owl-carousel .owl-stage-outer {
    padding: 8px 0 14px;
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
    .ms-section   { padding: 5rem 0 2.5rem; }
    .ms-body      { padding: 1.75rem 1.25rem; }
    .ms-chart     { padding: 1.5rem 1.25rem 1.75rem; }
    .ms-hero      { padding: 1.5rem 1.25rem; }
    .ms-hero-title { font-size: 1.2rem; }
    .ms-lb-content { max-width: 96vw; max-height: 88vh; }
    .ms-photo-frame { min-height: 220px; }
    .ms-photo-frame img { max-height: 210px; }
}

@media (max-width: 575.98px) {
    .ms-section  { padding: 4.5rem 0 2rem; }
    .ms-chart    { padding: 1.25rem 1rem 1.5rem; }
    .ms-lb-body  { padding: 1rem; }
}
</style>
@endsection

{{-- =====================================================
     CONTENT
     ===================================================== --}}
@section('content')

<div style="display:none;">
    <audio src="{{ asset('audio/mars-ldksyahid.mp3') }}" type="audio/mpeg" autoplay loop></audio>
</div>

<section class="ms-section">
    <div class="container">

        {{-- Section Header --}}
        <div class="text-center mb-5 ms-reveal">
            <div class="ms-badge">
                <span class="ms-badge-pulse"></span>
                Tentang Kami
            </div>
            <h2 class="section-title mb-2">
                Struktur <span class="text-gradient">Kepengurusan</span>
            </h2>
            <div class="section-divider mx-auto"></div>
            <p class="section-description mt-3">
                Mengenal pengurus dan struktur organisasi LDK Syahid UIN Jakarta secara lebih dekat
            </p>
        </div>

        @if(count($poststructure) > 0)

        {{-- =====================================================
             DESKTOP: Stacked Cards
             ===================================================== --}}
        <div class="desktop-only">
            @foreach($poststructure as $key => $data)
            <div class="ms-card ms-reveal ms-d{{ ($key % 3) + 1 }}">

                {{-- Gradient Hero Header --}}
                <div class="ms-hero">
                    <div class="ms-hero-inner">
                        <div>
                            <div class="ms-hero-eyebrow">{{ $data->batch }}</div>
                            <h3 class="ms-hero-title">{{ $data->structureName }}</h3>
                            <span class="ms-hero-period">
                                <i class="fas fa-calendar-alt" style="font-size:0.68rem;"></i>
                                Masa Bakti {{ $data->period }}
                            </span>
                        </div>
                        @if($loop->first)
                        <span class="ms-hero-current">
                            <i class="fas fa-star" style="font-size:0.58rem;"></i>
                            Pengurus Terkini
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Body: Description + Photo --}}
                <div class="ms-body">
                    <div class="row g-4 align-items-center">

                        {{-- Left — Info + Animated list --}}
                        <div class="col-lg-7">
                            <p class="ms-description">{{ $data->structureDescription }}</p>

                            <ul class="ms-feat-list" data-ms-list>
                                <li>
                                    <span class="ms-bullet"></span>
                                    <span>Organisasi mahasiswa islami yang bergerak dalam bidang dakwah dan pengembangan diri di UIN Syarif Hidayatullah Jakarta.</span>
                                </li>
                                <li>
                                    <span class="ms-bullet"></span>
                                    <span>Berkomitmen melahirkan generasi muslim yang unggul, berakhlak mulia, dan berdampak nyata bagi masyarakat luas.</span>
                                </li>
                                <li>
                                    <span class="ms-bullet"></span>
                                    <span>Struktur kepengurusan yang solid dan sinergis untuk mendukung seluruh program kerja masa bakti {{ $data->period }}.</span>
                                </li>
                            </ul>
                        </div>

                        {{-- Right — Profile Photo (full, no crop) --}}
                        <div class="col-lg-5">
                            <div class="ms-photo-frame">
                                <img
                                    src="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id }}"
                                    alt="Foto Pengurus LDK Syahid {{ $data->batch }}"
                                    loading="lazy"
                                    onerror="if(!this.dataset.err){this.src='https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd';this.dataset.err=1;}"
                                >
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Structure Chart — full width, natural height --}}
                <div class="ms-chart">
                    <div class="ms-chart-label">
                        <i class="fas fa-sitemap" style="color:var(--primary);"></i>
                        Bagan Struktur Organisasi
                    </div>
                    <div
                        class="ms-chart-wrap"
                        data-ms-lb
                        data-src="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id_2 }}=s5000"
                        data-title="Bagan Struktur Pengurus — {{ $data->batch }}"
                        role="button"
                        tabindex="0"
                        aria-label="Buka bagan struktur {{ $data->batch }} dalam tampilan penuh"
                    >
                        <img
                            src="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id_2 }}=s1600"
                            alt="Bagan Struktur Pengurus LDK Syahid {{ $data->batch }}"
                            loading="lazy"
                            onerror="if(!this.dataset.err){this.src='https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd';this.dataset.err=1;}"
                        >
                        <div class="ms-chart-overlay">
                            <button class="ms-expand-btn" type="button" tabindex="-1">
                                <i class="fas fa-expand-alt"></i>
                                Lihat Selengkapnya
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
        {{-- /DESKTOP --}}

        {{-- =====================================================
             MOBILE: Owl Carousel
             ===================================================== --}}
        <div class="mobile-only">
            <div class="ms-mob-wrap">
                <div class="ms-carousel owl-carousel" id="msCarousel">
                    @foreach($poststructure as $key => $data)
                    <div>
                        <div class="ms-mobile-card">

                            {{-- Gradient Hero Header --}}
                            <div class="ms-mob-hero">
                                <div class="ms-mob-hero-row">
                                    <div>
                                        <div class="ms-mob-eyebrow">LDK Syahid {{ $data->batch }}</div>
                                        <h6 class="ms-mob-hname">{{ $data->structureName }}</h6>
                                    </div>
                                    @if($loop->first)
                                    <span class="ms-mob-current">
                                        <i class="fas fa-star" style="font-size:0.52rem;"></i>
                                        Pengurus Saat Ini
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Profile Photo — full contain, no crop --}}
                            <div class="ms-mob-photo-area">
                                <img
                                    src="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id }}"
                                    alt="Foto Pengurus LDK Syahid {{ $data->batch }}"
                                    loading="lazy"
                                    onerror="if(!this.dataset.err){this.src='https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd';this.dataset.err=1;}"
                                >
                            </div>

                            {{-- Info --}}
                            <div class="ms-mob-info">
                                <p class="ms-mob-period">
                                    <i class="fas fa-calendar-alt me-1"></i>Masa Bakti {{ $data->period }}
                                </p>
                                <p class="ms-mob-desc">
                                    {{ Str::limit($data->structureDescription, 130) }}
                                </p>
                            </div>

                            {{-- View Detail Button — opens full popup --}}
                            <button
                                class="ms-view-chart-btn ms-detail-btn"
                                type="button"
                                data-name="{{ $data->structureName }}"
                                data-batch="LDK Syahid {{ $data->batch }}"
                                data-period="{{ $data->period }}"
                                data-desc="{{ $data->structureDescription }}"
                                data-photo="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id }}"
                                data-chart="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id_2 }}=s3000"
                            >
                                <i class="fas fa-expand-alt"></i>
                                Lihat Selengkapnya
                            </button>

                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Custom Navigation: Dots only --}}
                <div class="ms-mob-nav" id="msMobNav">
                    <div class="ms-mob-dots" id="msMobDots"></div>
                </div>

            </div>
        </div>
        {{-- /MOBILE --}}

        @else

        {{-- Empty State --}}
        <div class="ms-empty ms-reveal">
            <div class="ms-empty-icon"><i class="fas fa-users"></i></div>
            <h4 class="fw-bold mb-2" style="color:var(--dark);">Struktur Belum Tersedia</h4>
            <p class="text-secondary mb-0">Informasi struktur kepengurusan LDK Syahid akan segera diperbarui.</p>
        </div>

        @endif

    </div>
</section>

{{-- =====================================================
     LIGHTBOX MODAL
     ===================================================== --}}
<div
    class="ms-lightbox"
    id="msLightbox"
    role="dialog"
    aria-modal="true"
    aria-labelledby="msLbTitleText"
>
    <div class="ms-lb-backdrop" id="msLbBackdrop"></div>
    <div class="ms-lb-content" role="document">
        <div class="ms-lb-header">
            <span class="ms-lb-title" id="msLbTitleText"></span>
            <button class="ms-lb-close" id="msLbClose" aria-label="Tutup">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="ms-lb-body">
            <img id="msLbImg" src="" alt="Bagan Struktur Organisasi LDK Syahid">
        </div>
    </div>
</div>

{{-- =====================================================
     DETAIL POPUP MODAL — Bottom Sheet (Mobile)
     ===================================================== --}}
<div
    class="ms-detail-modal"
    id="msDetailModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="msDmName"
>
    <div class="ms-dm-backdrop" id="msDmBackdrop"></div>
    <div class="ms-dm-sheet" id="msDmSheet">
        <div class="ms-dm-handle"></div>

        {{-- Gradient Header --}}
        <div class="ms-dm-header">
            <div class="ms-dm-header-info">
                <div class="ms-dm-eyebrow" id="msDmBatch"></div>
                <h5 class="ms-dm-name" id="msDmName"></h5>
                <span class="ms-dm-period-badge" id="msDmPeriod">
                    <i class="fas fa-calendar-alt" style="font-size:0.62rem;"></i>
                </span>
            </div>
            <button class="ms-dm-close" id="msDmClose" aria-label="Tutup">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Scrollable Body --}}
        <div class="ms-dm-body">

            {{-- Profile Photo --}}
            <div class="ms-dm-photo-wrap">
                <img id="msDmPhoto" src="" alt="">
            </div>

            {{-- Description --}}
            <div class="ms-dm-desc-wrap">
                <div class="ms-dm-desc-label">
                    <i class="fas fa-info-circle" style="color:var(--primary);"></i>
                    Tentang Kepengurusan
                </div>
                <p id="msDmDesc"></p>
            </div>

            {{-- Structure Chart --}}
            <div class="ms-dm-chart-section">
                <div class="ms-dm-chart-label">
                    <i class="fas fa-sitemap" style="color:var(--primary);"></i>
                    Bagan Struktur Organisasi
                </div>
                <img id="msDmChart" src="" alt="">
            </div>

        </div>
    </div>
</div>

@endsection

{{-- =====================================================
     SCRIPTS
     ===================================================== --}}
@section('scripts')
<script>
(function () {
    'use strict';

    var btt = document.querySelector('.back-to-top');

    /* ─── Helper: hide / show back-to-top ─── */
    function hideBtt() {
        if (btt) btt.style.cssText =
            'opacity:0!important;pointer-events:none!important;transform:scale(0.7) translateY(10px)!important;transition:opacity .3s ease,transform .3s ease!important;';
    }
    function showBtt() {
        if (btt) btt.style.cssText = '';
    }

    /* ─── 1. SCROLL REVEAL ─── */
    var revealEls = document.querySelectorAll('.ms-reveal');
    if ('IntersectionObserver' in window && revealEls.length) {
        var ro = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('visible'); ro.unobserve(e.target); }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
        revealEls.forEach(function (el) { ro.observe(el); });
    } else {
        revealEls.forEach(function (el) { el.classList.add('visible'); });
    }

    /* ─── 2. ANIMATED FEATURE LIST ─── */
    var featLists = document.querySelectorAll('[data-ms-list]');
    if ('IntersectionObserver' in window && featLists.length) {
        var lo = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) {
                    e.target.querySelectorAll('li').forEach(function (li, i) {
                        li.style.animationDelay = (0.1 + i * 0.15) + 's';
                        li.classList.add('ms-li-visible');
                    });
                    lo.unobserve(e.target);
                }
            });
        }, { threshold: 0.2 });
        featLists.forEach(function (l) { lo.observe(l); });
    } else {
        featLists.forEach(function (l) {
            l.querySelectorAll('li').forEach(function (li) { li.classList.add('ms-li-visible'); });
        });
    }

    /* ─── 3. LIGHTBOX (desktop chart click) ─── */
    var lb        = document.getElementById('msLightbox');
    var lbImg     = document.getElementById('msLbImg');
    var lbTitle   = document.getElementById('msLbTitleText');
    var lbClose   = document.getElementById('msLbClose');
    var lbBg      = document.getElementById('msLbBackdrop');
    var prevFocus = null;

    if (lb) {
        function openLb(src, title) {
            prevFocus = document.activeElement;
            lbImg.src = src || '';
            lbTitle.textContent = title || '';
            lb.classList.add('ms-lb-active');
            lb.classList.remove('ms-lb-closing');
            document.body.classList.add('ms-modal-open');
            hideBtt();
            setTimeout(function () { if (lbClose) lbClose.focus(); }, 60);
        }

        function closeLb() {
            lb.classList.add('ms-lb-closing');
            setTimeout(function () {
                lb.classList.remove('ms-lb-active', 'ms-lb-closing');
                document.body.classList.remove('ms-modal-open');
                lbImg.src = '';
                showBtt();
                if (prevFocus) prevFocus.focus();
            }, 340);
        }

        document.querySelectorAll('[data-ms-lb]').forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                openLb(this.dataset.src, this.dataset.title);
            });
            el.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openLb(this.dataset.src, this.dataset.title); }
            });
        });

        lbClose.addEventListener('click', closeLb);
        lbBg.addEventListener('click', closeLb);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && lb.classList.contains('ms-lb-active')) closeLb();
        });

        lb.addEventListener('keydown', function (e) {
            if (e.key !== 'Tab') return;
            var f = lb.querySelectorAll('button,[href],[tabindex]:not([tabindex="-1"])');
            var first = f[0], last = f[f.length - 1];
            if (e.shiftKey) { if (document.activeElement === first) { e.preventDefault(); last.focus(); } }
            else            { if (document.activeElement === last)  { e.preventDefault(); first.focus(); } }
        });
    }

    /* ─── 4. DETAIL POPUP (mobile "Lihat Selengkapnya") ─── */
    var dm       = document.getElementById('msDetailModal');
    var dmBg     = document.getElementById('msDmBackdrop');
    var dmClose  = document.getElementById('msDmClose');
    var dmSheet  = document.getElementById('msDmSheet');
    var dmBatch  = document.getElementById('msDmBatch');
    var dmName   = document.getElementById('msDmName');
    var dmPeriod = document.getElementById('msDmPeriod');
    var dmDesc   = document.getElementById('msDmDesc');
    var dmPhoto  = document.getElementById('msDmPhoto');
    var dmChart  = document.getElementById('msDmChart');

    if (dm) {
        function openDm(data) {
            dmBatch.textContent = data.batch  || '';
            dmName.textContent  = data.name   || '';
            dmPeriod.innerHTML  = '<i class="fas fa-calendar-alt" style="font-size:0.62rem;"></i> Masa Bakti ' + (data.period || '');
            dmDesc.textContent  = data.desc   || '';
            dmPhoto.src = data.photo || '';
            dmPhoto.alt = 'Foto Pengurus ' + (data.batch || '');
            dmChart.src = data.chart || '';
            dmChart.alt = 'Bagan Struktur ' + (data.batch || '');
            dm.classList.add('ms-dm-active');
            dm.classList.remove('ms-dm-closing');
            document.body.classList.add('ms-modal-open');
            hideBtt();
            /* Scroll body to top */
            if (dmSheet) {
                var body = dmSheet.querySelector('.ms-dm-body');
                if (body) body.scrollTop = 0;
            }
            setTimeout(function () { if (dmClose) dmClose.focus(); }, 80);
        }

        function closeDm() {
            dm.classList.add('ms-dm-closing');
            setTimeout(function () {
                dm.classList.remove('ms-dm-active', 'ms-dm-closing');
                document.body.classList.remove('ms-modal-open');
                dmPhoto.src = '';
                dmChart.src = '';
                showBtt();
            }, 340);
        }

        document.querySelectorAll('.ms-detail-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openDm({
                    batch : this.dataset.batch,
                    name  : this.dataset.name,
                    period: this.dataset.period,
                    desc  : this.dataset.desc,
                    photo : this.dataset.photo,
                    chart : this.dataset.chart
                });
            });
        });

        dmClose.addEventListener('click', closeDm);
        dmBg.addEventListener('click', closeDm);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && dm.classList.contains('ms-dm-active')) closeDm();
        });
    }

    /* ─── 5. MOBILE OWL CAROUSEL + DOTS-ONLY NAV ─── */
    $(document).ready(function () {
        var $c = $('#msCarousel');
        if (!$c.length || window.innerWidth > 991) return;

        /* Init carousel — stagePadding for breathing room like article carousel */
        $c.owlCarousel({
            items       : 1,
            loop        : false,
            margin      : 0,
            stagePadding: 20,
            dots        : false,
            nav         : false,
            smartSpeed  : 480,
            autoplay    : false,
            touchDrag   : true,
            mouseDrag   : false
        });

        /* ── Build custom dots ── */
        var total   = $c.find('.owl-item').length;
        var $dots   = $('#msMobDots');

        for (var i = 0; i < total; i++) {
            $dots.append(
                '<button class="ms-mob-dot' + (i === 0 ? ' active' : '') +
                '" data-idx="' + i + '" aria-label="Slide ' + (i + 1) + '"></button>'
            );
        }

        /* Update active dot */
        function syncDots(idx) {
            $dots.find('.ms-mob-dot').removeClass('active');
            $dots.find('[data-idx="' + idx + '"]').addClass('active');
        }

        syncDots(0);

        /* Dot click — jump to slide */
        $dots.on('click', '.ms-mob-dot', function () {
            $c.trigger('to.owl.carousel', [parseInt($(this).data('idx')), 480]);
        });

        /* Sync on carousel change */
        $c.on('changed.owl.carousel', function (e) {
            syncDots(e.item.index);
        });

        /* Hide nav if only one item */
        if (total <= 1) {
            $('#msMobNav').hide();
        }
    });

})();
</script>
@endsection
