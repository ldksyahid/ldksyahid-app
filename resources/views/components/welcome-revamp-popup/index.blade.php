{{-- ================================================================
     WELCOME MILAD KE-30 LDK SYAHID POPUP
     Appears once per browser — marked in localStorage.
     Key: ldksyahid_welcome_popup_milad_30
     ================================================================ --}}
@include('components.welcome-revamp-popup.styles')

<div id="wrp-backdrop" role="dialog" aria-modal="true" aria-label="Selamat Milad ke-30 LDK Syahid!">
    <div id="wrp-outer">

        <div id="wrp-card">

            {{-- Close X --}}
            <button id="wrp-x" aria-label="Tutup popup"><i class="fas fa-times"></i></button>

            {{-- Header — flex-shrink:0 supaya tidak terpotong --}}
            <div id="wrp-header">
                <span id="wrp-header-dot1"></span>
                <span id="wrp-header-dot2"></span>
                <div id="wrp-badge">
                    <i class="fas fa-star"></i>
                    <span>Milad &bull; 30 Tahun</span>
                </div>
                <h2>Selamat Milad ke-30<br>LDK Syahid! 🎉✨</h2>
            </div>

            {{-- Body — scrollable --}}
            <div id="wrp-body">
                <p id="wrp-desc">
                    Alhamdulillah, 30 tahun LDK Syahid hadir membersamai dakwah kampus tercinta! 🌿
                    Setiap langkah hari ini, punya dampak untuk esok yang lebih baik. 🌍
                </p>

                <div id="wrp-features">
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-trophy"></i></div>
                        <div class="wrp-feat-text"><strong>3 Dekade Dakwah Kampus!</strong> Dari 28 Mei 1996 hingga hari ini — ribuan kader, satu semangat yang terus menyala. 🔥</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-sun"></i></div>
                        <div class="wrp-feat-text"><strong>"Glimpse of Radiant Years"</strong> — Merawat Hangatnya Ukhuwah, Mengukir Gemilangnya Dakwah. ✨</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-heart"></i></div>
                        <div class="wrp-feat-text">Dakwah ini dibangun bukan oleh satu generasi — tapi oleh hati-hati yang terus menjaga nyalanya hingga hari ini. 💙</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-camera"></i></div>
                        <div class="wrp-feat-text">Yuk jadi bagian dari sejarah 30 tahun ini! Pasang <strong>twibbon</strong> Milad ke-30 dan tunjukkan semangat dakwahmu ke seluruh penjuru! ✊</div>
                    </div>
                </div>

            </div>{{-- /wrp-body --}}

            {{-- Footer — flex-shrink:0 supaya tidak terpotong --}}
            <div id="wrp-footer">
                <button id="wrp-btn-explore">
                    <i class="fas fa-star"></i>
                    <span>Pasang Twibbon Milad ke-30! 🎉</span>
                </button>
                <button id="wrp-btn-dismiss">
                    Jangan tampilkan lagi
                </button>
            </div>

        </div>{{-- /wrp-card --}}
    </div>{{-- /wrp-outer --}}
</div>

@include('components.welcome-revamp-popup.scripts')
