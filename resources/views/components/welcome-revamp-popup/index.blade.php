{{-- ================================================================
     WELCOME QURBAN POPUP
     Appears once per browser — marked in localStorage.
     Key: ldksyahid_welcome_popup_qurban
     ================================================================ --}}
@include('components.welcome-revamp-popup.styles')

<div id="wrp-backdrop" role="dialog" aria-modal="true" aria-label="Yuk Qurban Bareng!">
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
                    <span>Ibadah &bull; Qurban</span>
                </div>
                <h2>Bestie, yuk qurban bareng!<br>Jangan cuma rebahan doang 🐐</h2>
            </div>

            {{-- Body — scrollable --}}
            <div id="wrp-body">
                <p id="wrp-desc">
                    Qurban itu ibadah paling W bestie — niatnya lillah, manfaatnya buat
                    sesama, pahalanya? <em>No cap</em>, gak ada habisnya! 🙏✨
                </p>

                <div id="wrp-features">
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-heart"></i></div>
                        <div class="wrp-feat-text">Qurban itu bentuk cinta ke Allah yang hits different — sunnah Nabi Ibrahim yang vibes-nya masih relevan sampe sekarang! 💜</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-users"></i></div>
                        <div class="wrp-feat-text">Daging qurban-mu nyebar ke seluruh penjuru — literally jadi berkah buat saudara kita yang butuh, no cap! 🌍</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-coins"></i></div>
                        <div class="wrp-feat-text">Bisa patungan bareng squad! Sapi dibagi 7, kambing sendiri — investasi akhirat yang paling worth it fr fr 💰</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-calendar-check"></i></div>
                        <div class="wrp-feat-text">Idul Adha udah deket gaes — jangan sampe kelewatan momen ibadah yang satu ini, yuk gas! 📅</div>
                    </div>
                </div>

                {{-- Mini Game: Kambing Runner (Chrome Dino style) --}}
                <div id="wrp-minigame">
                    <div id="wrp-game-label">🐐 Kambing Runner — loncat hindari halangan!</div>
                    <canvas id="wrp-dino-canvas"></canvas>
                    <p id="wrp-game-hint">Tap kanvas atau tekan Spasi &bull; Double jump OK!</p>
                </div>

            </div>{{-- /wrp-body --}}

            {{-- Footer — flex-shrink:0 supaya tidak terpotong --}}
            <div id="wrp-footer">
                <button id="wrp-btn-explore">
                    <i class="fas fa-star"></i>
                    <span>Gaspol Qurban Sekarang! 🐐🔥</span>
                </button>
                <button id="wrp-btn-dismiss">
                    Jangan tampilkan lagi
                </button>
            </div>

        </div>{{-- /wrp-card --}}
    </div>{{-- /wrp-outer --}}
</div>

@include('components.welcome-revamp-popup.scripts')
