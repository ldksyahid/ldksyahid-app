{{-- GLightbox CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

<style>
/* ═══════════════════════════════════════════════
   GALLERY SECTION - Modern & Elegant
   ═══════════════════════════════════════════════ */
.gallery-elegant {
    background: transparent;
    position: relative;
}

/* ── Header (Left Aligned - Matching About) ── */
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
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-light);
    border-radius: var(--radius-pill);
    padding: 0.5rem 1.25rem;
    margin-bottom: 0.75rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--primary);
    position: relative;
    box-shadow: 0 2px 8px rgba(0, 167, 157, 0.1);
}

.badge-emoji-gal {
    font-size: 1.1rem;
}

.badge-pulse-gal {
    width: 8px;
    height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: galPulse 2s ease-in-out infinite;
}

@keyframes galPulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.5;
        transform: scale(1.5);
    }
}

.section-title-gal {
    font-family: var(--font-primary);
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.title-highlight-gal {
    color: var(--primary);
    position: relative;
}

.title-highlight-gal::after {
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

.section-description-gal {
    color: var(--secondary);
    font-size: 1rem;
    margin-bottom: 0;
}

/* View All Button */
.btn-view-all-gal {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: var(--primary-gradient);
    color: white;
    padding: 0.875rem 1.5rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
    transition: all 0.3s ease;
}

.btn-view-all-gal:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 167, 157, 0.4);
    color: white;
}

/* ── Gallery Item ── */
.gallery-item-elegant {
    background: white;
    border-radius: 24px;
    padding: 1.5rem;
    margin-bottom: 2.5rem;
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    transform: translateY(40px) scale(0.97);
    transition: opacity 0.6s ease var(--anim-delay, 0s),
                transform 0.6s cubic-bezier(0.4, 0, 0.2, 1) var(--anim-delay, 0s),
                box-shadow 0.4s ease;
}

.gallery-item-elegant.is-visible {
    opacity: 1;
    transform: translateY(0) scale(1);
}

/* Event Header */
.event-header-gal {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.event-info-gal {
    flex: 1;
}

.event-badge-gal {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.1) 0%, rgba(0, 167, 157, 0.05) 100%);
    color: var(--primary);
    padding: 0.375rem 0.875rem;
    border-radius: var(--radius-pill);
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    box-shadow: 0 2px 8px rgba(0, 167, 157, 0.08);
}

.badge-icon {
    font-size: 0.9rem;
}

.event-title-gal {
    font-family: var(--font-primary);
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
    font-size: 1.25rem;
}

.event-desc-gal {
    color: var(--secondary);
    font-size: 0.9rem;
    line-height: 1.6;
    margin: 0;
    text-align: justify;
}

.doc-link-gal {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-light);
    color: var(--primary);
    padding: 0.625rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.doc-link-gal:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 167, 157, 0.2);
    color: var(--primary);
}

/* ═══════════════════════════════════════════════
   DESKTOP GALLERY GRID
   ═══════════════════════════════════════════════ */
.gallery-grid-desktop {
    display: block;
}

/* Image Wrapper (No Lightbox - Just Zoom) */
.img-wrapper-main,
.img-wrapper-thumb {
    display: block;
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    height: 100%;
    cursor: pointer;
}

/* Main Image (Full Width at Top) */
.gallery-main-img-full {
    width: 100%;
    margin-bottom: 1rem;
}

.img-main-gal {
    width: 100%;
    height: 100%;
    min-height: 450px;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    display: block;
}

.img-wrapper-main:hover .img-main-gal {
    transform: scale(1.08);
}

/* Thumbnails Grid (Full Width Below Main Image) */
.gallery-thumbs-grid {
    width: 100%;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 1rem;
}

.gallery-thumb-item {
    aspect-ratio: 1;
}

.img-thumb-gal {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: block;
}

.img-wrapper-thumb:hover .img-thumb-gal {
    transform: scale(1.12);
}

/* More Count Overlay */
.more-overlay-count {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.92) 0%, rgba(0, 143, 134, 0.95) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
}

.more-number {
    color: white;
    font-size: 2.8rem;
    font-weight: 700;
    text-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
}

/* Video Section (Desktop) - FULL WIDTH */
.gallery-video-section {
    width: 100%;
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
}

.video-link-gal {
    display: block;
    position: relative;
    text-decoration: none;
}

.video-thumb-gal {
    width: 100%;
    height: 500px;
    object-fit: contain;
    background: #000;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    display: block;
}

.video-link-gal:hover .video-thumb-gal {
    transform: scale(1.02);
}

.video-play-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease;
}

.video-link-gal:hover .video-play-overlay {
    background: rgba(0, 0, 0, 0.4);
}

.play-button-gal {
    width: 50px;
    height: 50px;
    background: var(--primary-gradient);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 167, 157, 0.4);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    animation: playPulse 2.5s ease-in-out infinite;
}

@keyframes playPulse {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.4);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 167, 157, 0.6);
    }
}

.video-link-gal:hover .play-button-gal {
    transform: scale(1.15);
    box-shadow: 0 8px 30px rgba(0, 167, 157, 0.7);
    animation: none;
}

.play-button-gal i {
    color: white;
    font-size: 1.2rem;
    margin-left: 3px;
}

/* ═══════════════════════════════════════════════
   MOBILE GRID (Show All Images)
   ═══════════════════════════════════════════════ */
.gallery-mobile-grid {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* Main Image (Full Width) */
.mobile-grid-main {
    width: 100%;
}

.mobile-img-wrapper {
    border-radius: 16px;
    overflow: hidden;
    background: #f8f9fa;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.mobile-img-main {
    width: 100%;
    height: auto;
    aspect-ratio: 16/10;
    object-fit: cover;
    display: block;
}

/* Thumbnail Grid */
.mobile-grid-thumbs {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

.mobile-thumb-item {
    position: relative;
}

.mobile-thumb-wrapper {
    border-radius: 12px;
    overflow: hidden;
    background: #f8f9fa;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.mobile-thumb-wrapper:active {
    transform: scale(0.98);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
}

.mobile-thumb-img {
    width: 100%;
    height: auto;
    aspect-ratio: 1;
    object-fit: cover;
    display: block;
}

/* Video Section (Mobile) */
.mobile-video-wrapper {
    width: 100%;
    margin-top: 0.5rem;
}

.mobile-video-card {
    border-radius: 16px;
    overflow: hidden;
    background: #000;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.iframe-wrapper-mobile {
    aspect-ratio: 16/9;
    position: relative;
}

.iframe-wrapper-mobile iframe {
    display: block;
}

/* ── Empty State ── */
.empty-state-gal {
    background: white;
    border-radius: 24px;
    padding: 4rem 2rem;
    text-align: center;
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
}

.empty-icon-gal {
    font-size: 5rem;
    margin-bottom: 1.5rem;
    animation: emptyFloat 3s ease-in-out infinite;
}

@keyframes emptyFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.empty-title-gal {
    font-family: var(--font-primary);
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.75rem;
    font-size: 1.5rem;
}

.empty-text-gal {
    color: var(--secondary);
    font-size: 1rem;
    margin: 0;
}


/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
@media (max-width: 991.98px) {
    .section-title-gal {
        font-size: 1.5rem;
    }

    .btn-view-all-gal {
        width: 100%;
        justify-content: center;
    }

    .gallery-item-elegant {
        padding: 1rem;
        margin-bottom: 2rem;
    }

    .event-header-gal {
        flex-direction: column;
    }

    .doc-link-gal {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 767.98px) {
    .section-title-gal {
        font-size: 1.4rem;
    }

    .event-title-gal {
        font-size: 1.1rem;
    }

    .mobile-img {
        height: 250px;
    }
}
</style>
