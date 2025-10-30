<script>
// Global variables
let isFullscreen = false;
let readerFrame = null;
let readerStatus = null;

document.addEventListener('DOMContentLoaded', function() {
    initializeReader();
    setupEventListeners();
});

function initializeReader() {
    readerFrame = document.getElementById('reader-frame');
    readerStatus = document.querySelector('.reader-status');

    if (!readerFrame) {
        console.error('Elemen pembaca tidak ditemukan');
        updateReaderStatus('error', 'Gagal memuat pembaca');
        return;
    }

    // Wait for iframe to load
    readerFrame.addEventListener('load', function() {
        console.log('Buku berhasil dimuat');
        updateReaderStatus('success', 'Buku siap dibaca');
        showSuccessMessage('Buku berhasil dimuat!');
    });

    readerFrame.addEventListener('error', function() {
        console.error('Gagal memuat buku digital');
        updateReaderStatus('error', 'Gagal memuat buku');
        showErrorMessage('Gagal memuat buku. Silakan coba lagi.');
    });

    // Show loading status initially
    updateReaderStatus('loading', 'Memuat buku...');
}

function updateReaderStatus(status, message) {
    if (!readerStatus) return;

    // Remove existing status classes
    readerStatus.classList.remove('status-loading', 'status-success', 'status-error');

    // Add new status class and update text
    readerStatus.classList.add(`status-${status}`);
    readerStatus.textContent = `Status: ${message}`;

    // Update colors based on status
    switch(status) {
        case 'loading':
            readerStatus.style.background = 'var(--warning)';
            readerStatus.style.color = 'var(--dark)';
            break;
        case 'success':
            readerStatus.style.background = 'var(--success)';
            readerStatus.style.color = 'var(--white)';
            break;
        case 'error':
            readerStatus.style.background = 'var(--danger)';
            readerStatus.style.color = 'var(--white)';
            break;
        default:
            readerStatus.style.background = 'var(--primary-light)';
            readerStatus.style.color = 'var(--primary)';
    }
}

function reloadReader() {
    if (readerFrame) {
        updateReaderStatus('loading', 'Memuat ulang...');

        // Add timestamp to prevent caching
        const currentSrc = readerFrame.src.split('?')[0];
        readerFrame.src = currentSrc + '?t=' + new Date().getTime();

        console.log('Memuat ulang buku...');

        // Show loading animation
        const btn = event.target.closest('.btn-control');
        if (btn) {
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            setTimeout(() => {
                btn.innerHTML = '<i class="fas fa-redo"></i>';
            }, 1000);
        }
    }
}

function openInNewTab() {
    const readerUrl = '{{ $book->getReaderLink() }}';
    if (readerUrl) {
        window.open(readerUrl, '_blank', 'noopener,noreferrer');
        console.log('Membuka buku di tab baru');

        // Show feedback
        showSuccessMessage('Membuka di tab baru...');
    } else {
        console.error('URL buku tidak tersedia');
        showErrorMessage('URL buku tidak tersedia');
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
            fullscreenBtn.classList.add('btn-fullscreen-active');
        }
        if (fullscreenControl) {
            fullscreenControl.innerHTML = '<i class="fas fa-compress"></i>';
        }

        isFullscreen = true;
        updateReaderStatus('success', 'Mode Layar Penuh');
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
            fullscreenBtn.classList.remove('btn-fullscreen-active');
        }
        if (fullscreenControl) {
            fullscreenControl.innerHTML = '<i class="fas fa-expand"></i>';
        }

        isFullscreen = false;
        updateReaderStatus('success', 'Buku siap dibaca');
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
            fullscreenBtn.classList.remove('btn-fullscreen-active');
        }
        if (fullscreenControl) {
            fullscreenControl.innerHTML = '<i class="fas fa-expand"></i>';
        }

        isFullscreen = false;
        updateReaderStatus('success', 'Buku siap dibaca');
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
        // Only trigger if not in input fields
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;

        switch(e.key) {
            case 'F11':
                e.preventDefault();
                toggleFullscreen();
                break;
            case 'Escape':
                if (isFullscreen) {
                    e.preventDefault();
                    toggleFullscreen();
                }
                break;
            case 'F5':
                e.preventDefault();
                reloadReader();
                break;
            case 'r':
            case 'R':
                if (e.ctrlKey || e.metaKey) {
                    e.preventDefault();
                    reloadReader();
                }
                break;
        }
    });

    // Add click animation to control buttons
    document.querySelectorAll('.btn-control').forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Add ripple effect
            const ripple = document.createElement('span');
            const rect = btn.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(0, 191, 166, 0.6);
                transform: scale(0);
                animation: ripple 0.6s linear;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
            `;

            btn.style.position = 'relative';
            btn.style.overflow = 'hidden';
            btn.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
}

function showSuccessMessage(message) {
    showMessage(message, 'success');
}

function showErrorMessage(message) {
    showMessage(message, 'error');
}

function showMessage(message, type) {
    // Remove existing messages
    const existingMessage = document.querySelector('.reader-message');
    if (existingMessage) {
        existingMessage.remove();
    }

    const messageEl = document.createElement('div');
    messageEl.className = `reader-message message-${type}`;
    messageEl.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
    `;

    // Add styles
    messageEl.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? 'var(--success)' : 'var(--danger)'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: var(--radius);
        box-shadow: var(--shadow-elegant);
        z-index: 10000;
        font-weight: 600;
        display: flex;
        align-items: center;
        animation: slideInRight 0.3s ease-out;
        max-width: 300px;
    `;

    document.body.appendChild(messageEl);

    // Auto remove after 3 seconds
    setTimeout(() => {
        messageEl.style.animation = 'slideOutRight 0.3s ease-in forwards';
        setTimeout(() => {
            if (messageEl.parentNode) {
                messageEl.remove();
            }
        }, 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

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

    .btn-fullscreen-active {
        background: linear-gradient(135deg, var(--warning) 0%, #ffb300 100%) !important;
        border-color: var(--warning) !important;
    }

    .status-loading {
        position: relative;
        overflow: hidden;
    }

    .status-loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% { left: -100%; }
        100% { left: 100%; }
    }
`;
document.head.appendChild(style);

// Export functions for global access
window.reloadReader = reloadReader;
window.openInNewTab = openInNewTab;
window.toggleFullscreen = toggleFullscreen;
</script>
