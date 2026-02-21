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
                    'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r="1" fill="currentColor" stroke="none"/><circle cx="17.5" cy="10.5" r="1" fill="currentColor" stroke="none"/><circle cx="8.5" cy="7.5" r="1" fill="currentColor" stroke="none"/><circle cx="6.5" cy="12.5" r="1" fill="currentColor" stroke="none"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>',
                    'title'    => 'Desain Grafis',
                    'tag'      => 'Visual',
                    'color'    => '#8b5cf6',
                    'light'    => '#f5f3ff',
                    'dark'     => '#7c3aed',
                    'preview'  => 'Ciptakan karya visual dan audio visual yang indah, selaras nilai-nilai Islam!',
                    'desc'     => 'Merupakan kelas yang akan mewadahi minat dan bakat peserta dalam mengembangkan potensinya di bidang desain grafis sehingga mampu dan mahir untuk menciptakan karya visual maupun audio visual yang selaras dengan nilai-nilai Islam.',
                ],
                [
                    'icon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>',
                    'title'    => 'Microsoft Office',
                    'tag'      => 'Produktivitas',
                    'color'    => '#0078d4',
                    'light'    => '#eff6ff',
                    'dark'     => '#005fa3',
                    'preview'  => 'Kuasai Word, Excel, dan PowerPoint untuk produktivitas dan karier yang lebih baik!',
                    'desc'     => 'Merupakan kelas yang akan membekali peserta dengan kemampuan menggunakan aplikasi Microsoft Office secara profesional, meliputi Microsoft Word untuk penulisan dokumen, Microsoft Excel untuk pengolahan data, serta Microsoft PowerPoint untuk pembuatan presentasi yang menarik dan efektif.',
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

                {{-- Overlapping circular icon --}}
                <div class="kmb2-card-photo-area">
                    <div class="kmb2-photo-ring">
                        <div class="kmb2-photo-icon">{!! $item['icon_svg'] !!}</div>
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
            <div class="kmb2-modal-photo-icon" id="kmb2MIcon"></div>
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
            <div class="kmb2-sheet-photo-icon" id="kmb2SIcon"></div>
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

@include('landing-page.home.partials.kmb-class.components._index-styles')
@include('landing-page.home.partials.kmb-class.components._index-scripts')
