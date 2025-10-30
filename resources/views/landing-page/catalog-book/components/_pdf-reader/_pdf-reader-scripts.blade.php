<!-- PDF.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
<!-- Turn.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/turn.js/4.1.1/turn.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Global variables
let flipbook = null;
let pdfDoc = null;
let currentPage = 1;
let totalPages = 0;
let currentZoom = 1.0;
let isFullscreen = false;
let renderedPages = new Set();

// Set PDF.js worker
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

document.addEventListener('DOMContentLoaded', function() {
    initializeTurnJS();
    setupEventListeners();
    updateProgressBar();
});

async function initializeTurnJS() {
    try {
        showLoadingState('Memuat buku digital...');

        const pdfUrl = '{{ $book->getPublicPdfUrl() }}';
        console.log('Loading PDF from:', pdfUrl);

        if (!pdfUrl) {
            throw new Error('PDF URL tidak tersedia');
        }

        // Load PDF document
        const loadingTask = pdfjsLib.getDocument(pdfUrl);
        pdfDoc = await loadingTask.promise;

        totalPages = pdfDoc.numPages;
        updateLoadingState(`Memuat ${totalPages} halaman...`);

        // Initialize Turn.js
        await createTurnJSBook();

        hideLoadingState();
        showNotification('Buku siap dibaca! 📖', 'success');

    } catch (error) {
        console.error('Error initializing turn.js:', error);
        showErrorState('Gagal memuat buku: ' + error.message);
    }
}

async function createTurnJSBook() {
    const flipbookElement = document.getElementById('flipbook');

    // Clear existing content
    flipbookElement.innerHTML = '';

    // Add cover page
    const coverPage = document.createElement('div');
    coverPage.className = 'page hard cover';
    coverPage.innerHTML = `
        <div class="page-content">
            <div class="cover-content">
                <h2>{{ $book->titleBook }}</h2>
                <p class="author">Oleh {{ $book->authorName }}</p>
                @if($book->coverImageUrl())
                    <div class="cover-image">
                        <img src="{{ $book->coverImageUrl() }}" alt="{{ $book->titleBook }}">
                    </div>
                @endif
                <div class="book-info">
                    <p><strong>Penerbit:</strong> {{ $book->publisherName }}</p>
                    <p><strong>Tahun:</strong> {{ $book->year }}</p>
                    <p><strong>Halaman:</strong> ${totalPages}</p>
                </div>
            </div>
        </div>
    `;
    flipbookElement.appendChild(coverPage);

    // Add PDF pages
    for (let i = 1; i <= totalPages; i++) {
        const pageElement = document.createElement('div');
        pageElement.className = 'page';
        pageElement.setAttribute('data-page', i);
        pageElement.innerHTML = `
            <div class="page-content">
                <div class="page-loader">
                    <div class="spinner"></div>
                    <p>Memuat halaman ${i}</p>
                </div>
                <canvas class="page-canvas" id="canvas-${i}"></canvas>
                <div class="page-number">${i}</div>
            </div>
        `;
        flipbookElement.appendChild(pageElement);
    }

    // Add back cover
    const backCover = document.createElement('div');
    backCover.className = 'page hard cover';
    backCover.innerHTML = `
        <div class="page-content">
            <div class="cover-content">
                <h3>Terima Kasih</h3>
                <p>Selamat membaca dan semoga bermanfaat!</p>
                <div class="library-info">
                    <p>Perpustakaan Digital</p>
                    <small>{{ config('app.name') }}</small>
                </div>
            </div>
        </div>
    `;
    flipbookElement.appendChild(backCover);

    // Initialize Turn.js
    flipbook = $(flipbookElement).turn({
        width: 900,
        height: 600,
        autoCenter: true,
        display: 'double',
        acceleration: true,
        elevation: 50,
        gradients: true,
        duration: 800,
        pages: totalPages + 2,
        when: {
            turning: function(e, page, view) {
                currentPage = page;
                updatePageInfo();
                updateNavigation();
                updateProgressBar();

                // Preload adjacent pages
                preloadPages(page);
            },
            turned: function(e, page) {
                // Render current page if not rendered
                renderPage(page);
            }
        }
    });

    // Render first page immediately
    setTimeout(() => {
        renderPage(1);
    }, 300);
}

async function renderPage(pageNumber) {
    if (renderedPages.has(pageNumber) || pageNumber === 1 || pageNumber === totalPages + 2) {
        return; // Skip covers and already rendered pages
    }

    const pdfPageNumber = pageNumber - 1; // Adjust for cover
    if (pdfPageNumber < 1 || pdfPageNumber > totalPages) return;

    const pageElement = document.querySelector(`[data-page="${pdfPageNumber}"]`);
    if (!pageElement) return;

    const canvas = pageElement.querySelector('.page-canvas');
    const loader = pageElement.querySelector('.page-loader');

    if (!canvas || renderedPages.has(pdfPageNumber)) return;

    try {
        const page = await pdfDoc.getPage(pdfPageNumber);
        const viewport = page.getViewport({ scale: 1.5 });

        canvas.width = viewport.width;
        canvas.height = viewport.height;

        const context = canvas.getContext('2d');
        const renderContext = {
            canvasContext: context,
            viewport: viewport
        };

        await page.render(renderContext).promise;

        // Hide loader and show canvas
        if (loader) loader.style.display = 'none';
        canvas.style.display = 'block';

        renderedPages.add(pdfPageNumber);

    } catch (error) {
        console.error('Error rendering page:', error);
        if (loader) {
            loader.innerHTML = '<p>Gagal memuat halaman</p>';
        }
    }
}

function preloadPages(currentPage) {
    const pagesToPreload = [currentPage - 1, currentPage + 1, currentPage - 2, currentPage + 2];

    pagesToPreload.forEach(page => {
        if (page > 1 && page <= totalPages + 1 && !renderedPages.has(page - 1)) {
            renderPage(page);
        }
    });
}

function updatePageInfo() {
    const actualPage = Math.max(1, currentPage - 1);
    document.getElementById('current-page').textContent = actualPage;
    document.getElementById('total-pages').textContent = totalPages;
    document.getElementById('current-page-display').textContent = actualPage;
    document.getElementById('total-pages-display').textContent = totalPages;
}

function updateProgressBar() {
    const progressBar = document.getElementById('page-progress-bar');
    if (progressBar && totalPages > 0) {
        const progress = ((currentPage - 1) / (totalPages + 1)) * 100;
        progressBar.style.width = `${progress}%`;
    }
}

function updateNavigation() {
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    if (prevBtn) {
        prevBtn.disabled = currentPage <= 1;
    }
    if (nextBtn) {
        nextBtn.disabled = currentPage >= totalPages + 2;
    }
}

// Navigation functions
function nextPage() {
    if (flipbook) {
        flipbook.turn('next');
    }
}

function prevPage() {
    if (flipbook) {
        flipbook.turn('previous');
    }
}

function goToPage(pageNum) {
    if (flipbook) {
        // Adjust for cover page
        const turnPage = pageNum + 1;
        flipbook.turn('page', turnPage);
    }
}

function goToMiddlePage() {
    const middlePage = Math.ceil(totalPages / 2);
    goToPage(middlePage);
}

function goToLastPage() {
    goToPage(totalPages);
}

function zoomIn() {
    if (flipbook) {
        currentZoom = Math.min(currentZoom + 0.2, 3.0);
        updateBookSize();
        document.getElementById('zoom-level').textContent = Math.round(currentZoom * 100) + '%';
        showNotification(`Zoom: ${Math.round(currentZoom * 100)}%`, 'info');
    }
}

function zoomOut() {
    if (flipbook) {
        currentZoom = Math.max(currentZoom - 0.2, 0.5);
        updateBookSize();
        document.getElementById('zoom-level').textContent = Math.round(currentZoom * 100) + '%';
        showNotification(`Zoom: ${Math.round(currentZoom * 100)}%`, 'info');
    }
}

function updateBookSize() {
    if (flipbook) {
        const newWidth = 900 * currentZoom;
        const newHeight = 600 * currentZoom;

        flipbook.turn('size', newWidth, newHeight);
        flipbook.turn('resize');
    }
}

function setViewMode(mode) {
    const singleBtn = document.getElementById('single-view-btn');
    const doubleBtn = document.getElementById('double-view-btn');

    if (mode === 'single') {
        singleBtn.classList.add('active');
        doubleBtn.classList.remove('active');
        if (flipbook) {
            flipbook.turn('display', 'single');
        }
        showNotification('Mode satu halaman diaktifkan', 'info');
    } else {
        singleBtn.classList.remove('active');
        doubleBtn.classList.add('active');
        if (flipbook) {
            flipbook.turn('display', 'double');
        }
        showNotification('Mode dua halaman diaktifkan', 'info');
    }
}

function toggleFullscreen() {
    const container = document.querySelector('.flipbook-container-enhanced');
    const fullscreenBtn = document.getElementById('fullscreen-btn');

    if (!isFullscreen) {
        if (container.requestFullscreen) {
            container.requestFullscreen();
        } else if (container.webkitRequestFullscreen) {
            container.webkitRequestFullscreen();
        } else if (container.mozRequestFullScreen) {
            container.mozRequestFullScreen();
        } else if (container.msRequestFullscreen) {
            container.msRequestFullscreen();
        }

        container.classList.add('fullscreen');
        document.body.classList.add('fullscreen-mode');
        fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
        fullscreenBtn.title = 'Keluar Layar Penuh';
        isFullscreen = true;

        // Resize book for fullscreen
        setTimeout(() => {
            if (flipbook) {
                flipbook.turn('size', 1200, 800);
                flipbook.turn('resize');
            }
        }, 300);
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }

        container.classList.remove('fullscreen');
        document.body.classList.remove('fullscreen-mode');
        fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
        fullscreenBtn.title = 'Layar Penuh';
        isFullscreen = false;

        // Resize book back to normal
        setTimeout(() => {
            if (flipbook) {
                flipbook.turn('size', 900 * currentZoom, 600 * currentZoom);
                flipbook.turn('resize');
            }
        }, 300);
    }
}

function handleFullscreenChange() {
    const container = document.querySelector('.flipbook-container-enhanced');
    const fullscreenBtn = document.getElementById('fullscreen-btn');

    if (!document.fullscreenElement &&
        !document.webkitFullscreenElement &&
        !document.mozFullScreenElement &&
        !document.msFullscreenElement) {
        container.classList.remove('fullscreen');
        document.body.classList.remove('fullscreen-mode');
        fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
        fullscreenBtn.title = 'Layar Penuh';
        isFullscreen = false;

        // Resize book back to normal
        setTimeout(() => {
            if (flipbook) {
                flipbook.turn('size', 900 * currentZoom, 600 * currentZoom);
                flipbook.turn('resize');
            }
        }, 300);
    }
}

function setupEventListeners() {
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (!flipbook) return;

        switch(e.key) {
            case 'ArrowLeft':
            case 'ArrowUp':
            case 'PageUp':
                e.preventDefault();
                prevPage();
                break;
            case 'ArrowRight':
            case 'ArrowDown':
            case 'PageDown':
            case ' ':
                e.preventDefault();
                nextPage();
                break;
            case 'Escape':
                if (isFullscreen) {
                    toggleFullscreen();
                }
                break;
            case 'Home':
                e.preventDefault();
                goToPage(1);
                break;
            case 'End':
                e.preventDefault();
                goToPage(totalPages);
                break;
            case 'F11':
                e.preventDefault();
                toggleFullscreen();
                break;
        }
    });

    // Fullscreen change listener
    document.addEventListener('fullscreenchange', handleFullscreenChange);
    document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
    document.addEventListener('mozfullscreenchange', handleFullscreenChange);
    document.addEventListener('MSFullscreenChange', handleFullscreenChange);

    // Touch swipe support
    let touchStartX = 0;

    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, false);

    document.addEventListener('touchend', function(e) {
        if (!flipbook) return;

        const touchEndX = e.changedTouches[0].screenX;
        const deltaX = touchEndX - touchStartX;
        const swipeThreshold = 50;

        if (deltaX < -swipeThreshold) {
            nextPage();
        } else if (deltaX > swipeThreshold) {
            prevPage();
        }
    }, false);
}

// Loading state functions
function showLoadingState(message) {
    const loadingState = document.getElementById('pdf-loading');
    const loadingText = document.getElementById('loading-text');

    if (loadingState) loadingState.style.display = 'flex';
    if (loadingText && message) loadingText.textContent = message;
}

function updateLoadingState(message) {
    const loadingText = document.getElementById('loading-text');
    if (loadingText && message) loadingText.textContent = message;
}

function hideLoadingState() {
    const loadingState = document.getElementById('pdf-loading');
    if (loadingState) loadingState.style.display = 'none';
}

function showErrorState(message) {
    const loadingState = document.getElementById('pdf-loading');
    const errorState = document.getElementById('pdf-error');

    if (loadingState) loadingState.style.display = 'none';
    if (errorState) errorState.style.display = 'flex';

    if (message) {
        document.getElementById('error-message').textContent = message;
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation-triangle' : 'info'}-circle"></i>
            <span>${message}</span>
        </div>
    `;

    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#00bfa6' : type === 'error' ? '#ff6b6b' : '#3498db'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
        max-width: 400px;
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Like book function
async function likeBook(bookID) {
    try {
        const response = await fetch(`/perpustakaan/buku/${bookID}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const result = await response.json();

        if (result.success) {
            showNotification('Terima kasih telah menyukai buku ini! 💖', 'success');
            // Update like count
            const likeCount = document.querySelector('.like-count');
            if (likeCount) {
                likeCount.textContent = result.favoriteCount;
            }
        } else {
            showNotification(result.message || 'Gagal menyukai buku', 'error');
        }
    } catch (error) {
        console.error('Error liking book:', error);
        showNotification('Terjadi kesalahan saat menyukai buku', 'error');
    }
}

// Initialize double page view by default
setTimeout(() => {
    setViewMode('double');
}, 1000);

// Add notification styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .notification-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .notification-content i {
        font-size: 1.2rem;
    }
`;
document.head.appendChild(style);
</script>
