<!-- PDF.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
<!-- Turn.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/turn.js/4.1.1/turn.min.js"></script>

<script>
// Global variables
let pdfDoc = null;
let currentPage = 1;
let totalPages = 0;
let currentZoom = 1;
let isFullscreen = false;
let isSinglePageMode = false;

// Set PDF.js worker
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

document.addEventListener('DOMContentLoaded', function() {
    initializePDFReader();
    setupEventListeners();
});

async function initializePDFReader() {
    const pdfUrl = '{{ $book->pdfFileUrl() }}';

    if (!pdfUrl) {
        showErrorState('Buku tidak tersedia untuk dibaca online.');
        return;
    }

    try {
        // Show loading state
        document.getElementById('pdf-loading').style.display = 'flex';

        // Load PDF document
        const loadingTask = pdfjsLib.getDocument(pdfUrl);
        pdfDoc = await loadingTask.promise;

        totalPages = pdfDoc.numPages;
        document.getElementById('total-pages').textContent = totalPages;

        // Initialize flipbook
        initializeFlipbook();

        // Hide loading state
        document.getElementById('pdf-loading').style.display = 'none';

    } catch (error) {
        console.error('Error loading PDF:', error);
        showErrorState('Gagal memuat buku. Silakan coba lagi.');
    }
}

function initializeFlipbook() {
    const flipbookContainer = document.getElementById('pdf-flipbook');

    // Clear container
    flipbookContainer.innerHTML = '';

    // Create flipbook structure
    const flipbookHTML = `
        <div class="flipbook" id="book">
            ${generatePagesHTML()}
        </div>
    `;

    flipbookContainer.innerHTML = flipbookHTML;

    // Initialize turn.js
    $('#book').turn({
        width: 800,
        height: 600,
        autoCenter: true,
        display: 'double',
        acceleration: true,
        gradients: true,
        elevation: 50,
        when: {
            turning: function(e, page) {
                currentPage = page;
                updatePageInfo();
                loadAdjacentPages(page);
            }
        }
    });

    // Load initial pages
    loadPage(1);
    if (totalPages > 1) {
        loadPage(2);
    }
}

function generatePagesHTML() {
    let html = '';

    // Add hard cover (front)
    html += `
        <div class="page hard">
            <div class="page-content cover-front">
                <div class="cover-content">
                    <h2>{{ $book->titleBook }}</h2>
                    <p class="author">Oleh {{ $book->authorName }}</p>
                    <div class="cover-image">
                        @if($book->coverImageUrl())
                            <img src="{{ $book->coverImageUrl() }}" alt="{{ $book->titleBook }}">
                        @else
                            <img src="https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd" alt="{{ $book->titleBook }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    `;

    // Generate pages for PDF content
    for (let i = 1; i <= totalPages; i++) {
        html += `
            <div class="page">
                <div class="page-content">
                    <canvas id="page-${i}"></canvas>
                </div>
            </div>
        `;
    }

    // Add hard cover (back)
    html += `
        <div class="page hard">
            <div class="page-content cover-back">
                <div class="cover-content">
                    <h3>Terima Kasih</h3>
                    <p>Selamat membaca!</p>
                    <div class="book-info">
                        <p><strong>Penerbit:</strong> {{ $book->publisherName }}</p>
                        <p><strong>Tahun:</strong> {{ $book->year }}</p>
                        <p><strong>ISBN:</strong> {{ $book->isbn ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    `;

    return html;
}

async function loadPage(pageNum) {
    if (!pdfDoc || pageNum < 1 || pageNum > totalPages) return;

    try {
        const page = await pdfDoc.getPage(pageNum);
        const canvas = document.getElementById(`page-${pageNum}`);
        const ctx = canvas.getContext('2d');

        const viewport = page.getViewport({ scale: currentZoom });

        canvas.height = viewport.height;
        canvas.width = viewport.width;

        const renderContext = {
            canvasContext: ctx,
            viewport: viewport
        };

        await page.render(renderContext).promise;

    } catch (error) {
        console.error('Error rendering page:', error);
    }
}

async function loadAdjacentPages(currentPage) {
    // Load previous and next pages for smooth flipping
    const pagesToLoad = [currentPage - 1, currentPage, currentPage + 1];

    for (const pageNum of pagesToLoad) {
        if (pageNum >= 1 && pageNum <= totalPages) {
            await loadPage(pageNum);
        }
    }
}

function updatePageInfo() {
    document.getElementById('current-page').textContent = currentPage;
}

function setupEventListeners() {
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        const book = $('#book');
        if (!book.turn('has')) return;

        switch(e.key) {
            case 'ArrowLeft':
                e.preventDefault();
                book.turn('previous');
                break;
            case 'ArrowRight':
                e.preventDefault();
                book.turn('next');
                break;
            case 'Escape':
                if (isFullscreen) {
                    exitFullscreen();
                }
                break;
        }
    });
}

function zoomIn() {
    currentZoom = Math.min(currentZoom + 0.2, 3.0);
    applyZoom();
}

function zoomOut() {
    currentZoom = Math.max(currentZoom - 0.2, 0.5);
    applyZoom();
}

function applyZoom() {
    const zoomPercentage = Math.round(currentZoom * 100);
    document.getElementById('zoom-level').textContent = zoomPercentage + '%';

    // Reload all visible pages with new zoom
    reloadVisiblePages();
}

function reloadVisiblePages() {
    const book = $('#book');
    if (!book.turn('has')) return;

    const currentView = book.turn('view');
    for (let i = 0; i < currentView.length; i++) {
        const pageNum = currentView[i];
        if (pageNum && pageNum >= 1 && pageNum <= totalPages) {
            loadPage(pageNum);
        }
    }
}

function setViewMode(mode) {
    const book = $('#book');
    const doubleViewBtn = document.getElementById('double-view-btn');

    if (mode === 'single') {
        book.turn('display', 'single');
        doubleViewBtn.classList.remove('active');
        isSinglePageMode = true;
    } else {
        book.turn('display', 'double');
        doubleViewBtn.classList.add('active');
        isSinglePageMode = false;
    }
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
        $('#book').turn('size', window.innerWidth * 0.8, window.innerHeight * 0.8);
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
        $('#book').turn('size', 800, 600);
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
        errorState.querySelector('p').textContent = message;
    }
}

// Navigation functions for buttons
function nextPage() {
    $('#book').turn('next');
}

function prevPage() {
    $('#book').turn('previous');
}

// Touch support
let touchStartX = 0;
let touchEndX = 0;

document.addEventListener('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
}, false);

document.addEventListener('touchend', function(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
}, false);

function handleSwipe() {
    const swipeThreshold = 50;
    const book = $('#book');

    if (!book.turn('has')) return;

    if (touchEndX < touchStartX - swipeThreshold) {
        book.turn('next');
    }

    if (touchEndX > touchStartX + swipeThreshold) {
        book.turn('previous');
    }
}

// Window resize handler
window.addEventListener('resize', function() {
    if ($('#book').turn('has')) {
        $('#book').turn('size', 800, 600);
    }
});

// Cleanup
window.addEventListener('beforeunload', function() {
    if (pdfDoc) {
        pdfDoc.destroy();
    }
});
</script>
