<style>
/* === VARIABLES === */
:root {
    --primary: #00bfa6;
    --primary-dark: #009b89;
    --primary-light: #e0f7f5;
    --secondary: #6c757d;
    --success: #28a745;
    --warning: #ffc107;
    --danger: #dc3545;
    --dark: #2c3e50;
    --light: #f8f9fa;
    --white: #ffffff;
    --bd-accent: #00bfa6;

    --radius-sm: 8px;
    --radius: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;

    --shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
    --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
    --shadow-elegant: 0 4px 24px rgba(0, 0, 0, 0.08);

    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* === BACK BUTTON === */
.bd-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--secondary);
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    padding: 0.375rem 0;
    transition: var(--transition);
    margin-bottom: 1.25rem;
}
.bd-back-btn:hover {
    color: var(--bd-accent);
    gap: 0.75rem;
}

/* === BOOK COVER === */
.book-cover-elegant { margin-bottom: 1.5rem; }

.cover-container {
    position: relative;
    text-align: center;
    background: #fff;
    border-radius: var(--radius-xl);
    padding: 2rem 1.5rem 1.5rem;
    box-shadow: var(--shadow-elegant);
    z-index: 1;
}

.cover-image {
    width: 100%;
    max-width: 260px;
    height: auto;
    border-radius: var(--radius-lg);
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.18);
    transition: var(--transition);
}
.cover-image:hover {
    transform: scale(1.02);
    box-shadow: 0 24px 64px rgba(0, 0, 0, 0.25);
}

.cover-overlay {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.premium-badge-gold,
.premium-badge {
    padding: 0.45rem 0.875rem;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    backdrop-filter: blur(10px);
}
.crown-premium {
    background: linear-gradient(135deg, #03a89e 0%, #02877e 100%);
    color: var(--white);
    box-shadow: 0 4px 12px rgba(3, 168, 158, 0.35);
}
.crown-gold {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    color: var(--white);
    box-shadow: 0 4px 12px rgba(255, 165, 0, 0.35);
}

/* === QUICK ACTIONS === */
.quick-actions {
    background: #fff;
    border-radius: var(--radius-xl);
    padding: 1.75rem;
    box-shadow: var(--shadow-elegant);
    position: relative;
    z-index: 1;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.875rem;
}

.btn-read {
    background: linear-gradient(135deg, var(--bd-accent) 0%, color-mix(in srgb, var(--bd-accent) 80%, black) 100%);
    border: none;
    color: var(--white);
    padding: 0.875rem 1.5rem;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 0.95rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}
.btn-read:hover {
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px color-mix(in srgb, var(--bd-accent) 45%, transparent);
    filter: brightness(0.92);
}

.btn-purchase {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    border: none;
    color: var(--white);
    padding: 0.875rem 1.5rem;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 0.95rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}
.btn-purchase:hover {
    background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(34, 197, 94, 0.35);
}

.btn-borrow {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border: none;
    color: var(--white);
    padding: 0.875rem 1.5rem;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 0.95rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}
.btn-borrow:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.35);
}

.action-group {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
    position: relative;
    align-items: stretch;
}

.btn-outline {
    background: var(--light);
    border: none;
    color: var(--dark);
    padding: 0.75rem;
    border-radius: var(--radius);
    font-weight: 500;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.4rem;
    text-decoration: none;
    cursor: pointer;
    min-height: 76px;
    justify-content: center;
    font-size: 0.85rem;
}
.btn-outline:hover {
    background: color-mix(in srgb, var(--bd-accent) 10%, white);
    color: var(--bd-accent);
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.07);
}

/* === LIKE BUTTON === */
.btn-like {
    position: relative;
    overflow: hidden;
    background: var(--light);
    border: none;
    color: var(--dark);
    padding: 0.75rem;
    border-radius: var(--radius);
    font-weight: 500;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.4rem;
    cursor: pointer;
    min-height: 76px;
    justify-content: center;
    font-size: 0.85rem;
}
.btn-like:hover:not(.liked):not(:disabled) {
    background: #fef2f2;
    color: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(220, 38, 38, 0.12);
}
.btn-like.liked {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: var(--white);
    cursor: not-allowed;
    transform: scale(1.03);
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
}
.btn-like.liked:hover { cursor: not-allowed; transform: scale(1.03); }
.btn-like:disabled { opacity: 0.7; cursor: not-allowed; }

.like-icon { font-size: 1.2rem; transition: var(--transition); }
.btn-like.liked .like-icon { color: var(--white); animation: heartBeat 0.6s ease; }

.like-count { font-size: 0.75rem; font-weight: 600; transition: var(--transition); }
.btn-like.liked .like-count { color: var(--white); }

@keyframes heartBeat {
    0%   { transform: scale(1); }
    25%  { transform: scale(1.3); }
    50%  { transform: scale(1); }
    75%  { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.btn-like.loading { pointer-events: none; opacity: 0.7; }
.btn-like.loading .like-icon { animation: bdPulse 1.5s infinite; }

@keyframes bdPulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.4; }
}

/* === LIKE SUCCESS MESSAGE === */
.like-success-message {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%) translateY(100%);
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: var(--white);
    padding: 0.875rem 1.75rem;
    border-radius: var(--radius-lg);
    box-shadow: 0 12px 28px rgba(239, 68, 68, 0.35);
    z-index: 9999;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    animation: bdSlideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

/* === SHARE === */
.share-button-container {
    position: relative;
    display: flex;
    flex-direction: column;
}

.share-options-floating {
    position: absolute;
    top: calc(100% + 10px);
    left: 50%;
    transform: translateX(-50%) translateY(-8px);
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    padding: 1.25rem;
    z-index: 1050;
    opacity: 0;
    visibility: hidden;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    min-width: 180px;
}
.share-options-floating.show {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
}
.share-options-floating::before {
    content: '';
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    width: 0; height: 0;
    border-left: 7px solid transparent;
    border-right: 7px solid transparent;
    border-bottom: 7px solid var(--white);
    filter: drop-shadow(0 -1px 1px rgba(0,0,0,0.07));
}

.share-options-content {
    display: flex;
    gap: 0.875rem;
    justify-content: center;
    align-items: center;
}

.share-option-btn {
    background: var(--light);
    border: none;
    color: var(--dark);
    padding: 0.75rem;
    border-radius: 50%;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    width: 48px;
    height: 48px;
    font-size: 1.1rem;
}
.share-option-btn:hover {
    background: var(--primary);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 191, 166, 0.3);
}
.share-option-btn .fa-whatsapp { color: #25D366; transition: var(--transition); }
.share-option-btn:hover .fa-whatsapp { color: var(--white); }
.share-option-btn .fa-copy { color: var(--primary); transition: var(--transition); }
.share-option-btn:hover .fa-copy { color: var(--white); }

.btn-share.active {
    background: color-mix(in srgb, var(--bd-accent) 12%, white);
    color: var(--bd-accent);
}

.share-overlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1040;
    opacity: 0;
    visibility: hidden;
    transition: var(--transition);
}
.share-overlay.show { opacity: 1; visibility: visible; }

/* === TAGS === */
.tags-section {
    margin-top: 1.25rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
}
.tags-title {
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--secondary);
    margin-bottom: 0.625rem;
    display: flex;
    align-items: center;
}
.tags-container { display: flex; flex-wrap: wrap; gap: 0.375rem; }
.tag-elegant {
    background: color-mix(in srgb, var(--bd-accent) 10%, white);
    color: var(--bd-accent);
    padding: 0.3rem 0.75rem;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 500;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.2rem;
}
.tag-elegant:hover {
    background: var(--bd-accent);
    color: var(--white);
    transform: translateY(-1px);
}

/* === BOOK HEADER === */
.book-header-elegant {
    background: #fff;
    border-radius: var(--radius-xl);
    padding: 2rem 2rem 1.75rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-elegant);
    position: relative;
    z-index: 1;
}

.bd-cat-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    background: color-mix(in srgb, var(--bd-accent) 12%, white);
    color: var(--bd-accent);
    padding: 0.3rem 0.875rem;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    margin-bottom: 0.875rem;
}

.book-title-elegant {
    font-size: 2rem;
    font-weight: 800;
    color: var(--dark);
    line-height: 1.2;
    margin-bottom: 0.5rem;
}

.book-subtitle {
    font-size: 0.95rem;
    color: var(--secondary);
    margin-bottom: 1.25rem;
    font-weight: 500;
}

.bd-stats-bar {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
}
.bd-stat {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.85rem;
    color: var(--secondary);
}
.bd-stat i { color: var(--bd-accent); font-size: 0.875rem; }
.bd-stat strong { color: var(--dark); font-weight: 600; }

/* === TABS — underline style === */
.book-tabs-elegant {
    background: #fff;
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-elegant);
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 1;
}

.tabs-navigation {
    padding: 0 1.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.07);
    background: var(--white);
}

.nav-tabs-elegant {
    display: flex;
    gap: 0;
    flex-wrap: wrap;
}

.nav-tab {
    background: transparent;
    border: none;
    border-bottom: 2px solid transparent;
    padding: 1rem 1.125rem;
    color: var(--secondary);
    font-weight: 500;
    font-size: 0.875rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
    cursor: pointer;
    margin-bottom: -1px;
}
.nav-tab:hover { color: var(--bd-accent); }
.nav-tab.active {
    color: var(--bd-accent);
    border-bottom-color: var(--bd-accent);
    font-weight: 600;
    background: transparent;
}

.tabs-content { padding: 0; }

.tab-pane { display: none; }
.tab-pane.active { display: block; animation: bdFadeIn 0.35s ease both; }

@keyframes bdFadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

.content-card { padding: 2rem; }

.content-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.content-title i { color: var(--bd-accent); }

.content-text {
    line-height: 1.85;
    color: #444;
    font-size: 0.975rem;
}
.content-text p { margin-bottom: 1rem; }
.content-text p:last-child { margin-bottom: 0; }

.comments-description {
    color: var(--secondary);
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
    line-height: 1.6;
}

.disqus-container {
    background: var(--white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    margin-top: 0.5rem;
}
#disqus_thread { background: var(--white); border-radius: var(--radius-lg); padding: 0; }
#disqus_thread iframe { border-radius: var(--radius-lg) !important; }

/* === DETAILS GRID — clean row design, no sharp borders === */
.details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.875rem 0.625rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.055);
    transition: background 0.2s ease;
}
.detail-item:hover { background: rgba(0, 0, 0, 0.018); }

.detail-label {
    display: flex;
    align-items: center;
    gap: 0.55rem;
    font-weight: 500;
    color: var(--secondary);
    font-size: 0.82rem;
}
.detail-label i {
    color: var(--bd-accent);
    font-size: 0.9rem;
    width: 14px;
    text-align: center;
}

.detail-value {
    font-weight: 600;
    color: var(--dark);
    text-align: right;
    font-size: 0.875rem;
    max-width: 55%;
}

.availability.available {
    background: color-mix(in srgb, #22c55e 14%, white);
    color: #16a34a;
    padding: 0.2rem 0.7rem;
    border-radius: 20px;
    font-size: 0.73rem;
    font-weight: 600;
}

/* === RELATED BOOKS === */
.related-books-elegant {
    background: #fff;
    border-radius: var(--radius-xl);
    padding: 2rem;
    box-shadow: var(--shadow-elegant);
    position: relative;
    z-index: 1;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}
.section-title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--dark);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
}
.section-title i { color: var(--bd-accent); }

.view-all-link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
}
.view-all-link:hover { color: var(--primary-dark); transform: translateX(2px); }

.related-books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1rem;
}

.related-book-card {
    display: flex;
    gap: 1rem;
    padding: 1.25rem;
    background: var(--light);
    border-radius: var(--radius-lg);
    transition: var(--transition);
    position: relative;
}
.related-book-card:hover {
    background: var(--white);
    transform: translateY(-3px);
    box-shadow: var(--shadow-hover);
}

.related-book-crown {
    position: absolute;
    top: -8px; right: -8px;
    width: 26px; height: 26px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    z-index: 2;
}

.book-cover-small {
    flex-shrink: 0;
    width: 72px;
    height: 96px;
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.book-cover-small img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: var(--transition);
}
.related-book-card:hover .book-cover-small img { transform: scale(1.05); }

.book-info-small {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
}
.book-title-small {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.25rem;
    line-height: 1.3;
}
.book-author-small {
    color: var(--primary);
    font-weight: 500;
    margin-bottom: 0.5rem;
    font-size: 0.8rem;
}
.book-meta-small { display: flex; gap: 0.75rem; margin-bottom: 0.625rem; }
.meta-item {
    display: flex;
    align-items: center;
    gap: 0.2rem;
    color: var(--secondary);
    font-size: 0.77rem;
}
.view-detail-btn {
    align-self: flex-start;
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.8rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-top: auto;
}
.view-detail-btn:hover { color: var(--primary-dark); transform: translateX(2px); }

/* === TOAST MESSAGES === */
.success-message {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%) translateY(100%);
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    color: var(--white);
    padding: 0.875rem 1.75rem;
    border-radius: var(--radius-lg);
    box-shadow: 0 12px 28px rgba(34, 197, 94, 0.35);
    z-index: 9999;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    animation: bdSlideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

@keyframes bdSlideUp {
    from { transform: translateX(-50%) translateY(100%); opacity: 0; }
    to   { transform: translateX(-50%) translateY(0);    opacity: 1; }
}
@keyframes bdSlideDown {
    from { transform: translateX(-50%) translateY(0);    opacity: 1; }
    to   { transform: translateX(-50%) translateY(100%); opacity: 0; }
}
.success-message.fade-out,
.like-success-message.fade-out {
    animation: bdSlideDown 0.3s ease forwards;
}

/* === BACK TO LIBRARY BUTTON === */
.bd-back-wrap {
    margin-top: 1.25rem;
    padding-top: 1.25rem;
    border-top: 1px solid rgba(0, 0, 0, 0.06);
}
.bd-back-bottom-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    background: var(--bd-accent);
    color: #fff;
    border: none;
    padding: 0.7rem 1.75rem;
    border-radius: 30px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
    box-shadow: 0 4px 18px color-mix(in srgb, var(--bd-accent) 35%, transparent);
}
.bd-back-bottom-btn:hover {
    color: #fff;
    filter: brightness(0.9);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px color-mix(in srgb, var(--bd-accent) 45%, transparent);
}

@media (max-width: 767.98px) {
    .bd-back-wrap { text-align: center; }
}

/* === SWEETALERT TOAST — below navbar === */
.swal-bd-toast.swal2-toast {
    margin-top: 72px !important;
}

/* === SCROLLBAR === */
.tabs-content::-webkit-scrollbar { width: 4px; }
.tabs-content::-webkit-scrollbar-track { background: transparent; }
.tabs-content::-webkit-scrollbar-thumb { background: var(--bd-accent); border-radius: 4px; }

/* === RESPONSIVE === */
@media (max-width: 1200px) {
    .details-grid { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
    .book-title-elegant { font-size: 1.7rem; }
    .book-header-elegant { padding: 1.375rem; }
    .content-card { padding: 1.375rem; }
    .related-books-elegant { padding: 1.375rem; }

    /* Mobile tabs — pill style */
    .tabs-navigation {
        padding: 0.75rem 0.75rem 0;
        border-bottom: none;
        background: #f4f4f4;
    }
    .nav-tabs-elegant {
        gap: 0.4rem;
        flex-wrap: nowrap;
        overflow-x: auto;
        scrollbar-width: none;
        padding-bottom: 0.75rem;
    }
    .nav-tabs-elegant::-webkit-scrollbar { display: none; }
    .nav-tab {
        border-bottom: 2px solid transparent;
        border-radius: 20px;
        padding: 0.45rem 1rem;
        background: var(--white);
        font-size: 0.82rem;
        white-space: nowrap;
        margin-bottom: 0;
        color: var(--secondary);
    }
    .nav-tab:hover {
        background: color-mix(in srgb, var(--bd-accent) 10%, white);
        color: var(--bd-accent);
    }
    .nav-tab.active {
        background: var(--bd-accent);
        color: var(--white);
        border-bottom-color: transparent;
        font-weight: 600;
    }

    .related-books-grid { grid-template-columns: 1fr; }
    .section-header { flex-direction: column; gap: 0.625rem; align-items: flex-start; }
    .action-group { grid-template-columns: 1fr; }
    .btn-like, .btn-outline { flex-direction: row; gap: 0.625rem; min-height: 54px; }
    .bd-stats-bar { gap: 1rem; }
    .share-options-floating { padding: 1rem; min-width: 160px; }
    .share-option-btn { width: 44px; height: 44px; font-size: 1rem; }
}

@media (max-width: 576px) {
    .book-title-elegant { font-size: 1.4rem; }
    .cover-image { max-width: 190px; }
    .details-grid { grid-template-columns: 1fr; }
    .detail-item { flex-direction: column; align-items: flex-start; gap: 0.2rem; }
    .detail-value { text-align: left; max-width: 100%; }
    .related-book-card { flex-direction: column; }
    .view-detail-btn { align-self: flex-start; }
    .bd-stats-bar { gap: 0.75rem; }
    .share-options-floating { min-width: 150px; top: calc(100% + 6px); }
    .share-option-btn { width: 44px; height: 44px; font-size: 0.95rem; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
[data-theme="dark"] .cover-container        { background: #1a1f2e; box-shadow: 0 8px 32px rgba(0,0,0,.4); }
[data-theme="dark"] .quick-actions          { background: #1a1f2e; box-shadow: 0 8px 32px rgba(0,0,0,.4); }
[data-theme="dark"] .book-header-elegant    { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .book-title-elegant    { color: #e2e8f0; }
[data-theme="dark"] .book-subtitle-elegant { color: #9ca3af; }
[data-theme="dark"] .book-author-small     { color: #9ca3af; }
[data-theme="dark"] .book-meta-small       { color: #9ca3af; }
[data-theme="dark"] .book-tabs-elegant     { background: #1a1f2e; }
[data-theme="dark"] .content-card          { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .content-text          { color: #cbd5e0; }
[data-theme="dark"] .detail-item           { border-bottom-color: rgba(0,167,157,.1); }
[data-theme="dark"] .detail-item:hover     { background: rgba(0,167,157,.05); }
[data-theme="dark"] .detail-label          { color: #9ca3af; }
[data-theme="dark"] .detail-value          { color: #e2e8f0; }
[data-theme="dark"] .bd-stat strong        { color: #e2e8f0; }
[data-theme="dark"] .bd-stat               { color: #9ca3af; }
[data-theme="dark"] .related-books-elegant { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .section-title         { color: #e2e8f0; }
[data-theme="dark"] .tabs-navigation       { background: #252b3b; border-bottom-color: rgba(0,167,157,.15); }
[data-theme="dark"] .tab-pane             { background: transparent; }
[data-theme="dark"] .nav-tab               { color: #9ca3af; }
[data-theme="dark"] .nav-tab:hover         { background: rgba(0,167,157,.1); color: #4dd9cf; }
[data-theme="dark"] .nav-tab.active        { color: #00c4b8; border-bottom-color: #00c4b8; }
[data-theme="dark"] .disqus-container,
[data-theme="dark"] #disqus_thread         { background: #1a1f2e; }
[data-theme="dark"] .related-book-card     { background: #252b3b; border-color: rgba(0,167,157,.15); }
[data-theme="dark"] .book-title-small      { color: #e2e8f0; }
[data-theme="dark"] .share-options-floating { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .btn-like:not(.liked),
[data-theme="dark"] .btn-outline           { background: #252b3b; border-color: rgba(0,167,157,.2); color: #e2e8f0; }
[data-theme="dark"] .btn-like.liked        { background: linear-gradient(135deg,#ef4444 0%,#dc2626 100%); color: #fff; box-shadow: 0 6px 20px rgba(239,68,68,.4); }
[data-theme="dark"] .tags-section          { border-top-color: rgba(0,167,157,.15); }
[data-theme="dark"] .tags-title            { color: #9ca3af; }
[data-theme="dark"] .tag-elegant           { background: rgba(0,167,157,.15); color: #4dd9cf; }
[data-theme="dark"] .tag-elegant:hover     { background: rgba(0,167,157,.35); color: #e2e8f0; }
[data-theme="dark"] .availability.available { background: rgba(34,197,94,.15); color: #4ade80; }

@media (max-width: 768px) {
    [data-theme="dark"] .tabs-navigation { background: #1a1f2e; }
    [data-theme="dark"] .nav-tab         { background: #2d3548; color: #9ca3af; }
    [data-theme="dark"] .nav-tab:hover   { background: rgba(0,167,157,.15); color: #4dd9cf; }
    [data-theme="dark"] .nav-tab.active  { background: #00a79d; color: #fff; border-bottom-color: transparent; }
}
</style>
