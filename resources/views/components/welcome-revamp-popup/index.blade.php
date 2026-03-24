{{-- ================================================================
     WELCOME SYAWAL FASTING POPUP
     Appears once per browser — marked in localStorage.
     Key: ldksyahid_welcome_popup_syawal_fasting
     ================================================================ --}}
@include('components.welcome-revamp-popup.styles')

<div id="wrp-backdrop" role="dialog" aria-modal="true" aria-label="Ajakan Puasa Syawal 6 Hari">
    <div id="wrp-outer">

        <div id="wrp-card">

            {{-- Close X --}}
            <button id="wrp-x" aria-label="Tutup popup"><i class="fas fa-times"></i></button>

            {{-- Header --}}
            <div id="wrp-header">
                <span id="wrp-header-dot1"></span>
                <span id="wrp-header-dot2"></span>
                <div id="wrp-badge">
                    <i class="fas fa-moon"></i>
                    <span>Puasa Syawal &bull; 6 Hari</span>
                </div>
                <h2>Bestie, jangan lupa<br>puasa Syawal yaa! 🌙✨</h2>
            </div>

            {{-- Body --}}
            <div id="wrp-body">
                <p id="wrp-desc">
                    6 hari puasa Syawal = pahala puasa <em>setahun penuh</em>!
                    That's literally insane bestie — Ramadan udah kelar
                    tapi bonus pahalanya masih ada loh 🙏
                </p>

                <div id="wrp-features">
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-star"></i></div>
                        <div class="wrp-feat-text">6 hari = setahun puasa. Literally salah satu deal terbaik di Islam! ✨</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-calendar-check"></i></div>
                        <div class="wrp-feat-text">Mulai 2 Syawal — gaskeun sekarang, jangan sampe kelewat bulannya! 📅</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="wrp-feat-text">Boleh nyicil, gak harus 6 hari berturut-turut — fleksibel banget bestie 🤝</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-fire"></i></div>
                        <div class="wrp-feat-text">Ramadan udah kelar, tapi momentum ibadahnya jangan ikut kelar ya! 🔥</div>
                    </div>
                </div>
            </div>

            {{-- Hadith --}}
            <div id="wrp-hadith">
                <div id="wrp-hadith-arabic">
                    مَنْ صَامَ رَمَضَانَ ثُمَّ أَتْبَعَهُ سِتًّا مِنْ شَوَّالٍ كَانَ كَصِيَامِ الدَّهْرِ
                </div>
                <div id="wrp-hadith-trans">
                    &ldquo;Barangsiapa berpuasa Ramadan kemudian mengikutinya dengan enam hari di bulan Syawal, maka ia seperti berpuasa sepanjang tahun.&rdquo;
                </div>
                <div id="wrp-hadith-source">HR. Muslim, no. 1164</div>
            </div>

            {{-- Footer --}}
            <div id="wrp-footer">
                <button id="wrp-btn-explore">
                    <i class="fas fa-moon"></i>
                    <span>Yuk mulai puasa! 🌙</span>
                </button>
                <button id="wrp-btn-dismiss">
                    Jangan tampilkan lagi
                </button>
            </div>

        </div>{{-- /wrp-card --}}
    </div>{{-- /wrp-outer --}}
</div>

@include('components.welcome-revamp-popup.scripts')
