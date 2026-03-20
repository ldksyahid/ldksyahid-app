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
                    <span>Eid Mubarak &bull; 1447 H</span>
                </div>
                <h2>Hayooo, Lebaran<br>udah tiba bestie! 🌙✨</h2>
            </div>

            {{-- Body --}}
            <div id="wrp-body">
                <p id="wrp-desc">
                    Jujur aja, Ramadan tahun ini cepet banget berlalu 😭
                    Semoga amal kita diterima Allah ﷻ ya — dan beneran deh,
                    mohon maaf lahir batin dari LDK Syahid! 🤍
                </p>

                <div id="wrp-features">
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-heart"></i></div>
                        <div class="wrp-feat-text">Maaf-maafan dulu yuk, no hard feelings! 🤝</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-hands-helping"></i></div>
                        <div class="wrp-feat-text">Minal aidin wal faizin — semoga kita beneran balik fitri 🌿</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-mosque"></i></div>
                        <div class="wrp-feat-text">Ibadah Ramadan kita semoga di-acc Allah ﷻ, aamiin 🙏</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-star-and-crescent"></i></div>
                        <div class="wrp-feat-text">Gas nikmatin Lebaran sama keluarga, jangan lupa THR-nya 😄</div>
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
