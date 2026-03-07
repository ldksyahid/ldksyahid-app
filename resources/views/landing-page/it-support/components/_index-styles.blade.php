@verbatim
<style>
/* ================================================================
   IT SUPPORT PAGE  —  prefix: its-
   ================================================================ */

:root {
    --its-primary:       #00a79d;
    --its-primary-dark:  #008b82;
    --its-primary-light: #e0f7f5;
    --its-dark:          #2c3e50;
    --its-gray:          #7f8c8d;
    --its-gray-100:      #f3f4f6;
    --its-gray-200:      #e5e7eb;
    --its-shadow-sm:     0 4px 20px rgba(0,0,0,.07);
    --its-shadow-hover:  0 14px 40px rgba(0,167,157,.15), 0 2px 8px rgba(0,0,0,.05);
}


/* ─── Page Section ────────────────────────────────────────────── */
.its-section {
    padding: 4rem 0 5.5rem;
}


/* ─── Section Header ──────────────────────────────────────────── */
.its-section-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--its-primary-light); color: var(--its-primary);
    border-radius: 50px; padding: .4rem 1.2rem;
    font-size: .85rem; font-weight: 600; position: relative;
}
.its-badge-pulse {
    width: 8px; height: 8px; background: var(--its-primary);
    border-radius: 50%; position: relative; flex-shrink: 0;
    animation: itsPulse 2s ease infinite;
}
@keyframes itsPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%       { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}
.its-section-title {
    font-size: 2rem; font-weight: 700; color: var(--its-dark); margin: 0;
}
.its-section-sub {
    color: var(--its-gray); font-size: 1rem; margin: .5rem 0 0;
}


/* ─── Animated Bullet ─────────────────────────────────────────── */
.its-bullet {
    display: inline-block;
    width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
    background: var(--its-primary);
    animation: itsGrow 2s ease-in-out infinite;
}
@keyframes itsGrow {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%       { transform: scale(1.5); opacity: .65; }
}


/* ─── Position Badge ──────────────────────────────────────────── */
.its-position-badge {
    display: inline-flex; align-items: center; gap: 5px;
    background: color-mix(in srgb, var(--its-primary) 10%, white);
    color: var(--its-primary);
    padding: 5px 14px 5px 10px; border-radius: 10px;
    font-size: .72rem; font-weight: 700; letter-spacing: .2px;
    box-shadow: 0 2px 8px color-mix(in srgb, var(--its-primary) 12%, transparent);
    transition: all .3s ease;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    max-width: 100%;
}
.its-position-badge::before {
    content: '';
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--its-primary); flex-shrink: 0;
    animation: itsDot 2s ease-in-out infinite;
}
@keyframes itsDot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .5; transform: scale(1.4); }
}
.its-card:hover .its-position-badge {
    background: var(--its-primary); color: white;
    box-shadow: 0 4px 14px color-mix(in srgb, var(--its-primary) 30%, transparent);
}
.its-card:hover .its-position-badge::before { background: white; animation: none; }


/* ─── Desktop Grid ────────────────────────────────────────────── */
.its-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}


/* ─── Desktop Card ────────────────────────────────────────────── */
.its-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    transition: all .35s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
}
.its-card:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow:
        0 20px 40px rgba(0,0,0,.09),
        0 4px 20px color-mix(in srgb, var(--its-primary) 18%, transparent);
}

/* Photo */
.its-card-img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 3 / 4;
    overflow: hidden;
}
.its-card-img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center top;
    display: block;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
}
.its-card:hover .its-card-img { transform: scale(1.07); }

/* "Terbaru" badge */
.its-card-new-badge {
    position: absolute; top: .75rem; right: .75rem; z-index: 2;
    background: linear-gradient(135deg, var(--its-primary) 0%, #00d9bb 100%);
    color: white; font-size: .67rem; font-weight: 700;
    padding: .22rem .75rem; border-radius: 50px;
    letter-spacing: .4px; text-transform: uppercase;
    box-shadow: 0 3px 10px rgba(0,167,157,.45);
}

/* Card Body */
.its-card-body {
    padding: 1.1rem 1.25rem 1.25rem;
    display: flex; flex-direction: column; flex: 1; gap: .5rem;
}

/* Name */
.its-card-name {
    font-size: .98rem; font-weight: 700; color: var(--its-dark);
    margin: 0; line-height: 1.4;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color .3s ease;
    /* Animated underline on hover */
    background-image: linear-gradient(var(--its-primary), var(--its-primary));
    background-size: 0% 2px;
    background-repeat: no-repeat; background-position: left bottom;
    transition: background-size .3s ease, color .3s ease;
    padding-bottom: 1px;
}
.its-card:hover .its-card-name {
    background-size: 100% 2px;
    color: var(--its-primary);
}

/* Forkat */
.its-forkat {
    display: flex; align-items: center; gap: .5rem;
    color: var(--its-gray); font-size: .8rem; font-weight: 500;
}
.its-forkat--sm {
    display: flex; align-items: center; gap: .4rem;
    color: var(--its-gray); font-size: .75rem; font-weight: 500;
}

/* Social Links */
.its-social-links {
    display: flex; gap: .5rem; margin-top: auto; padding-top: .25rem;
}
.its-social-btn {
    display: flex; align-items: center; justify-content: center;
    width: 36px; height: 36px; border-radius: 50%;
    text-decoration: none; font-size: .9rem;
    transition: all .28s cubic-bezier(.4,0,.2,1);
    flex-shrink: 0;
}
.its-social-btn--ig {
    background: color-mix(in srgb, #e1306c 10%, white);
    color: #e1306c;
}
.its-social-btn--ig:hover {
    background: linear-gradient(45deg, #f9ce34, #ee2a7b, #6228d7);
    color: white; transform: scale(1.12) rotate(-5deg);
    box-shadow: 0 4px 16px rgba(238,42,123,.35);
}
.its-social-btn--li {
    background: color-mix(in srgb, #0077b5 10%, white);
    color: #0077b5;
}
.its-social-btn--li:hover {
    background: #0077b5; color: white; transform: scale(1.12) rotate(5deg);
    box-shadow: 0 4px 16px rgba(0,119,181,.35);
}


/* ─── Empty State ─────────────────────────────────────────────── */
.its-empty-state {
    text-align: center; padding: 3.5rem 1.5rem 4rem; color: var(--its-gray);
}
.its-empty-visual {
    position: relative; display: inline-flex;
    align-items: center; justify-content: center;
    width: 160px; height: 160px; margin: 0 auto 2rem;
}
.its-empty-icon-wrap {
    position: relative; z-index: 3;
    width: 88px; height: 88px; border-radius: 28px;
    background: linear-gradient(135deg, #00c4b8, #00a79d);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 2rem;
    box-shadow: 0 12px 36px rgba(0,167,157,.38), 0 4px 12px rgba(0,0,0,.06);
    animation: itsEmptyFloat 3.2s ease-in-out infinite;
}
@keyframes itsEmptyFloat {
    0%, 100% { transform: translateY(0) rotate(-2deg); }
    50%       { transform: translateY(-10px) rotate(2deg); }
}
.its-empty-ring {
    position: absolute; border-radius: 50%;
    border: 2px solid rgba(0,167,157,.14);
    top: 50%; left: 50%; transform: translate(-50%, -50%);
    animation: itsEmptyRing 3s ease-out infinite;
}
.its-empty-ring-1 { width: 116px; height: 116px; animation-delay: 0s; }
.its-empty-ring-2 { width: 150px; height: 150px; animation-delay: .85s; }
@keyframes itsEmptyRing {
    0%   { opacity: .55; transform: translate(-50%, -50%) scale(.85); }
    100% { opacity: 0;   transform: translate(-50%, -50%) scale(1.35); }
}
.its-empty-title { font-size: 1.35rem; font-weight: 800; color: var(--its-dark); margin: 0 0 .5rem; }
.its-empty-sub   { font-size: .88rem; color: var(--its-gray); margin: 0 auto .85rem; max-width: 320px; line-height: 1.55; }


/* ─── Mobile Carousel ─────────────────────────────────────────── */
.its-mobile-carousel {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    gap: 1rem;
    padding: .25rem 1.25rem 1rem;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.its-mobile-carousel::-webkit-scrollbar { display: none; }

.its-mobile-card {
    flex: 0 0 66vw; max-width: 220px;
    scroll-snap-align: start;
    background: white; border-radius: 18px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.09);
    cursor: pointer;
    transition: transform .28s ease, box-shadow .28s ease;
}
.its-mobile-card:active {
    transform: scale(.97);
    box-shadow: 0 10px 30px color-mix(in srgb, var(--its-primary) 22%, transparent);
}

/* Mobile photo */
.its-m-photo {
    position: relative; overflow: hidden;
    aspect-ratio: 3 / 4;
}
.its-m-photo img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center top;
    display: block; transition: transform .4s ease;
}
.its-mobile-card:active .its-m-photo img { transform: scale(1.04); }

/* Tap hint */
.its-m-tap-hint {
    position: absolute; bottom: 10px; right: 10px;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
    border-radius: 20px; padding: 5px 12px;
    font-size: .7rem; font-weight: 600; color: var(--its-dark);
    z-index: 2;
    animation: itsTapPulse 2s ease-in-out infinite;
}
@keyframes itsTapPulse {
    0%, 100% { opacity: .9; transform: scale(1); }
    50%       { opacity: .6; transform: scale(.97); }
}

/* Mobile card body */
.its-m-body { padding: .8rem .9rem 1rem; display: flex; flex-direction: column; gap: .35rem; }
.its-m-name {
    font-size: .9rem; font-weight: 700; color: var(--its-dark);
    margin: 0; line-height: 1.35;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Carousel dots */
.its-carousel-dots {
    display: flex; justify-content: center; align-items: center;
    gap: .4rem; padding: .35rem .5rem;
}
.its-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--its-gray-200);
    transition: all .3s ease; cursor: pointer; flex-shrink: 0;
}
.its-dot.active {
    width: 20px; border-radius: 3px;
    background: var(--its-primary);
}


/* ─── Mobile Bottom Sheet ─────────────────────────────────────── */
.its-bs-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
    z-index: 1070;
    opacity: 0; visibility: hidden;
    transition: opacity .3s ease, visibility .3s ease;
}
.its-bs-backdrop.active { opacity: 1; visibility: visible; }

.its-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 1090; max-height: 88dvh;
    overflow-y: auto;
    overscroll-behavior: contain;
    transform: translateY(100%);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
}
.its-bottom-sheet.open { transform: translateY(0); }

.its-bs-close {
    position: absolute; top: .75rem; right: 1rem;
    background: rgba(255,255,255,.95); border: none;
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--its-primary); font-size: .9rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.15);
    transition: background .2s, color .2s; z-index: 5;
}
.its-bs-close:hover { background: var(--its-primary); color: white; }

.its-bs-content { position: relative; }

/* BS Photo */
.its-bs-photo-wrap {
    position: relative; width: 100%; height: 320px; overflow: hidden;
}
.its-bs-photo {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center top;
    display: block;
}
.its-bs-drag-handle {
    position: absolute; top: 12px; left: 50%;
    transform: translateX(-50%);
    width: 40px; height: 4px;
    background: rgba(255,255,255,.82); border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0,0,0,.18); z-index: 2;
}
.its-bs-photo-gradient {
    position: absolute; bottom: 0; left: 0; right: 0; height: 110px;
    background: linear-gradient(to top, white 0%, transparent 100%);
    pointer-events: none; z-index: 1;
}

/* BS Info */
.its-bs-info { padding: .6rem 1.4rem 2.5rem; }
.its-bs-name {
    font-size: 1.4rem; font-weight: 800; color: var(--its-dark);
    margin: .6rem 0 .4rem; line-height: 1.3;
}
.its-bs-forkat {
    display: flex; align-items: center; gap: .5rem;
    color: var(--its-gray); font-size: .9rem; font-weight: 500;
    margin: .6rem 0 1.5rem;
}

/* BS Social Buttons */
.its-bs-social {
    display: flex; gap: .75rem;
}
.its-bs-social-btn {
    display: flex; align-items: center; justify-content: center; gap: .55rem;
    flex: 1; padding: .85rem 1rem; border-radius: 50px;
    text-decoration: none; font-weight: 700; font-size: .88rem;
    transition: all .25s ease; border: none; cursor: pointer;
    box-shadow: 0 4px 16px rgba(0,0,0,.12);
}
.its-bs-social-btn:hover { transform: translateY(-2px); }

.its-bs-social-btn--ig {
    background: linear-gradient(135deg, #f9ce34 0%, #ee2a7b 50%, #6228d7 100%);
    color: white;
}
.its-bs-social-btn--ig:hover {
    box-shadow: 0 6px 20px rgba(238,42,123,.40);
    color: white;
}
.its-bs-social-btn--li {
    background: #0077b5; color: white;
}
.its-bs-social-btn--li:hover {
    background: #006396; color: white;
    box-shadow: 0 6px 20px rgba(0,119,181,.40);
}


/* ─── Scroll Lock + Back-to-Top Hide ─────────────────────────── */
body.its-sheet-open {
    overflow: hidden !important;
    touch-action: none;
}
body.its-sheet-open .back-to-top {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
    transition: opacity .3s ease, visibility .3s ease;
}


/* ─── SweetAlert toast above sheet ───────────────────────────── */
.its-swal-below-nav {
    top: 76px !important;
    right: 1rem !important;
    z-index: 1100 !important;
}


/* ─── Tablet: center bottom sheet ────────────────────────────── */
@media (min-width: 768px) {
    .its-bottom-sheet {
        max-width: 480px; left: 50%;
        transform: translate(-50%, 100%);
    }
    .its-bottom-sheet.open { transform: translate(-50%, 0); }
}


/* ─── Responsive ──────────────────────────────────────────────── */
@media (max-width: 1399.98px) {
    .its-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 1199.98px) {
    .its-grid { grid-template-columns: repeat(3, 1fr); }
    .its-section-title { font-size: 1.75rem; }
}
@media (max-width: 991.98px) {
    .its-section-title { font-size: 1.5rem; }
    .its-mobile-card { flex: 0 0 62vw; }
}
@media (max-width: 576px) {
    .its-mobile-card { flex: 0 0 72vw; }
    .its-section { padding: 3rem 0 4rem; }
}
</style>
@endverbatim
