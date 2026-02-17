@if(Auth::check() && Auth::user()->email_verified_at == null)

{{-- ===== VERIFY EMAIL POPUP MODAL ===== --}}
<div class="vepm-overlay" id="vepOverlay">
    <div class="vepm-box" id="vepBox">

        {{-- Close button --}}
        <button class="vepm-close" id="vepClose" title="Tutup sementara">
            <i class="fas fa-times"></i>
        </button>

        {{-- Badge --}}
        <div class="vepm-badge">
            <span>✉️</span>
            <span>Verifikasi Email</span>
            <span class="vepm-pulse"></span>
        </div>

        {{-- Icon --}}
        <div class="vepm-icon-wrap">
            <div class="vepm-icon-orbit">
                <span class="vepm-orbit-dot" style="--d:0s">✨</span>
                <span class="vepm-orbit-dot" style="--d:1.2s">⭐</span>
                <span class="vepm-orbit-dot" style="--d:2.4s">💫</span>
            </div>
            <div class="vepm-icon">
                <i class="fas fa-envelope-open-text"></i>
            </div>
            <div class="vepm-ring vepm-ring-1"></div>
            <div class="vepm-ring vepm-ring-2"></div>
        </div>

        {{-- Title --}}
        <h3 class="vepm-title">Satu Langkah Lagi! 🚀</h3>
        <p class="vepm-subtitle">Kami telah mengirimkan link verifikasi ke</p>

        {{-- Email chip --}}
        <div class="vepm-email-chip">
            <span>{{ Auth::user()->email }}</span>
        </div>

        <p class="vepm-hint">Buka email kamu dan klik link verifikasi untuk mengaktifkan akun.</p>

        {{-- Steps --}}
        <div class="vepm-steps">
            <div class="vepm-step">
                <div class="vepm-step-icon">📬</div>
                <span>Buka Email</span>
            </div>
            <div class="vepm-step-arrow"><i class="fas fa-chevron-right"></i></div>
            <div class="vepm-step">
                <div class="vepm-step-icon">🔗</div>
                <span>Klik Link</span>
            </div>
            <div class="vepm-step-arrow"><i class="fas fa-chevron-right"></i></div>
            <div class="vepm-step">
                <div class="vepm-step-icon">🎉</div>
                <span>Akun Aktif!</span>
            </div>
        </div>

        {{-- Divider --}}
        <div class="vepm-divider"></div>

        {{-- Resend --}}
        <p class="vepm-resend-label">Tidak menerima email?</p>
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="vepm-resend-btn">
                <span class="vepm-btn-icon"><i class="fas fa-paper-plane"></i></span>
                <span>Kirim Ulang Email</span>
                <div class="vepm-btn-shine"></div>
            </button>
        </form>

        {{-- Success --}}
        @if (session('resent'))
        <div class="vepm-success">
            <span>🎊</span>
            <div><strong>Terkirim!</strong> Segera periksa inbox kamu ya!</div>
        </div>
        @endif

        {{-- Note --}}
        <div class="vepm-note">
            <i class="fas fa-circle-info"></i>
            Jika belum menerima setelah kirim ulang, coba lagi besok karena ada batas pengiriman dari server.
        </div>

    </div>
</div>

<style>
    /* ===== VERIFY EMAIL POPUP MODAL ===== */
    .vepm-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        z-index: 10050;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        animation: vepmFadeIn 0.35s ease;
    }

    @keyframes vepmFadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    .vepm-box {
        position: relative;
        background: white;
        border-radius: 28px;
        padding: 2.5rem 2rem 2rem;
        max-width: 540px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        text-align: center;
        box-shadow: 0 24px 80px rgba(0, 0, 0, 0.18), 0 8px 30px rgba(0,167,157,0.12);
        border: 1px solid rgba(0,167,157,0.1);
        animation: vepmSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        scrollbar-width: thin;
        scrollbar-color: rgba(0,167,157,0.2) transparent;
    }

    .vepm-box::before {
        content: '';
        position: absolute;
        top: 0; left: 10%; right: 10%;
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, rgba(0,167,157,0.4) 30%, rgba(0,167,157,0.4) 70%, transparent 100%);
        filter: blur(1px);
    }

    @keyframes vepmSlideIn {
        from { opacity: 0; transform: translateY(40px) scale(0.94); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Close */
    .vepm-close {
        position: absolute;
        top: 1rem; right: 1rem;
        width: 34px; height: 34px;
        background: #f5f5f5;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--secondary);
        font-size: 0.85rem;
        transition: var(--transition-bounce);
        z-index: 10;
    }

    @media (hover: hover) {
        .vepm-close:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: scale(1.1) rotate(90deg);
        }
    }

    /* Badge */
    .vepm-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        border: 1px solid rgba(0,167,157,0.2);
        border-radius: 50px;
        padding: 0.4rem 1.1rem;
        margin-bottom: 1.5rem;
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--primary);
    }

    .vepm-pulse {
        width: 7px; height: 7px;
        background: var(--primary);
        border-radius: 50%;
        animation: badgePulse 2s ease-in-out infinite;
    }

    /* Icon */
    .vepm-icon-wrap {
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
    }

    .vepm-icon {
        width: 80px; height: 80px;
        background: var(--primary-gradient);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        box-shadow: var(--shadow-primary);
        position: relative;
        z-index: 2;
        animation: veIconBounce 3s ease-in-out infinite;
    }

    .vepm-ring {
        position: absolute;
        border-radius: 50%;
        border: 2px solid rgba(0,167,157,0.12);
        top: 50%; left: 50%;
        animation: veRingExpand 3s ease-out infinite;
    }
    .vepm-ring-1 { width: 120px; height: 120px; animation-delay: 0s; }
    .vepm-ring-2 { width: 155px; height: 155px; animation-delay: 0.9s; }

    /* Orbit dots */
    .vepm-icon-orbit {
        position: absolute;
        inset: -20px;
        animation: orbitSpin 14s linear infinite;
        z-index: 3;
    }
    .vepm-orbit-dot {
        position: absolute;
        font-size: 0.9rem;
        animation: orbitDotPulse 3s ease-in-out infinite;
        animation-delay: var(--d);
    }
    .vepm-orbit-dot:nth-child(1) { top: 0; left: 50%; transform: translateX(-50%); }
    .vepm-orbit-dot:nth-child(2) { bottom: 4px; left: 0; }
    .vepm-orbit-dot:nth-child(3) { bottom: 4px; right: 0; }

    /* Text */
    .vepm-title {
        font-family: var(--font-primary);
        font-size: 1.45rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.4rem;
    }

    .vepm-subtitle {
        color: var(--secondary);
        font-size: 0.9rem;
        margin-bottom: 0.65rem;
    }

    .vepm-email-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        background: var(--primary-light);
        border: 1px solid rgba(0,167,157,0.2);
        border-radius: 50px;
        padding: 0.45rem 1.1rem;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.88rem;
        margin-bottom: 0.6rem;
        word-break: break-all;
    }
    .vepm-email-chip i { color: var(--primary); font-size: 0.8rem; }

    .vepm-hint {
        color: var(--secondary);
        font-size: 0.85rem;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    /* Steps */
    .vepm-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    .vepm-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.35rem;
    }
    .vepm-step-icon {
        width: 46px; height: 46px;
        background: var(--primary-light);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        border: 1px solid rgba(0,167,157,0.12);
        transition: var(--transition-bounce);
    }
    .vepm-step:hover .vepm-step-icon {
        transform: translateY(-4px);
        box-shadow: 0 6px 16px rgba(0,167,157,0.14);
    }
    .vepm-step span {
        font-size: 0.68rem;
        font-weight: 600;
        color: var(--secondary);
    }
    .vepm-step-arrow {
        color: rgba(0,167,157,0.35);
        font-size: 0.75rem;
        margin-top: -12px;
    }

    /* Divider */
    .vepm-divider {
        width: 100%; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(0,167,157,0.15), transparent);
        margin: 0 0 1.25rem;
    }

    /* Resend */
    .vepm-resend-label {
        color: var(--secondary);
        font-size: 0.85rem;
        margin-bottom: 0.65rem;
    }

    .vepm-resend-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.7rem 1.75rem;
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 0.92rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: var(--shadow-primary);
        transition: var(--transition-bounce);
        position: relative;
        overflow: hidden;
    }

    .vepm-btn-icon {
        width: 26px; height: 26px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        transition: var(--transition);
    }

    .vepm-btn-shine {
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s ease;
    }

    @media (hover: hover) {
        .vepm-resend-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 28px rgba(0,167,157,0.3);
        }
        .vepm-resend-btn:hover .vepm-btn-icon { transform: rotate(-20deg) scale(1.1); }
        .vepm-resend-btn:hover .vepm-btn-shine { left: 100%; }
    }

    /* Success */
    .vepm-success {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        background: linear-gradient(135deg, #e8fdf5, #d0faf0);
        border: 1px solid rgba(0,167,157,0.2);
        border-radius: 12px;
        padding: 0.85rem 1rem;
        margin-top: 1rem;
        text-align: left;
        font-size: 0.85rem;
        color: var(--dark);
        animation: veSuccessIn 0.4s cubic-bezier(0.4,0,0.2,1);
    }
    .vepm-success span { font-size: 1.4rem; flex-shrink: 0; }

    /* Note */
    .vepm-note {
        display: flex;
        align-items: flex-start;
        gap: 0.45rem;
        margin-top: 1.25rem;
        padding: 0.75rem 0.9rem;
        background: #f8f9fa;
        border-radius: 10px;
        font-size: 0.77rem;
        color: var(--secondary);
        text-align: left;
        line-height: 1.5;
    }
    .vepm-note i { color: var(--primary); margin-top: 2px; flex-shrink: 0; }

    /* Responsive */
    @media (max-width: 575.98px) {
        .vepm-box { padding: 2rem 1.25rem 1.75rem; border-radius: 22px; }
        .vepm-title { font-size: 1.25rem; }
        .vepm-icon { width: 68px; height: 68px; font-size: 1.7rem; }
        .vepm-steps { gap: 0.4rem; }
        .vepm-step-icon { width: 40px; height: 40px; font-size: 1.15rem; }
    }
</style>

<style>
    /* Suppress back-to-top while modal is visible */
    .back-to-top.vepm-suppressed {
        opacity: 0 !important;
        visibility: hidden !important;
        transform: translateY(8px) scale(0.85) !important;
        transition: opacity 0.35s ease, visibility 0.35s ease, transform 0.35s ease !important;
        pointer-events: none !important;
    }
    @keyframes vepmFadeOut { to { opacity: 0; } }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.getElementById('vepOverlay');
    const closeBtn = document.getElementById('vepClose');
    const backToTop = document.querySelector('.back-to-top');
    if (!overlay) return;

    // Hide back-to-top & disable scroll while modal is open
    if (backToTop) backToTop.classList.add('vepm-suppressed');
    document.body.style.overflow = 'hidden';

    function closeModal() {
        overlay.style.animation = 'vepmFadeOut 0.3s ease forwards';
        document.body.style.overflow = '';
        // Restore back-to-top smoothly after modal fades out
        if (backToTop) {
            setTimeout(() => backToTop.classList.remove('vepm-suppressed'), 250);
        }
        setTimeout(() => overlay.style.display = 'none', 320);
    }

    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) closeModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
});
</script>

@endif
