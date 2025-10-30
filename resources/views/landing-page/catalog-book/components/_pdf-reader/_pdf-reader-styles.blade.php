<style>
/* === PREMIUM VARIABLES === */
:root {
    --primary: #00a896;
    --primary-dark: #008575;
    --primary-light: #e8f6f3;
    --secondary: #6c757d;
    --dark: #2c3e50;
    --light: #f8f9fa;
    --white: #ffffff;
    --gold: #d4af37;
    --error: #e74c3c;
    --success: #27ae60;
    --gray-100: #f8f9fa;
    --gray-200: #e9ecef;
    --gray-300: #dee2e6;
    --gray-400: #ced4da;
    --gray-500: #adb5bd;
    --gray-600: #6c757d;
    --gray-700: #495057;
    --gray-800: #343a40;
    --gray-900: #212529;

    --radius: 8px;
    --radius-lg: 12px;
    --radius-xl: 16px;
    --shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    --shadow-hover: 0 5px 25px rgba(0, 0, 0, 0.08);
    --shadow-floating: 0 8px 30px rgba(0, 0, 0, 0.12);
    --shadow-elegant: 0 10px 40px rgba(0, 0, 0, 0.1);

    /* Mobile spacing variables */
    --mobile-padding: 1rem;
    --mobile-margin: 0.5rem;
}

/* === ELEGANT BREADCRUMB === */
.elegant-breadcrumb {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    height: 60px;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    height: 100%;
}

.breadcrumb-link {
    color: var(--gray-600);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    padding: 0.5rem 0.75rem;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    height: 100%;
    font-size: 0.9rem;
}

.breadcrumb-link:hover {
    color: var(--primary);
    background: var(--primary-light);
}

.breadcrumb-item.active {
    color: var(--primary);
    font-weight: 600;
    display: flex;
    align-items: center;
    height: 100%;
    padding: 0.5rem 0.75rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "/";
    color: var(--gray-400);
    padding: 0 0.5rem;
    display: flex;
    align-items: center;
    height: 100%;
}

/* === MINIMALIST BOOK HEADER === */
.book-header-minimalist {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    background: var(--white);
    border-radius: var(--radius-xl);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-elegant);
    border: 1px solid var(--gray-200);
    position: relative;
    overflow: hidden;
}

.book-header-minimalist::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
}

.book-cover-elegant {
    flex-shrink: 0;
}

.cover-img-elegant {
    width: 90px;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.cover-img-elegant:hover {
    transform: scale(1.05);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}

.cover-placeholder-elegant {
    width: 90px;
    height: 120px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.book-info-elegant {
    flex: 1;
}

.book-title-elegant {
    font-size: 1.6rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.book-author-elegant {
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 1.2rem;
    font-size: 1.05rem;
    display: flex;
    align-items: center;
}

.book-meta-elegant {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    align-items: center;
}

.meta-item {
    display: flex;
    align-items: center;
    background: var(--primary-light);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    color: var(--dark);
    font-weight: 500;
}

.meta-divider {
    width: 1px;
    height: 20px;
    background: var(--gray-300);
}

/* === PREMIUM FLIPBOOK CONTAINER === */
.flipbook-container-premium {
    background: var(--white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-elegant);
    border: 1px solid var(--gray-200);
    min-height: 600px;
    position: relative;
    overflow: hidden;
    /* Improved mobile spacing */
    margin: 0 var(--mobile-margin);
}

.flipbook-wrapper-premium {
    width: 100%;
    height: 70vh;
    min-height: 600px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
}

.flipbook-viewer-premium {
    width: 900px;
    height: 600px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
    position: relative;
    overflow: hidden;
}

/* Premium FlipBook Controls */
.flipbook-controls-premium {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-top: 2rem;
    background: rgba(255, 255, 255, 0.95);
    padding: 1rem 2rem;
    border-radius: 50px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.control-btn-premium {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border: none;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(0, 168, 150, 0.4);
    position: relative;
}

.control-btn-premium:hover:not(:disabled) {
    transform: scale(1.15) translateY(-2px);
    box-shadow: 0 10px 30px rgba(0, 168, 150, 0.6);
}

.control-btn-premium:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    transform: none;
}

.page-info-premium {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    min-width: 120px;
}

.page-progress-premium {
    width: 100%;
    height: 4px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 2px;
    overflow: hidden;
}

.progress-bar-premium {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--gold));
    border-radius: 2px;
    width: 0%;
    transition: width 0.3s ease;
}

.page-numbers-premium {
    font-weight: 700;
    color: var(--dark);
    font-size: 1.1rem;
}

/* === PREMIUM LOADING STATE === */
.loading-state-premium {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    z-index: 30;
    color: white;
}

.flipbook-loader-premium {
    display: flex;
    align-items: center;
    gap: 3rem;
    max-width: 600px;
    padding: 2rem;
}

.book-spinner-premium {
    flex-shrink: 0;
}

.book-premium {
    width: 120px;
    height: 90px;
    position: relative;
    perspective: 1000px;
}

.page-premium {
    position: absolute;
    width: 50%;
    height: 100%;
    background: white;
    border-radius: 6px 0 0 6px;
    transform-origin: right;
    animation: pageFlip 2s infinite ease-in-out;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.page-premium:nth-child(1) { animation-delay: 0s; }
.page-premium:nth-child(2) { animation-delay: 0.4s; }
.page-premium:nth-child(3) { animation-delay: 0.8s; }

@keyframes pageFlip {
    0%, 100% { transform: rotateY(0deg); }
    50% { transform: rotateY(-20deg); }
}

.loading-content-premium {
    flex: 1;
}

/* FIXED: White text for loading state */
.loading-title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
    color: var(--white) !important;
}

.loading-text {
    margin-bottom: 1.5rem;
    opacity: 0.9;
    color: var(--white) !important;
    font-size: 1.1rem;
}

.progress-container-premium {
    width: 100%;
    height: 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar-premium {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--gold));
    border-radius: 4px;
    width: 0%;
    animation: progress 2s ease-in-out infinite;
}

@keyframes progress {
    0% { width: 0%; }
    50% { width: 70%; }
    100% { width: 100%; }
}

/* === PREMIUM ERROR STATE === */
.error-state-premium {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    z-index: 30;
    padding: 2rem;
}

.error-content-premium {
    text-align: center;
    color: white;
    max-width: 500px;
}

.error-icon-premium {
    font-size: 5rem;
    color: var(--gold);
    margin-bottom: 1.5rem;
    opacity: 0.9;
}

/* FIXED: White text for error state */
.error-title {
    font-size: 1.8rem;
    margin-bottom: 1rem;
    font-weight: 700;
    color: var(--white) !important;
}

.error-message {
    font-size: 1.1rem;
    margin-bottom: 2.5rem;
    opacity: 0.9;
    line-height: 1.6;
    color: var(--white) !important;
}

.error-actions-premium {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-retry-premium, .btn-back-premium {
    padding: 1rem 2rem;
    border-radius: var(--radius);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: none;
    color: var(--white) !important;
}

.btn-retry-premium {
    background: linear-gradient(135deg, var(--gold) 0%, #e6c260 100%);
    color: var(--white) !important;
}

.btn-retry-premium:hover {
    background: linear-gradient(135deg, #e6c260 0%, var(--gold) 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
    color: var(--white) !important;
}

.btn-back-premium {
    background: rgba(255, 255, 255, 0.2);
    color: var(--white) !important;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.btn-back-premium:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    color: var(--white) !important;
}

/* === ENHANCED FLOATING CONTROLS === */
.floating-controls-elegant {
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    width: auto;
    min-width: 300px;
    max-width: 90vw;
}

.floating-controls-panel-elegant {
    display: flex;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.98);
    padding: 1rem 1.5rem;
    border-radius: 50px;
    box-shadow: var(--shadow-floating);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    animation: slideUp 0.5s ease;
    /* Ensure it stays within viewport */
    max-width: 100%;
    overflow-x: auto;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}

/* Hide scrollbar for Chrome, Safari and Opera */
.floating-controls-panel-elegant::-webkit-scrollbar {
    display: none;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.control-section-elegant {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0 0.5rem;
    flex-shrink: 0; /* Prevent shrinking on mobile */
}

.control-section-elegant:not(:last-child) {
    border-right: 1px solid var(--gray-300);
    padding-right: 1rem;
}

.floating-btn-elegant {
    background: transparent;
    border: 2px solid var(--primary-light);
    color: var(--primary);
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    cursor: pointer;
    font-size: 0.9rem;
    flex-shrink: 0; /* Prevent button shrinking */
}

.floating-btn-elegant:hover {
    background: var(--primary);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 168, 150, 0.4);
}

.floating-btn-elegant.active {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
}

.page-display-elegant, .zoom-display-elegant {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.85rem;
    min-width: 50px;
    text-align: center;
    flex-shrink: 0; /* Prevent text shrinking */
}

/* === TURN.JS ENHANCEMENTS === */
.flipbook-viewer-premium .page {
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-content {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.page-canvas {
    max-width: 95%;
    max-height: 95%;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.page-number {
    position: absolute;
    bottom: 15px;
    right: 15px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.cover-content {
    padding: 3rem;
    text-align: center;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.cover-content h2 {
    font-size: 2.2rem;
    margin-bottom: 1rem;
    font-weight: 700;
    color: var(--white) !important;
}

.cover-content .author {
    font-size: 1.3rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    color: var(--white) !important;
}

.cover-image {
    margin: 2rem 0;
}

.cover-image img {
    max-width: 220px;
    max-height: 320px;
    border-radius: 12px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
}

.book-info {
    margin-top: 2rem;
}

.book-info p {
    margin: 0.5rem 0;
    font-size: 1rem;
    color: var(--white) !important;
}

.library-info {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.3);
}

.library-info p {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    color: var(--white) !important;
}

.library-info small {
    opacity: 0.8;
    color: var(--white) !important;
}

/* Page loader styles */
.page-loader {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #666;
    font-size: 0.9rem;
}

.spinner {
    border: 3px solid #f3f3f3;
    border-top: 3px solid var(--primary);
    border-radius: 50%;
    width: 30px;
    height: 30px;
    animation: spin 1s linear infinite;
    margin-bottom: 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* === FULLSCREEN ENHANCEMENTS === */
.flipbook-container-premium.fullscreen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9999;
    border-radius: 0;
    margin: 0;
}

.flipbook-container-premium.fullscreen .flipbook-wrapper-premium {
    height: 100vh;
    padding: 0;
}

.flipbook-container-premium.fullscreen .flipbook-viewer-premium {
    width: 95vw !important;
    height: 95vh !important;
}

body.fullscreen-mode {
    overflow: hidden;
}

body.fullscreen-mode .floating-controls-elegant {
    bottom: 1rem;
    width: calc(100% - 2rem);
}

/* === TURN.JS CUSTOM STYLES === */
.flipbook-viewer-premium .turn-page {
    background-color: white;
    background-repeat: no-repeat;
    background-size: 100% 100%;
}

.flipbook-viewer-premium .page-wrapper {
    perspective: 2000px;
}

.flipbook-viewer-premium .shadow {
    transition: box-shadow 0.5s;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
}

/* Even page gradient effect */
.flipbook-viewer-premium .page.even {
    background: -webkit-gradient(linear, right top, left top, color-stop(0.95, #fff), color-stop(1, #dadada));
    background-image: -webkit-linear-gradient(right, #fff 95%, #c4c4c4 100%);
    background-image: -moz-linear-gradient(right, #fff 95%, #c4c4c4 100%);
    background-image: -ms-linear-gradient(right, #fff 95%, #c4c4c4 100%);
    background-image: -o-linear-gradient(right, #fff 95%, #c4c4c4 100%);
    background-image: linear-gradient(right, #fff 95%, #c4c4c4 100%);
}

/* Odd page gradient effect */
.flipbook-viewer-premium .page.odd {
    background: -webkit-gradient(linear, left top, right top, color-stop(0.95, #fff), color-stop(1, #dadada));
    background-image: -webkit-linear-gradient(left, #fff 95%, #c4c4c4 100%);
    background-image: -moz-linear-gradient(left, #fff 95%, #c4c4c4 100%);
    background-image: -ms-linear-gradient(left, #fff 95%, #c4c4c4 100%);
    background-image: -o-linear-gradient(left, #fff 95%, #c4c4c4 100%);
    background-image: linear-gradient(left, #fff 95%, #c4c4c4 100%);
}

/* === ENHANCED RESPONSIVE DESIGN === */
@media (max-width: 1200px) {
    .flipbook-viewer-premium {
        width: 800px;
        height: 550px;
    }
}

@media (max-width: 992px) {
    .flipbook-viewer-premium {
        width: 700px;
        height: 500px;
    }

    .floating-controls-panel-elegant {
        flex-wrap: wrap;
        justify-content: center;
        border-radius: var(--radius-lg);
        padding: 1rem;
        gap: 0.75rem;
    }

    .control-section-elegant:not(:last-child) {
        border-right: none;
        padding-right: 0.5rem;
    }
}

@media (max-width: 768px) {
    /* Improved mobile container spacing */
    .container-fluid {
        padding-left: var(--mobile-padding);
        padding-right: var(--mobile-padding);
    }

    .book-header-minimalist {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
        padding: 1.5rem;
        margin-left: 0;
        margin-right: 0;
    }

    .flipbook-container-premium {
        margin: 0;
        border-radius: var(--radius-lg);
    }

    .flipbook-viewer-premium {
        width: 100% !important;
        height: 400px !important;
        border-radius: 12px;
    }

    .flipbook-wrapper-premium {
        height: 50vh;
        min-height: 450px;
        padding: 1rem;
    }

    .flipbook-controls-premium {
        padding: 0.8rem 1.5rem;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .control-btn-premium {
        width: 45px;
        height: 45px;
        font-size: 1.1rem;
    }

    .flipbook-loader-premium {
        flex-direction: column;
        text-align: center;
        gap: 2rem;
        padding: 1rem;
    }

    /* Enhanced floating controls for mobile */
    .floating-controls-elegant {
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 2rem);
        max-width: none;
    }

    .floating-controls-panel-elegant {
        justify-content: space-between;
        border-radius: var(--radius-lg);
        padding: 0.8rem 1rem;
        gap: 0.5rem;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .control-section-elegant {
        padding: 0 0.25rem;
    }

    .book-meta-elegant {
        justify-content: center;
    }

    /* Improved breadcrumb for mobile */
    .elegant-breadcrumb {
        padding: 0.8rem 1rem;
        height: auto;
        flex-wrap: wrap;
        margin-left: 0;
        margin-right: 0;
    }

    .breadcrumb-item {
        height: auto;
    }
}

@media (max-width: 576px) {
    .book-title-elegant {
        font-size: 1.3rem;
    }

    .flipbook-container-premium {
        margin: 0;
    }

    .floating-controls-panel-elegant {
        padding: 0.7rem 0.8rem;
        gap: 0.4rem;
    }

    .floating-btn-elegant {
        width: 38px;
        height: 38px;
        font-size: 0.8rem;
    }

    .page-display-elegant, .zoom-display-elegant {
        font-size: 0.8rem;
        min-width: 45px;
    }

    .elegant-breadcrumb {
        padding: 0.7rem 0.8rem;
    }

    /* Extra small devices */
    .flipbook-viewer-premium {
        height: 350px !important;
    }

    .flipbook-wrapper-premium {
        min-height: 400px;
        padding: 0.8rem;
    }
}

@media (max-width: 400px) {
    /* Ultra-small mobile optimization */
    .floating-controls-panel-elegant {
        padding: 0.6rem;
        gap: 0.3rem;
    }

    .floating-btn-elegant {
        width: 36px;
        height: 36px;
    }

    .page-display-elegant, .zoom-display-elegant {
        font-size: 0.75rem;
        min-width: 40px;
    }

    .control-section-elegant {
        gap: 0.3rem;
    }
}

/* === SMOOTH ANIMATIONS === */
.wow.fadeIn {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* === SAFE AREA INSETS FOR NOTCHED DEVICES === */
@supports(padding: max(0px)) {
    .floating-controls-elegant {
        bottom: max(2rem, env(safe-area-inset-bottom));
    }

    @media (max-width: 768px) {
        .floating-controls-elegant {
            bottom: max(1rem, env(safe-area-inset-bottom));
        }
    }
}
</style>
