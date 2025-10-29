<style>
/* === VARIABLES === */
:root {
    --primary: #00bfa6;
    --primary-dark: #009b89;
    --primary-light: #e0f7f5;
    --secondary: #6c757d;
    --dark: #2c3e50;
    --light: #f8f9fa;
    --white: #ffffff;

    --radius: 12px;
    --radius-lg: 16px;
    --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
}

/* === READER HEADER === */
.reader-header {
    background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
    border-radius: var(--radius-lg);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow);
    border: 1px solid rgba(0, 191, 166, 0.1);
}

.book-title-reader {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.book-author-reader {
    font-size: 1.2rem;
    color: var(--primary);
    font-weight: 600;
    margin: 0;
}

/* === FLIPBOOK CONTAINER === */
.flipbook-container {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow);
    border: 1px solid rgba(0, 191, 166, 0.1);
    min-height: 600px;
    position: relative;
    overflow: hidden;
}

.flipbook-wrapper {
    width: 100%;
    height: 70vh;
    min-height: 600px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    perspective: 2000px;
}

/* Custom Flipbook Styles */
.custom-flipbook {
    position: relative;
    width: 800px;
    height: 600px;
    transform-style: preserve-3d;
    transition: transform 0.6s ease;
}

.flipbook-page {
    position: absolute;
    width: 100%;
    height: 100%;
    background: white;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    transform-style: preserve-3d;
    transition: transform 0.6s ease;
    backface-visibility: hidden;
    overflow: hidden;
}

.flipbook-page .page-content {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
    position: relative;
}

.flipbook-page canvas {
    max-width: 100%;
    max-height: 100%;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

/* Page States */
.flipbook-page.active {
    z-index: 10;
    transform: rotateY(0deg);
}

.flipbook-page.next {
    z-index: 5;
    transform: rotateY(0deg);
}

.flipbook-page.prev {
    z-index: 5;
    transform: rotateY(-180deg);
}

.flipbook-page.hidden {
    display: none;
}

/* Cover Pages */
.cover-page {
    background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);
    color: white;
    text-align: center;
}

.cover-content h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.cover-content .author {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.cover-image {
    max-width: 200px;
    margin: 0 auto 2rem;
}

.cover-image img {
    width: 100%;
    height: auto;
    border-radius: 4px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.book-info {
    margin-top: 2rem;
    text-align: left;
}

.book-info p {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

/* Page numbers */
.page-number {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    z-index: 10;
}

/* Navigation Arrows */
.flipbook-nav {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    display: flex;
    justify-content: space-between;
    padding: 0 2rem;
    transform: translateY(-50%);
    z-index: 20;
}

.nav-btn {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: var(--primary);
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.nav-btn:hover {
    background: var(--primary);
    color: white;
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 191, 166, 0.4);
}

.nav-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

.nav-btn:disabled:hover {
    background: rgba(255, 255, 255, 0.9);
    color: var(--primary);
}

/* Flip Animation */
@keyframes flipNext {
    from {
        transform: rotateY(0deg);
    }
    to {
        transform: rotateY(-180deg);
    }
}

@keyframes flipPrev {
    from {
        transform: rotateY(-180deg);
    }
    to {
        transform: rotateY(0deg);
    }
}

.flipbook-page.flipping-next {
    animation: flipNext 0.6s ease forwards;
}

.flipbook-page.flipping-prev {
    animation: flipPrev 0.6s ease forwards;
}

/* === LOADING & ERROR STATES === */
.loading-state, .error-state {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: var(--white);
    z-index: 30;
}

.error-icon {
    font-size: 4rem;
    color: var(--secondary);
    margin-bottom: 1rem;
}

.error-state h4 {
    color: var(--dark);
    margin-bottom: 1rem;
    font-weight: 600;
}

.error-state p {
    color: var(--secondary);
    text-align: center;
    margin-bottom: 1.5rem;
}

/* === BUTTON STYLES === */
.btn-retry {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border: none;
    color: var(--white);
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius);
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    cursor: pointer;
}

.btn-retry:hover {
    background: linear-gradient(135deg, var(--primary-dark) 0%, #007f73 100%);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 191, 166, 0.4);
}

.btn-back {
    background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
    border: 2px solid var(--primary);
    color: var(--primary);
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius);
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    cursor: pointer;
}

.btn-back:hover {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 191, 166, 0.4);
}

/* === READER CONTROLS === */
.reader-controls {
    background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    box-shadow: var(--shadow);
    border: 1px solid rgba(0, 191, 166, 0.1);
}

.controls-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 2rem;
}

.control-group {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: var(--white);
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 191, 166, 0.1);
}

.btn-control {
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
    text-decoration: none;
}

.btn-control:hover {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 191, 166, 0.3);
}

.btn-control.active {
    background: var(--primary);
    color: var(--white);
    border-color: var(--primary);
}

.page-info, .zoom-info {
    font-weight: 600;
    color: var(--dark);
    min-width: 120px;
    text-align: center;
    font-size: 0.9rem;
}

/* === BOOK INFO FOOTER === */
.book-info-footer {
    background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
    border-radius: var(--radius-lg);
    padding: 2rem;
    box-shadow: var(--shadow);
    border: 1px solid rgba(0, 191, 166, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 2rem;
}

.info-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    flex: 1;
}

.info-item {
    color: var(--dark);
    font-size: 0.95rem;
    padding: 0.5rem 0;
}

.info-item strong {
    color: var(--primary);
}

.action-container {
    flex-shrink: 0;
}

/* === FULLSCREEN MODE === */
.flipbook-container.fullscreen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9999;
    border-radius: 0;
    margin: 0;
}

.flipbook-container.fullscreen .flipbook-wrapper {
    height: calc(100vh - 80px);
}

.flipbook-container.fullscreen .custom-flipbook {
    width: 90vw !important;
    height: 90vh !important;
}

body.fullscreen-mode {
    overflow: hidden;
}

/* === RESPONSIVE DESIGN === */
@media (max-width: 768px) {
    .book-title-reader {
        font-size: 1.5rem;
    }

    .book-author-reader {
        font-size: 1rem;
    }

    .flipbook-wrapper {
        height: 50vh;
        min-height: 400px;
        padding: 1rem;
    }

    .custom-flipbook {
        width: 100% !important;
        height: 100% !important;
    }

    .nav-btn {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .controls-container {
        gap: 1rem;
    }

    .control-group {
        padding: 0.5rem 1rem;
    }

    .page-info, .zoom-info {
        min-width: 100px;
        font-size: 0.8rem;
    }

    .book-info-footer {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }

    .info-container {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .action-container {
        width: 100%;
        display: flex;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .controls-container {
        flex-direction: column;
        gap: 1rem;
    }

    .control-group {
        width: 100%;
        justify-content: center;
    }

    .btn-retry, .btn-back {
        width: 100%;
        padding: 1rem 1.5rem;
    }

    .flipbook-nav {
        padding: 0 1rem;
    }
}

/* === ANIMATIONS === */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.wow.fadeIn {
    animation: fadeIn 0.6s ease-out;
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

.breadcrumb-item.active {
    color: var(--dark);
    font-weight: 600;
    display: flex;
    align-items: center;
}
</style>
