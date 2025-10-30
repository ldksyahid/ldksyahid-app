<style>
/* === PREMIUM VARIABLES === */
:root {
    --primary: #00bfa6;
    --primary-dark: #009b89;
    --primary-light: #e0f7f5;
    --secondary: #6c757d;
    --success: #28a745;
    --warning: #ffc107;
    --danger: #dc3545;
    --info: #17a2b8;
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

/* === ELEGANT BREADCRUMB === */
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
    content: "/";
    color: var(--secondary);
    padding: 0 0.5rem;
    font-weight: 300;
}

/* === BOOK READER HEADER === */
.book-reader-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
    border-radius: var(--radius-xl);
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-elegant);
    border: 1px solid rgba(0, 191, 166, 0.1);
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
    width: 100px;
    height: 130px;
    object-fit: cover;
    border-radius: var(--radius);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    transition: var(--transition);
    border: 3px solid var(--white);
}

.cover-image-reader:hover {
    transform: scale(1.05) rotate(1deg);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
}

.cover-placeholder-reader {
    width: 100px;
    height: 130px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.8rem;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    border: 3px solid var(--white);
}

.book-info-reader {
    flex: 1;
}

.book-title-reader {
    font-size: 1.8rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 0.75rem;
    line-height: 1.3;
    background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.book-author-reader {
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 1.25rem;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
}

.book-meta-reader {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    align-items: center;
}

.meta-item-reader {
    display: flex;
    align-items: center;
    background: var(--primary-light);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    color: var(--dark);
    font-weight: 500;
    transition: var(--transition);
}

.meta-item-reader:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 191, 166, 0.3);
}

.meta-divider-reader {
    width: 1px;
    height: 20px;
    background: var(--primary-light);
}

.reader-actions {
    display: flex;
    gap: 1rem;
    flex-shrink: 0;
}

.btn-back, .btn-fullscreen {
    padding: 0.875rem 1.5rem;
    border-radius: var(--radius);
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 2px solid;
    font-size: 0.95rem;
}

.btn-back {
    background: transparent;
    border-color: var(--primary);
    color: var(--primary);
}

.btn-back:hover {
    background: var(--primary);
    color: var(--white);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 191, 166, 0.4);
}

.btn-fullscreen {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-color: var(--primary);
    color: var(--white);
}

.btn-fullscreen:hover {
    background: linear-gradient(135deg, var(--primary-dark) 0%, #007f73 100%);
    border-color: var(--primary-dark);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 191, 166, 0.4);
}

/* === PREMIUM READER CONTAINER === */
.reader-container-premium {
    background: var(--white);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-elegant);
    border: 1px solid rgba(0, 191, 166, 0.1);
    min-height: 700px;
    position: relative;
    overflow: hidden;
    transition: var(--transition);
}

.reader-container-premium:hover {
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
}

/* Reader Content */
.reader-content {
    width: 100%;
    height: 100%;
    min-height: 700px;
}

.reader-frame-container {
    width: 100%;
    height: 100%;
    position: relative;
}

.reader-frame {
    width: 100%;
    height: 100%;
    min-height: 700px;
    border: none;
    background: white;
    transition: var(--transition);
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
    border: none;
}

.reader-container-premium.fullscreen .reader-frame {
    min-height: 100vh;
}

/* === READER CONTROLS PANEL === */
.reader-controls-panel {
    background: linear-gradient(135deg, var(--white) 0%, var(--light) 100%);
    border-radius: var(--radius-lg);
    padding: 1.5rem 2rem;
    box-shadow: var(--shadow);
    border: 1px solid rgba(0, 191, 166, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.controls-section {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.btn-control {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
    border: 2px solid var(--primary-light);
    background: transparent;
    color: var(--primary);
    font-size: 1.1rem;
}

.btn-control:hover {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: var(--white);
    border-color: var(--primary);
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 8px 20px rgba(0, 191, 166, 0.4);
}

.controls-info {
    flex: 1;
    text-align: end;
}

.reader-status {
    font-weight: 600;
    color: var(--primary);
    font-size: 0.95rem;
    padding: 0.5rem 1rem;
    background: var(--primary-light);
    border-radius: 20px;
    display: inline-block;
}

/* === RESPONSIVE DESIGN === */
@media (max-width: 992px) {
    .book-reader-header {
        padding: 2rem;
    }

    .book-title-reader {
        font-size: 1.6rem;
    }

    .reader-container-premium {
        min-height: 600px;
    }

    .reader-frame {
        min-height: 600px;
    }
}

@media (max-width: 768px) {
    .book-reader-header {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
        padding: 1.5rem;
    }

    .book-meta-reader {
        justify-content: center;
    }

    .reader-actions {
        width: 100%;
        justify-content: center;
        flex-direction: column;
    }

    .btn-back, .btn-fullscreen {
        width: 100%;
        justify-content: center;
    }

    .reader-controls-panel {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
        padding: 1.5rem;
    }

    .controls-section {
        justify-content: center;
    }

    .controls-info {
        order: -1;
    }

    .reader-container-premium {
        min-height: 500px;
    }

    .reader-frame {
        min-height: 500px;
    }

    .book-title-reader {
        font-size: 1.4rem;
    }

    .cover-image-reader, .cover-placeholder-reader {
        width: 80px;
        height: 110px;
    }
}

@media (max-width: 576px) {
    .book-title-reader {
        font-size: 1.3rem;
    }

    .book-author-reader {
        font-size: 1rem;
    }

    .elegant-breadcrumb {
        padding: 1rem 1.5rem;
    }

    .breadcrumb-link {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }

    .reader-container-premium {
        min-height: 400px;
    }

    .reader-frame {
        min-height: 400px;
    }

    .meta-item-reader {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
    }

    .btn-control {
        width: 45px;
        height: 45px;
        font-size: 1rem;
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

/* === ANIMATIONS === */
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

.reader-container-premium {
    animation: fadeInUp 0.6s ease-out;
}

.book-reader-header {
    animation: fadeInUp 0.4s ease-out;
}

.reader-controls-panel {
    animation: fadeInUp 0.5s ease-out 0.2s both;
}

/* === CUSTOM SCROLLBAR === */
.reader-frame-container::-webkit-scrollbar {
    width: 8px;
}

.reader-frame-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.reader-frame-container::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 4px;
}

.reader-frame-container::-webkit-scrollbar-thumb:hover {
    background: var(--primary-dark);
}
</style>
