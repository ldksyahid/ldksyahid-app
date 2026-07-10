{{-- ================================================================
     WELCOME GEMILANG POPUP
     Concept: "Gemilang" (Perunggu) — Istiqomah, Doa Orang Tua, Masa Terang
     Appears once per browser — marked in localStorage.
     Key: ldksyahid_welcome_popup_gemilang_2026
     ================================================================ --}}
@include('components.welcome-revamp-popup.styles')

<div id="wrp-backdrop" role="dialog" aria-modal="true" aria-label="Tentang Masa Terang Milikmu">
    <div id="wrp-outer">
        <div id="wrp-card">

            {{-- Close X --}}
            <button id="wrp-x" aria-label="Tutup popup"><i class="fas fa-times"></i></button>

            {{-- Header --}}
            <div id="wrp-header">
                <span id="wrp-header-dot1"></span>
                <span id="wrp-header-dot2"></span>
                <div id="wrp-badge">
                    <i class="fas fa-music"></i>
                    <span>Perunggu &bull; Gemilang</span>
                </div>
                <h2>Tentang Masa Terang<br>Milikmu, Gaes! ✨</h2>
                <p id="wrp-header-sub">seperti lagu Gemilang — <em>kebul jalan kuterjang</em></p>
            </div>

            {{-- Body --}}
            <div id="wrp-body">
                <p id="wrp-desc">
                    Kayak lirik Perunggu — <em>"terjilat matahari timur yang kejam, sengat melekat di bahuku"</em> — tapi kamu tetep nerjang gaes.
                    Itu bukan lemah, itu <strong>gemilang</strong>. Dan Allah liat semua usahamu. 🌟
                </p>

                <div id="wrp-features">
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-fire"></i></div>
                        <div class="wrp-feat-text"><strong>Berkah Kepala yang Batu!</strong> <span class="wrp-lyric">"Karena ini yang kumau, berkah kepala yang batu"</span> — azimah & istiqomah itu sunnah, no cap! 💪</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-hands"></i></div>
                        <div class="wrp-feat-text"><strong>Doa Orang Tua Hits Different!</strong> <span class="wrp-lyric">"Pasti doamu yang lancarkan upayaku"</span> — Allah dengerin setiap bisikan harap mereka di setiap malam, fr fr! 🤲</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-book-open"></i></div>
                        <div class="wrp-feat-text"><strong>Warisan Akal Budi!</strong> <span class="wrp-lyric">"Warisan akal budi gemilang"</span> — yang diingat dari kita bukan flexnya, tapi ilmu &amp; akhlak. That's the real legacy! 📚</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-sun"></i></div>
                        <div class="wrp-feat-text"><strong>Masa Terang Itu Nyata!</strong> <span class="wrp-lyric">"Tentang masa depan, tentang masa terang"</span> — pelan pasti, jalanmu bakal gemilang banget gaes! ☀️</div>
                    </div>
                </div>

            </div>{{-- /wrp-body --}}

            {{-- Footer --}}
            <div id="wrp-footer">
                <button id="wrp-btn-explore">
                    <i class="fas fa-share-alt"></i>
                    <span>Bagikan Semangat ke Squad! ✊</span>
                </button>
                <div id="wrp-share-fallback">
                    Salin link ini:
                    <a href="https://ldksyah.id/" target="_blank" rel="noopener noreferrer">ldksyah.id</a>
                    lalu bagikan ke Story atau WA squad kamu!
                </div>
                <button id="wrp-btn-dismiss">Jangan tampilkan lagi</button>
            </div>

        </div>{{-- /wrp-card --}}
    </div>{{-- /wrp-outer --}}
</div>

@include('components.welcome-revamp-popup.scripts')
