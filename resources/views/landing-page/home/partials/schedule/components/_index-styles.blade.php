<style>
/* ═══════════════════════════════════════════════
   SCHEDULE SECTION — Modern & Elegant
   ═══════════════════════════════════════════════ */
.schedule-fun {
    background: transparent;
    position: relative;
}

/* ── Header (Matching Gallery Style) ── */
.schedule-header-wrap {
    margin-bottom: 0;
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.schedule-header-wrap.is-visible {
    opacity: 1;
    transform: translateY(0);
}

.section-badge-schedule {
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
    box-shadow: 0 2px 8px rgba(0, 167, 157, 0.1);
}

/* ── Header Button ── */
.schedule-btn-view-all {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: white;
    color: var(--primary);
    padding: 0.9rem 2rem;
    border-radius: var(--radius-pill);
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: var(--transition);
    border: 2px solid rgba(0, 167, 157, 0.2);
    white-space: nowrap;
}

.schedule-btn-view-all:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-3px);
    box-shadow: var(--shadow-primary);
    border-color: transparent;
}

.schedule-btn-view-all i {
    transition: transform 0.3s ease;
}

.schedule-btn-view-all:hover i {
    transform: translateX(5px);
}

.badge-emoji {
    font-size: 1.1rem;
}

.badge-pulse {
    width: 8px;
    height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: schPulse 2s ease-in-out infinite;
}

@keyframes schPulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.5;
        transform: scale(1.5);
    }
}

.section-title-fun {
    font-family: var(--font-primary);
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.section-title-highlight {
    color: var(--primary);
    position: relative;
}

.section-title-highlight::after {
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

.section-description-fun {
    color: var(--secondary);
    font-size: 1rem;
    margin-bottom: 0;
}

/* ── Card Animations ── */
.schedule-card-animate {
    opacity: 0;
    transform: translateY(40px) scale(0.97);
    transition: opacity 0.6s ease var(--anim-delay, 0s),
                transform 0.6s cubic-bezier(0.4, 0, 0.2, 1) var(--anim-delay, 0s);
}

.schedule-card-animate.is-visible {
    opacity: 1;
    transform: translateY(0) scale(1);
}

/* ═══════════════════════════════════════════════
   SCHEDULE CARD — Elegant Horizontal Layout
   ═══════════════════════════════════════════════ */
.schedule-card-fun {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    margin-bottom: 2rem;
}

.schedule-card-fun:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
}

.schedule-card-inner {
    display: flex;
    align-items: stretch;
    min-height: 320px;
}

/* ── Image Section ── */
.schedule-image-wrapper {
    flex: 1;
    position: relative;
    min-height: 320px;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.schedule-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.schedule-card-fun:hover .schedule-img {
    transform: scale(1.1);
}

.schedule-image-gradient {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 120px;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.4), transparent);
    pointer-events: none;
}

/* ── Info Box Section ── */
.schedule-info-box {
    width: 380px;
    background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 50%, #f8fafc 100%);
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    flex-shrink: 0;
    border-left: 1px solid rgba(0, 167, 157, 0.1);
    overflow: hidden;
}

/* Decorative Icons */
.info-deco-top {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 167, 157, 0.05);
    border-radius: 50%;
    z-index: 1;
}

.info-deco-top i {
    font-size: 1.5rem;
    color: var(--primary);
    opacity: 0.3;
    animation: schDecoFloat1 4s ease-in-out infinite;
}

.info-deco-bottom {
    position: absolute;
    bottom: 30px;
    left: 25px;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(124, 58, 237, 0.05);
    border-radius: 50%;
    z-index: 1;
}

.info-deco-bottom i {
    font-size: 1.3rem;
    color: #7c3aed;
    opacity: 0.3;
    animation: schDecoFloat2 5s ease-in-out infinite;
}

@keyframes schDecoFloat1 {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-8px) rotate(5deg); }
}

@keyframes schDecoFloat2 {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(8px) rotate(-5deg); }
}

/* Pattern Background */
.info-pattern {
    position: absolute;
    inset: 0;
    opacity: 0.03;
    background-image:
        radial-gradient(circle at 25% 25%, var(--primary) 2px, transparent 2px),
        radial-gradient(circle at 75% 75%, var(--primary) 2px, transparent 2px);
    background-size: 40px 40px;
    background-position: 0 0, 20px 20px;
    pointer-events: none;
}

/* Main Content Wrapper */
.info-content {
    position: relative;
    z-index: 2;
    padding: 2.5rem;
    width: 100%;
}

.info-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.1) 0%, rgba(0, 167, 157, 0.05) 100%);
    color: var(--primary);
    padding: 0.6rem 1.25rem;
    border-radius: var(--radius-pill);
    margin-bottom: 1.5rem;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    box-shadow: 0 4px 15px rgba(0, 167, 157, 0.12);
    transition: all 0.3s ease;
}

.schedule-card-fun:hover .info-badge {
    background: var(--primary);
    color: white;
    transform: scale(1.05);
}

.info-badge i {
    font-size: 0.9rem;
}

.info-divider {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.75rem;
    width: 100%;
}

.divider-line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(0, 167, 157, 0.3), transparent);
}

.divider-icon {
    color: var(--primary);
    font-size: 0.9rem;
    animation: schStarSpin 3s linear infinite;
}

@keyframes schStarSpin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

/* Date Wrapper with Circle */
.info-date-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.25rem;
    margin-bottom: 1.75rem;
    padding: 1.5rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0, 167, 157, 0.08);
}

.info-date-circle {
    width: 70px;
    height: 70px;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 8px 20px rgba(0, 167, 157, 0.3);
    animation: schDatePulse 3s ease-in-out infinite;
}

.info-date-circle i {
    font-size: 1.8rem;
    color: white;
}

@keyframes schDatePulse {
    0%, 100% { transform: scale(1); box-shadow: 0 8px 20px rgba(0, 167, 157, 0.3); }
    50% { transform: scale(1.05); box-shadow: 0 12px 30px rgba(0, 167, 157, 0.4); }
}

.info-date {
    text-align: left;
}

.date-label {
    font-size: 0.65rem;
    color: var(--secondary);
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 1.5px;
    display: block;
    margin-bottom: 0.35rem;
    opacity: 0.8;
}

.date-month {
    font-family: var(--font-primary);
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--primary);
    margin: 0;
    line-height: 1.2;
    text-shadow: 0 2px 4px rgba(0, 167, 157, 0.1);
}

.date-year {
    font-size: 1rem;
    color: var(--secondary);
    font-weight: 600;
    display: block;
    margin-top: 0.15rem;
}

/* Description Section */
.info-description {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.08) 0%, rgba(0, 167, 157, 0.04) 100%);
    padding: 1rem 1.25rem;
    border-radius: 16px;
    margin-bottom: 1.75rem;
    box-shadow: inset 0 0 0 0 rgba(0, 167, 157, 0.3);
}

.info-description i {
    color: var(--primary);
    font-size: 0.9rem;
    margin-top: 0.15rem;
    flex-shrink: 0;
}

.info-description p {
    margin: 0;
    font-size: 0.8rem;
    line-height: 1.6;
    color: var(--dark);
    text-align: left;
    font-weight: 500;
}

/* Enhanced CTA Button */
.info-cta {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--primary-gradient);
    color: white;
    padding: 1.1rem 1.5rem;
    border-radius: 16px;
    text-decoration: none;
    box-shadow: 0 8px 25px rgba(0, 167, 157, 0.35);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    width: 100%;
    position: relative;
    overflow: hidden;
}

.info-cta::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s ease;
}

.info-cta:hover::before {
    left: 100%;
}

.info-cta:hover {
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(0, 167, 157, 0.45);
}

.cta-icon-wrap {
    width: 42px;
    height: 42px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    backdrop-filter: blur(10px);
}

.cta-icon-wrap i {
    font-size: 1.1rem;
}

.cta-text {
    flex: 1;
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
}

.cta-main {
    font-size: 0.9rem;
    font-weight: 700;
    letter-spacing: 0.3px;
}

.cta-sub {
    font-size: 0.7rem;
    opacity: 0.9;
    font-weight: 500;
}

.cta-arrow {
    font-size: 1rem;
    transition: transform 0.3s ease;
    flex-shrink: 0;
}

.info-cta:hover .cta-arrow {
    transform: translateX(5px);
}

/* ── Empty State ── */
.empty-state-schedule {
    display: flex;
    justify-content: center;
}

.empty-card {
    background: white;
    border-radius: 24px;
    padding: 4rem 3rem;
    text-align: center;
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
    max-width: 500px;
    width: 100%;
}

.empty-icon {
    font-size: 4.5rem;
    margin-bottom: 1.5rem;
    animation: schEmptyFloat 3s ease-in-out infinite;
}

@keyframes schEmptyFloat {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.empty-title {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1.4rem;
    color: var(--dark);
    margin-bottom: 0.75rem;
}

.empty-text {
    color: var(--secondary);
    font-size: 1rem;
    margin-bottom: 0;
    line-height: 1.6;
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    .schedule-card-inner {
        flex-direction: column;
    }

    .schedule-image-wrapper {
        min-height: 280px;
    }

    .schedule-info-box {
        width: 100%;
        border-left: none;
        border-top: 1px solid rgba(0, 167, 157, 0.1);
    }

    .info-content {
        padding: 2rem 1.5rem;
    }

    .section-title-fun {
        font-size: 1.6rem;
    }

    .date-month {
        font-size: 1.5rem;
    }

    .info-date-wrapper {
        gap: 1rem;
        padding: 1.25rem;
    }

    .info-date-circle {
        width: 60px;
        height: 60px;
    }

    .info-date-circle i {
        font-size: 1.5rem;
    }
}

@media (max-width: 767.98px) {
    .section-title-fun {
        font-size: 1.4rem;
    }

    .info-content {
        padding: 1.75rem 1.25rem;
    }

    .date-month {
        font-size: 1.35rem;
    }

    .info-badge {
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
    }

    .info-date-circle {
        width: 55px;
        height: 55px;
    }

    .info-date-circle i {
        font-size: 1.3rem;
    }

    .info-description {
        padding: 0.85rem 1rem;
    }

    .cta-icon-wrap {
        width: 38px;
        height: 38px;
    }

    .cta-main {
        font-size: 0.85rem;
    }

    .cta-sub {
        font-size: 0.65rem;
    }
}

/* ── Dark Mode ── */
[data-theme="dark"] .section-title-fun       { color: #e2e8f0; }
[data-theme="dark"] .section-title-highlight { color: #e2e8f0; }
[data-theme="dark"] .schedule-card-fun { background: #1a1f2e; }
[data-theme="dark"] .schedule-info-box {
    background: linear-gradient(135deg, #1e2d2c 0%, #1a1f2e 50%, #1e2535 100%);
    border-color: rgba(0,167,157,.15);
}
[data-theme="dark"] .schedule-btn-view-all { background: #1a1f2e; color: #00c4b8; border-color: rgba(0,167,157,.3); }
[data-theme="dark"] .info-date-wrapper { background: #252b3b; }
[data-theme="dark"] .info-description { background: linear-gradient(135deg, rgba(0,167,157,.1) 0%, rgba(0,167,157,.05) 100%); }
[data-theme="dark"] .info-description p { color: #cbd5e0; }
[data-theme="dark"] .date-label { color: #9ca3af; }
[data-theme="dark"] .date-year { color: #9ca3af; }
[data-theme="dark"] .empty-card { background: #1a1f2e; }
[data-theme="dark"] .empty-title { color: #e2e8f0; }
[data-theme="dark"] .empty-text { color: #9ca3af; }
</style>
