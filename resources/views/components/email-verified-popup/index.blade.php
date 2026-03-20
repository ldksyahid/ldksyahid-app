{{-- ===== EMAIL VERIFIED SUCCESS POPUP ===== --}}
<div class="evp-overlay" id="evpOverlay">
    <div class="evp-box" id="evpBox">

        {{-- Close button --}}
        <button class="evp-close" id="evpClose" title="Tutup">
            <i class="fas fa-times"></i>
        </button>

        {{-- Success icon with rings --}}
        <div class="evp-icon-wrap">
            <div class="evp-icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="evp-ring evp-ring-1"></div>
            <div class="evp-ring evp-ring-2"></div>
            <div class="evp-ring evp-ring-3"></div>
        </div>

        {{-- Confetti dots --}}
        <div class="evp-confetti" aria-hidden="true">
            <span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span>
        </div>

        {{-- Title --}}
        <h3 class="evp-title">Email Terverifikasi! 🎉</h3>
        <p class="evp-subtitle">
            Alhamdulillah, akun kamu di <strong style="color:var(--primary);">LDK Syahid</strong> sudah aktif sepenuhnya.
            Yuk mulai jelajahi semua fitur kami!
        </p>

        {{-- Features --}}
        <div class="evp-features">
            <div class="evp-feature">
                <span class="evp-feature-icon">📖</span>
                <span>Akses Katalog Buku</span>
            </div>
            <div class="evp-feature">
                <span class="evp-feature-icon">🕌</span>
                <span>Ikuti Event LDK</span>
            </div>
            <div class="evp-feature">
                <span class="evp-feature-icon">📰</span>
                <span>Baca Artikel</span>
            </div>
        </div>

        {{-- CTA --}}
        <button class="evp-btn" id="evpBtn">
            <span class="evp-btn-shine"></span>
            <i class="fas fa-compass"></i>
            Mulai Jelajahi
        </button>


    </div>
</div>

@include('components.email-verified-popup.styles')
@include('components.email-verified-popup.scripts')
