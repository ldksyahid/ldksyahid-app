<style>
/* ═══════════════════════════════════════════════
   TESTIMONY SECTION — Modern & Elegant
   ═══════════════════════════════════════════════ */
:root {
    --primary: #00a79d;
    --primary-light: rgba(0, 167, 157, 0.1);
    --primary-gradient: linear-gradient(135deg, #00a79d 0%, #00d4c4 100%);
    --secondary: #6c757d;
    --dark: #2d3e50;
    --font-primary: 'Poppins', sans-serif;
    --radius-pill: 50px;
}

.testimony-modern {
    background: transparent;
    position: relative;
}

/* ── Sidebar Container ── */
.testimony-sidebar {
    position: sticky;
    top: 100px;
    opacity: 0;
    transform: translateX(30px);
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.testimony-sidebar.is-visible {
    opacity: 1;
    transform: translateX(0);
}

.testimony-badge {
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
    max-width: 100%;
    word-wrap: break-word;
}

.testimony-badge__emoji {
    font-size: 1.1rem;
    flex-shrink: 0;
}

.testimony-badge__pulse {
    width: 8px;
    height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: testimonyPulse 2s ease-in-out infinite;
    flex-shrink: 0;
}

@keyframes testimonyPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.5); }
}

.testimony-heading {
    font-family: var(--font-primary);
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
    word-wrap: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
}

.testimony-heading__heart {
    display: inline-block;
    animation: heartBeat 1.5s ease-in-out infinite;
}

@keyframes heartBeat {
    0%, 100% { transform: scale(1); }
    25% { transform: scale(1.1); }
    50% { transform: scale(1); }
}

.testimony-subtitle {
    color: var(--secondary);
    font-size: 1rem;
    line-height: 1.6;
    max-width: 100%;
    margin: 0;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* ── Stats Sidebar ── */
.testimony-stats-sidebar {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
    position: relative;
    overflow: hidden;
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
                background-color 0.4s ease,
                border-color 0.4s ease;
}

.stat-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.08) 0%, rgba(0, 167, 157, 0.03) 100%);
    opacity: 0;
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 20px;
    pointer-events: none;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0, 167, 157, 0.15);
    border-color: var(--primary);
}

.stat-card:hover::after {
    opacity: 1;
}

.stat-card__icon {
    font-size: 2.5rem;
    filter: drop-shadow(0 2px 8px rgba(0, 167, 157, 0.2));
    position: relative;
    z-index: 1;
}

.stat-card__content {
    display: flex;
    flex-direction: column;
    position: relative;
    z-index: 1;
}

.stat-card__number {
    font-family: var(--font-primary);
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.stat-card__label {
    font-size: 0.85rem;
    color: var(--secondary);
    font-weight: 500;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.stat-card__shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 50%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
    transition: left 0.5s ease;
    z-index: 2;
    pointer-events: none;
}

.stat-card:hover .stat-card__shine {
    left: 100%;
}

/* ── Testimony Grid ── */
.testimony-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.testimony-card {
    background: white;
    border-radius: 20px;
    padding: 1.75rem;
    position: relative;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.04);
    transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1),
                background-color 0.4s ease,
                border-color 0.4s ease;
    display: flex;
    flex-direction: column;
}

.testimony-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.06) 0%, rgba(0, 167, 157, 0.02) 100%);
    opacity: 0;
    transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    border-radius: 20px;
    pointer-events: none;
}

.testimony-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    border-color: var(--primary);
}

.testimony-card:hover::after {
    opacity: 1;
}

.testimony-card__quote {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 4rem;
    font-family: Georgia, serif;
    color: var(--primary);
    opacity: 0.1;
    line-height: 1;
    pointer-events: none;
    z-index: 1;
}

.testimony-card__profile {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    margin-bottom: 1rem;
    position: relative;
    z-index: 2;
}

.profile__avatar-wrap {
    position: relative;
    flex-shrink: 0;
}

.profile__avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary-light);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.profile__status {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 14px;
    height: 14px;
    background: #10b981;
    border: 2px solid white;
    border-radius: 50%;
}

.profile__name {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1rem;
    color: var(--primary);
    margin: 0 0 0.25rem;
    line-height: 1.2;
}

.profile__role {
    font-size: 0.8rem;
    color: var(--secondary);
    display: block;
}

.testimony-card__divider {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    position: relative;
    z-index: 2;
}

.divider__line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, var(--primary), transparent);
}

.divider__line:last-child {
    background: linear-gradient(90deg, transparent, var(--primary));
}

.divider__dot {
    width: 6px;
    height: 6px;
    background: var(--primary);
    border-radius: 50%;
}

.testimony-card__text {
    color: var(--dark);
    font-size: 0.9rem;
    line-height: 1.7;
    font-style: italic;
    margin: 0;
    flex: 1;
    position: relative;
    z-index: 2;
}

/* ═══════════════════════════════════════════════
   MOBILE STYLES - COMPACT & MINIMAL
   ═══════════════════════════════════════════════ */

/* Mobile Header - Compact */
.testimony-badge-mobile {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: rgba(0, 167, 157, 0.08);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 167, 157, 0.15);
    border-radius: 50px;
    padding: 0.4rem 0.9rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--primary);
}

.testimony-heading-mobile {
    font-family: var(--font-primary);
    font-size: 1.6rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 0;
}

.testimony-subtitle-mobile {
    color: var(--secondary);
    font-size: 0.85rem;
    line-height: 1.5;
    max-width: 90%;
    margin: 0 auto;
}

/* Mobile Stats - Compact Horizontal */
.testimony-stats-compact {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1.5px solid rgba(0, 167, 157, 0.15);
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
    max-width: 280px;
    margin: 0 auto 1rem;
    box-shadow: 0 4px 15px rgba(0, 167, 157, 0.08),
                0 2px 6px rgba(0, 0, 0, 0.04);
}

.stat-compact {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex: 1;
}

.stat-compact__icon {
    font-size: 1.6rem;
    filter: drop-shadow(0 2px 4px rgba(0, 167, 157, 0.2));
}

.stat-compact__text {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.stat-compact__number {
    font-family: var(--font-primary);
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
}

.stat-compact__label {
    font-size: 0.65rem;
    color: var(--secondary);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.stat-compact-divider {
    width: 1px;
    height: 30px;
    background: linear-gradient(to bottom, transparent, rgba(0, 167, 157, 0.3), transparent);
    margin: 0 0.75rem;
}

/* Hide old mobile stats */
.testimony-stats-mobile {
    display: none;
}

.stat-mobile {
    background: linear-gradient(135deg, #ffffff 0%, rgba(0, 167, 157, 0.03) 100%);
    border-radius: 20px;
    padding: 1.25rem 1.75rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 6px 25px rgba(0, 167, 157, 0.12),
                0 3px 10px rgba(0, 0, 0, 0.06);
    border: 2px solid rgba(0, 167, 157, 0.1);
    flex: 0 1 auto;
    min-width: 150px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.stat-mobile::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 150%;
    height: 150%;
    background: radial-gradient(circle, rgba(0, 167, 157, 0.06) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.stat-mobile:hover::before {
    opacity: 1;
}

.stat-mobile:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 35px rgba(0, 167, 157, 0.18),
                0 5px 15px rgba(0, 0, 0, 0.1);
    border-color: rgba(0, 167, 157, 0.2);
}

.stat-mobile__icon {
    font-size: 2.2rem;
    filter: drop-shadow(0 2px 8px rgba(0, 167, 157, 0.2));
    flex-shrink: 0;
}

.stat-mobile__content {
    display: flex;
    flex-direction: column;
}

.stat-mobile__number {
    font-family: var(--font-primary);
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1.2;
}

.stat-mobile__label {
    font-size: 0.75rem;
    color: var(--secondary);
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

/* Carousel Container - Compact */
.testimony-carousel-container {
    position: relative;
    width: 100%;
}

/* Mobile Carousel */
.testimony-carousel.owl-carousel {
    margin: 0 -8px;
    width: calc(100% + 16px);
}

.testimony-carousel .owl-stage-outer {
    padding: 8px 0 16px;
    overflow: hidden;
}

.testimony-carousel .owl-item {
    display: flex;
    justify-content: center;
}

.testimony-card-mobile {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 28px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0, 167, 157, 0.12),
                0 2px 8px rgba(0, 0, 0, 0.04);
    border: 1.5px solid rgba(255, 255, 255, 0.8);
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    width: 100%;
    max-width: 300px;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

.testimony-card-mobile::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.03) 0%, rgba(0, 212, 196, 0.08) 100%);
    opacity: 1;
    z-index: 0;
}

.testimony-card-mobile::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at 30% 30%, rgba(0, 167, 157, 0.1) 0%, transparent 60%);
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: 0;
}

.testimony-card-mobile:active::after {
    opacity: 1;
}

.testimony-card-mobile:active {
    transform: scale(0.98);
    box-shadow: 0 4px 16px rgba(0, 167, 157, 0.15),
                0 2px 6px rgba(0, 0, 0, 0.06);
}

.testimony-card-mobile__header {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    position: relative;
    z-index: 1;
}

.testimony-card-mobile__avatar-wrapper {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    overflow: hidden;
    border: 2.5px solid rgba(255, 255, 255, 0.9);
    box-shadow: 0 4px 16px rgba(0, 167, 157, 0.2),
                0 2px 6px rgba(0, 0, 0, 0.08);
    flex-shrink: 0;
    position: relative;
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.1), rgba(255, 255, 255, 0.3));
}

.testimony-card-mobile__avatar-wrapper::after {
    content: '';
    position: absolute;
    inset: -2.5px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.3), rgba(0, 212, 196, 0.2));
    z-index: -1;
    opacity: 0.6;
}

.testimony-card-mobile__avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.testimony-card-mobile__info {
    flex: 1;
    min-width: 0;
}

.testimony-card-mobile__name {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1.05rem;
    color: var(--dark);
    margin: 0 0 0.2rem;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.testimony-card-mobile__role {
    font-size: 0.75rem;
    color: var(--primary);
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-weight: 600;
    opacity: 0.9;
}

.testimony-card-mobile__btn {
    width: 100%;
    padding: 0.875rem 1.25rem;
    background: linear-gradient(135deg, var(--primary) 0%, #00d4c4 100%);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 16px rgba(0, 167, 157, 0.3),
                0 2px 6px rgba(0, 0, 0, 0.08);
    position: relative;
    overflow: hidden;
    z-index: 1;
    letter-spacing: 0.2px;
}

.testimony-card-mobile__btn::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #00d4c4 0%, var(--primary) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.testimony-card-mobile__btn:active::before {
    opacity: 1;
}

.testimony-card-mobile__btn:active {
    transform: scale(0.96);
    box-shadow: 0 2px 8px rgba(0, 167, 157, 0.25),
                0 1px 4px rgba(0, 0, 0, 0.1);
}

/* Custom Dots Navigation - Minimal */
.testimony-carousel-dots {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    margin-top: 1rem;
    padding: 0.5rem 1rem;
    background: rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    width: fit-content;
    margin-left: auto;
    margin-right: auto;
    box-shadow: 0 2px 8px rgba(0, 167, 157, 0.08);
}

.testimony-carousel-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(0, 167, 157, 0.25);
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.testimony-carousel-dot:active {
    transform: scale(0.9);
}

.testimony-carousel-dot.active {
    width: 24px;
    border-radius: 12px;
    background: var(--primary);
    box-shadow: 0 2px 8px rgba(0, 167, 157, 0.3);
}

/* Hide default Owl Dots */
.owl-carousel .owl-dots {
    display: none !important;
}

/* Empty State */
.testimony-empty-mobile {
    text-align: center;
    padding: 2.5rem 1.5rem;
    background: white;
    border-radius: 24px;
    box-shadow: 0 6px 30px rgba(0, 0, 0, 0.06);
    max-width: 320px;
    margin: 0 auto;
}

.testimony-empty__icon {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

/* Bottom Sheet */
.testimony-sheet-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 10000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.testimony-sheet-overlay.active {
    opacity: 1;
    visibility: visible;
}

.testimony-sheet {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 10001;
    max-height: 80vh;
    overflow-y: auto;
    transform: translateY(100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.testimony-sheet.active {
    transform: translateY(0);
}

.testimony-sheet__header {
    position: sticky;
    top: 0;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 16px;
    z-index: 10;
    border-radius: 24px 24px 0 0;
}

.testimony-sheet__handle {
    width: 40px;
    height: 4px;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 2px;
}

.testimony-sheet__close {
    position: absolute;
    right: 16px;
    top: 12px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: var(--primary-light);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.testimony-sheet__close:hover {
    background: var(--primary);
    color: white;
}

.testimony-sheet__content {
    padding: 1.5rem 1.75rem 2.5rem;
    background: linear-gradient(to bottom, #ffffff 0%, rgba(0, 167, 157, 0.02) 100%);
}

.testimony-sheet__profile {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.testimony-sheet__avatar {
    width: 75px;
    height: 75px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(0, 167, 157, 0.2);
    box-shadow: 0 6px 20px rgba(0, 167, 157, 0.25),
                0 3px 10px rgba(0, 0, 0, 0.1);
    flex-shrink: 0;
    background: linear-gradient(135deg, var(--primary-light), rgba(255, 255, 255, 0.5));
    position: relative;
}

.testimony-sheet__avatar::after {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    border: 2px solid rgba(255, 255, 255, 0.6);
    pointer-events: none;
}

.testimony-sheet__info {
    flex: 1;
    min-width: 0;
}

.testimony-sheet__name {
    font-family: var(--font-primary);
    font-weight: 800;
    font-size: 1.2rem;
    color: var(--primary);
    margin: 0 0 0.25rem;
    word-break: break-word;
}

.testimony-sheet__role {
    font-size: 0.9rem;
    color: var(--secondary);
    display: block;
    word-break: break-word;
}

.testimony-sheet__divider {
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, var(--primary), transparent, var(--primary));
    margin-bottom: 1.5rem;
    border-radius: 4px;
}

.testimony-sheet__quote {
    font-size: 3.5rem;
    font-family: Georgia, serif;
    color: var(--primary);
    opacity: 0.15;
    line-height: 1;
    margin-bottom: -1.5rem;
}

.testimony-sheet__text {
    color: var(--dark);
    font-size: 1rem;
    line-height: 1.7;
    font-style: italic;
    margin: 0;
    word-wrap: break-word;
    overflow-wrap: break-word;
    hyphens: auto;
}

body.testimony-sheet-open {
    overflow: hidden !important;
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    .testimony-grid {
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }

    .testimony-heading {
        font-size: 1.6rem;
    }
}

@media (max-width: 767.98px) {
    .testimony-heading {
        font-size: 1.75rem;
    }

    .testimony-subtitle {
        font-size: 0.95rem;
        line-height: 1.6;
        padding: 0 0.5rem;
    }

    .testimony-badge {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
    }
}

@media (max-width: 480px) {
    .testimony-heading-mobile {
        font-size: 1.4rem;
    }

    .testimony-subtitle-mobile {
        font-size: 0.8rem;
        max-width: 95%;
    }

    .testimony-stats-compact {
        max-width: 260px;
        padding: 0.65rem 1.25rem;
    }

    .stat-compact__icon {
        font-size: 1.4rem;
    }

    .stat-compact__number {
        font-size: 1.15rem;
    }

    .stat-compact__label {
        font-size: 0.6rem;
    }

    .stat-compact-divider {
        height: 25px;
        margin: 0 0.5rem;
    }

    .testimony-card-mobile {
        max-width: 280px;
        padding: 1.25rem;
        border-radius: 24px;
    }

    .testimony-card-mobile__avatar-wrapper {
        width: 52px;
        height: 52px;
    }

    .testimony-card-mobile__name {
        font-size: 0.95rem;
    }

    .testimony-card-mobile__role {
        font-size: 0.7rem;
    }

    .testimony-card-mobile__btn {
        padding: 0.8rem 1.1rem;
        font-size: 0.85rem;
    }

    .testimony-carousel-dot {
        width: 6px;
        height: 6px;
    }

    .testimony-carousel-dot.active {
        width: 20px;
    }

    .testimony-carousel-dots {
        gap: 0.4rem;
        padding: 0.4rem 0.8rem;
    }
}
</style>
