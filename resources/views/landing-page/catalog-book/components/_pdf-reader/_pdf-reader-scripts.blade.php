<script>
// Global variables
let isFullscreen = false;
let readerFrame = null;

document.addEventListener('DOMContentLoaded', function() {
    initializeReader();
    setupEventListeners();
});

function initializeReader() {
    readerFrame = document.getElementById('reader-frame');

    if (!readerFrame) {
        console.error('Elemen pembaca tidak ditemukan');
        return;
    }

    // Wait for iframe to load
    readerFrame.addEventListener('load', function() {
        console.log('Buku berhasil dimuat');
    });

    readerFrame.addEventListener('error', function() {
        console.error('Gagal memuat buku digital');
    });
}

function reloadReader() {
    if (readerFrame) {
        // Add timestamp to prevent caching
        const currentSrc = readerFrame.src.split('?')[0];
        readerFrame.src = currentSrc + '?t=' + new Date().getTime();

        console.log('Memuat ulang buku...');
    }
}

function openInNewTab() {
    const readerUrl = '{{ $book->getReaderLink() }}';
    if (readerUrl) {
        window.open(readerUrl, '_blank');
        console.log('Membuka buku di tab baru');
    } else {
        console.error('URL buku tidak tersedia');
    }
}

function toggleFullscreen() {
    const readerContainer = document.querySelector('.reader-container-premium');
    const fullscreenBtn = document.getElementById('fullscreen-btn');
    const fullscreenControl = document.getElementById('fullscreen-control');

    if (!isFullscreen) {
        // Enter fullscreen
        if (readerContainer.requestFullscreen) {
            readerContainer.requestFullscreen();
        } else if (readerContainer.webkitRequestFullscreen) {
            readerContainer.webkitRequestFullscreen();
        } else if (readerContainer.mozRequestFullScreen) {
            readerContainer.mozRequestFullScreen();
        } else if (readerContainer.msRequestFullscreen) {
            readerContainer.msRequestFullscreen();
        }

        readerContainer.classList.add('fullscreen');
        document.body.classList.add('fullscreen-mode');

        // Update buttons
        if (fullscreenBtn) {
            fullscreenBtn.innerHTML = '<i class="fas fa-compress me-2"></i>Keluar Layar Penuh';
        }
        if (fullscreenControl) {
            fullscreenControl.innerHTML = '<i class="fas fa-compress"></i>';
        }

        isFullscreen = true;
        console.log('Mode layar penuh diaktifkan');
    } else {
        // Exit fullscreen
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }

        readerContainer.classList.remove('fullscreen');
        document.body.classList.remove('fullscreen-mode');

        // Update buttons
        if (fullscreenBtn) {
            fullscreenBtn.innerHTML = '<i class="fas fa-expand me-2"></i>Layar Penuh';
        }
        if (fullscreenControl) {
            fullscreenControl.innerHTML = '<i class="fas fa-expand"></i>';
        }

        isFullscreen = false;
        console.log('Mode layar penuh dinonaktifkan');
    }
}

function handleFullscreenChange() {
    const readerContainer = document.querySelector('.reader-container-premium');
    const fullscreenBtn = document.getElementById('fullscreen-btn');
    const fullscreenControl = document.getElementById('fullscreen-control');

    if (!document.fullscreenElement &&
        !document.webkitFullscreenElement &&
        !document.mozFullScreenElement &&
        !document.msFullscreenElement) {

        readerContainer.classList.remove('fullscreen');
        document.body.classList.remove('fullscreen-mode');

        if (fullscreenBtn) {
            fullscreenBtn.innerHTML = '<i class="fas fa-expand me-2"></i>Layar Penuh';
        }
        if (fullscreenControl) {
            fullscreenControl.innerHTML = '<i class="fas fa-expand"></i>';
        }

        isFullscreen = false;
    }
}

function setupEventListeners() {
    // Fullscreen button
    const fullscreenBtn = document.getElementById('fullscreen-btn');
    const fullscreenControl = document.getElementById('fullscreen-control');

    if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', toggleFullscreen);
    }

    if (fullscreenControl) {
        fullscreenControl.addEventListener('click', toggleFullscreen);
    }

    // Fullscreen change listeners
    document.addEventListener('fullscreenchange', handleFullscreenChange);
    document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
    document.addEventListener('mozfullscreenchange', handleFullscreenChange);
    document.addEventListener('MSFullscreenChange', handleFullscreenChange);

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F11') {
            e.preventDefault();
            toggleFullscreen();
        } else if (e.key === 'Escape' && isFullscreen) {
            toggleFullscreen();
        } else if (e.key === 'F5') {
            e.preventDefault();
            reloadReader();
        }
    });
}

// Export functions for global access
window.reloadReader = reloadReader;
window.openInNewTab = openInNewTab;
window.toggleFullscreen = toggleFullscreen;
</script>
