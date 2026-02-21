{{-- Article Section - Revamped Clean & Modern --}}
<section class="article-section py-5" id="articleSection">
    <div class="container">
        {{-- Section Header --}}
        <div class="row mb-4 mb-lg-5 align-items-center justify-content-between wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="art-badge">
                    <span class="art-badge__emoji">📝</span>
                    <span>Artikel</span>
                    <span class="art-badge__pulse"></span>
                </div>
                <h2 class="art-heading">
                    Karya Tulis <span class="art-heading__highlight">Kita</span>
                    <span class="art-heading__sparkle">✨</span>
                </h2>
                <p class="art-subtitle">
                    Hasil tulisan penuh semangat dari para anggota LDK Syahid. Yuk baca! 📚
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="/articles" class="art-btn-all">
                    <span>Lihat Semua</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Desktop Grid (hidden on mobile) --}}
        <div class="art-grid d-none d-md-grid wow fadeInUp" data-wow-delay="0.2s">
            @forelse($postarticle as $key => $article)
            @php
                $cardColors = ['#6366f1','#10b981','#f59e0b','#ef4444','#8b5cf6','#0ea5e9'];
                $accent = $cardColors[$key % count($cardColors)];
            @endphp
            <div class="art-card" style="--card-accent: {{ $accent }}">
                <div class="art-card__img-wrap">
                    <img src="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                         alt="{{ $article->title }}"
                         class="art-card__img"
                         loading="lazy">
                    <div class="art-card__date">
                        <span class="art-card__date-num">{{ \Carbon\Carbon::parse($article->dateevent)->format('d') }}</span>
                        <span class="art-card__date-month">{{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('MMM') }}</span>
                    </div>
                </div>
                <div class="art-card__body">
                    <span class="art-card__theme" style="--theme-color: {{ $accent }}">{{ $article->theme ?? 'Artikel' }}</span>
                    <h5 class="art-card__title">
                        <a href="/articles/{{ $article->id }}">{{ $article->title }}</a>
                    </h5>
                    <div class="art-card__people-card" style="--card-accent: {{ $accent }}">
                        <div class="art-card__meta">
                            <div class="art-card__avatar" style="background: {{ $accent }}20; color: {{ $accent }}">
                                <i class="fas fa-pen-fancy"></i>
                            </div>
                            <div class="art-card__meta-info">
                                <span class="art-card__meta-label">Penulis</span>
                                <span class="art-card__meta-name">{{ $article->writer }}</span>
                            </div>
                        </div>
                        @if($article->editor)
                        <div class="art-card__people-divider"></div>
                        <div class="art-card__meta">
                            <div class="art-card__avatar" style="background: {{ $accent }}20; color: {{ $accent }}">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="art-card__meta-info">
                                <span class="art-card__meta-label">Editor</span>
                                <span class="art-card__meta-name">{{ $article->editor }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    <a href="/articles/{{ $article->id }}" class="art-card__read">
                        <span>Baca Selengkapnya</span> <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="art-empty">
                <div class="art-empty__icon">📭</div>
                <h4>Belum Ada Artikel</h4>
                <p>Artikel sedang dalam proses penulisan. Tunggu ya!</p>
            </div>
            @endforelse
        </div>

        {{-- Mobile Carousel (hidden on desktop) --}}
        <div class="d-md-none wow fadeInUp" data-wow-delay="0.2s">
            <div class="owl-carousel art-carousel">
                @forelse($postarticle as $key => $article)
                @php
                    $cardColors = ['#6366f1','#10b981','#f59e0b','#ef4444','#8b5cf6','#0ea5e9'];
                    $accent = $cardColors[$key % count($cardColors)];
                @endphp
                <div class="art-card art-card--mobile"
                     style="--card-accent: {{ $accent }}; --theme-color: {{ $accent }}"
                     data-article-id="{{ $article->id }}"
                     data-article-title="{{ $article->title }}"
                     data-article-theme="{{ $article->theme ?? 'Artikel' }}"
                     data-article-writer="{{ $article->writer }}"
                     data-article-date="{{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('D MMMM YYYY') }}"
                     data-article-img="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                     data-article-editor="{{ $article->editor }}"
                     data-article-url="/articles/{{ $article->id }}"
                     data-article-accent="{{ $accent }}">
                    <div class="art-card__img-wrap">
                        <img src="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                             alt="{{ $article->title }}"
                             class="art-card__img"
                             loading="lazy">
                        <div class="art-card__date">
                            <span class="art-card__date-num">{{ \Carbon\Carbon::parse($article->dateevent)->format('d') }}</span>
                            <span class="art-card__date-month">{{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('MMM') }}</span>
                        </div>
                        {{-- Tap hint --}}
                        <div class="art-card__tap-hint">
                            Baca selengkapnya 👆
                        </div>
                    </div>
                    <div class="art-card__body">
                        <span class="art-card__theme" style="--theme-color: {{ $accent }}">{{ $article->theme ?? 'Artikel' }}</span>
                        <h5 class="art-card__title">{{ $article->title }}</h5>
                        <div class="art-card__people-card" style="--card-accent: {{ $accent }}">
                            <div class="art-card__meta">
                                <div class="art-card__avatar" style="background: {{ $accent }}20; color: {{ $accent }}">
                                    <i class="fas fa-pen-fancy"></i>
                                </div>
                                <div class="art-card__meta-info">
                                    <span class="art-card__meta-label">Penulis</span>
                                    <span class="art-card__meta-name">{{ $article->writer }}</span>
                                </div>
                            </div>
                            @if($article->editor)
                            <div class="art-card__people-divider"></div>
                            <div class="art-card__meta">
                                <div class="art-card__avatar" style="background: {{ $accent }}20; color: {{ $accent }}">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="art-card__meta-info">
                                    <span class="art-card__meta-label">Editor</span>
                                    <span class="art-card__meta-name">{{ $article->editor }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="art-empty">
                    <div class="art-empty__icon">📭</div>
                    <h4>Belum Ada Artikel</h4>
                    <p>Artikel sedang dalam proses penulisan. Tunggu ya!</p>
                </div>
                @endforelse
            </div>
            {{-- Carousel Indicators --}}
            @if(count($postarticle) > 1)
            <div class="art-carousel-dots"></div>
            @endif
        </div>
    </div>
</section>

{{-- Mobile Bottom Sheet --}}
<div class="art-sheet-overlay" id="artSheetOverlay"></div>
<div class="art-sheet" id="artSheet">
    <div class="art-sheet__header">
        <div class="art-sheet__handle"></div>
        <button class="art-sheet__close" id="artSheetClose" aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="art-sheet__content">
        <div class="art-sheet__img-wrap">
            <img src="" alt="" class="art-sheet__img" id="artSheetImg">
            <div class="art-sheet__img-gradient"></div>
        </div>
        <div class="art-sheet__info">
            <span class="art-card__theme" id="artSheetTheme" style="--theme-color: var(--primary)"></span>
            <h3 class="art-sheet__title" id="artSheetTitle"></h3>
            <div class="art-sheet__meta">
                <div class="art-sheet__meta-item">
                    <div class="art-sheet__meta-icon"><i class="fas fa-pen-fancy"></i></div>
                    <div class="art-sheet__meta-text">
                        <span class="art-sheet__meta-label">Penulis</span>
                        <span id="artSheetWriter"></span>
                    </div>
                </div>
                <div class="art-sheet__meta-item" id="artSheetEditorRow" style="display: none;">
                    <div class="art-sheet__meta-icon"><i class="fas fa-edit"></i></div>
                    <div class="art-sheet__meta-text">
                        <span class="art-sheet__meta-label">Editor</span>
                        <span id="artSheetEditor"></span>
                    </div>
                </div>
                <div class="art-sheet__meta-item">
                    <div class="art-sheet__meta-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div class="art-sheet__meta-text">
                        <span class="art-sheet__meta-label">Tanggal</span>
                        <span id="artSheetDate"></span>
                    </div>
                </div>
            </div>
            <a href="#" class="art-sheet__btn" id="artSheetBtn">
                <span>Baca Artikel Lengkap</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

@include('landing-page.home.partials.article.components._index-styles')
@include('landing-page.home.partials.article.components._index-scripts')
