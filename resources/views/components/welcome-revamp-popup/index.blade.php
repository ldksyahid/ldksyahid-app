{{-- ================================================================
     WELCOME 17 AGUSTUS — HUT RI KE-81 POPUP (REVAMP)
     Appears once per browser — marked in localStorage.
     Key: ldksyahid_welcome_popup_17agustus_2026
     ================================================================ --}}
@include('components.welcome-revamp-popup.styles')

<div id="wrp-backdrop" role="dialog" aria-modal="true" aria-label="Dirgahayu Republik Indonesia ke-81">
    {{-- Full-screen fireworks/confetti layer --}}
    <canvas id="wrp-confetti-canvas" aria-hidden="true"></canvas>

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
                <p>Semangat kemerdekaan membakar cita,<br>ilmu yang terus berkobar, dan dakwah yang makin berkibar.</p>
            </div>

            {{-- Body --}}
            <div id="wrp-body">

                {{-- Kado HUT RI ke-81 (Reveal Surprise) --}}
                <div id="wrp-gift">
                    <div id="wrp-gift-box" tabindex="0" role="button" aria-label="Buka kado HUT RI ke-81">
                        <div id="wrp-gift-lid"><i class="fas fa-gift"></i></div>
                        <div id="wrp-gift-body"><i class="fas fa-ribbon"></i></div>
                        <div id="wrp-gift-hint">Klik untuk membuka kado 🎁</div>
                    </div>
                    <div id="wrp-gift-reveal" hidden>
                        <div id="wrp-gift-card">
                            <div id="wrp-gift-card-emblem">🇮🇩</div>
                            <h3>Terkadang dari LDK Syahid ✨</h3>
                            <p id="wrp-gift-card-message">
                                Dirgahayu Republik Indonesia ke-81! Semoga negeri ini diberkahi Allah, dipersatukan dalam keberagaman, dijauhkan dari segala fitnah, dan dipimpin oleh amanah yang membawa kesejahteraan. Aamiin. 🤲🇮🇩
                            </p>
                            <div id="wrp-gift-card-doa">
                                <strong>Doa untuk Negeri:</strong><br>
                                "Ya Allah, rahmati dan lindungi Indonesia. Karuniakan keadilan, persatuan, dan kemakmuran bagi seluruh rakyatnya. Aamiin ya Rabbal 'Alamin." 🤲
                            </div>
                            <button id="wrp-btn-gift-share">
                                <i class="fas fa-heart"></i>
                                <span>Terima Kadonya &amp; Bagikan</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Mini Game --}}
                <div id="wrp-game-area">
                    <div id="wrp-game-top">
                        <div id="wrp-game-label">
                            <i class="fas fa-fire"></i> Nyalakan Kembang Api Kemerdekaan!
                        </div>
                        <div id="wrp-best"><i class="fas fa-trophy"></i> <span id="wrp-best-val">0</span></div>
                    </div>
                    <canvas id="wrp-canvas" aria-label="Mini game tangkap percikan kembang api"></canvas>
                    <div id="wrp-score-row">
                        <span id="wrp-score"><i class="fas fa-star"></i> <span id="wrp-score-val">0</span> percikan</span>
                        <span id="wrp-combo"><i class="fas fa-fire"></i> combo <span id="wrp-combo-val">0</span></span>
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
                <div id="wrp-share-row">
                    <button id="wrp-share-copy" class="wrp-share-btn" title="Salin link">
                        <i class="fas fa-copy"></i><span>Salin</span>
                    </button>
                    <button id="wrp-share-wa" class="wrp-share-btn" title="Bagikan ke WhatsApp">
                        <i class="fab fa-whatsapp"></i><span>WA</span>
                    </button>
                    <button id="wrp-share-fb" class="wrp-share-btn" title="Bagikan ke Facebook">
                        <i class="fab fa-facebook-f"></i><span>FB</span>
                    </button>
                    <button id="wrp-share-x" class="wrp-share-btn" title="Bagikan ke X">
                        <i class="fab fa-twitter"></i><span>X</span>
                    </button>
                </div>
                <div id="wrp-share-fallback">
                    Salin link ini: <b>ldksyahid.com</b> lalu bagikan ke Story atau WA kamu! 🇮🇩
                </div>
                <button id="wrp-btn-dismiss">Jangan tampilkan lagi</button>
            </div>

        </div>{{-- /wrp-card --}}
    </div>{{-- /wrp-outer --}}
</div>

@include('components.welcome-revamp-popup.scripts')
