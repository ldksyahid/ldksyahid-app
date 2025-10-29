<!-- PDF.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>

<script>
// Global variables
let pdfDoc = null;
let currentPage = 1;
let totalPages = 0;
let currentZoom = 1.0;
let isFullscreen = false;
let viewMode = 'single';
let isAnimating = false;
let renderedPages = new Set();

// Set PDF.js worker
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

document.addEventListener('DOMContentLoaded', function() {
    initializeFlipbook();
    setupEventListeners();
});

async function initializeFlipbook() {
    try {
        document.getElementById('pdf-loading').style.display = 'flex';

        // Get PDF URL
        const pdfUrl = '{{ $book->getFlipbookPdfUrl() }}';

        if (!pdfUrl) {
            throw new Error('PDF URL not available');
        }

        // Load PDF document
        const loadingTask = pdfjsLib.getDocument(pdfUrl);
        pdfDoc = await loadingTask.promise;

        totalPages = pdfDoc.numPages;

        // Create flipbook structure
        await createFlipbook();

        // Hide loading state
        document.getElementById('pdf-loading').style.display = 'none';

        // Update page info
        updatePageInfo();

    } catch (error) {
        console.error('Error initializing flipbook:', error);
        showErrorState('Gagal memuat buku: ' + error.message);
    }
}

async function createFlipbook() {
    const flipbookElement = document.getElementById('flipbook');

    // Generate pages HTML
    let pagesHTML = generatePagesHTML();
    flipbookElement.innerHTML = pagesHTML;

    // Load initial page
    await loadPage(1);

    // Update navigation buttons
    updateNavigation();
}

function generatePagesHTML() {
    let html = '';

    // Front cover
    html += `
        <div class="flipbook-page active cover-page" data-page="0">
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
                        <p><strong>ISBN:</strong> {{ $book->isbn ?? '-' }}</p>
                    </div>
                    <button class="btn btn-start-reading" onclick="goToPage(1)" style="margin-top: 2rem; padding: 10px 20px; background: white; color: #8B4513; border: none; border-radius: 5px; cursor: pointer;">
                        <i class="fas fa-play me-2"></i>Mulai Membaca
                    </button>
                </div>
            </div>
        </div>
    `;

    // PDF pages
    for (let i = 1; i <= totalPages; i++) {
        html += `
            <div class="flipbook-page hidden" data-page="${i}">
                <div class="page-content">
                    <canvas id="page-canvas-${i}"></canvas>
                    <div class="page-number">${i}</div>
                </div>
            </div>
        `;
    }

    // Back cover
    html += `
        <div class="flipbook-page hidden cover-page" data-page="${totalPages + 1}">
            <div class="page-content">
                <div class="cover-content">
                    <h3>Terima Kasih</h3>
                    <p>Selamat membaca!</p>
                    <div class="book-info">
                        <p><strong>Total Halaman:</strong> ${totalPages}</p>
                        <p><strong>Kategori:</strong> {{ $book->getBookCategory->bookCategoryName ?? '-' }}</p>
                        <p><strong>Bahasa:</strong> {{ $book->getLanguage->languageName ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    `;

    return html;
}

async function loadPage(pageNum) {
    if (!pdfDoc || pageNum < 1 || pageNum > totalPages || renderedPages.has(pageNum)) return;

    try {
        const page = await pdfDoc.getPage(pageNum);
        const canvas = document.getElementById(`page-canvas-${pageNum}`);

        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        const viewport = page.getViewport({ scale: currentZoom });

        canvas.height = viewport.height;
        canvas.width = viewport.width;

        const renderContext = {
            canvasContext: ctx,
            viewport: viewport
        };

        await page.render(renderContext).promise;
        renderedPages.add(pageNum);

    } catch (error) {
        console.error(`Error rendering page ${pageNum}:`, error);
    }
}

function updatePageInfo() {
    document.getElementById('current-page').textContent = currentPage;
    document.getElementById('total-pages').textContent = totalPages;
    document.getElementById('zoom-level').textContent = Math.round(currentZoom * 100) + '%';
}

function updateNavigation() {
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    if (prevBtn) {
        prevBtn.disabled = currentPage <= 0;
    }
    if (nextBtn) {
        nextBtn.disabled = currentPage >= totalPages + 1;
    }
}

async function flipToNextPage() {
    if (isAnimating || currentPage >= totalPages + 1) return;

    isAnimating = true;
    const currentPageElement = document.querySelector(`[data-page="${currentPage}"]`);
    const nextPage = currentPage + 1;
    const nextPageElement = document.querySelector(`[data-page="${nextPage}"]`);

    if (currentPageElement && nextPageElement) {
        // Add flipping animation
        currentPageElement.classList.add('flipping-next');
        nextPageElement.classList.remove('hidden');
        nextPageElement.classList.add('next');

        // Load the page content if it's a PDF page
        if (nextPage >= 1 && nextPage <= totalPages) {
            await loadPage(nextPage);
        }

        setTimeout(() => {
            currentPageElement.classList.remove('active', 'flipping-next');
            currentPageElement.classList.add('prev');
            nextPageElement.classList.remove('next');
            nextPageElement.classList.add('active');

            currentPage = nextPage;
            updatePageInfo();
            updateNavigation();
            isAnimating = false;
        }, 600);
    }
}

async function flipToPrevPage() {
    if (isAnimating || currentPage <= 0) return;

    isAnimating = true;
    const currentPageElement = document.querySelector(`[data-page="${currentPage}"]`);
    const prevPage = currentPage - 1;
    const prevPageElement = document.querySelector(`[data-page="${prevPage}"]`);

    if (currentPageElement && prevPageElement) {
        // Add flipping animation
        currentPageElement.classList.add('flipping-prev');
        prevPageElement.classList.remove('hidden');
        prevPageElement.classList.add('prev');

        setTimeout(() => {
            currentPageElement.classList.remove('active', 'flipping-prev');
            currentPageElement.classList.add('next');
            prevPageElement.classList.remove('prev');
            prevPageElement.classList.add('active');

            currentPage = prevPage;
            updatePageInfo();
            updateNavigation();
            isAnimating = false;
        }, 600);
    }
}

function goToPage(pageNum) {
    if (pageNum < 0 || pageNum > totalPages + 1 || isAnimating) return;

    // Simple page jump without animation for cover
    const allPages = document.querySelectorAll('.flipbook-page');
    allPages.forEach(page => {
        page.classList.remove('active', 'prev', 'next', 'flipping-next', 'flipping-prev');
        page.classList.add('hidden');
    });

    const targetPage = document.querySelector(`[data-page="${pageNum}"]`);
    if (targetPage) {
        targetPage.classList.remove('hidden');
        targetPage.classList.add('active');
        currentPage = pageNum;
        updatePageInfo();
        updateNavigation();

        // Load the page content if it's a PDF page
        if (pageNum >= 1 && pageNum <= totalPages) {
            loadPage(pageNum);
        }
    }
}

function setupEventListeners() {
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (isAnimating) return;

        switch(e.key) {
            case 'ArrowLeft':
            case 'ArrowUp':
                e.preventDefault();
                flipToPrevPage();
                break;
            case 'ArrowRight':
            case 'ArrowDown':
                e.preventDefault();
                flipToNextPage();
                break;
            case 'Escape':
                if (isFullscreen) {
                    exitFullscreen();
                }
                break;
            case '+':
                e.preventDefault();
                zoomIn();
                break;
            case '-':
                e.preventDefault();
                zoomOut();
                break;
            case 'Home':
                e.preventDefault();
                goToPage(0);
                break;
            case 'End':
                e.preventDefault();
                goToPage(totalPages + 1);
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
    let touchStartY = 0;

    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
        touchStartY = e.changedTouches[0].screenY;
    }, false);

    document.addEventListener('touchend', function(e) {
        if (isAnimating) return;

        const touchEndX = e.changedTouches[0].screenX;
        const touchEndY = e.changedTouches[0].screenY;
        const swipeThreshold = 50;
        const verticalThreshold = 30;

        // Only process horizontal swipes with minimal vertical movement
        if (Math.abs(touchEndY - touchStartY) > verticalThreshold) return;

        if (touchEndX < touchStartX - swipeThreshold) {
            flipToNextPage();
        } else if (touchEndX > touchStartX + swipeThreshold) {
            flipToPrevPage();
        }
    }, false);
}

function zoomIn() {
    currentZoom = Math.min(currentZoom + 0.2, 3.0);
    applyZoom();
}

function zoomOut() {
    currentZoom = Math.max(currentZoom - 0.2, 0.5);
    applyZoom();
}

async function applyZoom() {
    updatePageInfo();

    // Clear rendered pages and reload with new zoom
    renderedPages.clear();

    // Reload current page and adjacent pages
    const pagesToLoad = [currentPage, currentPage - 1, currentPage + 1];
    for (const pageNum of pagesToLoad) {
        if (pageNum >= 1 && pageNum <= totalPages) {
            await loadPage(pageNum);
        }
    }
}

function setViewMode(mode) {
    viewMode = mode;

    // Update button states
    document.getElementById('single-page-btn').classList.toggle('active', mode === 'single');
    document.getElementById('double-page-btn').classList.toggle('active', mode === 'double');

    // Note: Single/Double page view would require more complex layout changes
    // For now, we'll keep it as single page flipbook
}

function toggleFullscreen() {
    if (!isFullscreen) {
        enterFullscreen();
    } else {
        exitFullscreen();
    }
}

function enterFullscreen() {
    const container = document.querySelector('.flipbook-container');
    const fullscreenBtn = document.getElementById('fullscreen-btn');

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
    isFullscreen = true;

    // Resize flipbook for fullscreen
    setTimeout(() => {
        const flipbook = document.querySelector('.custom-flipbook');
        if (flipbook) {
            flipbook.style.width = '90vw';
            flipbook.style.height = '90vh';
        }
    }, 100);
}

function exitFullscreen() {
    const container = document.querySelector('.flipbook-container');
    const fullscreenBtn = document.getElementById('fullscreen-btn');

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
    isFullscreen = false;

    // Resize flipbook back to normal
    setTimeout(() => {
        const flipbook = document.querySelector('.custom-flipbook');
        if (flipbook) {
            flipbook.style.width = '800px';
            flipbook.style.height = '600px';
        }
    }, 100);
}

function handleFullscreenChange() {
    const container = document.querySelector('.flipbook-container');
    const fullscreenBtn = document.getElementById('fullscreen-btn');

    if (!document.fullscreenElement &&
        !document.webkitFullscreenElement &&
        !document.mozFullScreenElement &&
        !document.msFullscreenElement) {
        container.classList.remove('fullscreen');
        document.body.classList.remove('fullscreen-mode');
        fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
        isFullscreen = false;
    }
}

function showErrorState(message) {
    const loadingState = document.getElementById('pdf-loading');
    const errorState = document.getElementById('pdf-error');

    loadingState.style.display = 'none';
    errorState.style.display = 'flex';

    if (message) {
        document.getElementById('error-message').textContent = message;
    }
}

// Cleanup
window.addEventListener('beforeunload', function() {
    if (pdfDoc) {
        pdfDoc.destroy();
    }
});

// Initialize view mode
document.getElementById('single-page-btn').classList.add('active');
</script>
