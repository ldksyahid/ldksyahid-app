<style>
/* === VARIABLES & RESET === */
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

    --radius-sm: 8px;
    --radius: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;

    --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
    --shadow-elegant: 0 10px 40px rgba(0, 0, 0, 0.1);

    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* === BREADCRUMB === */
.elegant-breadcrumb {
    background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
    border-radius: var(--radius-lg);
    padding: 1.25rem 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(0, 191, 166, 0.1);
    box-shadow: var(--shadow);
}

.breadcrumb-item {
    display: flex;
    align-items: center;
}

.breadcrumb-link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
    padding: 0.5rem 1rem;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
}

.breadcrumb-link:hover {
    color: var(--primary-dark);
    background: var(--primary-light);
    transform: translateY(-1px);
}

.breadcrumb-item.active {
    color: var(--dark);
    font-weight: 600;
    display: flex;
    align-items: center;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: var(--secondary);
    font-weight: 300;
}

/* === BOOK COVER ELEGANT === */
.book-cover-elegant {
    margin-bottom: 2rem;
}

.cover-container {
    position: relative;
    text-align: center;
    background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
    border-radius: var(--radius-xl);
    padding: 2rem;
    box-shadow: var(--shadow-elegant);
    border: 1px solid rgba(0, 191, 166, 0.1);
}

.cover-image {
    width: 100%;
    max-width: 280px;
    height: auto;
    border-radius: var(--radius-lg);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    transition: var(--transition);
    border: 4px solid var(--white);
}

.cover-image:hover {
    transform: scale(1.02) rotate(1deg);
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
}

.cover-overlay {
    position: absolute;
    top: 1rem;
    right: 1rem;
}

.premium-badge-gold {
    padding: 0.75rem 1.25rem;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 700;
    box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.8);
}

.premium-badge {
    padding: 0.75rem 1.25rem;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 700;
    box-shadow: 0 6px 20px rgba(3, 168, 158, 0.4);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.8);
}

.crown-premium {
    background: linear-gradient(135deg, #03a89e 0%, #02877e 100%);
    color: var(--white);
}

.crown-gold {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    color: #000;
}

/* === QUICK ACTIONS === */
.quick-actions {
    background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
    border-radius: var(--radius-xl);
    padding: 2rem;
    box-shadow: var(--shadow);
    border: 1px solid rgba(0, 191, 166, 0.1);
    position: relative;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.btn-read {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border: none;
    color: var(--white);
    padding: 1rem 1.5rem;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 1rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-read:hover {
    background: linear-gradient(135deg, var(--primary-dark) 0%, #007f73 100%);
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 191, 166, 0.4);
}

.btn-purchase {
    background: linear-gradient(135deg, var(--success) 0%, #20c997 100%);
    border: none;
    color: var(--white);
    padding: 1rem 1.5rem;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 1rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.btn-purchase:hover {
    background: linear-gradient(135deg, #20c997 0%, #199c7a 100%);
    color: var(--white);
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(40, 167, 69, 0.4);
}

.btn-borrow {
    background: linear-gradient(135deg, var(--warning) 0%, #ffb300 100%);
    border: none;
    color: var(--dark);
    padding: 1rem 1.5rem;
    border-radius: var(--radius);
    font-weight: 600;
    font-size: 1rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.btn-borrow:hover {
    background: linear-gradient(135deg, #ffb300 0%, #e6a200 100%);
    color: var(--dark);
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(255, 193, 7, 0.4);
}

.action-group {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
    position: relative;
}

.btn-outline {
    background: transparent;
    border: 2px solid var(--primary-light);
    color: var(--primary);
    padding: 0.75rem;
    border-radius: var(--radius);
    font-weight: 500;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    cursor: pointer;
}

.btn-outline:hover {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 191, 166, 0.3);
}

/* === SHARE OPTIONS === */
.share-options {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(10px);
    background: var(--white);
    border-radius: var(--radius);
    box-shadow: var(--shadow-elegant);
    padding: 1rem;
    min-width: 200px;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(0, 191, 166, 0.1);
}

.share-options.show {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
}

.share-options-content {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
}

.share-option-btn {
    background: transparent;
    border: 2px solid var(--primary-light);
    color: var(--primary);
    padding: 0.75rem 1rem;
    border-radius: var(--radius);
    font-weight: 500;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    min-width: 80px;
}

.share-option-btn:hover {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 191, 166, 0.3);
}

/* === TAGS SECTION === */
.tags-section {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(0, 191, 166, 0.1);
}

.tags-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.tags-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tag-elegant {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: var(--white);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.tag-elegant:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 191, 166, 0.4);
}

/* === BOOK HEADER ELEGANT === */
.book-header-elegant {
    background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
    border-radius: var(--radius-xl);
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-elegant);
    border: 1px solid rgba(0, 191, 166, 0.1);
}

.book-title-elegant {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--dark);
    line-height: 1.2;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.book-subtitle {
    font-size: 1.2rem;
    color: var(--primary);
    margin-bottom: 0;
    font-weight: 600;
}

/* === BOOK TABS ELEGANT === */
.book-tabs-elegant {
    background: var(--white);
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-elegant);
    margin-bottom: 2rem;
}

.tabs-navigation {
    background: linear-gradient(135deg, var(--primary-light) 0%, #f8f9fa 100%);
    padding: 0.5rem;
}

.nav-tabs-elegant {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.nav-tab {
    background: transparent;
    border: none;
    padding: 1rem 1.5rem;
    border-radius: var(--radius);
    color: var(--secondary);
    font-weight: 600;
    transition: var(--transition);
    display: flex;
    align-items: center;
    cursor: pointer;
}

.nav-tab:hover {
    background: rgba(0, 191, 166, 0.1);
    color: var(--primary);
}

.nav-tab.active {
    background: var(--primary);
    color: var(--white);
    box-shadow: 0 4px 15px rgba(0, 191, 166, 0.3);
}

.tabs-content {
    padding: 0;
}

.tab-pane {
    display: none;
    animation: fadeIn 0.5s ease-in-out;
}

.tab-pane.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.content-card {
    padding: 2.5rem;
}

.content-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
}

.content-text {
    line-height: 1.8;
    color: var(--dark);
    font-size: 1.05rem;
}

.content-text p {
    margin-bottom: 1rem;
}

.content-text p:last-child {
    margin-bottom: 0;
}

/* === DETAILS GRID === */
.details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
    background: var(--light);
    border-radius: var(--radius);
    border-left: 4px solid var(--primary);
    transition: var(--transition);
}

.detail-item:hover {
    background: var(--primary-light);
    transform: translateX(5px);
}

.detail-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    color: var(--dark);
}

.detail-label i {
    color: var(--primary);
    font-size: 1.1rem;
}

.detail-value {
    font-weight: 600;
    color: var(--primary);
    text-align: right;
}

.availability.available {
    background: var(--success);
    color: var(--white);
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.65rem;
    font-weight: 600;
}

/* === RELATED BOOKS ELEGANT === */
.related-books-elegant {
    background: var(--white);
    border-radius: var(--radius-xl);
    padding: 2.5rem;
    box-shadow: var(--shadow-elegant);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    display: flex;
    align-items: center;
    margin: 0;
}

.view-all-link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
    display: flex;
    align-items: center;
}

.view-all-link:hover {
    color: var(--primary-dark);
    transform: translateX(3px);
}

.related-books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.related-book-card {
    display: flex;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--light);
    border-radius: var(--radius-lg);
    transition: var(--transition);
    border: 1px solid rgba(0, 191, 166, 0.1);
    position: relative;
}

.related-book-card:hover {
    background: var(--white);
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

.related-book-crown {
    position: absolute;
    top: -8px;
    right: -8px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    z-index: 2;
    border: 2px solid var(--white);
}

.book-cover-small {
    flex-shrink: 0;
    width: 80px;
    height: 100px;
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.book-cover-small img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.related-book-card:hover .book-cover-small img {
    transform: scale(1.1);
}

.book-info-small {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.book-title-small {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.book-author-small {
    color: var(--primary);
    font-weight: 500;
    margin-bottom: 0.75rem;
    font-size: 0.9rem;
}

.book-meta-small {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: var(--secondary);
    font-size: 0.85rem;
}

.view-detail-btn {
    align-self: flex-start;
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: var(--transition);
    display: flex;
    align-items: center;
}

.view-detail-btn:hover {
    color: var(--primary-dark);
    transform: translateX(3px);
}

/* === SUCCESS MESSAGE === */
.success-message {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, var(--success) 0%, #20c997 100%);
    color: var(--white);
    padding: 1rem 2rem;
    border-radius: var(--radius-lg);
    box-shadow: 0 10px 30px rgba(40, 167, 69, 0.4);
    z-index: 9999;
    animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

@keyframes slideUp {
    from {
        transform: translateX(-50%) translateY(100%);
        opacity: 0;
    }
    to {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }
}

.success-message.fade-out {
    animation: slideDown 0.3s ease forwards;
}

@keyframes slideDown {
    from {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
    }
    to {
        transform: translateX(-50%) translateY(100%);
        opacity: 0;
    }
}

/* === RESPONSIVE DESIGN === */
@media (max-width: 1200px) {
    .details-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .book-title-elegant {
        font-size: 2rem;
    }

    .book-subtitle {
        font-size: 1.1rem;
    }

    .nav-tabs-elegant {
        flex-direction: column;
    }

    .related-books-grid {
        grid-template-columns: 1fr;
    }

    .section-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .content-card {
        padding: 1.5rem;
    }

    .book-header-elegant {
        padding: 1.5rem;
    }

    .share-options {
        left: 0;
        transform: translateX(0) translateY(10px);
    }

    .share-options.show {
        transform: translateX(0) translateY(0);
    }

    .share-options-content {
        flex-direction: column;
    }

    .share-option-btn {
        flex-direction: row;
        justify-content: flex-start;
    }
}

@media (max-width: 576px) {
    .book-title-elegant {
        font-size: 1.6rem;
    }

    .book-subtitle {
        font-size: 1rem;
    }

    .cover-image {
        max-width: 200px;
    }

    .action-group {
        grid-template-columns: 1fr;
    }

    .related-book-card {
        flex-direction: column;
        text-align: center;
    }

    .view-detail-btn {
        align-self: center;
    }

    .details-grid {
        grid-template-columns: 1fr;
    }

    .detail-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .detail-value {
        text-align: left;
    }

    .related-book-crown {
        top: -6px;
        right: -6px;
        width: 24px;
        height: 24px;
        font-size: 0.8rem;
    }
}

/* Animation Enhancements */
.wow.fadeInUp {
    animation-duration: 0.6s;
}

/* Custom Scrollbar */
.tabs-content::-webkit-scrollbar {
    width: 6px;
}

.tabs-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.tabs-content::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 3px;
}

.tabs-content::-webkit-scrollbar-thumb:hover {
    background: var(--primary-dark);
}
</style>
