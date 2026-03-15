<style>
/* ═══════════════════════════════════════════════
   ARTICLE SECTION — Clean Modern Fun Design
   ═══════════════════════════════════════════════ */

.article-section {
    background: transparent;
    position: relative;
    overflow: hidden;
}

/* ── Section Header ── */
.art-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-light);
    border-radius: var(--radius-pill);
    padding: 0.5rem 1.25rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--primary);
    position: relative;
}

.art-badge__pulse {
    width: 8px;
    height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: artBadgePulse 2s ease-in-out infinite;
}

@keyframes artBadgePulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.5); }
}

.art-heading {
    font-family: var(--font-primary);
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.art-heading__highlight {
    color: var(--primary);
    position: relative;
}

.art-heading__highlight::after {
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

.art-heading__sparkle {
    display: inline-block;
    animation: artSparkle 2s ease-in-out infinite;
}

@keyframes artSparkle {
    0%, 100% { transform: rotate(0deg) scale(1); }
    50% { transform: rotate(15deg) scale(1.2); }
}

.art-subtitle {
    color: var(--secondary);
    font-size: 1rem;
    margin-bottom: 0;
}

/* ── View All Button ── */
.art-btn-all {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: white;
    color: var(--primary);
    padding: 0.875rem 1.5rem;
    border-radius: var(--radius-pill);
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    transition: var(--transition);
    border: none;
}

.art-btn-all:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-primary);
}

.art-btn-all i { transition: transform 0.3s ease; }
.art-btn-all:hover i { transform: translateX(5px); }

/* ── Desktop Grid ── */
.art-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.75rem;
}

/* ═══════════════════════════════════════════════
   ARTICLE CARD — Fun & Colorful
   ═══════════════════════════════════════════════ */
.art-card {
    --card-accent: var(--primary);
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    display: flex;
    flex-direction: column;
}

.art-card:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow:
        0 20px 40px rgba(0, 0, 0, 0.08),
        0 4px 20px color-mix(in srgb, var(--card-accent) 25%, transparent);
}

/* ── Image ── */
.art-card__img-wrap {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.art-card__img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.art-card:hover .art-card__img {
    transform: scale(1.08);
}

/* Date Badge */
.art-card__date {
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

.art-card:hover .art-card__date {
    transform: rotate(-3deg) scale(1.05);
}

.art-card__date-num {
    display: block;
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--card-accent);
}

.art-card__date-month {
    display: block;
    font-size: 0.6rem;
    font-weight: 700;
    color: var(--secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 1px;
}

/* Tap hint on mobile */
.art-card__tap-hint {
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
    opacity: 0.9;
    animation: artPulse 2s ease-in-out infinite;
}

@keyframes artPulse {
    0%, 100% { opacity: 0.9; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(0.97); }
}

/* ── Body ── */
.art-card__body {
    padding: 1.1rem 1.25rem 1.25rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.art-card__theme {
    margin-bottom: 0.6rem;
    --theme-color: var(--primary);
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: color-mix(in srgb, var(--theme-color) 10%, white);
    color: var(--theme-color);
    padding: 5px 14px 5px 10px;
    border-radius: 10px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.2px;
    box-shadow: 0 2px 8px color-mix(in srgb, var(--theme-color) 15%, transparent);
    transition: all 0.3s ease;
}

.art-card__theme::before {
    content: '';
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--theme-color);
    flex-shrink: 0;
    animation: artThemeDot 2s ease-in-out infinite;
}

@keyframes artThemeDot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.4); }
}

.art-card:hover .art-card__theme {
    background: var(--theme-color);
    color: white;
    box-shadow: 0 4px 14px color-mix(in srgb, var(--theme-color) 30%, transparent);
}

.art-card:hover .art-card__theme::before {
    background: white;
}

.art-card__title {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 0.95rem;
    line-height: 1.5;
    margin-bottom: 0.75rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex: 1;
}

.art-card__title a {
    color: var(--dark);
    text-decoration: none;
    transition: color 0.3s ease;
    background-image: linear-gradient(var(--card-accent), var(--card-accent));
    background-size: 0% 2px;
    background-repeat: no-repeat;
    background-position: left bottom;
    transition: background-size 0.3s ease, color 0.3s ease;
    padding-bottom: 1px;
}

.art-card:hover .art-card__title a {
    background-size: 100% 2px;
    color: var(--card-accent);
}

/* People Card */
.art-card__people-card {
    background: color-mix(in srgb, var(--card-accent) 5%, #f8f9fa);
    border-radius: 14px;
    padding: 0.7rem 0.85rem;
    margin-bottom: 0.85rem;
    display: flex;
    flex-direction: column;
    gap: 0;
    transition: background 0.3s ease;
}

.art-card:hover .art-card__people-card {
    background: color-mix(in srgb, var(--card-accent) 8%, #f8f9fa);
}

.art-card__people-divider {
    height: 1px;
    background: color-mix(in srgb, var(--card-accent) 12%, transparent);
    margin: 0.45rem 0;
    border-radius: 1px;
}

/* Meta row */
.art-card__meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--secondary);
    font-size: 0.8rem;
    font-weight: 500;
    min-width: 0;
}

.art-card__meta-info {
    display: flex;
    flex-direction: column;
    min-width: 0;
    line-height: 1.25;
}

.art-card__meta-label {
    font-size: 0.6rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--secondary);
    opacity: 0.6;
}

.art-card__meta-name {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--dark);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.art-card__avatar {
    width: 28px;
    height: 28px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    flex-shrink: 0;
    transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.art-card:hover .art-card__avatar {
    transform: scale(1.1) rotate(-3deg);
}

/* Read Button — Full width */
.art-card__read {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    color: var(--card-accent);
    background: color-mix(in srgb, var(--card-accent) 8%, transparent);
    font-weight: 700;
    font-size: 0.82rem;
    text-decoration: none;
    padding: 10px 18px;
    border-radius: 14px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    margin-top: auto;
}

.art-card__read::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--card-accent);
    border-radius: inherit;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 0;
}

.art-card:hover .art-card__read::before {
    transform: scaleX(1);
}

.art-card__read span,
.art-card__read i {
    position: relative;
    z-index: 1;
    transition: color 0.3s ease;
}

.art-card:hover .art-card__read {
    color: white;
    box-shadow: 0 6px 20px color-mix(in srgb, var(--card-accent) 30%, transparent);
}

.art-card__read i {
    font-size: 0.72rem;
    transition: transform 0.3s ease, color 0.3s ease;
}

.art-card:hover .art-card__read i {
    transform: translateX(4px);
    animation: artArrowBounce 0.6s ease-in-out 0.15s;
}

@keyframes artArrowBounce {
    0%, 100% { transform: translateX(4px); }
    50% { transform: translateX(8px); }
}

/* ── Empty State ── */
.art-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
}

.art-empty__icon { font-size: 3.5rem; margin-bottom: 1rem; }
.art-empty h4 { color: var(--dark); margin-bottom: 0.5rem; }
.art-empty p { color: var(--secondary); margin-bottom: 0; }

/* ═══════════════════════════════════════════════
   OWL CAROUSEL — Mobile
   ═══════════════════════════════════════════════ */
.art-carousel.owl-carousel .owl-stage-outer {
    overflow: hidden;
    padding: 8px 0 16px;
}

.art-carousel.owl-carousel .owl-stage {
    display: flex !important;
    align-items: stretch;
}

.art-carousel.owl-carousel .owl-item {
    float: none !important;
    display: flex;
}

.art-carousel .art-card {
    width: 100%;
    margin: 0;
}

/* Custom dots */
.art-carousel-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 1.25rem;
}

.art-carousel-dots .art-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(0, 167, 157, 0.2);
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.art-carousel-dots .art-dot.active {
    width: 28px;
    border-radius: 4px;
    background: var(--primary);
}

/* Hide default owl dots/nav */
.art-carousel .owl-dots,
.art-carousel .owl-nav {
    display: none !important;
}

/* ═══════════════════════════════════════════════
   MOBILE BOTTOM SHEET
   ═══════════════════════════════════════════════ */

.art-sheet-overlay {
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

.art-sheet-overlay.active {
    opacity: 1;
    visibility: visible;
}

.art-sheet {
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

.art-sheet.active {
    transform: translateY(0);
}

.art-sheet__header {
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

.art-sheet__handle {
    width: 40px;
    height: 4px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.art-sheet__close {
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

.art-sheet__close:hover {
    background: var(--primary);
    color: white;
}

.art-sheet__content {
    padding: 0 0 2rem;
    position: relative;
}

.art-sheet__img-wrap {
    position: relative;
    width: 100%;
    height: 280px;
    overflow: hidden;
}

.art-sheet__img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    object-position: center top;
    display: block;
}

.art-sheet__img-gradient {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100px;
    background: linear-gradient(to top, white, transparent);
    pointer-events: none;
    z-index: 1;
}

.art-sheet__info {
    padding: 0.75rem 1.5rem 0;
}

.art-sheet__title {
    font-family: var(--font-primary);
    font-weight: 800;
    font-size: 1.3rem;
    color: var(--dark);
    line-height: 1.4;
    margin-bottom: 1rem;
    margin-top: 0.5rem;
}

.art-sheet__meta {
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
    margin-bottom: 1.5rem;
}

.art-sheet__meta-item {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: var(--secondary);
    font-size: 0.9rem;
    font-weight: 500;
}

.art-sheet__meta-icon {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    background: var(--primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.art-sheet__meta-icon i {
    color: var(--primary);
    font-size: 0.8rem;
}

.art-sheet__meta-text {
    display: flex;
    flex-direction: column;
    line-height: 1.3;
}

.art-sheet__meta-label {
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--secondary);
    opacity: 0.7;
}

.art-sheet__meta-text span:not(.art-sheet__meta-label) {
    font-weight: 600;
    color: var(--dark);
}

.art-sheet__btn {
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

.art-sheet__btn:hover {
    color: white;
    transform: scale(1.02);
    box-shadow: 0 8px 30px rgba(0, 167, 157, 0.4);
}

/* ── Scroll lock ── */
body.art-sheet-open {
    overflow: hidden !important;
    touch-action: none;
}

/* ── Back-to-top smooth hide ── */
body.art-sheet-open .back-to-top {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
    transition: opacity 0.3s ease, visibility 0.3s ease !important;
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */

@media (max-width: 991.98px) {
    .art-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    .art-heading { font-size: 1.6rem; }
}

@media (max-width: 767.98px) {
    .art-card__body {
        padding: 0.9rem 1.1rem 1rem;
    }
}

@media (max-width: 575.98px) {
    .art-btn-all {
        width: 100%;
        justify-content: center;
    }
}

/* Tablet bottom sheet */
@media (min-width: 768px) {
    .art-sheet {
        max-width: 480px;
        left: 50%;
        transform: translate(-50%, 100%);
        border-radius: 24px 24px 0 0;
    }

    .art-sheet.active {
        transform: translate(-50%, 0);
    }

    .art-card__tap-hint {
        display: none;
    }
}

/* ── Dark Mode ── */
[data-theme="dark"] .art-card { background: #1a1f2e; }
[data-theme="dark"] .art-card__title a { color: #e2e8f0; }
[data-theme="dark"] .art-card__meta { color: #9ca3af; }
[data-theme="dark"] .art-btn-all { background: #1a1f2e; color: #00c4b8; border-color: rgba(0,167,157,.4); }
[data-theme="dark"] .art-empty { background: #1a1f2e; color: #9ca3af; }
[data-theme="dark"] .art-sheet { background: #1a1f2e; }
[data-theme="dark"] .art-sheet__img-gradient { background: linear-gradient(to bottom, transparent, #1a1f2e); }
[data-theme="dark"] .art-sheet__title { color: #e2e8f0; }
[data-theme="dark"] .art-sheet__meta { color: #9ca3af; }
[data-theme="dark"] .art-sheet__body { color: #cbd5e0; }
[data-theme="dark"] .art-heading            { color: #e2e8f0; }
[data-theme="dark"] .art-heading__highlight { color: #4dd9cf; }
[data-theme="dark"] .art-card__title                        { color: #e2e8f0; }
[data-theme="dark"] .art-card__people-card                  { background: #252b3b; }
[data-theme="dark"] .art-card:hover .art-card__people-card  { background: #2d3548; }
[data-theme="dark"] .art-card__meta-name                    { color: #e2e8f0; }
[data-theme="dark"] .art-card:hover .art-card__meta-name    { color: #e2e8f0; }
[data-theme="dark"] .art-card__meta-label                   { color: #9ca3af; }
[data-theme="dark"] .art-card__theme                        { background: rgba(0,167,157,.15); color: #4dd9cf; }
[data-theme="dark"] .art-card__read                         { background: rgba(0,167,157,.15); color: #4dd9cf; }
[data-theme="dark"] .art-card__tap-hint     { background: rgba(26,31,46,.92); color: #e2e8f0; }
[data-theme="dark"] .art-sheet__meta-item   { color: #9ca3af; }
[data-theme="dark"] .art-sheet__meta-icon   { background: rgba(0,167,157,.15); }
[data-theme="dark"] .art-sheet__meta-text span:not(.art-sheet__meta-label) { color: #e2e8f0; }
</style>
