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
                        <div class="wrp-feat-text"><strong>Kepala Batu itu Berkah lho!</strong> <span class="wrp-lyric">"Karena ini yang kumau, berkah kepala yang batu"</span> Teguh di jalan kebaikan? That's literally azimah — sunnah banget, no cap! 💪</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-hands"></i></div>
                        <div class="wrp-feat-text"><strong>Doa Mereka di Setiap Malammu!</strong> <span class="wrp-lyric">"Tertulis jelas namamu, di setiap harap malammu"</span> Orang tuamu nyebut namamu tiap malam gaes — itu bahan bakar yang paling W! 🤲</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-book-open"></i></div>
                        <div class="wrp-feat-text"><strong>Tinggalkan Sesuatu yang Nyata!</strong> <span class="wrp-lyric">"Warisan akal budi gemilang"</span> Bukan follower atau views yang dikenang — tapi ilmu yang bermanfaat &amp; akhlak yang baik. Real legacy! 📚</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-sun"></i></div>
                        <div class="wrp-feat-text"><strong>Pelan-Pelan, Pasti Sampai!</strong> <span class="wrp-lyric">"Pelan pasti ku kabulkan segala catatan harapmu"</span> Jalan kamu mungkin belum selesai, tapi arah kamu udah bener gaes. Keep going! ☀️</div>
                    </div>
                </div>

                {{-- Pesan dari Sesama ──────────────────────────── --}}
                <div id="wrp-msg-section">

                    <div id="wrp-msg-heading">
                        <i class="fas fa-comment-dots"></i>
                        <span>Ada Titipan Semangat Buatmu 💛</span>
                    </div>

                    {{-- Daftar pesan --}}
                    <div id="wrp-msg-list">
                        <div id="wrp-msg-empty">Belum ada yang nitip semangat nih — kamu duluan dong! 🌟</div>
                    </div>

                    <button id="wrp-msg-load-more" style="display:none">
                        Lihat semangat lainnya <i class="fas fa-chevron-down"></i>
                    </button>

                    {{-- Divider --}}
                    <div id="wrp-msg-divider">
                        <span><i class="fas fa-pen-nib"></i> Giliran Kamu Nitip ✨</span>
                    </div>

                    {{-- Form kirim pesan --}}
                    <form id="wrp-msg-form" novalidate data-no-global-loading>
                        @csrf
                        <div id="wrp-msg-form-fields">
                            <input  id="wrp-msg-name"    type="text"     maxlength="80"  placeholder="Namamu siapa? 😊" autocomplete="off" />
                            <textarea id="wrp-msg-text"  maxlength="300" placeholder="Titip kata semangat buat temanmu... 🌟" rows="2"></textarea>
                        </div>
                        <div id="wrp-msg-form-footer">
                            <span id="wrp-msg-char">0/300</span>
                            <button type="submit" id="wrp-msg-submit">
                                <i class="fas fa-paper-plane"></i> Titip!
                            </button>
                        </div>
                        <div id="wrp-msg-feedback"></div>
                    </form>

                </div>{{-- /wrp-msg-section --}}

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
