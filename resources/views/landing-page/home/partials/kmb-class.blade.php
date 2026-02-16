{{-- KMB Class Section — Interactive with Modal & Bottom Sheet --}}
<section class="kmb2-section py-5" id="kmb-section">

    {{-- Floating Decorations --}}
    <div class="kmb2-bg-decor" aria-hidden="true">
        <span class="kmb2-blob b1"></span>
        <span class="kmb2-blob b2"></span>
        <span class="kmb2-blob b3"></span>
        <span class="kmb2-flt e1">✍️</span>
        <span class="kmb2-flt e2">💡</span>
        <span class="kmb2-flt e3">🎨</span>
        <span class="kmb2-flt e4">🎤</span>
        <span class="kmb2-flt e5">📚</span>
        <span class="kmb2-flt e6">💼</span>
    </div>

    <div class="container position-relative" style="z-index:1;">

        {{-- Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="kmb2-badge">
                <span>🌟</span>
                <span>Yuk Ikut KMB!</span>
                <span class="kmb2-badge-dot"></span>
            </div>
            <h2 class="kmb2-title">
                Kelas Minat Bakat
                <span class="kmb2-title-hl">UKM LDK Syahid</span>
            </h2>
            <p class="kmb2-subtitle">
                Kelas Minat Bakat merupakan kelas yang mewadahi bakat dan minat anggota LDK Syahid
                agar dapat mengembangkan potensinya. <strong>Klik kartu untuk info lengkap!</strong> 👇
            </p>
        </div>

        {{-- Cards --}}
        @php
            $kelas = [
                [
                    'img'      => 'https://lh3.googleusercontent.com/d/1Libi_zhvvc5nC5IU10puFt_p28fRi5vG',
                    'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>',
                    'title'    => 'Kepenulisan Fiksi',
                    'tag'      => 'Kreativitas',
                    'color'    => '#6366f1',
                    'light'    => '#eef2ff',
                    'dark'     => '#4f46e5',
                    'preview'  => 'Tulis cerpen, puisi, novel, dan berbagai karya fiksi lainnya secara kreatif!',
                    'desc'     => 'Merupakan kelas yang akan membantu peserta dalam mengembangkan keterampilannya di bidang fiksi seperti cerpen, puisi, novel, dan sebagainya serta menyiapkan peserta untuk menciptakan sebuah karya tulis di bidang tersebut.',
                ],
                [
                    'img'      => 'https://lh3.googleusercontent.com/d/1tl4ZDZRMmAzi0MOGYJkXk-0WYSLWIBIy',
                    'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
                    'title'    => 'Kepenulisan Non Fiksi',
                    'tag'      => 'Ilmiah',
                    'color'    => '#10b981',
                    'light'    => '#ecfdf5',
                    'dark'     => '#059669',
                    'preview'  => 'Asah kemampuan menulis esai ilmiah, karya tulis, dan kepenulisan berbasis riset!',
                    'desc'     => 'Merupakan kelas yang akan membantu peserta dalam mengembangkan keterampilannya pada kepenulisan berbasis ilmiah dan terstruktur seperti esai ilmiah, karya tulis ilmiah, dan sebagainya.',
                ],
                [
                    'img'      => 'https://lh3.googleusercontent.com/d/16rCOS6itQtju7N6ELYwQpLTkAESQ9PEd',
                    'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>',
                    'title'    => 'Entrepreneur',
                    'tag'      => 'Bisnis',
                    'color'    => '#f59e0b',
                    'light'    => '#fffbeb',
                    'dark'     => '#d97706',
                    'preview'  => 'Wujudkan jiwa wirausaha, bangun unit usaha kompetitif, dan kuasai business plan!',
                    'desc'     => "Merupakan kelas yang akan membahas dan mendiskusikan perihal kewirausahaan, sehingga peserta yang memiliki jiwa entrepreneur atau yang sedang belajar dapat menciptakan unit usaha baru yang kompetitif. Tidak hanya itu, KMB Entrepreneur juga akan membahas mengenai hal-hal mendasar dalam berwirausaha termasuk business plan.",
                ],
                [
                    'img'      => 'https://lh3.googleusercontent.com/d/1lfwpEtfLepTOcmu6DcZlmX-7RY01g_Lv',
                    'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>',
                    'title'    => 'Public Speaking',
                    'tag'      => 'Komunikasi',
                    'color'    => '#ef4444',
                    'light'    => '#fef2f2',
                    'dark'     => '#dc2626',
                    'preview'  => "Percaya diri berbicara di depan umum dan cetak da'i yang komunikatif!",
                    'desc'     => "Merupakan kelas yang akan mewadahi peserta yang berminat dan/atau berbakat dalam public speaking dan mengasah kemampuan peserta untuk dapat berbicara di depan umum hingga mencetak da'i yang mampu berkomunikasi dengan baik.",
                ],
                [
                    'img'      => 'https://lh3.googleusercontent.com/d/126xPzrizaxfbhH0iQj0rjFh9n19JlI3Y',
                    'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r="1" fill="currentColor" stroke="none"/><circle cx="17.5" cy="10.5" r="1" fill="currentColor" stroke="none"/><circle cx="8.5" cy="7.5" r="1" fill="currentColor" stroke="none"/><circle cx="6.5" cy="12.5" r="1" fill="currentColor" stroke="none"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>',
                    'title'    => 'Desain Grafis',
                    'tag'      => 'Visual',
                    'color'    => '#8b5cf6',
                    'light'    => '#f5f3ff',
                    'dark'     => '#7c3aed',
                    'preview'  => 'Ciptakan karya visual dan audio visual yang indah, selaras nilai-nilai Islam!',
                    'desc'     => 'Merupakan kelas yang akan mewadahi minat dan bakat peserta dalam mengembangkan potensinya di bidang desain grafis sehingga mampu dan mahir untuk menciptakan karya visual maupun audio visual yang selaras dengan nilai-nilai Islam.',
                ],
            ];
        @endphp

        <div class="kmb2-grid">
            @foreach($kelas as $i => $item)
            <div class="kmb2-card wow fadeInUp" data-wow-delay="{{ 0.1 + ($i * 0.1) }}s"
                 style="--kc:{{ $item['color'] }};--kl:{{ $item['light'] }};--kd:{{ $item['dark'] }};"
                 onclick="kmbOpen({{ $i }})" role="button" tabindex="0"
                 onkeydown="if(event.key==='Enter'||event.key===' ')kmbOpen({{ $i }})">

                {{-- Colorful top banner --}}
                <div class="kmb2-card-banner">
                    <div class="kmb2-banner-dots"></div>
                    <span class="kmb2-banner-tag">{{ $item['tag'] }}</span>
                    <span class="kmb2-banner-emoji">{!! $item['icon_svg'] !!}</span>
                </div>

                {{-- Overlapping circular photo --}}
                <div class="kmb2-card-photo-area">
                    <div class="kmb2-photo-ring">
                        <img src="{{ $item['img'] }}" alt="{{ $item['title'] }}" class="kmb2-photo">
                    </div>
                    <span class="kmb2-photo-chip">{!! $item['icon_svg'] !!}</span>
                </div>

                {{-- Card Body --}}
                <div class="kmb2-card-body">
                    <h5 class="kmb2-card-name">{{ $item['title'] }}</h5>
                    <p class="kmb2-card-preview">{{ $item['preview'] }}</p>
                    <span class="kmb2-card-cta">
                        Lihat Selengkapnya
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </span>
                </div>

                <div class="kmb2-card-shine" aria-hidden="true"></div>
            </div>
            @endforeach
        </div>

        {{-- CTA --}}
        <div class="kmb2-cta wow fadeInUp" data-wow-delay="0.7s">
            <div class="kmb2-cta-inner">
                <div class="kmb2-cta-left">
                    <span class="kmb2-cta-rocket">🚀</span>
                    <div>
                        <div class="kmb2-cta-h">Siap Mengembangkan Potensimu?</div>
                        <div class="kmb2-cta-s">Bergabunglah dengan Kelas Minat Bakat LDK Syahid dan mulai berkarya!</div>
                    </div>
                </div>
                <div class="kmb2-cta-chips">
                    @foreach($kelas as $item)
                    <span title="{{ $item['title'] }}">{!! $item['icon_svg'] !!}</span>
                    @endforeach
                </div>
            </div>
            <span class="kmb2-cta-orb oa" aria-hidden="true"></span>
            <span class="kmb2-cta-orb ob" aria-hidden="true"></span>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════
     Modal Popup (Desktop ≥ 992px)
     ══════════════════════════════════════════ --}}
<div class="kmb2-modal-backdrop" id="kmb2MBackdrop"></div>
<div class="kmb2-modal" id="kmb2Modal" role="dialog" aria-modal="true" aria-label="Detail KMB">

    <button class="kmb2-modal-x" id="kmb2MClose" aria-label="Tutup">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
    </button>

    {{-- Modal Banner --}}
    <div class="kmb2-modal-banner" id="kmb2MBanner">
        <div class="kmb2-modal-banner-dots"></div>
        <span class="kmb2-modal-banner-emoji" id="kmb2MEmoji"></span>
        <span class="kmb2-modal-banner-tag" id="kmb2MTag"></span>
    </div>

    {{-- Modal Nav Arrows (inside banner) --}}
    <button class="kmb2-modal-nav mnav-prev" id="kmb2MPrev" aria-label="Kelas sebelumnya">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
    </button>
    <button class="kmb2-modal-nav mnav-next" id="kmb2MNext" aria-label="Kelas berikutnya">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
    </button>

    {{-- Modal Photo --}}
    <div class="kmb2-modal-photo-area">
        <div class="kmb2-modal-photo-ring" id="kmb2MPhotoRing">
            <img id="kmb2MImg" class="kmb2-modal-photo" src="" alt="">
        </div>
        <span class="kmb2-modal-photo-chip" id="kmb2MChip"></span>
    </div>

    {{-- Modal Content --}}
    <div class="kmb2-modal-body">
        <h4 class="kmb2-modal-title" id="kmb2MTitle"></h4>
        <p class="kmb2-modal-desc" id="kmb2MDesc"></p>
    </div>

    {{-- Indicator dots --}}
    <div class="kmb2-modal-dots" id="kmb2MDots"></div>
</div>

{{-- ══════════════════════════════════════════
     Bottom Sheet (Mobile < 992px)
     ══════════════════════════════════════════ --}}
<div class="kmb2-sheet-backdrop" id="kmb2SBackdrop"></div>
<div class="kmb2-sheet" id="kmb2Sheet">

    {{-- Banner contains the drag handle so no white area shows --}}
    <div class="kmb2-sheet-banner" id="kmb2SBanner">
        <div class="kmb2-sheet-handle"></div>
        <div class="kmb2-sheet-banner-dots"></div>
        <span class="kmb2-sheet-banner-emoji" id="kmb2SEmoji"></span>
        <span class="kmb2-sheet-banner-tag" id="kmb2STag"></span>
    </div>

    <div class="kmb2-sheet-photo-area">
        <div class="kmb2-sheet-photo-ring" id="kmb2SPhotoRing">
            <img id="kmb2SImg" class="kmb2-sheet-photo" src="" alt="">
        </div>
        <span class="kmb2-sheet-photo-chip" id="kmb2SChip"></span>
    </div>

    <div class="kmb2-sheet-body">
        <h5 class="kmb2-sheet-title" id="kmb2STitle"></h5>
        <p class="kmb2-sheet-desc" id="kmb2SDesc"></p>
    </div>

    <div class="kmb2-sheet-footer">
        <div class="kmb2-sheet-nav-row">
            <button class="kmb2-sheet-nav-btn" id="kmb2SPrev">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                Sebelumnya
            </button>
            <div class="kmb2-sheet-dots" id="kmb2SDots"></div>
            <button class="kmb2-sheet-nav-btn" id="kmb2SNext">
                Berikutnya
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
            </button>
        </div>
        <button class="kmb2-sheet-close" id="kmb2SClose">Tutup</button>
    </div>
</div>

{{-- ══════════════════════════════════════════ --}}
{{-- STYLES                                    --}}
{{-- ══════════════════════════════════════════ --}}
<style>
/* ════ BACK-TO-TOP smooth toggle ════ */
.back-to-top {
    transition: opacity 0.35s ease, transform 0.35s ease !important;
}
body.kmb2-popup-open .back-to-top {
    opacity: 0 !important;
    transform: scale(0.8) translateY(12px) !important;
    pointer-events: none !important;
}

/* ════ BASE ════ */
.kmb2-section {
    background: transparent;
    position: relative;
    overflow: hidden;
}

/* ════ BG DECOR ════ */
.kmb2-bg-decor {
    position: absolute;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
    z-index: 0;
}
.kmb2-blob {
    position: absolute;
    border-radius: 50%;
    background: var(--primary);
    opacity: 0.04;
}
.kmb2-blob.b1 { width: 360px; height: 360px; top: -110px; right: -90px; }
.kmb2-blob.b2 { width: 240px; height: 240px; bottom: 30px; left: -90px; }
.kmb2-blob.b3 { width: 140px; height: 140px; top: 42%;    right: 3%;   }

.kmb2-flt {
    position: absolute;
    font-size: 1.5rem;
    opacity: 0.07;
    animation: kmb2Float 13s ease-in-out infinite;
    pointer-events: none;
}
.kmb2-flt.e1 { top:6%;  left:2%;  animation-delay:0s;  }
.kmb2-flt.e2 { top:19%; right:5%; animation-delay:2s;  font-size:1.3rem; }
.kmb2-flt.e3 { bottom:9%;  right:2%; animation-delay:4s;  }
.kmb2-flt.e4 { bottom:20%; left:4%;  animation-delay:6s;  font-size:1.2rem; }
.kmb2-flt.e5 { top:50%;  left:1%;  animation-delay:8s;  }
.kmb2-flt.e6 { top:34%;  right:3%; animation-delay:10s; font-size:1.4rem; }

@keyframes kmb2Float {
    0%,100%{ transform:translateY(0) rotate(0deg); }
    33%     { transform:translateY(-18px) rotate(9deg); }
    66%     { transform:translateY(11px) rotate(-6deg); }
}

/* ════ HEADER ════ */
.kmb2-badge {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: var(--primary-light);
    border: 1px solid rgba(0,167,157,.25);
    border-radius: 50px;
    padding: .5rem 1.25rem;
    margin-bottom: 1rem;
    font-size: .9rem;
    font-weight: 600;
    color: var(--primary);
}
.kmb2-badge-dot {
    width: 8px; height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: kmb2Pulse 2s ease-in-out infinite;
}
@keyframes kmb2Pulse {
    0%,100%{ opacity:1; transform:scale(1); }
    50%    { opacity:.3; transform:scale(1.8); }
}
.kmb2-title {
    font-family: var(--font-primary);
    font-size: 2.4rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.2;
    margin-bottom: .7rem;
}
.kmb2-title-hl {
    display: block;
    color: var(--primary);
    position: relative;
    z-index: 1;
}
.kmb2-title-hl::after {
    content:'';
    position:absolute;
    bottom:3px; left:0;
    width:100%; height:10px;
    background:rgba(0,167,157,.12);
    border-radius:4px;
    z-index:-1;
}
.kmb2-subtitle {
    color: var(--secondary);
    font-size: 1rem;
    max-width: 620px;
    margin: 0 auto;
    line-height: 1.75;
}

/* ════ GRID (6-col → 3-2 centred) ════ */
.kmb2-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 1.5rem;
    margin-bottom: 2.5rem;
}
.kmb2-grid .kmb2-card:nth-child(1) { grid-column: 1/3; }
.kmb2-grid .kmb2-card:nth-child(2) { grid-column: 3/5; }
.kmb2-grid .kmb2-card:nth-child(3) { grid-column: 5/7; }
.kmb2-grid .kmb2-card:nth-child(4) { grid-column: 2/4; }
.kmb2-grid .kmb2-card:nth-child(5) { grid-column: 4/6; }

/* ════ CARD ════ */
.kmb2-card {
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.6);
    border-radius: 24px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    position: relative;
    cursor: pointer;
    box-shadow: 0 4px 24px rgba(0,0,0,.06), 0 1px 4px rgba(0,0,0,.04);
    transition: transform .4s cubic-bezier(.4,0,.2,1),
                box-shadow .4s cubic-bezier(.4,0,.2,1);
    outline: none;
}
@media(hover:hover) {
    .kmb2-card:hover {
        transform: translateY(-10px) scale(1.01);
        box-shadow: 0 28px 60px rgba(0,0,0,.11), 0 0 0 2px var(--kc);
    }
}
.kmb2-card:focus-visible {
    box-shadow: 0 0 0 3px var(--kc);
}

/* ── Banner ── */
.kmb2-card-banner {
    height: 110px;
    background: var(--kc);
    position: relative;
    overflow: hidden;
    flex-shrink: 0;
}
.kmb2-banner-dots {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle, rgba(255,255,255,.18) 1px, transparent 1px);
    background-size: 20px 20px;
}
.kmb2-banner-tag {
    position: absolute;
    top: 14px; left: 14px;
    background: rgba(255,255,255,.22);
    backdrop-filter: blur(6px);
    color: white;
    font-size: .7rem;
    font-weight: 700;
    padding: .28rem .85rem;
    border-radius: 50px;
    letter-spacing: .6px;
    text-transform: uppercase;
    border: 1px solid rgba(255,255,255,.3);
}
.kmb2-banner-emoji {
    position: absolute;
    bottom: 12px; right: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    filter: drop-shadow(0 2px 8px rgba(0,0,0,.2));
    animation: kmb2BounceIcon 3.5s ease-in-out infinite;
}
.kmb2-banner-emoji svg {
    width: 2.2rem;
    height: 2.2rem;
    display: block;
}
@keyframes kmb2BounceIcon {
    0%,100%{ transform:translateY(0) rotate(0); }
    40%    { transform:translateY(-7px) rotate(-9deg); }
    70%    { transform:translateY(3px) rotate(5deg); }
}

/* ── Overlapping Photo ── */
.kmb2-card-photo-area {
    display: flex;
    justify-content: center;
    padding: 0 1rem .5rem;
    position: relative;
    margin-top: -50px;
    z-index: 2;
}
.kmb2-photo-ring {
    width: 100px; height: 100px;
    border-radius: 50%;
    padding: 4px;
    background: linear-gradient(135deg, var(--kc), var(--kl));
    box-shadow: 0 8px 28px rgba(0,0,0,.12);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
}
@media(hover:hover) {
    .kmb2-card:hover .kmb2-photo-ring { transform: scale(1.08) rotate(4deg); }
}
.kmb2-photo {
    width: 100%; height: 100%;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid white;
    display: block;
}
.kmb2-photo-chip {
    position: absolute;
    bottom: 2px;
    right: calc(50% - 64px);
    width: 30px; height: 30px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--kc);
    box-shadow: 0 3px 10px rgba(0,0,0,.12);
    border: 2px solid var(--kl);
    transition: transform .3s ease;
}
.kmb2-photo-chip svg {
    width: 14px;
    height: 14px;
    display: block;
}
@media(hover:hover) {
    .kmb2-card:hover .kmb2-photo-chip { transform: scale(1.18) rotate(-12deg); }
}

/* ── Card Body ── */
.kmb2-card-body {
    padding: .75rem 1.35rem 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: .5rem;
    text-align: center;
}
.kmb2-card-name {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1.05rem;
    color: var(--dark);
    margin: 0;
    padding-bottom: .6rem;
    position: relative;
}
.kmb2-card-name::after {
    content:'';
    position:absolute;
    bottom:0; left:50%;
    transform:translateX(-50%);
    width:36px; height:3px;
    background: var(--kc);
    border-radius:2px;
    transition: width .35s ease;
}
@media(hover:hover) {
    .kmb2-card:hover .kmb2-card-name::after { width:70px; }
}
.kmb2-card-preview {
    color: var(--secondary);
    font-size: .85rem;
    line-height: 1.6;
    margin: 0;
    flex: 1;
}
.kmb2-card-cta {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    background: var(--kc);
    color: white;
    font-size: .8rem;
    font-weight: 600;
    padding: .55rem 1.25rem;
    border-radius: 50px;
    margin-top: .25rem;
    box-shadow: 0 4px 14px rgba(0,0,0,.15);
    transition: transform .25s ease, box-shadow .25s ease;
    cursor: pointer;
}
@media(hover:hover) {
    .kmb2-card:hover .kmb2-card-cta {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,.2);
    }
}

/* ── Shine on hover ── */
.kmb2-card-shine {
    position: absolute;
    top: 0; left: -100%;
    width: 60%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.12), transparent);
    transform: skewX(-20deg);
    pointer-events: none;
    transition: left .6s ease;
}
@media(hover:hover) {
    .kmb2-card:hover .kmb2-card-shine { left: 160%; }
}

/* ════ CTA BANNER ════ */
.kmb2-cta {
    background: var(--primary-gradient);
    border-radius: 24px;
    padding: 1.75rem 2rem;
    box-shadow: 0 10px 36px rgba(0,167,157,.28);
    position: relative;
    overflow: hidden;
}
.kmb2-cta-orb {
    position: absolute;
    border-radius: 50%;
    background: rgba(255,255,255,.08);
    pointer-events: none;
}
.kmb2-cta-orb.oa { width:180px; height:180px; top:-60px;    right:-40px; }
.kmb2-cta-orb.ob { width:110px; height:110px; bottom:-35px; left:60px;  }
.kmb2-cta-inner {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    flex-wrap: wrap;
}
.kmb2-cta-left  { display:flex; align-items:center; gap:1rem; }
.kmb2-cta-rocket { font-size:2.6rem; flex-shrink:0; animation:kmb2Float 4s ease-in-out infinite; }
.kmb2-cta-h { color:white; font-family:var(--font-primary); font-weight:700; font-size:1.1rem; }
.kmb2-cta-s { color:rgba(255,255,255,.85); font-size:.85rem; margin-top:.2rem; line-height:1.5; }
.kmb2-cta-chips { display:flex; gap:.6rem; flex-wrap:wrap; }
.kmb2-cta-chips span {
    display:inline-flex; align-items:center; justify-content:center;
    width:50px; height:50px;
    color: white;
    background:rgba(255,255,255,.16);
    border-radius:14px;
    border:1px solid rgba(255,255,255,.22);
    cursor:default;
    transition:transform .3s ease;
}
.kmb2-cta-chips span svg {
    width: 1.4rem;
    height: 1.4rem;
    display: block;
}
@media(hover:hover) {
    .kmb2-cta-chips span:hover { transform:translateY(-5px) scale(1.1); }
}

/* ════════════════════════════════════════════
   MODAL (Desktop)
   ════════════════════════════════════════════ */
.kmb2-modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 9100;
    opacity: 0;
    transition: opacity .3s ease;
}
.kmb2-modal-backdrop.active { display:block; opacity:1; }

.kmb2-modal {
    display: none;
    position: fixed;
    top: 50%; left: 50%;
    transform: translate(-50%,-50%) scale(.9);
    width: min(520px, 94vw);
    max-height: 90vh;
    overflow-y: auto;
    background: white;
    border-radius: 28px;
    z-index: 9101;
    opacity: 0;
    transition: opacity .35s ease, transform .35s cubic-bezier(.34,1.56,.64,1);
    scrollbar-width: none;
}
.kmb2-modal::-webkit-scrollbar { display:none; }
.kmb2-modal.active {
    display: block;
    opacity: 1;
    transform: translate(-50%,-50%) scale(1);
}

/* Modal close */
.kmb2-modal-x {
    position: absolute;
    top: 14px; right: 14px;
    width: 46px; height: 46px;
    background: rgba(255,255,255,.3) !important;
    backdrop-filter: blur(8px);
    border: 1.5px solid rgba(255,255,255,.5) !important;
    border-radius: 50% !important;
    color: white !important;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    outline: none !important;
    box-shadow: none !important;
    transition: transform .25s ease;
    appearance: none;
}
.kmb2-modal-x:hover,
.kmb2-modal-x:focus,
.kmb2-modal-x:active {
    transform: scale(1.18) !important;
    background: rgba(255,255,255,.3) !important;
    border-color: rgba(255,255,255,.5) !important;
    color: white !important;
    box-shadow: none !important;
    outline: none !important;
}

/* Modal banner */
.kmb2-modal-banner {
    height: 160px;
    position: relative;
    overflow: hidden;
    border-radius: 28px 28px 0 0;
    transition: background .4s ease;
}
.kmb2-modal-banner-dots {
    position:absolute; inset:0;
    background-image: radial-gradient(circle,rgba(255,255,255,.2) 1px,transparent 1px);
    background-size: 22px 22px;
}
.kmb2-modal-banner-emoji {
    position: absolute;
    bottom: 18px; right: 26px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    filter: drop-shadow(0 4px 12px rgba(0,0,0,.2));
    animation: kmb2BounceIcon 3.5s ease-in-out infinite;
}
.kmb2-modal-banner-emoji svg {
    width: 3rem;
    height: 3rem;
    display: block;
}
.kmb2-modal-banner-tag {
    position: absolute;
    top: 18px; left: 18px;
    background: rgba(255,255,255,.22);
    backdrop-filter: blur(6px);
    color: white;
    font-size: .78rem;
    font-weight: 700;
    padding: .35rem 1rem;
    border-radius: 50px;
    text-transform: uppercase;
    letter-spacing: .6px;
    border: 1px solid rgba(255,255,255,.3);
}

/* Modal nav arrows — inside banner, hover = scale only */
.kmb2-modal-nav {
    position: absolute;
    top: 57px;
    width: 46px; height: 46px;
    background: rgba(255,255,255,.28) !important;
    backdrop-filter: blur(8px);
    border: 1.5px solid rgba(255,255,255,.45) !important;
    border-radius: 50% !important;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 6;
    color: white !important;
    outline: none !important;
    box-shadow: none !important;
    transition: transform .25s cubic-bezier(.4,0,.2,1);
    appearance: none;
}
.kmb2-modal-nav:hover,
.kmb2-modal-nav:focus,
.kmb2-modal-nav:active {
    transform: scale(1.2) !important;
    background: rgba(255,255,255,.28) !important;
    border-color: rgba(255,255,255,.45) !important;
    color: white !important;
    box-shadow: none !important;
    outline: none !important;
}
.kmb2-modal-nav.mnav-prev { left: 14px; }
.kmb2-modal-nav.mnav-next { right: 14px; }

/* Modal photo (overlapping) */
.kmb2-modal-photo-area {
    display: flex;
    justify-content: center;
    margin-top: -58px;
    position: relative;
    z-index: 2;
}
.kmb2-modal-photo-ring {
    width: 116px; height: 116px;
    border-radius: 50%;
    padding: 5px;
    box-shadow: 0 10px 32px rgba(0,0,0,.14);
    transition: background .4s ease;
}
.kmb2-modal-photo {
    width:100%; height:100%;
    object-fit:cover;
    border-radius:50%;
    border:4px solid white;
    display:block;
}
.kmb2-modal-photo-chip {
    position: absolute;
    bottom: 0; right: calc(50% - 74px);
    width: 36px; height: 36px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0,0,0,.12);
    border: 2px solid #f3f3f3;
}
.kmb2-modal-photo-chip svg {
    width: 16px;
    height: 16px;
    display: block;
}

/* Modal body */
.kmb2-modal-body {
    padding: .75rem 2rem 2rem;
    text-align: center;
}
.kmb2-modal-title {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 1.3rem;
    color: var(--dark);
    margin-bottom: .5rem;
}
.kmb2-modal-desc {
    color: var(--secondary);
    font-size: .925rem;
    line-height: 1.8;
    text-align: justify;
    margin: 0 0 1rem;
}

/* Modal dots — hover = scale only */
.kmb2-modal-dots {
    display: flex;
    justify-content: center;
    gap: 6px;
    padding-bottom: 1.25rem;
}
.kmb2-modal-dots .mdot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #ddd;
    cursor: pointer;
    transition: all .3s ease;
}
.kmb2-modal-dots .mdot:hover { transform: scale(1.35); }
.kmb2-modal-dots .mdot.active {
    width: 24px;
    border-radius: 50px;
    background: var(--primary);
}

/* ════════════════════════════════════════════
   BOTTOM SHEET (Mobile)
   ════════════════════════════════════════════ */
.kmb2-sheet-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.45);
    z-index: 9100;
    opacity: 0;
    transition: opacity .3s ease;
}
.kmb2-sheet-backdrop.active { display:block; opacity:1; }

.kmb2-sheet {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 9101;
    transform: translateY(100%);
    transition: transform .38s cubic-bezier(.4,0,.2,1);
    max-height: 92dvh;
    overflow-y: auto;
    scrollbar-width: none;
}
.kmb2-sheet::-webkit-scrollbar { display:none; }
.kmb2-sheet.active { transform: translateY(0); }

/* Handle sits inside the colored banner — no white gap */
.kmb2-sheet-handle {
    width: 42px; height: 4px;
    background: rgba(255,255,255,0.55);
    border-radius: 4px;
    position: absolute;
    top: 11px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 3;
}

/* Sheet banner */
.kmb2-sheet-banner {
    height: 136px;
    position: relative;
    overflow: hidden;
    border-radius: 24px 24px 0 0;
    transition: background .4s ease;
}
.kmb2-sheet-banner-dots {
    position:absolute; inset:0;
    background-image: radial-gradient(circle,rgba(255,255,255,.2) 1px,transparent 1px);
    background-size:20px 20px;
}
.kmb2-sheet-banner-emoji {
    position:absolute;
    bottom:14px; right:18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    filter:drop-shadow(0 3px 8px rgba(0,0,0,.2));
    animation:kmb2BounceIcon 3.5s ease-in-out infinite;
}
.kmb2-sheet-banner-emoji svg {
    width: 2.5rem;
    height: 2.5rem;
    display: block;
}
.kmb2-sheet-banner-tag {
    position:absolute;
    top:14px; left:14px;
    background:rgba(255,255,255,.22);
    backdrop-filter:blur(6px);
    color:white;
    font-size:.7rem;
    font-weight:700;
    padding:.28rem .85rem;
    border-radius:50px;
    text-transform:uppercase;
    letter-spacing:.6px;
    border:1px solid rgba(255,255,255,.3);
}

/* Sheet photo */
.kmb2-sheet-photo-area {
    display:flex;
    justify-content:center;
    margin-top:-48px;
    position:relative;
    z-index:2;
}
.kmb2-sheet-photo-ring {
    width:96px; height:96px;
    border-radius:50%;
    padding:4px;
    box-shadow:0 8px 24px rgba(0,0,0,.13);
    transition:background .4s ease;
}
.kmb2-sheet-photo {
    width:100%; height:100%;
    object-fit:cover;
    border-radius:50%;
    border:3px solid white;
    display:block;
}
.kmb2-sheet-photo-chip {
    position:absolute;
    bottom:0; right:calc(50% - 60px);
    width:30px; height:30px;
    background:white;
    border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 3px 10px rgba(0,0,0,.12);
    border:2px solid #f3f3f3;
}
.kmb2-sheet-photo-chip svg {
    width: 13px;
    height: 13px;
    display: block;
}

/* Sheet body */
.kmb2-sheet-body {
    padding:.6rem 1.5rem 1rem;
    text-align:center;
}
.kmb2-sheet-title {
    font-family:var(--font-primary);
    font-weight:700;
    font-size:1.1rem;
    color:var(--dark);
    margin-bottom:.4rem;
}
.kmb2-sheet-desc {
    color:var(--secondary);
    font-size:.875rem;
    line-height:1.75;
    text-align:justify;
    margin:0;
}

/* Sheet footer */
.kmb2-sheet-footer {
    padding:.75rem 1.5rem 1.5rem;
    display:flex;
    flex-direction:column;
    gap:.75rem;
}
.kmb2-sheet-nav-row {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:.5rem;
}
/* Nav buttons: hover = scale only, no color change */
.kmb2-sheet-nav-btn {
    display:inline-flex;
    align-items:center;
    gap:.35rem;
    background:var(--primary-light);
    color:var(--primary);
    border:1px solid rgba(0,167,157,.2);
    border-radius:50px;
    padding:.5rem 1rem;
    font-size:.8rem;
    font-weight:600;
    cursor:pointer;
    transition: transform .22s ease;
}
.kmb2-sheet-nav-btn:hover { transform: scale(1.07); }
.kmb2-sheet-dots {
    display:flex;
    gap:5px;
    align-items:center;
}
.kmb2-sheet-dots .sdot {
    width:7px; height:7px;
    border-radius:50%;
    background:#ddd;
    transition:all .3s ease;
    cursor:pointer;
}
.kmb2-sheet-dots .sdot:hover { transform: scale(1.35); }
.kmb2-sheet-dots .sdot.active {
    width:20px;
    border-radius:50px;
    background:var(--primary);
}
.kmb2-sheet-close {
    display:block;
    width:100%;
    background:var(--primary-gradient);
    color:white;
    border:none;
    border-radius:50px;
    padding:.75rem;
    font-size:.9rem;
    font-weight:600;
    cursor:pointer;
    box-shadow:0 4px 14px rgba(0,167,157,.3);
    transition: transform .22s ease;
}
.kmb2-sheet-close:hover { transform: scale(1.02); }

/* ════ RESPONSIVE ════ */
@media(max-width:991.98px) {
    .kmb2-title { font-size:1.9rem; }
    .kmb2-grid {
        grid-template-columns:repeat(4,1fr);
        gap:1.1rem;
    }
    .kmb2-grid .kmb2-card:nth-child(1){grid-column:1/3;}
    .kmb2-grid .kmb2-card:nth-child(2){grid-column:3/5;}
    .kmb2-grid .kmb2-card:nth-child(3){grid-column:1/3;}
    .kmb2-grid .kmb2-card:nth-child(4){grid-column:3/5;}
    .kmb2-grid .kmb2-card:nth-child(5){grid-column:2/4;}
    .kmb2-cta { padding:1.5rem; }
}
@media(max-width:767.98px) {
    .kmb2-title { font-size:1.65rem; }
    .kmb2-grid {
        grid-template-columns:1fr;
        gap:.9rem;
    }
    .kmb2-grid .kmb2-card:nth-child(n) { grid-column:auto; }
    .kmb2-cta-inner { flex-direction:column; text-align:center; }
    .kmb2-cta-left  { flex-direction:column; align-items:center; }
    .kmb2-cta-chips { justify-content:center; }
}
@media(max-width:575.98px) {
    .kmb2-title  { font-size:1.4rem; }
    .kmb2-badge  { font-size:.8rem; padding:.4rem 1rem; }
    .kmb2-cta    { padding:1.25rem; }
    .kmb2-cta-chips span { width:42px; height:42px; border-radius:12px; }
}
</style>

{{-- ══════════════════════════════════════════ --}}
{{-- SCRIPT                                    --}}
{{-- ══════════════════════════════════════════ --}}
<script>
(function() {
    const KMB_DATA = @json($kelas);
    let currentIdx = 0;

    /* ── Helpers ── */
    function isDesktop() { return window.innerWidth >= 992; }

    /* ── Back-to-top toggle (smooth) ── */
    function hideBackToTop() {
        document.body.classList.add('kmb2-popup-open');
    }
    function showBackToTop() {
        document.body.classList.remove('kmb2-popup-open');
        // Re-trigger jQuery fade-in if scrolled far enough
        setTimeout(function() {
            if (window.jQuery && (window.scrollY || document.documentElement.scrollTop) > 300) {
                jQuery('.back-to-top').stop(true).fadeIn(300);
            }
        }, 380);
    }

    /* ── Populate Modal ── */
    function populateModal(idx) {
        const d = KMB_DATA[idx];
        document.getElementById('kmb2MBanner').style.background = d.color;
        document.getElementById('kmb2MPhotoRing').style.background =
            'linear-gradient(135deg,' + d.color + ',' + d.light + ')';
        document.getElementById('kmb2MEmoji').innerHTML  = d.icon_svg;
        document.getElementById('kmb2MTag').textContent  = d.tag;
        document.getElementById('kmb2MImg').src          = d.img;
        document.getElementById('kmb2MImg').alt          = d.title;
        var chip = document.getElementById('kmb2MChip');
        chip.innerHTML    = d.icon_svg;
        chip.style.color  = d.color;
        document.getElementById('kmb2MTitle').textContent = d.title;
        document.getElementById('kmb2MDesc').textContent  = d.desc;
        // Update dots
        document.querySelectorAll('#kmb2MDots .mdot').forEach(function(dot, i) {
            dot.classList.toggle('active', i === idx);
        });
    }

    /* ── Populate Sheet ── */
    function populateSheet(idx) {
        const d = KMB_DATA[idx];
        document.getElementById('kmb2SBanner').style.background = d.color;
        document.getElementById('kmb2SPhotoRing').style.background =
            'linear-gradient(135deg,' + d.color + ',' + d.light + ')';
        document.getElementById('kmb2SEmoji').innerHTML  = d.icon_svg;
        document.getElementById('kmb2STag').textContent  = d.tag;
        document.getElementById('kmb2SImg').src          = d.img;
        document.getElementById('kmb2SImg').alt          = d.title;
        var chip = document.getElementById('kmb2SChip');
        chip.innerHTML    = d.icon_svg;
        chip.style.color  = d.color;
        document.getElementById('kmb2STitle').textContent = d.title;
        document.getElementById('kmb2SDesc').textContent  = d.desc;
        // Update dots
        document.querySelectorAll('#kmb2SDots .sdot').forEach(function(dot, i) {
            dot.classList.toggle('active', i === idx);
        });
        // Scroll sheet to top
        document.getElementById('kmb2Sheet').scrollTop = 0;
    }

    /* ── Open ── */
    window.kmbOpen = function(idx) {
        currentIdx = idx;
        if (isDesktop()) openModal(idx);
        else             openSheet(idx);
    };

    function openModal(idx) {
        populateModal(idx);
        var bd = document.getElementById('kmb2MBackdrop');
        var md = document.getElementById('kmb2Modal');
        bd.style.display = 'block';
        md.style.display = 'block';
        requestAnimationFrame(function() {
            bd.classList.add('active');
            md.classList.add('active');
        });
        document.body.style.overflow = 'hidden';
        hideBackToTop();
        document.getElementById('kmb2MClose').focus();
    }

    function closeModal() {
        var bd = document.getElementById('kmb2MBackdrop');
        var md = document.getElementById('kmb2Modal');
        bd.classList.remove('active');
        md.classList.remove('active');
        setTimeout(function() {
            bd.style.display = 'none';
            md.style.display = 'none';
            document.body.style.overflow = '';
            showBackToTop();
        }, 350);
    }

    function openSheet(idx) {
        populateSheet(idx);
        var bd = document.getElementById('kmb2SBackdrop');
        var sh = document.getElementById('kmb2Sheet');
        bd.style.display = 'block';
        sh.style.display = 'block';
        requestAnimationFrame(function() {
            bd.classList.add('active');
            sh.classList.add('active');
        });
        document.body.style.overflow = 'hidden';
        hideBackToTop();
    }

    function closeSheet() {
        var bd = document.getElementById('kmb2SBackdrop');
        var sh = document.getElementById('kmb2Sheet');
        bd.classList.remove('active');
        sh.classList.remove('active');
        setTimeout(function() {
            bd.style.display = 'none';
            sh.style.display = 'none';
            document.body.style.overflow = '';
            showBackToTop();
        }, 380);
    }

    /* ── Navigate ── */
    function navigateTo(idx) {
        currentIdx = (idx + KMB_DATA.length) % KMB_DATA.length;
        if (isDesktop()) populateModal(currentIdx);
        else             populateSheet(currentIdx);
    }

    /* ── Build Dots ── */
    function buildDots(containerId, cssClass) {
        var container = document.getElementById(containerId);
        if (!container) return;
        container.innerHTML = '';
        KMB_DATA.forEach(function(_, i) {
            var dot = document.createElement('span');
            dot.className = cssClass + (i === 0 ? ' active' : '');
            dot.addEventListener('click', function() { navigateTo(i); });
            container.appendChild(dot);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        buildDots('kmb2MDots', 'mdot');
        buildDots('kmb2SDots', 'sdot');

        /* Modal events */
        document.getElementById('kmb2MClose').addEventListener('click', closeModal);
        document.getElementById('kmb2MBackdrop').addEventListener('click', closeModal);
        document.getElementById('kmb2MPrev').addEventListener('click', function() { navigateTo(currentIdx - 1); });
        document.getElementById('kmb2MNext').addEventListener('click', function() { navigateTo(currentIdx + 1); });

        /* Sheet events */
        document.getElementById('kmb2SClose').addEventListener('click', closeSheet);
        document.getElementById('kmb2SBackdrop').addEventListener('click', closeSheet);
        document.getElementById('kmb2SPrev').addEventListener('click', function() { navigateTo(currentIdx - 1); });
        document.getElementById('kmb2SNext').addEventListener('click', function() { navigateTo(currentIdx + 1); });

        /* Keyboard: Escape to close, arrows to navigate */
        document.addEventListener('keydown', function (e) {
            var mOpen = document.getElementById('kmb2Modal').classList.contains('active');
            var sOpen = document.getElementById('kmb2Sheet').classList.contains('active');
            if (!mOpen && !sOpen) return;
            if (e.key === 'Escape')     { mOpen ? closeModal() : closeSheet(); }
            if (e.key === 'ArrowLeft')  { navigateTo(currentIdx - 1); }
            if (e.key === 'ArrowRight') { navigateTo(currentIdx + 1); }
        });
    });
})();
</script>
