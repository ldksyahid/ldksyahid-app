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
        <form method="POST" action="{{ route('verification.resend') }}" id="resendVerificationForm" onsubmit="return handleResendVerification(event);">
            @csrf
            <button type="submit" class="vepm-resend-btn" id="resendBtn">
                <span class="vepm-btn-icon"><i class="fas fa-paper-plane"></i></span>
                <span id="resendBtnText">Kirim Ulang Email</span>
                <div class="vepm-btn-shine"></div>
            </button>
        </form>

        {{-- Message Alert --}}
        <div id="resendMessage" class="vepm-message" style="display: none;"></div>

        {{-- Note --}}
        <div class="vepm-note">
            <i class="fas fa-circle-info"></i>
            Jika belum menerima setelah kirim ulang, coba lagi besok karena ada batas pengiriman dari server.
        </div>

    </div>
</div>

@include('landing-page.home.partials.verify-email.components._index-styles')
@include('landing-page.home.partials.verify-email.components._index-scripts')
@endif
