{{-- ================================================================
     WELCOME EID FITRI POPUP
     Muncul sekali per browser — ditandai di localStorage.
     Key: ldksyahid_welcome_popup_eid_fitri
     ================================================================ --}}
@include('components.welcome-revamp-popup.styles')

<div id="wrp-backdrop" role="dialog" aria-modal="true" aria-label="Selamat Hari Raya Idul Fitri 1447 Hijriah">
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
                    <span>Eid Mubarak &bull; 1447 Hijriah</span>
                </div>
                <h2>Selamat Hari Raya<br>Idul Fitri 1447 H 🌙</h2>
            </div>

            {{-- Body --}}
            <div id="wrp-body">
                <p id="wrp-desc">
                    Taqabbalallahu minna wa minkum. Semoga Allah ﷻ menerima
                    amal ibadah kita selama Ramadan dan mempertemukan kita
                    kembali di Ramadan berikutnya.
                </p>

                <div id="wrp-features">
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-heart"></i></div>
                        <div class="wrp-feat-text">Mohon maaf lahir dan batin dari keluarga besar LDK Syahid</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-hands-helping"></i></div>
                        <div class="wrp-feat-text">Minal Aidin wal Faizin — semoga kita kembali fitri</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-mosque"></i></div>
                        <div class="wrp-feat-text">Semoga amal ibadah Ramadan kita diterima Allah ﷻ</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-star-and-crescent"></i></div>
                        <div class="wrp-feat-text">Selamat merayakan Lebaran bersama keluarga tercinta</div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div id="wrp-footer">
                <button id="wrp-btn-explore">
                    <i class="fas fa-moon"></i>
                    <span>Eid Mubarak! 🌙</span>
                </button>
                <button id="wrp-btn-dismiss">
                    Jangan tampilkan lagi
                </button>
            </div>

        </div>{{-- /wrp-card --}}
    </div>{{-- /wrp-outer --}}
</div>

@include('components.welcome-revamp-popup.scripts')
