{{-- ================================================================
     WELCOME 17 AGUSTUS — HUT RI KE-81 POPUP
     Appears once per browser — marked in localStorage.
     Key: ldksyahid_welcome_popup_17agustus_2026
     ================================================================ --}}
@include('components.welcome-revamp-popup.styles')

<div id="wrp-backdrop" role="dialog" aria-modal="true" aria-label="Dirgahayu Republik Indonesia ke-81">
    <div id="wrp-outer">
        <div id="wrp-card">

            {{-- Close X --}}
            <button id="wrp-x" aria-label="Tutup popup"><i class="fas fa-times"></i></button>

            {{-- Header --}}
            <div id="wrp-header">
                <canvas id="wrp-moon-canvas"></canvas>
                <div id="wrp-badge">
                    <i class="fas fa-flag"></i>
                    <span>17 Agustus &bull; HUT RI ke-81</span>
                </div>
                <h2>Dirgahayu Republik<br>Indonesia! 🇮🇩✨</h2>
                <p>Semoga semangat kemerdekaan membakar cita,<br>ilmu yang terus berkobar, dan dakwah yang makin berkibar.</p>
            </div>

            {{-- Body --}}
            <div id="wrp-body">

                {{-- Mini Game --}}
                <div id="wrp-game-area">
                    <div id="wrp-game-label">
                        <i class="fas fa-fire"></i> Nyalakan Kembang Api Kemerdekaan!
                    </div>
                    <canvas id="wrp-canvas" aria-label="Mini game tangkap percikan kembang api"></canvas>
                    <div id="wrp-score-row">
                        <span id="wrp-score"><i class="fas fa-star"></i> <span id="wrp-score-val">0</span> percikan</span>
                        <span id="wrp-timer"><i class="fas fa-clock"></i> <span id="wrp-timer-val">15</span>s</span>
                    </div>
                    <div id="wrp-game-msg">Klik percikan kembang api yang jatuh secepat mungkin!</div>
                </div>

                {{-- Feature Cards --}}
                <div id="wrp-features">
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-flag"></i></div>
                        <div class="wrp-feat-text"><strong>17 Agustus 1945</strong> — momentum perjuangan yang mengajarkan kita arti pengorbanan dan persatuan.</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-bolt"></i></div>
                        <div class="wrp-feat-text">Isi kemerdekaan dengan <strong>karya dan dakwah</strong> — merdeka bukan cuma dari penjajah, tapi juga dari kemalasan berbuat baik. 🔥</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-users"></i></div>
                        <div class="wrp-feat-text">LDK Syahid bersama seluruh kader mengucapkan — <strong>Dirgahayu Indonesia, Merdeka!</strong> 🇮🇩</div>
                    </div>
                </div>

            </div>{{-- /wrp-body --}}

            {{-- Footer --}}
            <div id="wrp-footer">
                <button id="wrp-btn-share">
                    <i class="fas fa-share-alt"></i>
                    <span>Bagikan Semangat Kemerdekaan!</span>
                </button>
                <div id="wrp-share-fallback">
                    Salin link ini:
                    <a href="https://ldksyahid.com" target="_blank" rel="noopener noreferrer">ldksyahid.com</a>
                    lalu bagikan ke Story atau WA kamu! 🇮🇩
                </div>
                <button id="wrp-btn-dismiss">Jangan tampilkan lagi</button>
            </div>

        </div>{{-- /wrp-card --}}
    </div>{{-- /wrp-outer --}}
</div>

@include('components.welcome-revamp-popup.scripts')