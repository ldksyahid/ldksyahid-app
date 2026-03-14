<style>
/* ═══════════════════════════════════════════════
   HOME GALLERY SECTION
   ═══════════════════════════════════════════════ */
.gallery-elegant {
    background: transparent;
    position: relative;
}

/* ── Section Header ── */
.gallery-header-wrap {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}
.gallery-header-wrap.is-visible {
    opacity: 1;
    transform: translateY(0);
}
.section-badge-gal {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: var(--primary-light);
    border-radius: var(--radius-pill);
    padding: 0.5rem 1.25rem;
    margin-bottom: 0.75rem;
    font-size: 0.9rem; font-weight: 500;
    color: var(--primary);
    position: relative;
    box-shadow: 0 2px 8px rgba(0,167,157,.1);
}
.badge-emoji-gal { font-size: 1.1rem; }
.badge-pulse-gal {
    width: 8px; height: 8px;
    background: var(--primary); border-radius: 50%;
    animation: galPulse 2s ease-in-out infinite;
}
@keyframes galPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.5; transform: scale(1.5); }
}
.section-title-gal {
    font-family: var(--font-primary);
    font-size: 2rem; font-weight: 700;
    color: var(--dark); margin-bottom: 0.5rem;
}
.title-highlight-gal {
    color: var(--primary); position: relative;
}
.title-highlight-gal::after {
    content: '';
    position: absolute; bottom: 2px; left: 0;
    width: 100%; height: 8px;
    background: rgba(0,167,157,.15);
    border-radius: 4px; z-index: -1;
}
.section-description-gal {
    color: var(--secondary); font-size: 1rem; margin-bottom: 0;
}

/* ── View All Button ── */
.btn-view-all-gal {
    display: inline-flex; align-items: center; gap: 0.75rem;
    background: var(--primary-gradient);
    color: white; padding: 0.875rem 1.5rem;
    border-radius: 50px; font-weight: 600; text-decoration: none;
    box-shadow: 0 4px 15px rgba(0,167,157,.3);
    transition: all 0.3s ease;
}
.btn-view-all-gal:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,167,157,.4);
    color: white;
}

/* ═══════════════════════════════════════════════
   EVENT CARD (Desktop) — sama persis dengan about/gallery
   ═══════════════════════════════════════════════ */
.gl-event-card {
    background: white; border-radius: 24px;
    box-shadow: 0 4px 24px rgba(0,0,0,.07);
    margin-bottom: 2.25rem; overflow: hidden;
    transition: box-shadow .3s ease, transform .3s ease;
    position: relative;
}
.gl-event-card:hover {
    box-shadow: 0 14px 40px rgba(0,167,157,.15), 0 2px 8px rgba(0,0,0,.05);
    transform: translateY(-4px);
}

/* Gradient Header */
.gl-card-header {
    background: linear-gradient(135deg, #00a79d 0%, #008b82 100%);
    padding: 1rem 1.5rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    position: relative; overflow: hidden;
}
.gl-card-header::before {
    content: '';
    position: absolute; top: -28px; right: -18px;
    width: 90px; height: 90px; border-radius: 50%;
    background: rgba(255,255,255,.1); pointer-events: none;
}
.gl-card-header::after {
    content: '';
    position: absolute; bottom: -30px; left: 30%;
    width: 70px; height: 70px; border-radius: 50%;
    background: rgba(255,255,255,.07); pointer-events: none;
}
.gl-card-header-left {
    display: flex; align-items: center; gap: .65rem;
    position: relative; z-index: 1;
}
.gl-card-header-name {
    color: rgba(255,255,255,.88); font-size: .82rem; font-weight: 700;
    letter-spacing: .2px;
}
.gl-card-header-badges {
    display: flex; align-items: center; gap: .4rem;
    position: relative; z-index: 1; flex-shrink: 0;
}
.gl-card-header .gl-video-badge {
    background: rgba(255,255,255,.15); color: rgba(255,255,255,.95);
    border: 1px solid rgba(255,255,255,.25);
}
.gl-card-header .gl-photo-count {
    background: rgba(255,255,255,.15); color: rgba(255,255,255,.95);
    border: 1px solid rgba(255,255,255,.25); margin-left: 0;
}
.gl-card-body {
    padding: 1.5rem 1.75rem 1.75rem;
    background: linear-gradient(to bottom, #f7fffe 0%, white 60px);
}

/* Badges */
.gl-video-badge {
    background: #fef2f2; color: #ef4444;
    border-radius: 50px; padding: .25rem .75rem;
    font-size: .75rem; font-weight: 600;
    display: inline-flex; align-items: center; gap: .3rem;
}
.gl-photo-count {
    background: var(--primary-light); color: var(--primary);
    border-radius: 50px; padding: .25rem .75rem;
    font-size: .75rem; font-weight: 600;
    display: inline-flex; align-items: center; gap: .3rem;
}

/* Title with left accent bar */
.gl-card-title {
    font-size: 1.4rem; font-weight: 700; color: var(--dark);
    margin: 0 0 .65rem; line-height: 1.35;
    padding-left: 1rem; position: relative;
}
.gl-card-title::before {
    content: '';
    position: absolute; left: 0; top: .15em; bottom: .1em;
    width: 4px; border-radius: 2px;
    background: linear-gradient(to bottom, #00a79d, #008b82);
}
.gl-card-desc {
    color: var(--secondary); font-size: .9rem; line-height: 1.7;
    margin-bottom: 1.25rem;
}

/* Photo grid 3-col (first photo spans full width) */
.gl-photo-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: .65rem; margin-bottom: 1.25rem;
}
.gl-grid-item {
    aspect-ratio: 4/3; border-radius: 10px; overflow: hidden;
    cursor: pointer; transition: transform .25s ease, box-shadow .25s ease;
}
.gl-grid-item:first-child {
    grid-column: 1 / -1; aspect-ratio: 21/7;
}
.gl-grid-item:hover { transform: scale(1.025); box-shadow: 0 6px 18px rgba(0,0,0,.16); }
.gl-grid-item img { width: 100%; height: 100%; object-fit: cover; display: block; }

/* YouTube inline section */
.gl-video-section { margin-bottom: 1.25rem; }
.gl-video-label {
    font-size: .78rem; font-weight: 700; color: var(--secondary);
    text-transform: uppercase; letter-spacing: .5px;
    margin-bottom: .6rem;
    display: flex; align-items: center; gap: .4rem;
}
.gl-video-label i { color: #ef4444; }
.gl-video-thumb {
    position: relative; border-radius: 14px; overflow: hidden;
    aspect-ratio: 16/7; cursor: pointer;
    transition: transform .25s ease, box-shadow .25s ease;
}
.gl-video-thumb:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,.2); }
.gl-video-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.gl-play-btn {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
    width: 68px; height: 68px; border-radius: 50%;
    background: rgba(255,0,0,.85);
    display: flex; align-items: center; justify-content: center;
    transition: all .25s;
}
.gl-play-btn i { color: white; font-size: 26px; margin-left: 5px; }
.gl-video-thumb:hover .gl-play-btn { background: #ef4444; transform: translate(-50%,-50%) scale(1.1); }

/* Card Footer (doc link) */
.gl-card-footer {
    display: flex; align-items: center;
    padding-top: 1rem; margin-top: .5rem;
    border-top: 1px solid var(--gray-200, #e5e7eb);
}
.gl-doc-link {
    display: inline-flex; align-items: center; gap: .4rem;
    color: var(--secondary); font-size: .82rem; font-weight: 600; text-decoration: none;
    padding: .45rem 1rem; border: 1.5px solid #e5e7eb; border-radius: 50px;
    transition: all .2s;
}
.gl-doc-link:hover { color: var(--primary); border-color: var(--primary-light); background: var(--primary-light); }

/* ── Empty State ── */
.gl-empty-state {
    background: white; border-radius: 24px;
    padding: 4rem 2rem; text-align: center;
    box-shadow: 0 8px 40px rgba(0,0,0,.08);
    color: var(--secondary);
}
.gl-empty-icon { font-size: 4rem; margin-bottom: 1rem; opacity: .5; }
.gl-empty-state h4 { font-weight: 700; color: var(--dark); margin-bottom: .5rem; }

/* ═══════════════════════════════════════════════
   MOBILE CARD — sama persis dengan about/gallery
   ═══════════════════════════════════════════════ */
.gl-mobile-card {
    background: white; border-radius: 20px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.09); cursor: pointer;
    transition: transform .28s ease, box-shadow .28s ease;
    margin-bottom: 1.25rem;
}
.gl-mobile-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,167,157,.14), 0 2px 8px rgba(0,0,0,.06);
}
.gl-mobile-thumb { position: relative; aspect-ratio: 4/3; overflow: hidden; }
.gl-mobile-thumb img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform .45s ease;
}
.gl-mobile-card:hover .gl-mobile-thumb img { transform: scale(1.06); }
.gl-mobile-thumb::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, transparent 38%, rgba(0,0,0,.65) 100%);
    pointer-events: none; z-index: 1;
}
.gl-mobile-thumb-bottom {
    position: absolute; bottom: 0; left: 0; right: 0;
    z-index: 2; padding: .65rem .75rem;
    display: flex; justify-content: space-between; align-items: flex-end; gap: .4rem;
}
.gl-m-tag-img {
    background: rgba(0,167,157,.88); color: white;
    border-radius: 50px; padding: .22rem .8rem;
    font-size: .72rem; font-weight: 700; letter-spacing: .2px;
    backdrop-filter: blur(4px); max-width: 62%;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.gl-m-badges { display: flex; gap: .3rem; align-items: center; flex-shrink: 0; }
.gl-m-count, .gl-m-video {
    background: rgba(0,0,0,.45); backdrop-filter: blur(4px);
    color: white; border-radius: 50px;
    padding: .2rem .55rem; font-size: .7rem; font-weight: 600;
    display: inline-flex; align-items: center; gap: .28rem;
}
.gl-m-video { color: #ff6b6b; }
.gl-mobile-card-body { padding: .9rem 1.1rem 1.1rem; }
.gl-mobile-card-no-thumb {
    padding: .85rem 1.1rem .2rem;
    border-bottom: 1px solid #f3f4f6;
}
.gl-m-tag {
    display: inline-block;
    background: var(--primary-light); color: var(--primary);
    border-radius: 50px; padding: .22rem .75rem;
    font-size: .72rem; font-weight: 700;
}
.gl-m-title { font-size: 1rem; font-weight: 700; color: var(--dark); margin: 0 0 .4rem; line-height: 1.35; }
.gl-m-desc  { font-size: .81rem; color: var(--secondary); line-height: 1.55; margin: 0 0 .75rem; }
.gl-m-tap-hint {
    display: inline-flex; align-items: center; gap: .4rem;
    background: var(--primary-light); color: var(--primary);
    font-size: .74rem; font-weight: 700;
    padding: .38rem .9rem; border-radius: 50px;
    transition: background .2s, color .2s;
}
.gl-mobile-card:hover .gl-m-tap-hint { background: var(--primary); color: white; }
.gl-m-tap-hint i { font-size: .65rem; }

/* ═══════════════════════════════════════════════
   VIDEO LIGHTBOX
   ═══════════════════════════════════════════════ */
.gl-video-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.88);
    z-index: 1080;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity .3s ease;
}
.gl-video-overlay.active { opacity: 1; pointer-events: all; }
.gl-video-wrap {
    width: min(90vw, 960px); aspect-ratio: 16/9;
    border-radius: 12px; overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,.5);
}
.gl-video-wrap iframe { width: 100%; height: 100%; border: none; display: block; }
.gl-video-close {
    position: absolute; top: 1.25rem; right: 1.25rem;
    background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2);
    color: white; width: 44px; height: 44px;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: 1rem;
    transition: background .2s, transform .2s;
}
.gl-video-close:hover { background: rgba(255,255,255,.28); transform: rotate(90deg); }

/* ═══════════════════════════════════════════════
   PHOTO ZOOM OVERLAY
   ═══════════════════════════════════════════════ */
.gl-zoom-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.92);
    z-index: 1080;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity .25s ease;
}
.gl-zoom-overlay.active { opacity: 1; pointer-events: all; }
.gl-zoom-img-wrap { max-width: 90vw; max-height: 85vh; display: flex; align-items: center; justify-content: center; }
.gl-zoom-img-wrap img { max-width: 100%; max-height: 85vh; object-fit: contain; border-radius: 8px; box-shadow: 0 8px 40px rgba(0,0,0,.6); }
.gl-zoom-close {
    position: absolute; top: 1rem; right: 1rem;
    background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
    color: white; width: 42px; height: 42px;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .2s, transform .2s; font-size: 1rem;
}
.gl-zoom-close:hover { background: rgba(255,255,255,.25); transform: rotate(90deg); }
.gl-zoom-prev, .gl-zoom-next {
    position: absolute; top: 50%; transform: translateY(-50%);
    background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
    color: white; width: 48px; height: 48px;
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .2s; font-size: .95rem;
}
.gl-zoom-prev { left: 1.5rem; }
.gl-zoom-next { right: 1.5rem; }
.gl-zoom-prev:hover, .gl-zoom-next:hover { background: rgba(255,255,255,.25); }
.gl-zoom-counter {
    position: absolute; bottom: 1.5rem; left: 50%; transform: translateX(-50%);
    background: rgba(0,0,0,.5); color: rgba(255,255,255,.8);
    padding: .3rem .9rem; border-radius: 50px; font-size: .8rem;
}

/* ═══════════════════════════════════════════════
   MOBILE BOTTOM SHEET
   ═══════════════════════════════════════════════ */
.gl-bs-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.5); backdrop-filter: blur(4px);
    z-index: 1070;
    opacity: 0; pointer-events: none;
    transition: opacity .3s ease;
}
.gl-bs-backdrop.active { opacity: 1; pointer-events: all; }

body.gl-sheet-open { overflow: hidden !important; touch-action: none; }

.gl-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: #dff4f2;
    border-radius: 24px 24px 0 0;
    z-index: 1075;
    max-height: 88dvh;
    transform: translateY(100%);
    transition: transform .35s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column; overflow: hidden;
}
.gl-bottom-sheet.active { transform: translateY(0); }
.gl-bs-handle { display: none; }
.gl-bs-close {
    position: absolute; top: .75rem; right: 1rem;
    background: rgba(255,255,255,.7); border: none;
    width: 34px; height: 34px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: #008b82; font-size: .85rem;
    transition: background .2s, color .2s;
    backdrop-filter: blur(4px); z-index: 2;
}
.gl-bs-close:hover { background: #fecaca; color: #ef4444; }

.gl-bs-content {
    overflow-y: auto; flex: 1;
    padding: 0 1.1rem 2rem;
    scrollbar-width: thin;
    background: linear-gradient(to bottom, #dff4f2 0%, white 200px);
}
.gl-bs-content::before {
    content: '';
    display: block;
    width: 40px; height: 4px;
    background: rgba(0,167,157,.45); border-radius: 2px;
    margin: .85rem auto .4rem;
    position: sticky; top: .85rem; z-index: 5; flex-shrink: 0;
}

.gl-bs-header {
    padding: .75rem 0 1.1rem;
    border-bottom: 2px solid var(--primary-light);
    margin-bottom: 1.1rem;
    background: transparent; position: relative; overflow: visible;
}
.gl-bs-header::after {
    content: '';
    position: absolute; top: -10px; right: -1.1rem;
    width: 100px; height: 100px; border-radius: 50%;
    background: rgba(0,167,157,.07); pointer-events: none;
}
.gl-bs-meta { display: flex; align-items: center; gap: .5rem; margin-bottom: .5rem; position: relative; z-index: 1; }
.gl-bs-tag {
    background: var(--primary); color: white;
    border-radius: 50px; padding: .22rem .8rem;
    font-size: .72rem; font-weight: 700; letter-spacing: .2px;
}
.gl-bs-title { font-size: 1.1rem; font-weight: 700; color: var(--dark); margin: 0 0 .5rem; line-height: 1.3; position: relative; z-index: 1; }
.gl-bs-desc  { font-size: .83rem; color: var(--secondary); line-height: 1.6; margin: 0; position: relative; z-index: 1; }

.gl-bs-photo-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; margin-bottom: 1rem; }
.gl-bs-photo { aspect-ratio: 4/3; border-radius: 10px; overflow: hidden; cursor: pointer; }
.gl-bs-photo:first-child { grid-column: span 2; aspect-ratio: 16/7; }
.gl-bs-photo img { width: 100%; height: 100%; object-fit: cover; display: block; }

.gl-bs-video { margin-bottom: 1rem; }
.gl-bs-video-label { font-size: .75rem; font-weight: 700; color: var(--secondary); text-transform: uppercase; letter-spacing: .5px; margin-bottom: .5rem; display: flex; align-items: center; gap: .35rem; }
.gl-bs-video-label i { color: #ef4444; }
.gl-bs-video-thumb { position: relative; border-radius: 12px; overflow: hidden; aspect-ratio: 16/7; cursor: pointer; }
.gl-bs-video-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
.gl-bs-play-btn {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,0,0,.85);
    display: flex; align-items: center; justify-content: center;
}
.gl-bs-play-btn i { color: white; font-size: 18px; margin-left: 3px; }

.gl-bs-actions { display: flex; gap: .6rem; flex-wrap: wrap; margin-top: .5rem; }
.gl-bs-doc {
    display: inline-flex; align-items: center; gap: .4rem;
    color: var(--primary); font-size: .82rem; font-weight: 600; text-decoration: none;
    padding: .5rem 1.1rem; border: 1.5px solid var(--primary-light); border-radius: 50px;
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    .section-title-gal { font-size: 1.5rem; }
    .btn-view-all-gal { width: 100%; justify-content: center; }
    .gl-zoom-prev, .gl-zoom-next { display: none; }
}
@media (max-width: 767.98px) {
    .section-title-gal { font-size: 1.4rem; }
}
</style>
