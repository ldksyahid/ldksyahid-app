@verbatim
<style>
/* ============================================================
   PRF — Profile Page Styles
   Warna mengikuti global style-v1.0.0.css:
     --primary      : #00a79d
     --primary-dark : #008f86
     --primary-light: #e0f7f5
     --warning      : #ffc107
     --dark         : #282d30
   prefix: prf-
   ============================================================ */

.prf-section {
    padding: 6.5rem 0 5rem;
    min-height: 100vh;
    background: transparent;
    position: relative;
}

/* ============================================================
   HERO
   ============================================================ */

/* --- Photo Wrap --- */
.prf-photo-wrap {
    position: relative;
}

.prf-photo-frame {
    width: 100%;
    aspect-ratio: 3 / 4;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(0, 167, 157, 0.18);
    border: 3px solid rgba(255, 255, 255, 0.9);
    transition: transform 0.35s ease, box-shadow 0.35s ease;
    position: relative;
    z-index: 1;
}

/* Shine sweep on hover */
.prf-photo-frame::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        120deg,
        rgba(255,255,255,0)   0%,
        rgba(255,255,255,0.2)  50%,
        rgba(255,255,255,0)   100%
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
    box-shadow: 0 22px 55px rgba(0, 167, 157, 0.25);
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
    background: linear-gradient(135deg, #ffc107 0%, #e6a800 100%);
    color: #282d30;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    padding: 0.35rem 0.9rem;
    border-radius: 50rem;
    box-shadow: 0 4px 14px rgba(255, 193, 7, 0.38);
    white-space: nowrap;
    z-index: 3;
}

/* --- Member Number Pill (bottom glassmorphism, inside frame) --- */
.prf-member-pill {
    position: absolute;
    bottom: 12px;
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

/* --- Delete Photo Button --- */
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
    background: rgba(220, 53, 69, 0.08);
    color: #dc3545;
    font-size: 0.78rem;
    font-weight: 600;
    border-radius: 50rem;
    cursor: pointer;
    border: none;
    transition: background 0.22s ease, transform 0.2s ease;
}
.prf-delete-photo-btn:hover {
    background: rgba(220, 53, 69, 0.16);
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

.prf-bio-name-group { flex: 1; }

.prf-name {
    font-size: 2.4rem;
    font-weight: 800;
    line-height: 1.1;
    color: #282d30;
    margin-bottom: 0.2rem;
}

.prf-fullname {
    font-size: 0.95rem;
    color: #8d9297;
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

/* Divider bar */
.prf-bio-divider {
    width: 48px;
    height: 4px;
    background: linear-gradient(90deg, #00a79d 0%, #008f86 100%);
    border-radius: 50rem;
    margin: 1rem 0;
}

.prf-tentang {
    font-size: 0.93rem;
    line-height: 1.85;
    color: #343a40;
    text-align: justify;
    margin-bottom: 0;
}

/* ============================================================
   INFO CARDS — matches prf-form-card glassmorphism style
   ============================================================ */

.prf-info-card {
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.05) 0%, rgba(255, 255, 255, 0.8) 100%);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(0, 167, 157, 0.15);
    border-radius: 28px;
    padding: 1.75rem 2.25rem;
    box-shadow: 0 20px 60px rgba(0, 167, 157, 0.08);
    position: relative;
    z-index: 1;
    transition: border-color 0.3s, box-shadow 0.3s, transform 0.3s;
    overflow: hidden;
    height: 100%;
}
.prf-info-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        120deg,
        rgba(255,255,255,0)   0%,
        rgba(255,255,255,0.22) 50%,
        rgba(255,255,255,0)   100%
    );
    transform: translateX(-100%);
    transition: transform 0.6s ease;
    pointer-events: none;
    z-index: 0;
}
.prf-info-card:hover::after { transform: translateX(100%); }
.prf-info-card:hover {
    border-color: rgba(0, 167, 157, 0.25);
    box-shadow: 0 25px 70px rgba(0, 167, 157, 0.12);
    transform: translateY(-4px);
}

.prf-card-title {
    font-size: 0.73rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #00a79d;
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
    background: rgba(0, 167, 157, 0.08);
}
.prf-info-item--full { grid-column: 1 / -1; }

/* Animated bullet */
.prf-bullet {
    width: 9px;
    height: 9px;
    min-width: 9px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00a79d 0%, #6dd5c7 100%);
    margin-top: 0.35rem;
    box-shadow: 0 0 0 2px rgba(0, 167, 157, 0.2);
    animation: prfGrow 2.4s ease-in-out infinite;
    flex-shrink: 0;
}
@keyframes prfGrow {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 0 0 2px rgba(0, 167, 157, 0.2);
    }
    50% {
        transform: scale(1.3);
        box-shadow: 0 0 0 4px rgba(0, 167, 157, 0.1);
    }
}

.prf-item-label {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: #adb5bd;
    margin-bottom: 0.12rem;
}
.prf-item-value {
    font-size: 0.875rem;
    color: #282d30;
    font-weight: 500;
    word-break: break-word;
    margin-bottom: 0;
}

/* ============================================================
   ACTIONS
   ============================================================ */
.prf-actions {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 0.85rem;
    padding-bottom: 3rem;
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
.prf-btn:hover { transform: translateY(-3px); text-decoration: none; }

/* Back */
.prf-btn-back {
    background: #e9ecef;
    color: #343a40;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
}
.prf-btn-back:hover {
    background: #dee2e6;
    color: #282d30;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

/* Edit */
.prf-btn-edit {
    background: linear-gradient(135deg, #00a79d 0%, #008f86 100%);
    color: #fff;
    box-shadow: 0 4px 16px rgba(0, 167, 157, 0.28);
}
.prf-btn-edit:hover {
    box-shadow: 0 10px 28px rgba(0, 167, 157, 0.38);
    color: #fff;
}

/* ============================================================
   RESPONSIVE
   Bootstrap col-lg-* stacks at < 992px
   ============================================================ */
@media (max-width: 991.98px) {
    .prf-section { padding: 5.5rem 0 4rem; }
    .prf-photo-wrap { max-width: 260px; margin: 0 auto; }
    .prf-name { font-size: 2rem; }
    .prf-bio-logo { width: 64px; height: 64px; }
    .prf-info-card { padding: 1.5rem 1.5rem; }
}

@media (max-width: 767.98px) {
    .prf-section { padding: 4.5rem 0 3rem; }
    .prf-photo-wrap { max-width: 220px; }
    .prf-bio-wrap { padding-top: 0; }
    .prf-bio-header { align-items: center; }
    .prf-bio-logo { width: 52px; height: 52px; }
    .prf-name { font-size: 1.75rem; }
    .prf-tentang { text-align: left; }
    .prf-info-card { padding: 1.25rem 1rem; }
    .prf-info-grid { grid-template-columns: 1fr; gap: 0.25rem; }
    .prf-info-item--full { grid-column: auto; }
    .prf-actions { grid-template-columns: 1fr; gap: 0.65rem; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
[data-theme="dark"] .prf-name         { color: #e2e8f0; }
[data-theme="dark"] .prf-fullname     { color: #9ca3af; }
[data-theme="dark"] .prf-tentang      { color: #cbd5e0; }
[data-theme="dark"] .prf-info-card    { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .prf-item-label   { color: #9ca3af; }
[data-theme="dark"] .prf-item-value   { color: #e2e8f0; }
[data-theme="dark"] .prf-btn-back     { background: #252b3b; color: #9ca3af; }
</style>
@endverbatim
