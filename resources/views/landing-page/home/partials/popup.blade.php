{{-- Popup Modal - Modern Responsive Design --}}
<div class="popup-overlay" id="popupOverlay">
    <div class="popup-container">
        <div class="popup-content">
            {{-- Close Button --}}
            <button type="button" class="popup-close" id="popupClose" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>

            {{-- Popup Image/Content --}}
            <a href="https://ldksyah.id/ekspresi" rel="noopener noreferrer" target="_blank" class="popup-link">
                <img src="https://lh3.googleusercontent.com/d/1Kf3H9XkdVBKPxlig3rxelbuWOhduz45e"
                     alt="Popup Banner"
                     class="popup-image">
            </a>
        </div>
    </div>
</div>

<style>
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .popup-overlay.show {
        display: flex;
        opacity: 1;
    }

    .popup-container {
        position: relative;
        max-width: 90%;
        max-height: 90vh;
        animation: popupSlideIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes popupSlideIn {
        from {
            opacity: 0;
            transform: scale(0.8) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .popup-content {
        position: relative;
        background: var(--white);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
    }

    .popup-close {
        position: absolute;
        top: -12px;
        right: -12px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--white);
        border: none;
        color: var(--dark);
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        z-index: 10;
    }

    .popup-close:hover {
        background: var(--danger);
        color: var(--white);
        transform: rotate(90deg);
    }

    .popup-link {
        display: block;
        line-height: 0;
    }

    .popup-image {
        width: 100%;
        height: auto;
        max-width: 280px;
        display: block;
        transition: transform 0.3s ease;
    }

    .popup-link:hover .popup-image {
        transform: scale(1.02);
    }

    /* Responsive */
    @media (min-width: 576px) {
        .popup-image {
            max-width: 350px;
        }

        .popup-close {
            top: -15px;
            right: -15px;
            width: 40px;
            height: 40px;
        }
    }

    @media (min-width: 768px) {
        .popup-image {
            max-width: 400px;
        }
    }

    @media (min-width: 992px) {
        .popup-image {
            max-width: 450px;
        }

        .popup-close {
            width: 44px;
            height: 44px;
            font-size: 1.1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const popupOverlay = document.getElementById('popupOverlay');
        const popupClose = document.getElementById('popupClose');

        // Check if popup was already shown in this session
        const popupShown = sessionStorage.getItem('popupShown');

        if (!popupShown && popupOverlay) {
            // Show popup after a short delay
            setTimeout(function() {
                popupOverlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }, 1500);

            // Mark as shown
            sessionStorage.setItem('popupShown', 'true');
        }

        // Close popup handlers
        if (popupClose) {
            popupClose.addEventListener('click', closePopup);
        }

        if (popupOverlay) {
            popupOverlay.addEventListener('click', function(e) {
                if (e.target === popupOverlay) {
                    closePopup();
                }
            });
        }

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && popupOverlay && popupOverlay.classList.contains('show')) {
                closePopup();
            }
        });

        function closePopup() {
            if (popupOverlay) {
                popupOverlay.style.opacity = '0';
                setTimeout(function() {
                    popupOverlay.classList.remove('show');
                    popupOverlay.style.opacity = '';
                    document.body.style.overflow = '';
                }, 300);
            }
        }
    });
</script>
