{{-- ================================================================
     WELCOME MUHARRAM 1448 H POPUP
     Appears once per browser — marked in localStorage.
     Key: ldksyahid_welcome_popup_muharram_1448
     ================================================================ --}}
@include('components.welcome-revamp-popup.styles')

<div id="wrp-backdrop" role="dialog" aria-modal="true" aria-label="Selamat Tahun Baru Hijriyah 1448 H">
    <div id="wrp-outer">
        <div id="wrp-card">

            {{-- Close X --}}
            <button id="wrp-x" aria-label="Tutup popup"><i class="fas fa-times"></i></button>

            {{-- Header --}}
            <div id="wrp-header">
                <canvas id="wrp-moon-canvas"></canvas>
                <div id="wrp-badge">
                    <i class="fas fa-moon"></i>
                    <span>1 Muharram &bull; 1448 H</span>
                </div>
                <h2>Selamat Tahun Baru<br>Hijriyah 1448 H 🌙✨</h2>
                <p>Semoga tahun ini membawa hijrah yang lebih baik,<br>ilmu yang lebih dalam, dan dakwah yang terus menyala.</p>
            </div>

            {{-- Body --}}
            <div id="wrp-body">

                {{-- Mini Game --}}
                <div id="wrp-game-area">
                    <div id="wrp-game-label">
                        <i class="fas fa-star"></i> Tangkap Bintang Harapan!
                    </div>
                    <canvas id="wrp-canvas" aria-label="Mini game tangkap bintang jatuh"></canvas>
                    <div id="wrp-score-row">
                        <span id="wrp-score"><i class="fas fa-star"></i> <span id="wrp-score-val">0</span> bintang</span>
                        <span id="wrp-timer"><i class="fas fa-clock"></i> <span id="wrp-timer-val">15</span>s</span>
                    </div>
                    <div id="wrp-game-msg">Klik bintang yang jatuh secepat mungkin!</div>
                </div>

                {{-- Feature Cards --}}
                <div id="wrp-features">
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-moon"></i></div>
                        <div class="wrp-feat-text"><strong>Muharram</strong> adalah bulan Allah yang dimuliakan — momentum terbaik untuk niat dan langkah baru.</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-tint"></i></div>
                        <div class="wrp-feat-text">Jangan lupa <strong>puasa Asyura</strong> (10 Muharram) — menghapus dosa setahun yang lalu. 🤲</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-users"></i></div>
                        <div class="wrp-feat-text">LDK Syahid bersama seluruh kader mengucapkan — <strong>Kull 'am wa antum bikhair.</strong> 💙</div>
                    </div>
                </div>

            </div>{{-- /wrp-body --}}

            {{-- Footer --}}
            <div id="wrp-footer">
                <button id="wrp-btn-share">
                    <i class="fas fa-share-alt"></i>
                    <span>Bagikan Semangat Muharram!</span>
                </button>
                <div id="wrp-share-fallback">
                    Salin link ini:
                    <a href="https://ldksyahid.com" target="_blank" rel="noopener noreferrer">ldksyahid.com</a>
                    lalu bagikan ke Story atau WA kamu! 🌙
                </div>
                <button id="wrp-btn-dismiss">Jangan tampilkan lagi</button>
            </div>

        </div>{{-- /wrp-card --}}
    </div>{{-- /wrp-outer --}}
</div>

@include('components.welcome-revamp-popup.scripts')