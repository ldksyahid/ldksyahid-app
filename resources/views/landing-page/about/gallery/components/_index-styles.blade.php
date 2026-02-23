<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">

<style>
/* ================================================================
   GALLERY PAGE STYLES
   ================================================================ */

:root {
    --primary:       #00a79d;
    --primary-dark:  #008b82;
    --primary-light: #e0f7f5;
    --dark:          #2c3e50;
    --gray:          #7f8c8d;
    --gray-100:      #f3f4f6;
    --gray-200:      #e5e7eb;
    --gray-300:      #d1d5db;
}

/* ─── Hero / Jumbotron (verbatim from contact-us) ──────────────── */

.hero-fun {
    position: relative;
    overflow: visible;
    background: transparent;
    padding-top: 80px !important;
    margin-bottom: 0;
}

.hero-carousel-wrapper {
    padding: 1rem;
    background: transparent;
    margin-bottom: 0;
}

.hero-carousel-card {
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0,0,0,.1);
    position: relative;
    background: white;
}

@media (min-width: 992px) {
    .hero-carousel-wrapper { padding: 1.5rem 2.5rem; }
    .hero-carousel-card    { border-radius: 32px; }
}

.hero-slide { position: relative; width: 100%; overflow: hidden; }
.hero-image { width: 100%; height: auto; display: block; object-fit: cover; }

@media (min-width: 992px) {
    .hero-slide  { height: auto; }
    .hero-image  { height: auto; object-fit: unset; }
}

/* Desktop hadith content */
.hero-desktop-content {
    background: white;
    padding: 0 1.5rem 2.5rem;
    margin-top: -20px;
    position: relative;
    z-index: 5;
    border-radius: 0 0 32px 32px;
    overflow: visible;
}

.hero-divider-desktop {
    position: absolute;
    top: -40px; left: -10px;
    width: calc(100% + 20px);
    height: 60px;
    background: white;
    border-radius: 50% 50% 0 0;
    z-index: 30;
}

.hadith-background-animation {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    overflow: hidden;
    z-index: 1;
    pointer-events: none;
}

.floating-icon {
    position: absolute;
    font-size: 2.5rem;
    opacity: .25;
    animation: float 15s infinite ease-in-out;
    z-index: 1;
    pointer-events: none;
    filter: drop-shadow(0 2px 5px rgba(0,0,0,.1));
    display: block;
}

.floating-shape {
    position: absolute;
    width: 150px; height: 150px;
    background: radial-gradient(circle at 30% 30%, var(--primary-light), transparent 70%);
    border-radius: 50%;
    opacity: .2;
    animation: pulse 20s infinite ease-in-out;
    z-index: 1;
    pointer-events: none;
    filter: blur(8px);
    display: block;
    mix-blend-mode: multiply;
}

/* Desktop icon positions */
.hadith-background-animation:not(.mobile) .icon-1 { top:10%;   left:5%;   animation-delay:0s; }
.hadith-background-animation:not(.mobile) .icon-2 { bottom:15%;right:8%;  animation-delay:2s;  font-size:2.5rem; }
.hadith-background-animation:not(.mobile) .icon-3 { top:25%;  right:15%; animation-delay:4s;  font-size:1.8rem; }
.hadith-background-animation:not(.mobile) .icon-4 { bottom:20%;left:12%;  animation-delay:6s;  font-size:2.2rem; }
.hadith-background-animation:not(.mobile) .icon-5 { top:40%;  left:20%;  animation-delay:8s; }
.hadith-background-animation:not(.mobile) .icon-6 { top:65%;  right:15%; animation-delay:10s; font-size:2.3rem; }
.hadith-background-animation:not(.mobile) .icon-7 { bottom:8%;left:15%;  animation-delay:12s; }
.hadith-background-animation:not(.mobile) .icon-8 { top:20%;  right:25%; animation-delay:14s; font-size:2.4rem; }
.hadith-background-animation:not(.mobile) .shape-1 {
    top:20%; right:10%; width:150px; height:150px;
    animation:pulse 18s infinite;
    background: radial-gradient(circle at 20% 20%, var(--primary-light), transparent 80%);
}
.hadith-background-animation:not(.mobile) .shape-2 {
    bottom:10%; left:5%; width:120px; height:120px;
    animation: pulse 22s infinite reverse;
    background: radial-gradient(circle at 80% 80%, var(--primary-light), transparent 80%);
}

/* Mobile icon positions */
.hadith-background-animation.mobile .icon-1 { top:20%; left:5%;   font-size:2rem;   animation:float 12s infinite; }
.hadith-background-animation.mobile .icon-3 { top:15%; right:10%; font-size:1.8rem; animation:float 16s infinite 2s; }
.hadith-background-animation.mobile .icon-5 { top:25%; left:20%;  font-size:1.9rem; animation:float 15s infinite 4s; }
.hadith-background-animation.mobile .shape-1 {
    top:20%; right:5%; width:90px; height:90px;
    animation:pulse 15s infinite;
    background:radial-gradient(circle at 30% 30%, var(--primary-light), transparent 70%);
}
.hadith-background-animation.mobile .shape-2 {
    bottom:5%; left:10%; width:60px; height:60px;
    animation:pulse 18s infinite reverse;
    background:radial-gradient(circle at 70% 70%, var(--primary-light), transparent 70%);
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    25%       { transform: translateY(-20px) rotate(8deg); }
    50%       { transform: translateY(15px) rotate(-8deg); }
    75%       { transform: translateY(-8px) rotate(5deg); }
}
@keyframes pulse {
    0%, 100% { transform: scale(1);   opacity: .2; }
    50%       { transform: scale(1.4); opacity: .35; }
}

.desktop-countdown {
    position: absolute;
    bottom: 20px; right: 30px;
    background: rgba(0,0,0,.35);
    backdrop-filter: blur(6px);
    color: white;
    padding: .4rem 1rem;
    border-radius: 50px;
    font-size: .75rem;
    z-index: 40;
    border: 1px solid rgba(255,255,255,.08);
}
.desktop-countdown-number { font-weight: 700; color: #ffd700; margin: 0 2px; }

.hero-desktop-card { max-width: 900px; margin: 0 auto; text-align: center; position: relative; z-index: 35; padding-top: 30px; }

.hero-desktop-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--primary-light); color: var(--primary);
    border-radius: 50px; padding: .4rem 1rem;
    font-size: .8rem; font-weight: 600;
    margin-bottom: 1rem; position: relative; z-index: 35;
}

.hadith-desktop-wrapper {
    max-height: 150px; overflow: hidden; position: relative;
    transition: max-height .5s ease; margin-bottom: .75rem; z-index: 35;
}
.hadith-desktop-wrapper.expanded { max-height: 2000px; }
.hadith-desktop-wrapper:not(.expanded)::after {
    content: ''; position: absolute; bottom: 0; left: 0;
    width: 100%; height: 50px;
    background: linear-gradient(to bottom, transparent, white);
    pointer-events: none; z-index: 36;
}

.hadith-fade-text { transition: opacity .5s ease-in-out; opacity: 1; }
.hadith-fade-text.fade-out { opacity: 0; }

.loading-text  { display: inline-block; }
.loading-dots  { display: inline-block; margin-left: 2px; }
.dot { display: inline-block; animation: bounce 1.4s infinite; font-size: 1.2rem; line-height: 1; }
.dot:nth-child(2) { animation-delay: .2s; }
.dot:nth-child(3) { animation-delay: .4s; }
@keyframes bounce {
    0%, 60%, 100% { transform: translateY(0); opacity: .3; }
    30%            { transform: translateY(-5px); opacity: 1; }
}

.hero-desktop-arab {
    font-family: 'Amiri','Traditional Arabic',serif;
    font-size: 1.4rem; line-height: 2; color: var(--dark);
    margin-bottom: .75rem; direction: rtl; padding: 0 .5rem;
    position: relative; z-index: 35;
}
.hero-desktop-text {
    font-size: .85rem; color: var(--gray); line-height: 1.6;
    margin-bottom: .35rem; font-style: italic; position: relative; z-index: 35;
}
.hero-desktop-number {
    display: block; font-size: .7rem; color: var(--primary);
    font-weight: 600; margin-bottom: .5rem; position: relative; z-index: 35;
}

.desktop-toggle-btn {
    background: none; border: 1px solid var(--primary-light); color: var(--primary);
    padding: .5rem 1.5rem; border-radius: 50px; font-size: .8rem; font-weight: 600;
    cursor: pointer; transition: all .3s ease;
    display: inline-flex; align-items: center; gap: .4rem;
    margin-top: .25rem; position: relative; z-index: 35;
}
.desktop-toggle-btn:hover,
.desktop-toggle-btn:focus,
.desktop-toggle-btn:active { background: transparent; border-color: var(--primary-light); color: var(--primary); transform: none; box-shadow: none; outline: none; }
.desktop-toggle-btn i { transition: transform .3s ease; font-size: .7rem; }
.desktop-toggle-btn.expanded i { transform: rotate(180deg); }

/* Mobile hadith content */
.hero-mobile-content {
    padding: 0 1.25rem 1rem; text-align: center;
    background: white; border-radius: 0 0 20px 20px;
    margin-top: -20px; position: relative; z-index: 4; overflow: visible;
}
.hero-divider-mobile {
    position: absolute; top: -20px; left: -5px;
    width: calc(100% + 10px); height: 45px;
    background: white; border-radius: 50% 50% 0 0;
    z-index: 30; box-shadow: 0 -3px 10px rgba(0,0,0,.02);
}
.hero-mobile-badge {
    display: inline-flex; align-items: center; gap: .4rem;
    background: var(--primary-light); color: var(--primary);
    border-radius: 50px; padding: .3rem .85rem;
    font-size: .75rem; font-weight: 600;
    margin-bottom: 1rem; position: relative; z-index: 35; margin-top: 20px;
}
.hero-mobile-arab {
    font-size: 1.1rem; color: var(--dark); line-height: 2;
    margin-bottom: .75rem; direction: rtl;
    font-family: 'Amiri','Traditional Arabic',serif;
    padding: 0 .5rem; position: relative; z-index: 35;
}
.hero-mobile-desc {
    font-size: .85rem; color: var(--gray); line-height: 1.5;
    margin-bottom: .75rem; font-style: italic; position: relative; z-index: 35;
}
.hadith-mobile-wrapper {
    max-height: 150px; overflow: hidden; position: relative;
    transition: max-height .4s ease; margin-bottom: 1rem; z-index: 35;
}
.hadith-mobile-wrapper.expanded { max-height: 2000px; }
.hadith-mobile-wrapper:not(.expanded)::after {
    content: ''; position: absolute; bottom: 0; left: 0;
    width: 100%; height: 40px;
    background: linear-gradient(to bottom, transparent, white);
    pointer-events: none; z-index: 36;
}
.hadith-number { display: block; font-size: .7rem; color: var(--primary); font-weight: 600; margin-top: .5rem; opacity: .7; position: relative; z-index: 35; }
.mobile-action-area { display: flex; justify-content: space-between; align-items: center; margin-top: .5rem; padding: 0 .25rem; position: relative; z-index: 35; }
.hadith-toggle {
    background: none; border: 1px solid var(--primary-light); color: var(--primary);
    font-size: .75rem; font-weight: 600; cursor: pointer;
    padding: .4rem 1.2rem; outline: none;
    display: inline-flex; align-items: center; gap: .3rem;
    border-radius: 50px; transition: all .3s ease; flex-shrink: 0;
}
.hadith-toggle:hover,.hadith-toggle:focus,.hadith-toggle:active { background: transparent; border-color: var(--primary-light); color: var(--primary); transform: none; box-shadow: none; outline: none; }
.hadith-toggle i { font-size: .6rem; transition: transform .3s ease; }
.hadith-toggle.expanded i { transform: rotate(180deg); }
.mobile-countdown {
    background: rgba(0,0,0,.35); backdrop-filter: blur(6px);
    color: rgba(255,255,255,.85); padding: .3rem .9rem;
    border-radius: 50px; font-size: .65rem;
    border: 1px solid rgba(255,255,255,.08); white-space: nowrap; flex-shrink: 0; z-index: 40;
}
.mobile-countdown-number { font-weight: 700; color: #ffd700; margin: 0 2px; }


/* ─── Gallery Section Header ───────────────────────────────────── */
.gl-section-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--primary-light); color: var(--primary);
    border-radius: 50px; padding: .4rem 1.2rem;
    font-size: .85rem; font-weight: 600; position: relative;
}
.gl-badge-pulse {
    width: 8px; height: 8px; background: var(--primary);
    border-radius: 50%; position: relative; flex-shrink: 0;
    animation: glPulse 2s ease infinite;
}
@keyframes glPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%      { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}
.gl-section-title { font-size: 2rem; font-weight: 700; color: var(--dark); margin: 0; }
.gl-section-sub   { color: var(--gray); font-size: 1rem; margin: .5rem 0 0; }


/* ─── Desktop Event Card ────────────────────────────────────────── */
.gl-event-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,.07);
    margin-bottom: 2rem;
    overflow: hidden;
    transition: box-shadow .3s ease;
    position: relative;
}
.gl-event-card:hover { box-shadow: 0 10px 32px rgba(0,0,0,.11); }

/* Gradient Header — replaces thin accent line */
.gl-card-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    padding: 1rem 1.5rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    position: relative; overflow: hidden;
}

.gl-card-header-left {
    display: flex; align-items: center; gap: .65rem;
    position: relative; z-index: 1;
}
.gl-card-header-name {
    color: rgba(255,255,255,.82); font-size: .82rem; font-weight: 600;
}
.gl-card-header-badges {
    display: flex; align-items: center; gap: .4rem;
    position: relative; z-index: 1; flex-shrink: 0;
}
.gl-card-header .gl-video-badge {
    background: rgba(255,255,255,.15); color: rgba(255,255,255,.9);
    border: 1px solid rgba(255,255,255,.25);
}
.gl-card-header .gl-photo-count {
    background: rgba(255,255,255,.15); color: rgba(255,255,255,.9);
    border: 1px solid rgba(255,255,255,.25); margin-left: 0;
}

.gl-card-body { padding: 1.5rem 1.75rem 1.75rem; }

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

.gl-card-title {
    font-size: 1.35rem; font-weight: 700; color: var(--dark);
    margin: 0 0 .6rem; line-height: 1.35;
}
.gl-card-desc {
    color: var(--gray); font-size: .9rem; line-height: 1.7;
    margin-bottom: 1.25rem;
}

/* All-photos grid (inline, desktop) */
.gl-photo-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .65rem;
    margin-bottom: 1.25rem;
}
.gl-grid-item {
    aspect-ratio: 4/3; border-radius: 10px; overflow: hidden;
    cursor: pointer; transition: transform .25s ease, box-shadow .25s ease;
}
.gl-grid-item:first-child {
    grid-column: 1 / -1;
    aspect-ratio: 21/7;
}
.gl-grid-item:hover { transform: scale(1.025); box-shadow: 0 6px 18px rgba(0,0,0,.16); }
.gl-grid-item img { width: 100%; height: 100%; object-fit: cover; display: block; }

/* YouTube inline section */
.gl-video-section { margin-bottom: 1.25rem; }
.gl-video-label {
    font-size: .78rem; font-weight: 700; color: var(--gray);
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

/* Card Footer (doc link only) */
.gl-card-footer {
    display: flex; align-items: center;
    padding-top: 1rem; margin-top: .5rem;
    border-top: 1px solid var(--gray-200);
}
.gl-doc-link {
    display: inline-flex; align-items: center; gap: .4rem;
    color: var(--gray); font-size: .82rem; font-weight: 600; text-decoration: none;
    padding: .45rem 1rem; border: 1.5px solid var(--gray-200); border-radius: 50px;
    transition: all .2s;
}
.gl-doc-link:hover { color: var(--primary); border-color: var(--primary-light); background: var(--primary-light); }

/* Empty State */
.gl-empty-state {
    text-align: center; padding: 4rem 1rem;
    color: var(--gray);
}
.gl-empty-icon { font-size: 4rem; margin-bottom: 1rem; opacity: .5; }
.gl-empty-state h4 { font-weight: 700; color: var(--dark); margin-bottom: .5rem; }


/* ─── Mobile Card List ──────────────────────────────────────────── */
.gl-mobile-card {
    background: white; border-radius: 18px; overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,.08); cursor: pointer;
    transition: transform .25s ease, box-shadow .25s ease;
    margin-bottom: 1.1rem;
}
.gl-mobile-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,.13); }

.gl-mobile-thumb { position: relative; aspect-ratio: 16/9; overflow: hidden; }
.gl-mobile-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .4s ease; }
.gl-mobile-card:hover .gl-mobile-thumb img { transform: scale(1.05); }
.gl-mobile-thumb-overlay {
    position: absolute; bottom: .6rem; right: .6rem;
    display: flex; gap: .4rem;
}
.gl-m-count, .gl-m-video {
    background: rgba(0,0,0,.5); backdrop-filter: blur(4px);
    color: white; border-radius: 50px;
    padding: .2rem .6rem; font-size: .72rem; font-weight: 600;
    display: inline-flex; align-items: center; gap: .3rem;
}
.gl-m-video { color: #ff4444; }

.gl-mobile-card-body { padding: 1rem 1.1rem 1.25rem; }
.gl-mobile-meta { display: flex; align-items: center; gap: .5rem; margin-bottom: .4rem; }
.gl-m-tag { background: var(--gray-100); color: var(--dark); border-radius: 50px; padding: .2rem .7rem; font-size: .72rem; font-weight: 600; }
.gl-m-title { font-size: 1rem; font-weight: 700; color: var(--dark); margin: 0 0 .4rem; line-height: 1.3; }
.gl-m-desc  { font-size: .82rem; color: var(--gray); line-height: 1.5; margin: 0 0 .75rem; }
.gl-m-tap-hint {
    display: flex; align-items: center; justify-content: flex-end; gap: .4rem;
    color: var(--primary); font-size: .75rem; font-weight: 600;
}
.gl-m-tap-hint i { opacity: .6; }

/* ─── AJAX Loading State ─────────────────────────────────────── */
#gl-cards-wrap { transition: opacity .25s ease; }
#gl-cards-wrap.gl-cards-loading { opacity: .4; pointer-events: none; }

/* ─── Pagination ─────────────────────────────────────────────── */
.gl-pagination {
    display: flex; flex-direction: column; align-items: center; gap: .9rem;
    margin-top: 3rem; padding-bottom: 1rem;
}
.gl-pag-info {
    font-size: .82rem; color: var(--gray);
}
.gl-pag-info strong { color: var(--primary); font-weight: 700; }
.gl-pag-inner {
    display: flex; align-items: center; gap: .4rem;
    flex-wrap: wrap; justify-content: center;
}

/* ── Shared base for nav & page numbers ── */
.gl-pag-nav,
.gl-pag-num {
    height: 40px;
    border: 1.5px solid var(--primary);
    background: #fff;
    color: var(--primary);
    cursor: pointer;
    font-size: .82rem; font-weight: 600; line-height: 1;
    display: inline-flex; align-items: center; justify-content: center;
    text-decoration: none; flex-shrink: 0;
    transition: background .22s cubic-bezier(.4,0,.2,1),
                color .22s cubic-bezier(.4,0,.2,1),
                border-color .22s,
                transform .22s cubic-bezier(.4,0,.2,1),
                box-shadow .22s cubic-bezier(.4,0,.2,1);
}

/* ── Nav: <<, <, >, >> ── */
.gl-pag-nav {
    width: 40px;
    border-radius: 50px;
}
/* Asymmetric pill for edge buttons */
.gl-pag-edge:first-child,
a.gl-pag-edge:first-child,
button.gl-pag-edge:first-child { border-radius: 50px 14px 14px 50px; }
.gl-pag-edge:last-child,
a.gl-pag-edge:last-child,
button.gl-pag-edge:last-child  { border-radius: 14px 50px 50px 14px; }

.gl-pag-nav:hover:not([disabled]) {
    background: var(--primary); color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,167,157,.28);
}
.gl-pag-nav[disabled] {
    color: #c8d6d5; border-color: #e2ecec;
    background: #f7fafa; cursor: default; pointer-events: none;
}

/* ── Page numbers ── */
.gl-pag-num {
    min-width: 40px; padding: 0 .55rem;
    border-radius: 50px;
}
.gl-pag-num:hover:not(.active) {
    background: var(--primary); color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,167,157,.28);
}
.gl-pag-num.active {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark, #007a72) 100%);
    border-color: transparent; color: #fff; font-weight: 700; font-size: .9rem;
    transform: translateY(-3px) scale(1.08);
    box-shadow: 0 8px 22px rgba(0,167,157,.38);
    pointer-events: none;
}

/* ── Pages container ── */
.gl-pag-pages {
    display: flex; align-items: center; gap: .4rem;
    flex-wrap: wrap; justify-content: center;
}

/* ── Ellipsis ── */
.gl-pag-ellipsis {
    width: 28px; height: 40px;
    display: flex; align-items: flex-end; justify-content: center;
    color: var(--primary); font-weight: 800; font-size: .78rem;
    padding-bottom: 4px; letter-spacing: 2px; user-select: none; opacity: .7;
}

/* ── Mobile ── */
@media (max-width: 575.98px) {
    .gl-pagination { width: 100%; }
    .gl-pag-inner {
        flex-wrap: nowrap;
        overflow-x: auto;
        justify-content: flex-start;
        width: 100%;
        padding: .25rem .5rem;
        gap: .25rem;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .gl-pag-inner::-webkit-scrollbar { display: none; }
    .gl-pag-nav, .gl-pag-num { height: 34px; flex-shrink: 0; }
    .gl-pag-nav { width: 34px; }
    .gl-pag-num { min-width: 34px; font-size: .75rem; }
    .gl-pag-ellipsis { height: 34px; font-size: .7rem; flex-shrink: 0; }
    .gl-pag-info { font-size: .78rem; text-align: center; }
}


/* ─── YouTube Video Lightbox ───────────────────────────────────── */
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
    width: min(90vw, 960px);
    aspect-ratio: 16/9;
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


/* ─── Photo Zoom Overlay ───────────────────────────────────────── */
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


/* ─── Mobile Bottom Sheet ──────────────────────────────────────── */
.gl-bs-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.5);
    backdrop-filter: blur(4px);
    z-index: 1070;
    opacity: 0; pointer-events: none;
    transition: opacity .3s ease;
}
.gl-bs-backdrop.active { opacity: 1; pointer-events: all; }

.gl-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 1075;
    max-height: 88dvh;
    transform: translateY(100%);
    transition: transform .35s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
    overflow: hidden;
}
.gl-bottom-sheet.active { transform: translateY(0); }

.gl-bs-handle {
    width: 40px; height: 4px; background: var(--gray-300);
    border-radius: 2px; margin: .75rem auto .25rem;
    flex-shrink: 0;
}
.gl-bs-close {
    position: absolute; top: .75rem; right: 1rem;
    background: var(--gray-100); border: none;
    width: 34px; height: 34px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--dark); font-size: .85rem;
    transition: background .2s;
}
.gl-bs-close:hover { background: #fecaca; color: #ef4444; }
.gl-bs-content {
    overflow-y: auto; flex: 1;
    padding: .25rem 1.1rem 2rem;
    scrollbar-width: thin;
}

/* Bottom sheet inner elements */
.gl-bs-header { padding: .5rem 0 1rem; border-bottom: 1px solid var(--gray-200); margin-bottom: 1rem; }
.gl-bs-meta { display: flex; align-items: center; gap: .5rem; margin-bottom: .4rem; }
.gl-bs-tag { background: var(--gray-100); color: var(--dark); border-radius: 50px; padding: .2rem .7rem; font-size: .73rem; font-weight: 600; }
.gl-bs-title { font-size: 1.05rem; font-weight: 700; color: var(--dark); margin: 0 0 .5rem; line-height: 1.3; }
.gl-bs-desc  { font-size: .83rem; color: var(--gray); line-height: 1.6; margin: 0; }

/* Bottom sheet photo grid (2-col) */
.gl-bs-photo-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .5rem; margin-bottom: 1rem; }
.gl-bs-photo { aspect-ratio: 4/3; border-radius: 10px; overflow: hidden; cursor: pointer; }
.gl-bs-photo:first-child { grid-column: span 2; aspect-ratio: 16/7; }
.gl-bs-photo img { width: 100%; height: 100%; object-fit: cover; display: block; }

/* Bottom sheet video */
.gl-bs-video { margin-bottom: 1rem; }
.gl-bs-video-label { font-size: .75rem; font-weight: 700; color: var(--gray); text-transform: uppercase; letter-spacing: .5px; margin-bottom: .5rem; display: flex; align-items: center; gap: .35rem; }
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

/* Bottom sheet doc link + footer */
.gl-bs-actions { display: flex; gap: .6rem; flex-wrap: wrap; margin-top: .5rem; }
.gl-bs-doc { display: inline-flex; align-items: center; gap: .4rem; color: var(--primary); font-size: .82rem; font-weight: 600; text-decoration: none; padding: .5rem 1.1rem; border: 1.5px solid var(--primary-light); border-radius: 50px; }


/* ─── Mobile Media Query ───────────────────────────────────────── */
@media (max-width: 991.98px) {
    html, body { overflow-x: hidden; }

    .hero-fun { padding-top: 75px !important; }

    .hero-carousel-wrapper { padding: 1.25rem 0.75rem 1rem; }
    .hero-carousel-card    { border-radius: 20px; overflow: hidden; }

    .hero-fun .hero-slide  { height: auto !important; overflow: hidden; }
    .hero-fun .hero-image  {
        width: 100% !important; height: auto !important;
        max-height: none !important; display: block;
        object-fit: cover !important; object-position: center !important;
    }

    .hero-mobile-content {
        display: flex; flex-direction: column; align-items: center;
        gap: .75rem; text-align: center;
        padding: 1.5rem 1.25rem 1.5rem; margin-top: 0 !important;
    }
    .hero-mobile-content .hero-mobile-badge     { margin-bottom: 0; }
    .hero-mobile-content .hadith-mobile-wrapper { margin-bottom: 0; }
    .hero-mobile-content .hadith-mobile-wrapper,
    .hero-mobile-content .mobile-action-area    { width: 100%; }

    .gl-section-title { font-size: 1.5rem; }

    /* Hide prev/next zoom nav on touch (use swipe) */
    .gl-zoom-prev, .gl-zoom-next { display: none; }
}

@media (max-width: 480px) {
    .mobile-action-area { flex-direction: column; gap: .75rem; align-items: stretch; }
    .mobile-countdown   { align-self: flex-end; }
    .hadith-toggle      { align-self: flex-start; }
}
</style>
