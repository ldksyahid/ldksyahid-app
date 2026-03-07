@verbatim
<style>
/* ============================================================
   PRF — Profile Page Styles
   prefix: prf-
   ============================================================ */

/* --- Section Shell --- */
.prf-section {
    padding: 6.5rem 0 5rem;
    min-height: 100vh;
    background: transparent;
    position: relative;
}

/* ============================================================
   HERO
   ============================================================ */
.prf-hero {
    display: grid;
    grid-template-columns: 290px 1fr;
    gap: 3rem;
    align-items: start;
    max-width: 980px;
    margin: 0 auto 2.5rem;
    padding: 0 1.5rem;
}

/* --- Photo Wrap --- */
.prf-photo-wrap {
    position: relative;
}

.prf-photo-frame {
    width: 100%;
    aspect-ratio: 3 / 4;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(0, 120, 116, 0.18);
    border: 3px solid rgba(255, 255, 255, 0.9);
    transition: transform 0.35s ease, box-shadow 0.35s ease;
    position: relative;
    z-index: 1;
}

.prf-photo-frame::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        120deg,
        rgba(255, 255, 255, 0) 0%,
        rgba(255, 255, 255, 0.2) 50%,
        rgba(255, 255, 255, 0) 100%
    );
    transform: translateX(-100%);
    transition: transform 0.6s ease;
    pointer-events: none;
}

.prf-photo-wrap:hover .prf-photo-frame::after {
    transform: translateX(100%);
}

.prf-photo-wrap:hover .prf-photo-frame {
    transform: translateY(-5px);
    box-shadow: 0 22px 55px rgba(0, 120, 116, 0.25);
}

.prf-photo-frame img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* --- Sifat Badge (top-left overlap) --- */
.prf-sifat-badge {
    position: absolute;
    top: -14px;
    left: -14px;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #fff;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    padding: 0.35rem 0.9rem;
    border-radius: 50rem;
    box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
    white-space: nowrap;
    z-index: 3;
}

/* --- Member Number Pill (bottom glassmorphism) --- */
.prf-member-pill {
    position: absolute;
    bottom: 14px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.38);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.09em;
    padding: 0.3rem 1.1rem;
    border-radius: 50rem;
    white-space: nowrap;
    z-index: 3;
}

/* --- Delete Photo Button (below photo frame) --- */
.prf-delete-photo-form {
    margin-top: 0.85rem;
}

.prf-delete-photo-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    width: 100%;
    padding: 0.55rem 1rem;
    background: rgba(239, 68, 68, 0.08);
    color: #dc2626;
    font-size: 0.78rem;
    font-weight: 600;
    border-radius: 50rem;
    cursor: pointer;
    border: none;
    transition: background 0.22s ease, transform 0.2s ease;
}

.prf-delete-photo-btn:hover {
    background: rgba(239, 68, 68, 0.16);
    transform: translateY(-2px);
}

/* --- Bio Wrap --- */
.prf-bio-wrap {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-top: 0.75rem;
}

.prf-bio-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.prf-bio-name-group {
    flex: 1;
}

.prf-name {
    font-size: 2.4rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0d3d3c;
    margin-bottom: 0.2rem;
}

.prf-fullname {
    font-size: 0.95rem;
    color: #6b7280;
    font-weight: 500;
    margin-bottom: 0;
}

.prf-bio-logo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: contain;
    opacity: 0.85;
    flex-shrink: 0;
}

/* Divider bar between name and tentang */
.prf-bio-divider {
    width: 48px;
    height: 4px;
    background: linear-gradient(90deg, #00b8ad 0%, #006D6D 100%);
    border-radius: 50rem;
    margin: 1rem 0;
}

.prf-tentang {
    font-size: 0.93rem;
    line-height: 1.85;
    color: #374151;
    text-align: justify;
    margin-bottom: 0;
}

/* ============================================================
   INFO SECTION
   ============================================================ */
.prf-info-section {
    max-width: 980px;
    margin: 0 auto;
    padding: 0 1.5rem 2rem;
}

/* --- Info Card --- */
.prf-info-card {
    background: #fff;
    border-radius: 20px;
    padding: 1.75rem 2.25rem;
    box-shadow: 0 8px 32px rgba(0, 120, 116, 0.09);
    margin-bottom: 1.25rem;
    position: relative;
    z-index: 1;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.prf-info-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        120deg,
        rgba(255, 255, 255, 0) 0%,
        rgba(255, 255, 255, 0.22) 50%,
        rgba(255, 255, 255, 0) 100%
    );
    transform: translateX(-100%);
    transition: transform 0.6s ease;
    pointer-events: none;
    z-index: 0;
}

.prf-info-card:hover::after {
    transform: translateX(100%);
}

.prf-info-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 48px rgba(0, 120, 116, 0.15);
}

.prf-card-title {
    font-size: 0.73rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #00b8ad;
    margin-bottom: 1.25rem;
    position: relative;
    z-index: 1;
}

/* --- Info Grid --- */
.prf-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem 1.5rem;
    position: relative;
    z-index: 1;
}

/* --- Info Item --- */
.prf-info-item {
    display: flex;
    align-items: flex-start;
    gap: 0.8rem;
    padding: 0.6rem 0.65rem;
    border-radius: 12px;
    transition: background 0.22s ease;
}

.prf-info-item:hover {
    background: rgba(0, 184, 173, 0.06);
}

.prf-info-item--full {
    grid-column: 1 / -1;
}

/* Animated bullet */
.prf-bullet {
    width: 9px;
    height: 9px;
    min-width: 9px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00b8ad 0%, #00cfb5 100%);
    margin-top: 0.35rem;
    box-shadow: 0 0 0 3px rgba(0, 184, 173, 0.18);
    animation: prfGrow 2.4s ease-in-out infinite;
    flex-shrink: 0;
}

@keyframes prfGrow {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 0 0 3px rgba(0, 184, 173, 0.18);
    }
    50% {
        transform: scale(1.65);
        box-shadow: 0 0 0 5px rgba(0, 184, 173, 0.08);
    }
}

.prf-item-label {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: #9ca3af;
    margin-bottom: 0.12rem;
}

.prf-item-value {
    font-size: 0.875rem;
    color: #1f2937;
    font-weight: 500;
    word-break: break-word;
    margin-bottom: 0;
}

/* ============================================================
   ACTIONS
   ============================================================ */
.prf-actions-wrap {
    max-width: 980px;
    margin: 0 auto;
    padding: 0 1.5rem 4.5rem;
}

.prf-actions {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.85rem;
}

/* Base button */
.prf-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.8rem 1.25rem;
    border-radius: 50rem;
    font-size: 0.86rem;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    white-space: nowrap;
    line-height: 1;
}

.prf-btn:hover {
    transform: translateY(-3px);
    text-decoration: none;
}

/* Back */
.prf-btn-back {
    background: #e2e5ea;
    color: #374151;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
}
.prf-btn-back:hover {
    background: #d1d5db;
    color: #111827;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

/* Export */
.prf-btn-export {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #fff;
    box-shadow: 0 4px 16px rgba(245, 158, 11, 0.28);
}
.prf-btn-export:hover {
    box-shadow: 0 10px 28px rgba(245, 158, 11, 0.38);
    color: #fff;
}

/* Edit */
.prf-btn-edit {
    background: linear-gradient(135deg, #00b8ad 0%, #006D6D 100%);
    color: #fff;
    box-shadow: 0 4px 16px rgba(0, 184, 173, 0.28);
}
.prf-btn-edit:hover {
    box-shadow: 0 10px 28px rgba(0, 184, 173, 0.38);
    color: #fff;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */

/* --- Tablet --- */
@media (max-width: 991.98px) {
    .prf-section {
        padding: 5.5rem 0 4rem;
    }

    .prf-hero {
        grid-template-columns: 240px 1fr;
        gap: 2rem;
    }

    .prf-name {
        font-size: 2rem;
    }

    .prf-bio-logo {
        width: 64px;
        height: 64px;
    }

    .prf-info-card {
        padding: 1.5rem 1.5rem;
    }
}

/* --- Mobile --- */
@media (max-width: 767.98px) {
    .prf-section {
        padding: 4.5rem 0 3rem;
    }

    .prf-hero {
        grid-template-columns: 1fr;
        gap: 1.75rem;
        padding: 0 1rem;
        max-width: 100%;
    }

    .prf-photo-wrap {
        max-width: 220px;
        margin: 0 auto;
    }

    .prf-bio-wrap {
        padding-top: 0;
    }

    .prf-bio-header {
        align-items: center;
    }

    .prf-bio-logo {
        width: 52px;
        height: 52px;
    }

    .prf-name {
        font-size: 1.75rem;
    }

    .prf-tentang {
        text-align: left;
    }

    .prf-info-section {
        padding: 0 1rem 1.25rem;
    }

    .prf-info-card {
        padding: 1.25rem 1rem;
    }

    .prf-info-grid {
        grid-template-columns: 1fr;
        gap: 0.25rem;
    }

    .prf-info-item--full {
        grid-column: auto;
    }

    .prf-actions-wrap {
        padding: 0 1rem 3.5rem;
    }

    .prf-actions {
        grid-template-columns: 1fr;
        gap: 0.65rem;
    }
}
</style>
@endverbatim
