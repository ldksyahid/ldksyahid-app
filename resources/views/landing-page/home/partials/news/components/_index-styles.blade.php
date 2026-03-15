<style>
/* ═══════════════════════════════════════════════
   NEWS SECTION — Clean Modern Design
   ═══════════════════════════════════════════════ */

.news-section {
    background: transparent;
    position: relative;
}

/* ── Section Header (matching About style) ── */
.news-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-light);
    border: 1px solid rgba(0, 167, 157, 0.2);
    border-radius: var(--radius-pill);
    padding: 0.5rem 1.25rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--primary);
    position: relative;
}

.news-badge__emoji { font-size: 1.1rem; }

.news-badge__pulse {
    width: 8px;
    height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: newsBadgePulse 2s ease-in-out infinite;
}

@keyframes newsBadgePulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.5); }
}

.news-heading {
    font-family: var(--font-primary);
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.news-heading__highlight {
    color: var(--primary);
    position: relative;
}

.news-heading__highlight::after {
    content: '';
    position: absolute;
    bottom: 2px;
    left: 0;
    width: 100%;
    height: 8px;
    background: rgba(0, 167, 157, 0.15);
    border-radius: 4px;
    z-index: -1;
}

.news-subtitle {
    color: var(--secondary);
    font-size: 1rem;
    margin-bottom: 0;
    max-width: 480px;
    margin-left: auto;
    margin-right: auto;
}

/* ── Viewport Animations ── */
.news-header-animate {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.news-header-animate.is-visible {
    opacity: 1;
    transform: translateY(0);
}

.news-card-animate {
    opacity: 0;
    transform: translateY(40px) scale(0.97);
    transition: opacity 0.6s ease var(--anim-delay, 0s),
                transform 0.6s cubic-bezier(0.4, 0, 0.2, 1) var(--anim-delay, 0s);
}

.news-card-animate.is-visible {
    opacity: 1;
    transform: translateY(0) scale(1);
}

/* ── Desktop Grid ── */
.news-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.75rem;
}

/* Featured card spans full width */
.news-card--featured {
    grid-column: 1 / -1;
    display: grid;
    grid-template-columns: 1fr 1fr;
}

.news-card--featured .news-card__img-wrap {
    border-radius: 20px 0 0 20px;
    min-height: 380px;
}

.news-card--featured .news-card__img {
    height: 100%;
    position: absolute;
    inset: 0;
}

.news-card--featured .news-card__body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 2rem;
}

.news-card--featured .news-card__title {
    font-size: 1.35rem;
}

/* ═══════════════════════════════════════════════
   NEWS CARD — Modern & Clean
   ═══════════════════════════════════════════════ */
.news-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(0, 0, 0, 0.04);
}

.news-card:hover {
    transform: translateY(-10px);
    box-shadow:
        0 25px 60px rgba(0, 0, 0, 0.12),
        0 10px 35px rgba(0, 167, 157, 0.15);
    border-color: rgba(0, 167, 157, 0.15);
}

/* ── Image ── */
.news-card__img-wrap {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.news-card__img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.news-card:hover .news-card__img {
    transform: scale(1.06);
}

/* Featured tag */
.news-card__featured-tag {
    position: absolute;
    top: 12px;
    right: 12px;
    background: var(--primary-gradient);
    color: white;
    padding: 5px 14px;
    border-radius: var(--radius-pill);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    box-shadow: 0 4px 15px rgba(0, 167, 157, 0.35);
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 5px;
}

.news-card__featured-tag i {
    font-size: 0.65rem;
    animation: newsStarPulse 2s ease-in-out infinite;
}

@keyframes newsStarPulse {
    0%, 100% { transform: scale(1) rotate(0); }
    50% { transform: scale(1.2) rotate(15deg); }
}

/* Date Badge */
.news-card__date-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 14px;
    padding: 6px 10px;
    text-align: center;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    line-height: 1;
    z-index: 2;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.news-card:hover .news-card__date-badge {
    transform: rotate(-3deg) scale(1.05);
}

.news-card__date-day {
    display: block;
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--primary);
}

.news-card__date-month {
    display: block;
    font-size: 0.6rem;
    font-weight: 700;
    color: var(--secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 1px;
}

/* Mobile tap hint */
.news-card__tap-hint {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    border-radius: 20px;
    padding: 5px 12px;
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--dark);
    z-index: 2;
    animation: newsTapPulse 2.5s ease-in-out infinite;
}

@keyframes newsTapPulse {
    0%, 100% { opacity: 0.9; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(0.96); }
}

/* ── Body ── */
.news-card__body {
    padding: 1.1rem 1.25rem 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.news-card__title {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1rem;
    line-height: 1.5;
    margin-bottom: 0.65rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.news-card__title a {
    color: var(--dark);
    text-decoration: none;
    background-image: linear-gradient(var(--primary), var(--primary));
    background-size: 0% 2px;
    background-repeat: no-repeat;
    background-position: left bottom;
    transition: background-size 0.35s ease, color 0.3s ease;
    padding-bottom: 2px;
}

.news-card:hover .news-card__title a {
    background-size: 100% 2px;
    color: var(--primary);
}

/* Meta */
.news-card__meta-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
}

.news-card__meta {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    color: var(--secondary);
    font-size: 0.78rem;
    font-weight: 500;
}

.news-card__meta i {
    color: var(--primary);
    font-size: 0.68rem;
    transition: transform 0.3s ease;
}

.news-card:hover .news-card__meta i {
    transform: scale(1.15);
}

/* Excerpt */
.news-card__excerpt {
    color: var(--secondary);
    font-size: 0.88rem;
    line-height: 1.7;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Read Button */
.news-card__read {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--primary);
    background: var(--primary-light);
    font-weight: 700;
    font-size: 0.82rem;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 14px;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    margin-top: auto;
    width: fit-content;
}

.news-card__read::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--primary-gradient);
    border-radius: inherit;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 0;
}

.news-card:hover .news-card__read::before {
    transform: scaleX(1);
}

.news-card__read span,
.news-card__read i {
    position: relative;
    z-index: 1;
    transition: color 0.3s ease;
}

.news-card:hover .news-card__read {
    color: white;
    box-shadow: 0 6px 20px rgba(0, 167, 157, 0.3);
}

.news-card__read i {
    font-size: 0.72rem;
    transition: transform 0.3s ease, color 0.3s ease;
}

.news-card:hover .news-card__read i {
    transform: translateX(4px);
}

/* ── View All Button ── */
.news-btn-all {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: white;
    color: var(--primary);
    padding: 0.875rem 2rem;
    border-radius: var(--radius-pill);
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    transition: var(--transition);
    border: 1px solid rgba(0, 167, 157, 0.15);
}

.news-btn-all:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-primary);
    border-color: transparent;
}

.news-btn-all i { transition: transform 0.3s ease; }
.news-btn-all:hover i { transform: translateX(5px); }

.news-btn-all--mobile {
    width: 100%;
    justify-content: center;
}

/* ── Empty State ── */
.news-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
}

.news-empty__icon { font-size: 3.5rem; margin-bottom: 1rem; }
.news-empty h4 { color: var(--dark); margin-bottom: 0.5rem; }
.news-empty p { color: var(--secondary); margin-bottom: 0; }

/* ═══════════════════════════════════════════════
   OWL CAROUSEL — Mobile
   ═══════════════════════════════════════════════ */
.news-carousel.owl-carousel .owl-stage-outer {
    overflow: hidden;
    padding: 8px 0 16px;
}

.news-carousel.owl-carousel .owl-stage {
    display: flex !important;
    align-items: stretch;
}

.news-carousel.owl-carousel .owl-item {
    float: none !important;
    display: flex;
}

.news-carousel .news-card {
    width: 100%;
    margin: 0;
}

/* Custom dots */
.news-carousel-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 1.25rem;
}

.news-carousel-dots .news-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(0, 167, 157, 0.2);
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.news-carousel-dots .news-dot.active {
    width: 28px;
    border-radius: 4px;
    background: var(--primary);
}

/* Hide default owl dots/nav */
.news-carousel .owl-dots,
.news-carousel .owl-nav {
    display: none !important;
}

/* ═══════════════════════════════════════════════
   MOBILE BOTTOM SHEET
   ═══════════════════════════════════════════════ */
.news-sheet-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 10000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.news-sheet-overlay.active {
    opacity: 1;
    visibility: visible;
}

.news-sheet {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 10001;
    max-height: 85vh;
    overflow-y: auto;
    overscroll-behavior: contain;
    transform: translateY(100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.news-sheet.active {
    transform: translateY(0);
}

.news-sheet__header {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 16px;
    z-index: 10;
    background: transparent;
}

.news-sheet__handle {
    width: 40px;
    height: 4px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.news-sheet__close {
    position: absolute;
    right: 16px;
    top: 12px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: rgba(255, 255, 255, 0.95);
    color: var(--primary);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
}

.news-sheet__close:hover {
    background: var(--primary);
    color: white;
}

.news-sheet__content {
    padding: 0 0 2rem;
    position: relative;
}

.news-sheet__img-wrap {
    position: relative;
    width: 100%;
    height: 280px;
    overflow: hidden;
}

.news-sheet__img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    object-position: center top;
    display: block;
}

.news-sheet__img-gradient {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100px;
    background: linear-gradient(to top, white, transparent);
    pointer-events: none;
    z-index: 1;
}

.news-sheet__info {
    padding: 0.75rem 1.5rem 0;
}

.news-sheet__title {
    font-family: var(--font-primary);
    font-weight: 800;
    font-size: 1.3rem;
    color: var(--dark);
    line-height: 1.4;
    margin-bottom: 1rem;
    margin-top: 0;
}

.news-sheet__meta {
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
    margin-bottom: 1.25rem;
}

.news-sheet__meta-item {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: var(--secondary);
    font-size: 0.9rem;
    font-weight: 500;
}

.news-sheet__meta-icon {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    background: var(--primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.news-sheet__meta-icon i {
    color: var(--primary);
    font-size: 0.8rem;
}

.news-sheet__meta-text {
    display: flex;
    flex-direction: column;
    line-height: 1.3;
}

.news-sheet__meta-label {
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--secondary);
    opacity: 0.7;
}

.news-sheet__meta-text span:not(.news-sheet__meta-label) {
    font-weight: 600;
    color: var(--dark);
}

.news-sheet__excerpt {
    color: var(--secondary);
    font-size: 0.88rem;
    line-height: 1.7;
    margin-bottom: 1.5rem;
    text-align: justify;
}

.news-sheet__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    width: 100%;
    background: var(--primary-gradient);
    color: white;
    padding: 1rem;
    border-radius: var(--radius-pill);
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: var(--transition);
    box-shadow: 0 6px 24px rgba(0, 167, 157, 0.35);
}

.news-sheet__btn:hover {
    color: white;
    transform: scale(1.02);
    box-shadow: 0 8px 30px rgba(0, 167, 157, 0.4);
}

/* ── Scroll lock & back-to-top ── */
body.news-sheet-open {
    overflow: hidden !important;
    touch-action: none;
}

body.news-sheet-open .back-to-top {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
    transition: opacity 0.3s ease, visibility 0.3s ease !important;
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    .news-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    .news-card--featured {
        grid-column: 1 / -1;
        grid-template-columns: 1fr 1fr;
    }

    .news-heading { font-size: 1.6rem; }
}

@media (max-width: 767.98px) {
    .news-card__body {
        padding: 0.9rem 1.1rem 1rem;
    }

    .news-card__title {
        font-size: 0.92rem;
    }
}

@media (max-width: 575.98px) {
    .news-heading { font-size: 1.4rem; }
}

/* Tablet bottom sheet */
@media (min-width: 768px) {
    .news-sheet {
        max-width: 480px;
        left: 50%;
        transform: translate(-50%, 100%);
        border-radius: 24px 24px 0 0;
    }

    .news-sheet.active {
        transform: translate(-50%, 0);
    }

    .news-card__tap-hint {
        display: none;
    }
}

/* ── Dark Mode ── */
[data-theme="dark"] .news-heading           { color: #e2e8f0; }
[data-theme="dark"] .news-heading__highlight { color: #4dd9cf; }
[data-theme="dark"] .news-card { background: #1a1f2e; border-color: rgba(0,167,157,.12); }
[data-theme="dark"] .news-card__title a { color: #e2e8f0; }
[data-theme="dark"] .news-card__meta  { color: #9ca3af; }
[data-theme="dark"] .news-card__title { color: #e2e8f0; }
[data-theme="dark"] .news-card__excerpt { color: #9ca3af; }
[data-theme="dark"] .news-card__date-badge { background: rgba(26,31,46,.95); }
[data-theme="dark"] .news-card__date-month { color: #9ca3af; }
[data-theme="dark"] .news-btn-all { background: #1a1f2e; color: #00c4b8; border-color: rgba(0,167,157,.25); }
[data-theme="dark"] .news-empty { background: #1a1f2e; }
[data-theme="dark"] .news-empty h4 { color: #e2e8f0; }
[data-theme="dark"] .news-empty p { color: #9ca3af; }
[data-theme="dark"] .news-sheet { background: #1a1f2e; }
[data-theme="dark"] .news-sheet__img-gradient { background: linear-gradient(to top, #1a1f2e, transparent); }
[data-theme="dark"] .news-sheet__title { color: #e2e8f0; }
[data-theme="dark"] .news-sheet__meta-item { color: #9ca3af; }
[data-theme="dark"] .news-sheet__meta-text span:not(.news-sheet__meta-label) { color: #e2e8f0; }
[data-theme="dark"] .news-sheet__excerpt    { color: #9ca3af; }
[data-theme="dark"] .news-subtitle          { color: #9ca3af; }
[data-theme="dark"] .news-card__tap-hint    { background: rgba(26,31,46,.92); color: #e2e8f0; }
[data-theme="dark"] .news-sheet__meta-icon  { background: rgba(0,167,157,.15); }
</style>
