{{-- ================================================================
     WELCOME REVAMP POPUP
     Muncul sekali per browser — ditandai di localStorage.
     Key: ldksyahid_welcome_popup
     ================================================================ --}}
@include('components.welcome-revamp-popup.styles')

<div id="wrp-backdrop" role="dialog" aria-modal="true" aria-label="Selamat datang di tampilan baru LDK Syahid">
    <div id="wrp-outer">

        <div id="wrp-card">

            {{-- Close X --}}
            <button id="wrp-x" aria-label="Tutup popup"><i class="fas fa-times"></i></button>

            {{-- Header --}}
            <div id="wrp-header">
                <span id="wrp-header-dot1"></span>
                <span id="wrp-header-dot2"></span>
                <div id="wrp-badge">
                    <i class="fas fa-star-and-crescent"></i>
                    <span>Alhamdulillah &bull; Pembaruan Terbaru</span>
                </div>
                <h2>Wajah Baru,<br>Manfaat Lebih Luas! 🌙</h2>
            </div>

            {{-- Body --}}
            <div id="wrp-body">
                <p id="wrp-desc">
                    Dengan penuh rasa syukur kehadirat Allah ﷻ, kami mempersembahkan
                    tampilan baru Website LDK Syahid — lebih mudah, lebih nyaman,
                    demi memperluas manfaat dakwah bagi seluruh umat.
                </p>

                <div id="wrp-features">
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-paint-brush"></i></div>
                        <div class="wrp-feat-text">Tampilan bersih mencerminkan nilai-nilai Islam</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-book-open"></i></div>
                        <div class="wrp-feat-text">Akses ilmu &amp; kajian kapanpun, dimanapun</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-search"></i></div>
                        <div class="wrp-feat-text">Cari konten dakwah lebih mudah &amp; cepat</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-heart"></i></div>
                        <div class="wrp-feat-text">Mempererat ukhuwah Islamiyah antar sesama</div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div id="wrp-footer">
                <button id="wrp-btn-explore">
                    <i class="fas fa-rocket"></i>
                    <span>Jelajahi Sekarang</span>
                </button>
            </div>

        </div>{{-- /wrp-card --}}
    </div>{{-- /wrp-outer --}}
</div>

@include('components.welcome-revamp-popup.scripts')
