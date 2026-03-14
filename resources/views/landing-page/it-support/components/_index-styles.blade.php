@verbatim
<style>
/* ================================================================
   IT SUPPORT PAGE  —  prefix: its-
   ================================================================ */

:root {
    --its-primary:       #00a79d;
    --its-primary-dark:  #008b82;
    --its-primary-light: #e0f7f5;
    --its-dark:          #1e293b;
    --its-gray:          #64748b;
    --its-gray-100:      #f1f5f9;
    --its-gray-200:      #e2e8f0;
    --its-shadow-sm:     0 4px 20px rgba(0,0,0,.07);
}


/* ─── Page Section ────────────────────────────────────────────── */
.its-section { padding: 4rem 0 6rem; }


/* ─── Section Header ──────────────────────────────────────────── */
.its-section-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--its-primary-light); color: var(--its-primary);
    border-radius: 50px; padding: .4rem 1.2rem;
    font-size: .85rem; font-weight: 600;
}
.its-badge-pulse {
    width: 8px; height: 8px; background: var(--its-primary);
    border-radius: 50%; flex-shrink: 0;
    animation: itsPulse 2s ease infinite;
}
@keyframes itsPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%       { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}
.its-section-title { font-size: 2rem; font-weight: 800; color: var(--its-dark); margin: 0; letter-spacing: -.3px; }
.its-section-sub   { color: var(--its-gray); font-size: 1rem; margin: .5rem 0 0; }


/* ─── Animated Growing Bullet ─────────────────────────────────── */
.its-bullet {
    display: inline-block;
    width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0;
    background: var(--its-accent, var(--its-primary));
    animation: itsGrow 2.4s ease-in-out infinite;
}
@keyframes itsGrow {
    0%, 100% { transform: scale(1); opacity: 1; box-shadow: 0 0 0 0 color-mix(in srgb, var(--its-accent, var(--its-primary)) 40%, transparent); }
    50%       { transform: scale(1.6); opacity: .7; box-shadow: 0 0 0 5px transparent; }
}


/* ─── Position Badge ──────────────────────────────────────────── */
.its-position-badge {
    display: inline-flex; align-items: center; gap: 5px;
    background: color-mix(in srgb, var(--its-accent, var(--its-primary)) 12%, white);
    color: var(--its-accent, var(--its-primary));
    padding: 5px 14px 5px 10px; border-radius: 10px;
    font-size: .7rem; font-weight: 700; letter-spacing: .15px;
    transition: all .3s ease;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    max-width: 180px;
}
.its-position-badge::before {
    content: ''; width: 6px; height: 6px; border-radius: 50%;
    background: var(--its-accent, var(--its-primary)); flex-shrink: 0;
    animation: itsDot 2s ease-in-out infinite;
}
@keyframes itsDot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .45; transform: scale(1.5); }
}
.its-card:hover .its-position-badge {
    background: var(--its-accent, var(--its-primary)); color: white;
    box-shadow: 0 4px 14px color-mix(in srgb, var(--its-accent, var(--its-primary)) 35%, transparent);
}
.its-card:hover .its-position-badge::before { background: white; animation: none; }


/* ═══════════════════════════════════════════════════════════════
   DESKTOP GRID
   ═══════════════════════════════════════════════════════════════ */
.its-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.75rem;
    margin-bottom: 1.5rem;
}


/* ─── Desktop Card ────────────────────────────────────────────── */
.its-card {
    --its-accent: #00a79d;
    background: white;
    border-radius: 22px;
    overflow: hidden;
    box-shadow:
        0 1px 3px rgba(0,0,0,.04),
        0 6px 24px rgba(0,0,0,.08);
    transition: transform .4s cubic-bezier(.4,0,.2,1),
                box-shadow .4s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
    text-align: center;
    z-index: 1;
}
.its-card:hover {
    transform: translateY(-12px);
    box-shadow:
        0 2px 4px rgba(0,0,0,.04),
        0 28px 56px color-mix(in srgb, var(--its-accent) 22%, rgba(0,0,0,.12));
}

/* Gradient Header */
.its-card-hdr {
    height: 116px;
    background: linear-gradient(
        135deg,
        var(--its-accent) 0%,
        color-mix(in srgb, var(--its-accent) 65%, #0f172a) 100%
    );
    position: relative;
    flex-shrink: 0;
}
/* Subtle shine sweep on hover */
.its-card-hdr::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.14) 50%, transparent 60%);
    transform: translateX(-100%);
    transition: transform .55s ease;
    pointer-events: none;
}
.its-card:hover .its-card-hdr::after { transform: translateX(100%); }

/* "Terbaru" badge on header */
.its-card-new-badge {
    position: absolute; top: .8rem; right: .8rem;
    background: rgba(255,255,255,.22);
    backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.38);
    color: white; font-size: .65rem; font-weight: 700;
    padding: .22rem .75rem; border-radius: 50px;
    letter-spacing: .5px; text-transform: uppercase;
}

/* Photo band — circular overlap */
.its-photo-band {
    display: flex; justify-content: center;
    background: white; flex-shrink: 0;
}
.its-photo-ring {
    width: 108px; height: 108px;
    border-radius: 50%;
    border: 5px solid white;
    box-shadow:
        0 0 0 2px color-mix(in srgb, var(--its-accent) 25%, transparent),
        0 8px 24px rgba(0,0,0,.18);
    overflow: hidden;
    margin-top: -54px;
    position: relative; z-index: 2;
    background: var(--its-gray-100);
    transition: transform .45s cubic-bezier(.175,.885,.32,1.275),
                box-shadow .45s ease;
}
.its-card:hover .its-photo-ring {
    transform: scale(1.1) translateY(-5px);
    box-shadow:
        0 0 0 3px color-mix(in srgb, var(--its-accent) 40%, transparent),
        0 14px 36px color-mix(in srgb, var(--its-accent) 35%, rgba(0,0,0,.2));
}
.its-card-img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center top;
    border-radius: 50%; display: block;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
}
.its-card:hover .its-card-img { transform: scale(1.06); }

/* Card body */
.its-card-body {
    padding: .8rem 1.4rem 1.6rem;
    display: flex; flex-direction: column; align-items: center; flex: 1;
    gap: .45rem;
}

/* Name */
.its-card-name {
    font-size: 1.02rem; font-weight: 800; color: var(--its-dark);
    margin: 0; line-height: 1.35; letter-spacing: -.1px;
    transition: color .3s ease;
}
.its-card:hover .its-card-name { color: var(--its-accent); }

/* Forkat */
.its-forkat {
    display: flex; align-items: center; gap: .45rem; justify-content: center;
    color: var(--its-gray); font-size: .78rem; font-weight: 500;
}

/* Social Links */
.its-social-links {
    display: flex; gap: .55rem; justify-content: center; margin-top: .4rem;
}
.its-social-btn {
    display: flex; align-items: center; justify-content: center;
    width: 40px; height: 40px; border-radius: 50%;
    text-decoration: none; font-size: .95rem;
    transition: all .3s cubic-bezier(.175,.885,.32,1.275);
    flex-shrink: 0;
}
.its-social-btn--ig {
    background: color-mix(in srgb, #e1306c 10%, white);
    color: #e1306c;
    box-shadow: 0 2px 8px rgba(225,48,108,.15);
}
.its-social-btn--ig:hover {
    background: linear-gradient(45deg, #f9ce34, #ee2a7b, #6228d7);
    color: white; transform: scale(1.18) rotate(-6deg);
    box-shadow: 0 6px 20px rgba(238,42,123,.42);
}
.its-social-btn--li {
    background: color-mix(in srgb, #0077b5 10%, white);
    color: #0077b5;
    box-shadow: 0 2px 8px rgba(0,119,181,.15);
}
.its-social-btn--li:hover {
    background: #0077b5; color: white; transform: scale(1.18) rotate(6deg);
    box-shadow: 0 6px 20px rgba(0,119,181,.42);
}


/* ─── Empty State ─────────────────────────────────────────────── */
.its-empty-state {
    text-align: center; padding: 4rem 1.5rem 4rem; color: var(--its-gray);
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
    top: 50%; left: 50%; transform: translate(-50%,-50%);
    animation: itsEmptyRing 3s ease-out infinite;
}
.its-empty-ring-1 { width: 116px; height: 116px; animation-delay: 0s; }
.its-empty-ring-2 { width: 150px; height: 150px; animation-delay: .85s; }
@keyframes itsEmptyRing {
    0%   { opacity: .55; transform: translate(-50%,-50%) scale(.85); }
    100% { opacity: 0;   transform: translate(-50%,-50%) scale(1.35); }
}
.its-empty-title { font-size: 1.35rem; font-weight: 800; color: var(--its-dark); margin: 0 0 .5rem; }
.its-empty-sub   { font-size: .88rem; color: var(--its-gray); max-width: 300px; margin: 0 auto; }


/* ═══════════════════════════════════════════════════════════════
   MOBILE CAROUSEL
   ═══════════════════════════════════════════════════════════════ */
.its-mobile-carousel {
    display: flex;
    overflow-x: auto; scroll-snap-type: x mandatory;
    gap: 1rem; padding: .5rem 1.25rem 1rem;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.its-mobile-carousel::-webkit-scrollbar { display: none; }

.its-mobile-card {
    --its-accent: #00a79d;
    flex: 0 0 58vw; max-width: 210px;
    scroll-snap-align: start;
    background: white; border-radius: 18px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.09);
    cursor: pointer; text-align: center;
    display: flex; flex-direction: column;
    transition: transform .28s ease, box-shadow .28s ease;
}
.its-mobile-card:active {
    transform: scale(.96);
    box-shadow: 0 10px 30px color-mix(in srgb, var(--its-accent) 22%, transparent);
}

/* Mobile gradient header */
.its-m-hdr {
    height: 90px;
    background: linear-gradient(
        135deg,
        var(--its-accent) 0%,
        color-mix(in srgb, var(--its-accent) 62%, #0f172a) 100%
    );
    position: relative; flex-shrink: 0;
}

/* Mobile photo */
.its-m-photo-band {
    display: flex; justify-content: center;
    background: white; flex-shrink: 0;
}
.its-m-photo-ring {
    width: 88px; height: 88px;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow:
        0 0 0 2px color-mix(in srgb, var(--its-accent) 22%, transparent),
        0 6px 18px rgba(0,0,0,.16);
    overflow: hidden;
    margin-top: -44px; position: relative; z-index: 2;
    background: var(--its-gray-100);
}
.its-m-photo-ring img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center top;
    border-radius: 50%; display: block;
}

/* Mobile card body */
.its-m-body {
    padding: .65rem .9rem 1rem;
    display: flex; flex-direction: column; align-items: center;
    gap: .3rem; flex: 1;
}
.its-m-name {
    font-size: .9rem; font-weight: 700; color: var(--its-dark);
    margin: 0; line-height: 1.3;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}
.its-forkat--sm {
    display: flex; align-items: center; gap: .38rem; justify-content: center;
    color: var(--its-gray); font-size: .73rem; font-weight: 500;
}
.its-m-tap-hint {
    font-size: .68rem; font-weight: 600; color: var(--its-gray);
    margin-top: .15rem; opacity: .55;
    animation: itsTapPulse 2.2s ease-in-out infinite;
}
@keyframes itsTapPulse {
    0%, 100% { opacity: .55; }
    50%       { opacity: .3; }
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
    width: 20px; border-radius: 3px; background: var(--its-primary);
}


/* ═══════════════════════════════════════════════════════════════
   MOBILE BOTTOM SHEET
   ═══════════════════════════════════════════════════════════════ */
.its-bs-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.48);
    backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);
    z-index: 1070; opacity: 0; visibility: hidden;
    transition: opacity .3s ease, visibility .3s ease;
}
.its-bs-backdrop.active { opacity: 1; visibility: visible; }

.its-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: white; border-radius: 26px 26px 0 0;
    z-index: 1090; max-height: 88dvh;
    overflow-y: auto; overscroll-behavior: contain;
    transform: translateY(100%);
    transition: transform .42s cubic-bezier(.4,0,.2,1);
}
.its-bottom-sheet.open { transform: translateY(0); }

.its-bs-close {
    position: absolute; top: .85rem; right: 1rem;
    background: rgba(255,255,255,.96); border: none;
    width: 38px; height: 38px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--its-primary); font-size: .9rem;
    box-shadow: 0 2px 14px rgba(0,0,0,.15);
    transition: background .2s, color .2s; z-index: 5;
}
.its-bs-close:hover { background: var(--its-primary); color: white; }
.its-bs-content { position: relative; }

/* BS gradient header */
.its-bs-hdr {
    height: 200px;
    background: linear-gradient(
        135deg,
        var(--its-bs-accent, #00a79d) 0%,
        color-mix(in srgb, var(--its-bs-accent, #00a79d) 60%, #0f172a) 100%
    );
    position: relative; flex-shrink: 0;
}
.its-bs-drag-handle {
    position: absolute; top: 12px; left: 50%;
    transform: translateX(-50%);
    width: 40px; height: 4px;
    background: rgba(255,255,255,.6); border-radius: 2px; z-index: 2;
}
/* bottom gradient fade to white */
.its-bs-hdr::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0; height: 80px;
    background: linear-gradient(to top, white 0%, transparent 100%);
    pointer-events: none; z-index: 1;
}

/* BS photo — overlapping */
.its-bs-photo-band {
    display: flex; justify-content: center;
    background: white;
}
.its-bs-photo-ring {
    width: 130px; height: 130px;
    border-radius: 50%;
    border: 5px solid white;
    box-shadow:
        0 0 0 3px color-mix(in srgb, var(--its-bs-accent, #00a79d) 28%, transparent),
        0 12px 36px rgba(0,0,0,.2);
    overflow: hidden;
    margin-top: -65px; position: relative; z-index: 3;
    background: var(--its-gray-100);
}
.its-bs-photo {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center top;
    border-radius: 50%; display: block;
}

/* BS Info */
.its-bs-info {
    padding: .85rem 1.5rem 2.5rem;
    text-align: center;
}
.its-bs-name {
    font-size: 1.5rem; font-weight: 800; color: var(--its-dark);
    margin: .65rem 0 .4rem; line-height: 1.25; letter-spacing: -.2px;
}
.its-bs-forkat {
    display: flex; align-items: center; gap: .5rem; justify-content: center;
    color: var(--its-gray); font-size: .9rem; font-weight: 500;
    margin: .65rem 0 1.75rem;
}

/* BS Social Buttons */
.its-bs-social {
    display: flex; gap: .75rem;
}
.its-bs-social-btn {
    display: flex; align-items: center; justify-content: center; gap: .55rem;
    flex: 1; padding: .9rem 1rem; border-radius: 50px;
    text-decoration: none; font-weight: 700; font-size: .9rem;
    transition: all .28s ease; border: none; cursor: pointer;
}
.its-bs-social-btn:hover { transform: translateY(-2px); }
.its-bs-social-btn--ig {
    background: linear-gradient(135deg, #f9ce34 0%, #ee2a7b 50%, #6228d7 100%);
    color: white; box-shadow: 0 5px 18px rgba(238,42,123,.32);
}
.its-bs-social-btn--ig:hover {
    box-shadow: 0 8px 24px rgba(238,42,123,.48); color: white;
}
.its-bs-social-btn--li {
    background: #0077b5; color: white;
    box-shadow: 0 5px 18px rgba(0,119,181,.32);
}
.its-bs-social-btn--li:hover {
    background: #006396; color: white;
    box-shadow: 0 8px 24px rgba(0,119,181,.48);
}


/* ─── Scroll Lock + Back-to-Top ───────────────────────────────── */
body.its-sheet-open {
    overflow: hidden !important; touch-action: none;
}
body.its-sheet-open .back-to-top {
    opacity: 0 !important; visibility: hidden !important;
    pointer-events: none !important;
    transition: opacity .3s ease, visibility .3s ease;
}

/* ─── SweetAlert above sheet ──────────────────────────────────── */
.its-swal-below-nav {
    top: 76px !important; right: 1rem !important; z-index: 1100 !important;
}


/* ─── Tablet: center sheet ────────────────────────────────────── */
@media (min-width: 768px) {
    .its-bottom-sheet {
        max-width: 480px; left: 50%;
        transform: translate(-50%, 100%);
    }
    .its-bottom-sheet.open { transform: translate(-50%, 0); }
}


/* ─── Responsive ──────────────────────────────────────────────── */
@media (max-width: 1399.98px) { .its-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 1199.98px) {
    .its-grid { grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    .its-section-title { font-size: 1.75rem; }
}
@media (max-width: 991.98px) {
    .its-section-title { font-size: 1.5rem; }
    .its-mobile-card { flex: 0 0 55vw; }
}
@media (max-width: 576px) {
    .its-mobile-card { flex: 0 0 68vw; }
    .its-section { padding: 3rem 0 4.5rem; }
}
</style>
@endverbatim
