@verbatim
<style>
/* ================================================================
   KTA LDK SYAHID PAGE  —  prefix: kta-
   ================================================================ */

:root {
    --kta-primary:       #00a79d;
    --kta-primary-dark:  #007a72;
    --kta-primary-light: #e0f7f5;
    --kta-dark:          #1e293b;
    --kta-muted:         #64748b;
    --kta-gray-50:       #f8fafc;
    --kta-gray-100:      #f1f5f9;
    --kta-gray-200:      #e2e8f0;
    --kta-shadow-sm:     0 4px 20px rgba(0,0,0,.07);
    --kta-shadow-md:     0 8px 32px rgba(0,0,0,.10);
    --kta-shadow-teal:   0 12px 36px rgba(0,167,157,.18);
    --kta-radius:        20px;
}


/* ═══════════════════════════════════════════════════════════════
   HERO SECTION
   ═══════════════════════════════════════════════════════════════ */

.kta-hero {
    background: linear-gradient(135deg, #00b8ad 0%, #006D6D 100%);
    padding: 6.5rem 0 5rem;
    position: relative;
    overflow: hidden;
}
/* Subtle radial glow — not a pattern, just depth */
.kta-hero::before {
    content: '';
    position: absolute; top: -60px; right: -60px;
    width: 420px; height: 420px; border-radius: 50%;
    background: radial-gradient(circle, rgba(255,255,255,.06) 0%, transparent 70%);
    pointer-events: none;
}

/* Hero inner — CSS Grid (replaces Bootstrap .row) */
.kta-hero-inner {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 3.5rem;
    align-items: center;
}

/* ── Photo ── */
.kta-photo-wrap {
    position: relative;
    display: inline-block;
    flex-shrink: 0;
}
.kta-photo {
    width: 230px; height: 290px;
    object-fit: cover; object-position: center top;
    border-radius: 22px;
    border: 5px solid rgba(255,255,255,.92);
    box-shadow:
        0 4px 8px rgba(0,0,0,.08),
        0 20px 50px rgba(0,0,0,.28);
    display: block;
    transition: transform .4s cubic-bezier(.4,0,.2,1),
                box-shadow .4s ease;
}
.kta-photo:hover {
    transform: translateY(-4px) scale(1.015);
    box-shadow: 0 6px 12px rgba(0,0,0,.1), 0 28px 60px rgba(0,0,0,.32);
}
/* LDK badge — bottom right of photo */
.kta-ldk-badge {
    position: absolute; bottom: -14px; right: -14px;
    width: 68px; height: 68px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00b8ad 0%, #006D6D 100%);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 18px rgba(0,0,0,.22); padding: 8px;
    transition: transform .35s cubic-bezier(.175,.885,.32,1.275);
}
.kta-ldk-badge:hover { transform: scale(1.12) rotate(-5deg); }
.kta-ldk-badge img { width: 100%; height: 100%; border-radius: 50%; display: block; }

/* ── Hero Text ── */
.kta-hero-text { min-width: 0; }

.kta-hero-top {
    display: flex; align-items: center;
    justify-content: space-between; gap: 1rem;
    margin-bottom: 1rem;
}
.kta-ldk-logo { width: 70px; opacity: .85; flex-shrink: 0; }

/* Member number pill */
.kta-member-num {
    display: inline-flex; align-items: center; gap: .5rem;
    background: rgba(255,255,255,.18);
    backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.32);
    color: white; font-size: .85rem; font-weight: 600;
    padding: .4rem 1.1rem; border-radius: 50px;
    letter-spacing: .2px;
}
.kta-member-num i { font-size: .78rem; opacity: .85; }

/* Name */
.kta-hero-name {
    font-size: 2.5rem; font-weight: 800; color: white;
    letter-spacing: -.3px; margin: 0 0 .9rem;
    text-shadow: 0 2px 12px rgba(0,0,0,.18);
    line-height: 1.2;
}

/* Info chips (generation, faculty) */
.kta-hero-chips {
    display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 1.25rem;
}
.kta-chip {
    display: inline-flex; align-items: center; gap: .35rem;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.28);
    color: rgba(255,255,255,.95);
    font-size: .78rem; font-weight: 600;
    padding: .3rem .9rem; border-radius: 50px;
}
.kta-chip i { font-size: .7rem; opacity: .85; }

/* Bio */
.kta-hero-bio {
    color: rgba(255,255,255,.85);
    font-size: .98rem; line-height: 1.8;
    max-width: 520px; margin: 0;
}


/* ═══════════════════════════════════════════════════════════════
   MAIN CONTENT — CSS Grid (no Bootstrap rows)
   ═══════════════════════════════════════════════════════════════ */
.kta-main { padding: 4rem 0 2rem; background: transparent; }

.kta-content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    align-items: start;
}
.kta-right-col {
    display: flex; flex-direction: column; gap: 1.5rem;
}


/* ─── Card ────────────────────────────────────────────────────── */
.kta-card {
    background: white;
    border-radius: var(--kta-radius);
    box-shadow:
        0 1px 3px rgba(0,0,0,.04),
        0 6px 24px rgba(0,0,0,.08);
    overflow: hidden;
    position: relative; z-index: 1;
    transition: transform .35s cubic-bezier(.4,0,.2,1),
                box-shadow .35s ease;
}
.kta-card:hover {
    transform: translateY(-6px);
    box-shadow:
        0 2px 4px rgba(0,0,0,.04),
        0 18px 42px rgba(0,167,157,.14),
        0 6px 16px rgba(0,0,0,.06);
}

/* Card header */
.kta-card-hdr {
    background: linear-gradient(135deg, var(--kta-primary) 0%, var(--kta-primary-dark) 100%);
    padding: 1rem 1.5rem;
    display: flex; align-items: center; gap: .65rem;
    position: relative; overflow: hidden;
}
/* Subtle shine sweep on hover */
.kta-card-hdr::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.12) 50%, transparent 60%);
    transform: translateX(-100%);
    transition: transform .5s ease; pointer-events: none;
}
.kta-card:hover .kta-card-hdr::after { transform: translateX(100%); }

.kta-card-hdr-icon {
    width: 34px; height: 34px; border-radius: 10px;
    background: rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: .85rem; flex-shrink: 0;
}
.kta-card-hdr h3 {
    color: white; font-size: 1.05rem; font-weight: 700; margin: 0;
}

/* Card body */
.kta-card-body { padding: 1.4rem 1.5rem; }


/* ─── Biodata Items (no inner Bootstrap rows) ─────────────────── */
.kta-info-item {
    display: flex; gap: .85rem; align-items: flex-start;
    padding: .8rem 0;
    border-bottom: 1px solid var(--kta-gray-100);
    transition: background .2s ease;
}
.kta-info-item:last-child { border-bottom: none; }
.kta-info-item:hover { background: #fafcfc; margin: 0 -.5rem; padding: .8rem .5rem; border-radius: 10px; }

.kta-info-label {
    display: flex; align-items: center; gap: .45rem;
    min-width: 130px; flex-shrink: 0;
    font-size: .73rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .4px;
    color: var(--kta-muted); padding-top: 2px;
}
.kta-info-value {
    font-size: .92rem; font-weight: 600; color: var(--kta-dark);
    flex: 1; line-height: 1.45;
    word-break: break-word;
}


/* ─── Animated Bullet ─────────────────────────────────────────── */
.kta-bullet {
    display: inline-block;
    width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0;
    background: var(--kta-primary);
    animation: ktaGrow 2.4s ease-in-out infinite;
}
@keyframes ktaGrow {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%       { transform: scale(1.65); opacity: .6; }
}


/* ─── Quote / Slogan ──────────────────────────────────────────── */
.kta-quote-wrap {
    position: relative;
    background: linear-gradient(135deg, #f2fbfa 0%, #e6f8f6 100%);
    border-radius: 14px;
    padding: 1.5rem 1.25rem 1.25rem 2rem;
    overflow: hidden;
}
.kta-quote-mark {
    font-size: 5.5rem; line-height: .8;
    color: rgba(0,167,157,.12);
    font-family: Georgia, serif;
    position: absolute; top: .5rem; left: .85rem;
    pointer-events: none; user-select: none;
    font-style: normal;
}
.kta-quote-text {
    font-size: .95rem; font-style: italic;
    color: var(--kta-dark); line-height: 1.85;
    position: relative; z-index: 1; margin: 0;
    font-weight: 500;
}


/* ─── Social Buttons ──────────────────────────────────────────── */
.kta-social-btn {
    display: flex; align-items: center; justify-content: center; gap: .6rem;
    width: 100%; padding: .9rem 1.25rem; border-radius: 14px;
    text-decoration: none; font-weight: 700; font-size: .9rem;
    transition: all .28s cubic-bezier(.4,0,.2,1);
    border: none; cursor: pointer; margin-bottom: .65rem;
    letter-spacing: .1px;
}
.kta-social-btn:last-child { margin-bottom: 0; }
.kta-social-btn--ig {
    background: linear-gradient(135deg, #f9ce34 0%, #ee2a7b 50%, #6228d7 100%);
    color: white;
    box-shadow: 0 4px 18px rgba(238,42,123,.28);
}
.kta-social-btn--ig:hover {
    color: white; transform: translateY(-2px);
    box-shadow: 0 8px 26px rgba(238,42,123,.44);
    filter: brightness(1.06);
}
.kta-social-btn--li {
    background: #0077b5; color: white;
    box-shadow: 0 4px 18px rgba(0,119,181,.28);
}
.kta-social-btn--li:hover {
    color: white; transform: translateY(-2px);
    background: #0069a0;
    box-shadow: 0 8px 26px rgba(0,119,181,.44);
}


/* ═══════════════════════════════════════════════════════════════
   ORGANIZATION SECTION
   ═══════════════════════════════════════════════════════════════ */
.kta-org-section {
    background: transparent;
    padding: 4.5rem 0 5rem;
    margin-top: 1rem;
}

/* Section badge + title */
.kta-section-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--kta-primary-light); color: var(--kta-primary);
    border-radius: 50px; padding: .4rem 1.2rem;
    font-size: .85rem; font-weight: 600;
}
.kta-badge-pulse {
    width: 8px; height: 8px; background: var(--kta-primary);
    border-radius: 50%; flex-shrink: 0;
    animation: ktaPulse 2s ease infinite;
}
@keyframes ktaPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%       { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}
.kta-section-title {
    font-size: 1.85rem; font-weight: 800; color: var(--kta-dark);
    margin: 0; letter-spacing: -.2px;
}

/* Org grid — CSS Grid (no Bootstrap .row) */
.kta-org-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    align-items: start;
}

/* Org Card */
.kta-org-card {
    background: white;
    border-radius: var(--kta-radius);
    box-shadow: var(--kta-shadow-sm);
    overflow: hidden;
    height: 100%;
    position: relative; z-index: 1;
    transition: transform .35s ease, box-shadow .35s ease;
}
.kta-org-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--kta-shadow-teal);
}
.kta-org-card-hdr {
    background: linear-gradient(135deg, var(--kta-primary) 0%, var(--kta-primary-dark) 100%);
    padding: 1.1rem 1.5rem;
    display: flex; align-items: center; gap: .7rem;
}
.kta-org-card-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: .9rem; flex-shrink: 0;
}
.kta-org-card-hdr h3 {
    color: white; font-size: 1.05rem; font-weight: 700; margin: 0;
}
.kta-org-card-body { padding: 1.4rem 1.5rem; }
.kta-org-card-body p {
    color: var(--kta-dark); font-size: .92rem; line-height: 1.8;
    font-style: italic; margin: 0;
}

/* Mission list */
.kta-mission-list {
    padding-left: 1.2rem; margin: 0;
    display: flex; flex-direction: column; gap: .55rem;
}
.kta-mission-list li {
    font-size: .9rem; color: var(--kta-dark); line-height: 1.6;
    padding-left: .25rem;
}
.kta-mission-list li::marker {
    color: var(--kta-primary); font-weight: 700;
}

/* ─── Tabs ────────────────────────────────────────────────────── */
.kta-tabs-wrapper {
    display: inline-flex;
    flex-wrap: wrap;
    gap: .5rem;
    justify-content: center;
    background: white;
    padding: 6px;
    border-radius: 18px;
    box-shadow: var(--kta-shadow-sm);
    position: relative;
    z-index: 1;
}
.kta-tabs-slider {
    position: absolute;
    height: calc(100% - 12px);
    top: 6px;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--kta-primary) 0%, var(--kta-primary-dark) 100%);
    box-shadow: 0 4px 14px rgba(0,167,157,.35);
    transition: all .4s cubic-bezier(.4,0,.2,1);
    z-index: 1;
    pointer-events: none;
}
.kta-tab-btn {
    display: flex; align-items: center; gap: .5rem;
    padding: .7rem 1.25rem;
    border: none; background: transparent;
    border-radius: 14px;
    font-weight: 600; font-size: .92rem;
    color: var(--kta-muted);
    cursor: pointer;
    transition: color .3s ease, background .3s ease;
    position: relative; z-index: 2;
}
@media (hover: hover) {
    .kta-tab-btn:hover { color: var(--kta-primary); background: var(--kta-primary-light); }
}
.kta-tab-btn.active { color: white; }
@media (min-width: 992px) {
    .kta-tab-btn.active:hover { color: white; background: transparent; }
}
.kta-tab-icon { font-size: 1.05rem; }

.kta-tab-contents { margin-top: 1.5rem; }
.kta-tab-content {
    display: none;
    animation: ktaTabIn .45s cubic-bezier(.4,0,.2,1);
}
.kta-tab-content.active { display: block; }
@keyframes ktaTabIn {
    from { opacity: 0; transform: translateY(20px) scale(.98); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

/* Mobile tab adjustments */
@media (max-width: 991.98px) {
    .kta-tabs-wrapper { padding: 5px; border-radius: 14px; display: flex; justify-content: center; }
    .kta-tab-btn { padding: .55rem .9rem; font-size: .85rem; }
    .kta-tab-text { display: none; }
    .kta-tabs-slider { display: none; }
    .kta-tab-btn.active {
        background: linear-gradient(135deg, var(--kta-primary) 0%, var(--kta-primary-dark) 100%);
        color: white;
        box-shadow: 0 4px 14px rgba(0,167,157,.35);
    }
}


/* Org description */
.kta-org-desc {
    background: white;
    border-radius: var(--kta-radius);
    box-shadow: var(--kta-shadow-sm);
    padding: 1.75rem 2rem;
    position: relative; z-index: 1;
}
.kta-org-desc p {
    color: var(--kta-muted); font-size: .93rem;
    line-height: 1.9; margin: 0;
    text-align: justify;
}


/* ═══════════════════════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════════════════════ */

/* Tablet (lg: 992px) → stack hero */
@media (max-width: 991.98px) {
    .kta-hero { padding: 5.5rem 0 4rem; }
    .kta-hero-inner {
        grid-template-columns: 1fr;
        justify-items: center;
        text-align: center;
        gap: 2rem;
    }
    .kta-hero-top {
        justify-content: center; flex-direction: column-reverse; gap: .75rem;
    }
    .kta-ldk-logo { display: none; }
    .kta-hero-name { font-size: 2rem; }
    .kta-hero-chips { justify-content: center; }
    .kta-hero-bio { max-width: 100%; }
    .kta-photo-wrap { margin: 0 auto; }

    /* Stack content grid */
    .kta-content-grid { grid-template-columns: 1fr; }
    .kta-org-grid { grid-template-columns: 1fr; }

    .kta-section-title { font-size: 1.6rem; }
}

/* Mobile (max 576px) */
@media (max-width: 575.98px) {
    .kta-hero { padding: 4.5rem 0 3.5rem; }
    .kta-hero-name { font-size: 1.75rem; }
    .kta-photo { width: 190px; height: 240px; }
    .kta-info-label { min-width: 100px; font-size: .68rem; }
    .kta-info-value { font-size: .88rem; }
    .kta-org-section { padding: 3.5rem 0 4rem; }
    .kta-org-desc { padding: 1.25rem 1.25rem; }
    .kta-card-body { padding: 1.1rem 1.1rem; }
    .kta-main { padding: 3rem 0 1.5rem; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
[data-theme="dark"] .kta-section-badge { background: rgba(0,167,157,.15); color: #4dd9cf; }
[data-theme="dark"] .kta-section-title { color: #e2e8f0; }
/* Tabs */
[data-theme="dark"] .kta-tabs-wrapper  { background: #1a1f2e; box-shadow: 0 2px 12px rgba(0,0,0,.3); }
[data-theme="dark"] .kta-tab-btn       { color: #9ca3af; }
[data-theme="dark"] .kta-tab-btn:hover { color: #4dd9cf !important; background: rgba(0,167,157,.12) !important; }
[data-theme="dark"] .kta-tab-btn.active { color: #fff; }
/* Cards */
[data-theme="dark"] .kta-card      { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .kta-card-body { background: #1a1f2e; }
[data-theme="dark"] .kta-card-name { color: #e2e8f0; }
[data-theme="dark"] .kta-card-meta { color: #9ca3af; }
[data-theme="dark"] .kta-org-card  { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .kta-org-desc  { background: #252b3b; border-color: rgba(0,167,157,.2); color: #e2e8f0; }
[data-theme="dark"] .kta-info-nav  { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .kta-info-label { color: #9ca3af; }
[data-theme="dark"] .kta-info-value { color: #e2e8f0; }
</style>
@endverbatim
