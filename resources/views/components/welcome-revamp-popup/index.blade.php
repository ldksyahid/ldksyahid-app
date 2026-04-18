{{-- ================================================================
     WELCOME SELF-REWARD POPUP
     Appears once per browser — marked in localStorage.
     Key: ldksyahid_welcome_popup_self_reward
     ================================================================ --}}
@include('components.welcome-revamp-popup.styles')

<div id="wrp-backdrop" role="dialog" aria-modal="true" aria-label="Manajemen Self-Reward yang Berkah">
    <div id="wrp-outer">

        <div id="wrp-card">

            {{-- Close X --}}
            <button id="wrp-x" aria-label="Tutup popup"><i class="fas fa-times"></i></button>

            {{-- Header --}}
            <div id="wrp-header">
                <span id="wrp-header-dot1"></span>
                <span id="wrp-header-dot2"></span>
                <div id="wrp-badge">
                    <i class="fas fa-star"></i>
                    <span>Gaya Hidup &bull; Self-Reward</span>
                </div>
                <h2>Gaes, udah capek? Gaskeun<br>self-reward yang berkah! 💙✨</h2>
            </div>

            {{-- Body --}}
            <div id="wrp-body">
                <p id="wrp-desc">
                    Self-reward itu bukan hal yang guilty loh gaes — it's literally
                    self-care! Yang penting reward-mu berkah dan gak bikin dompet
                    nangis <em>fr fr</em> 😭🙏
                </p>

                <div id="wrp-features">
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="wrp-feat-text">Self-reward halal itu valid banget! Niatkan sebagai bentuk syukur — bukan flexing doang, no cap ✨</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-heart"></i></div>
                        <div class="wrp-feat-text">Istirahat yang ikhlas itu hits different — menjaga diri sendiri literally bagian dari ibadah gaes 💫</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-utensils"></i></div>
                        <div class="wrp-feat-text">Makan enak yang halal, nongkrong sama squad, atau upgrade skill — that's a W reward fr! 🏆</div>
                    </div>
                    <div class="wrp-feat">
                        <div class="wrp-feat-icon"><i class="fas fa-balance-scale"></i></div>
                        <div class="wrp-feat-text">Jangan sampe reward-mu jadi red flag buat ibadah & tanggung jawab — stay balanced, gaes! ⚖️</div>
                    </div>
                </div>

                {{-- Hadith --}}
                <div id="wrp-hadith">
                    <div id="wrp-hadith-arabic">
                        إِنَّ لِنَفْسِكَ عَلَيْكَ حَقًّا
                    </div>
                    <div id="wrp-hadith-trans">
                        &ldquo;Sesungguhnya dirimu memiliki hak atas dirimu.&rdquo;
                    </div>
                    <div id="wrp-hadith-source">HR. Bukhari, no. 1968</div>
                </div>
            </div>

            {{-- Footer --}}
            <div id="wrp-footer">
                <button id="wrp-btn-explore">
                    <i class="fas fa-star"></i>
                    <span>Slay dengan cara berkah! 💙</span>
                </button>
                <button id="wrp-btn-dismiss">
                    Jangan tampilkan lagi
                </button>
            </div>

        </div>{{-- /wrp-card --}}
    </div>{{-- /wrp-outer --}}
</div>

@include('components.welcome-revamp-popup.scripts')
