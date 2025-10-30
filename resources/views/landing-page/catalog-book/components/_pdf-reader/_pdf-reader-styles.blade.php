<style>
/* === ENHANCED VARIABLES === */
:root {
    --primary: #00bfa6;
    --primary-dark: #009b89;
    --primary-light: #e0f7f5;
    --secondary: #6c757d;
    --dark: #2c3e50;
    --light: #f8f9fa;
    --white: #ffffff;
    --gold: #ffd700;
    --error: #ff6b6b;
    --success: #51cf66;

    --radius: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
    --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
    --shadow-floating: 0 10px 40px rgba(0, 0, 0, 0.15);
}

/* === COMPACT BOOK HEADER === */
.book-header-compact {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
    border: 1px solid rgba(0, 191, 166, 0.1);
    position: relative;
}

.book-cover-mini {
    flex-shrink: 0;
}

.cover-img {
    width: 80px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.cover-img:hover {
    transform: scale(1.05);
}

.cover-placeholder {
    width: 80px;
    height: 100px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.book-info-mini {
    flex: 1;
}

.book-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.book-author {
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1rem;
}

.book-meta-compact {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.meta-badge {
    background: rgba(0, 191, 166, 0.1);
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    color: var(--dark);
    font-weight: 500;
    border: 1px solid rgba(0, 191, 166, 0.2);
}

.btn-like-mini, .btn-download-mini {
    background: var(--white);
    border: 2px solid var(--primary-light);
    color: var(--primary);
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    position: relative;
}

.btn-like-mini:hover, .btn-download-mini:hover {
    background: var(--primary);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.like-count {
    position: absolute;
    top: -5px;
    right: -5px;
    background: var(--error);
    color: white;
    font-size: 0.7rem;
    padding: 2px 6px;
    border-radius: 10px;
    min-width: 18px;
    text-align: center;
}

/* === ENHANCED FLIPBOOK CONTAINER === */
.flipbook-container-enhanced {
    background: var(--white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-floating);
    border: 1px solid rgba(0, 191, 166, 0.1);
    min-height: 600px;
    position: relative;
    overflow: hidden;
    margin: 0 1rem;
}

.flipbook-wrapper-enhanced {
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

.flipbook-viewer-enhanced {
    width: 900px;
    height: 600px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
    position: relative;
    overflow: hidden;
}

/* Enhanced FlipBook Controls */
.flipbook-controls-enhanced {
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

.control-btn-enhanced {
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
    box-shadow: 0 6px 20px rgba(0, 191, 166, 0.4);
    position: relative;
}

.control-btn-enhanced:hover:not(:disabled) {
    transform: scale(1.15) translateY(-2px);
    box-shadow: 0 10px 30px rgba(0, 191, 166, 0.6);
}

.control-btn-enhanced:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    transform: none;
}

.page-info-enhanced {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    min-width: 120px;
}

.page-progress {
    width: 100%;
    height: 4px;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 2px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--gold));
    border-radius: 2px;
    width: 0%;
    transition: width 0.3s ease;
}

.page-numbers {
    font-weight: 700;
    color: var(--dark);
    font-size: 1.1rem;
}

/* === ENHANCED LOADING STATE === */
.loading-state-enhanced {
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

.flipbook-loader-enhanced {
    display: flex;
    align-items: center;
    gap: 3rem;
    max-width: 600px;
    padding: 2rem;
}

.book-spinner {
    flex-shrink: 0;
}

.book {
    width: 120px;
    height: 90px;
    position: relative;
    perspective: 1000px;
}

.page {
    position: absolute;
    width: 50%;
    height: 100%;
    background: white;
    border-radius: 6px 0 0 6px;
    transform-origin: right;
    animation: pageFlip 2s infinite ease-in-out;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.page:nth-child(1) { animation-delay: 0s; }
.page:nth-child(2) { animation-delay: 0.4s; }
.page:nth-child(3) { animation-delay: 0.8s; }

@keyframes pageFlip {
    0%, 100% { transform: rotateY(0deg); }
    50% { transform: rotateY(-20deg); }
}

.loading-content {
    flex: 1;
}

.loading-content h4 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.loading-content p {
    margin-bottom: 1.5rem;
    opacity: 0.9;
}

.progress-container-enhanced {
    width: 100%;
    height: 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar-enhanced {
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

/* === ENHANCED ERROR STATE === */
.error-state-enhanced {
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

.error-content {
    text-align: center;
    color: white;
    max-width: 500px;
}

.error-icon {
    font-size: 5rem;
    color: var(--gold);
    margin-bottom: 1.5rem;
    opacity: 0.9;
}

.error-content h4 {
    font-size: 1.8rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.error-content p {
    font-size: 1.1rem;
    margin-bottom: 2.5rem;
    opacity: 0.9;
    line-height: 1.6;
}

.error-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-retry-enhanced, .btn-back-enhanced {
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
}

.btn-retry-enhanced {
    background: linear-gradient(135deg, var(--gold) 0%, #ffed4e 100%);
    color: var(--dark);
}

.btn-retry-enhanced:hover {
    background: linear-gradient(135deg, #ffed4e 0%, var(--gold) 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
}

.btn-back-enhanced {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.btn-back-enhanced:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

/* === FLOATING CONTROLS === */
.floating-controls {
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
}

.floating-controls-panel {
    display: flex;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.95);
    padding: 1rem 1.5rem;
    border-radius: 50px;
    box-shadow: var(--shadow-floating);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    animation: slideUp 0.5s ease;
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

.control-section {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0 0.5rem;
}

.control-section:not(:last-child) {
    border-right: 1px solid rgba(0, 0, 0, 0.1);
    padding-right: 1rem;
}

.floating-btn {
    background: transparent;
    border: 2px solid var(--primary-light);
    color: var(--primary);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    cursor: pointer;
    font-size: 0.9rem;
}

.floating-btn:hover {
    background: var(--primary);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 191, 166, 0.4);
}

.floating-btn.active {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
}

.page-display, .zoom-display {
    font-weight: 600;
    color: var(--dark);
    font-size: 0.85rem;
    min-width: 50px;
    text-align: center;
}

/* === TURN.JS ENHANCEMENTS === */
.flipbook-viewer-enhanced .page {
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
}

.cover-content .author {
    font-size: 1.3rem;
    margin-bottom: 2rem;
    opacity: 0.9;
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
}

.library-info {
    margin-top: 3rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.3);
}

.library-info p {
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}

.library-info small {
    opacity: 0.8;
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
.flipbook-container-enhanced.fullscreen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9999;
    border-radius: 0;
    margin: 0;
}

.flipbook-container-enhanced.fullscreen .flipbook-wrapper-enhanced {
    height: 100vh;
    padding: 0;
}

.flipbook-container-enhanced.fullscreen .flipbook-viewer-enhanced {
    width: 95vw !important;
    height: 95vh !important;
}

body.fullscreen-mode {
    overflow: hidden;
}

body.fullscreen-mode .floating-controls {
    bottom: 1rem;
}

/* === TURN.JS CUSTOM STYLES === */
.flipbook-viewer-enhanced .turn-page {
    background-color: white;
    background-repeat: no-repeat;
    background-size: 100% 100%;
}

.flipbook-viewer-enhanced .page-wrapper {
    perspective: 2000px;
}

.flipbook-viewer-enhanced .shadow {
    transition: box-shadow 0.5s;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
}

/* Even page gradient effect */
.flipbook-viewer-enhanced .page.even {
    background: -webkit-gradient(linear, right top, left top, color-stop(0.95, #fff), color-stop(1, #dadada));
    background-image: -webkit-linear-gradient(right, #fff 95%, #c4c4c4 100%);
    background-image: -moz-linear-gradient(right, #fff 95%, #c4c4c4 100%);
    background-image: -ms-linear-gradient(right, #fff 95%, #c4c4c4 100%);
    background-image: -o-linear-gradient(right, #fff 95%, #c4c4c4 100%);
    background-image: linear-gradient(right, #fff 95%, #c4c4c4 100%);
}

/* Odd page gradient effect */
.flipbook-viewer-enhanced .page.odd {
    background: -webkit-gradient(linear, left top, right top, color-stop(0.95, #fff), color-stop(1, #dadada));
    background-image: -webkit-linear-gradient(left, #fff 95%, #c4c4c4 100%);
    background-image: -moz-linear-gradient(left, #fff 95%, #c4c4c4 100%);
    background-image: -ms-linear-gradient(left, #fff 95%, #c4c4c4 100%);
    background-image: -o-linear-gradient(left, #fff 95%, #c4c4c4 100%);
    background-image: linear-gradient(left, #fff 95%, #c4c4c4 100%);
}

/* === RESPONSIVE DESIGN === */
@media (max-width: 1200px) {
    .flipbook-viewer-enhanced {
        width: 800px;
        height: 550px;
    }
}

@media (max-width: 992px) {
    .flipbook-viewer-enhanced {
        width: 700px;
        height: 500px;
    }

    .floating-controls-panel {
        flex-wrap: wrap;
        justify-content: center;
        border-radius: var(--radius-lg);
        padding: 1rem;
    }

    .control-section:not(:last-child) {
        border-right: none;
        padding-right: 0.5rem;
    }
}

@media (max-width: 768px) {
    .book-header-compact {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }

    .flipbook-viewer-enhanced {
        width: 100% !important;
        height: 400px !important;
    }

    .flipbook-wrapper-enhanced {
        height: 50vh;
        min-height: 450px;
        padding: 1rem;
    }

    .flipbook-controls-enhanced {
        padding: 0.8rem 1.5rem;
        gap: 1rem;
    }

    .control-btn-enhanced {
        width: 45px;
        height: 45px;
        font-size: 1.1rem;
    }

    .flipbook-loader-enhanced {
        flex-direction: column;
        text-align: center;
        gap: 2rem;
    }

    .floating-controls {
        bottom: 1rem;
        left: 1rem;
        right: 1rem;
        transform: none;
    }

    .floating-controls-panel {
        justify-content: space-between;
        border-radius: var(--radius);
    }
}

@media (max-width: 576px) {
    .book-title {
        font-size: 1.3rem;
    }

    .book-meta-compact {
        justify-content: center;
    }

    .flipbook-container-enhanced {
        margin: 0 0.5rem;
    }

    .floating-controls-panel {
        padding: 0.8rem;
        gap: 0.5rem;
    }

    .floating-btn {
        width: 35px;
        height: 35px;
        font-size: 0.8rem;
    }

    .page-display, .zoom-display {
        font-size: 0.8rem;
        min-width: 40px;
    }
}

/* === BREADCRUMB ENHANCEMENT === */
.elegant-breadcrumb {
    background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
    border-radius: var(--radius-lg);
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(0, 191, 166, 0.1);
    box-shadow: var(--shadow);
}

.breadcrumb-link {
    color: var(--primary);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    padding: 0.5rem 1rem;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
}

.breadcrumb-link:hover {
    color: var(--primary-dark);
    background: var(--primary-light);
    transform: translateY(-1px);
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
</style>
