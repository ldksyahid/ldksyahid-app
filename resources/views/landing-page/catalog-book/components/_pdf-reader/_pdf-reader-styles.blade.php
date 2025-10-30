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
    --success: #28a745;
    --warning: #ffc107;
    --danger: #dc3545;
    --info: #17a2b8;

    --radius: 8px;
    --radius-lg: 12px;
    --radius-xl: 16px;
    --shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    --shadow-hover: 0 5px 25px rgba(0, 0, 0, 0.08);
    --shadow-floating: 0 8px 30px rgba(0, 0, 0, 0.12);
    --shadow-elegant: 0 10px 40px rgba(0, 0, 0, 0.1);

    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* === ELEGANT BREADCRUMB === */
.elegant-breadcrumb {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow);
}

.breadcrumb-item {
    display: flex;
    align-items: center;
}

.breadcrumb-link {
    color: var(--secondary);
    text-decoration: none;
    font-weight: 500;
    transition: var(--transition);
    padding: 0.5rem 0.75rem;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
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
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "/";
    color: var(--secondary);
    padding: 0 0.5rem;
}

/* === BOOK READER HEADER === */
.book-reader-header {
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

.book-reader-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(to bottom, var(--primary), var(--primary-dark));
}

.book-cover-reader {
    flex-shrink: 0;
}

.cover-image-reader {
    width: 80px;
    height: 100px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    transition: var(--transition);
}

.cover-image-reader:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
}

.cover-placeholder-reader {
    width: 80px;
    height: 100px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.book-info-reader {
    flex: 1;
}

.book-title-reader {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.book-author-reader {
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1rem;
    display: flex;
    align-items: center;
}

.book-meta-reader {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    align-items: center;
}

.meta-item-reader {
    display: flex;
    align-items: center;
    background: var(--primary-light);
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    color: var(--dark);
    font-weight: 500;
}

.meta-divider-reader {
    width: 1px;
    height: 16px;
    background: var(--gray-300);
}

.reader-actions {
    display: flex;
    gap: 1rem;
    flex-shrink: 0;
}

.btn-back, .btn-fullscreen {
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius);
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid;
}

.btn-back {
    background: transparent;
    border-color: var(--primary);
    color: var(--primary);
}

.btn-back:hover {
    background: var(--primary);
    color: var(--white);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 168, 150, 0.3);
}

.btn-fullscreen {
    background: var(--primary);
    border-color: var(--primary);
    color: var(--white);
}

.btn-fullscreen:hover {
    background: var(--primary-dark);
    border-color: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 168, 150, 0.4);
}

/* === PREMIUM READER CONTAINER === */
.reader-container-premium {
    background: var(--white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-elegant);
    border: 1px solid var(--gray-200);
    min-height: 600px;
    position: relative;
    overflow: hidden;
}

/* Reader Content */
.reader-content {
    width: 100%;
    height: 100%;
    min-height: 600px;
}

.reader-frame-container {
    width: 100%;
    height: 100%;
    position: relative;
}

.reader-frame {
    width: 100%;
    height: 100%;
    min-height: 600px;
    border: none;
    background: white;
}

/* Fullscreen styles */
.reader-container-premium.fullscreen {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9999;
    border-radius: 0;
    margin: 0;
}

.reader-container-premium.fullscreen .reader-frame {
    min-height: 100vh;
}

/* === READER CONTROLS PANEL === */
.reader-controls-panel {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    box-shadow: var(--shadow);
    border: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.controls-section {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.btn-control {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
}

.btn-control:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.controls-info {
    flex: 1;
    text-align: center;
}

.reader-status {
    font-weight: 600;
    color: var(--primary);
    font-size: 0.9rem;
}

/* === RESPONSIVE DESIGN === */
@media (max-width: 768px) {
    .book-reader-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
        padding: 1.5rem;
    }

    .book-meta-reader {
        justify-content: center;
    }

    .reader-actions {
        width: 100%;
        justify-content: center;
    }

    .reader-controls-panel {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }

    .controls-section {
        justify-content: center;
    }

    .controls-info {
        order: -1;
    }

    .reader-frame {
        min-height: 500px;
    }
}

@media (max-width: 576px) {
    .book-title-reader {
        font-size: 1.3rem;
    }

    .reader-actions {
        flex-direction: column;
        width: 100%;
    }

    .btn-back, .btn-fullscreen {
        width: 100%;
    }

    .reader-frame {
        min-height: 400px;
    }
}

/* === SAFE AREA INSETS FOR NOTCHED DEVICES === */
@supports(padding: max(0px)) {
    .reader-container-premium.fullscreen {
        padding-top: env(safe-area-inset-top);
        padding-bottom: env(safe-area-inset-bottom);
        padding-left: env(safe-area-inset-left);
        padding-right: env(safe-area-inset-right);
    }
}
</style>
