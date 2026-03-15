{{-- News Section - Clean & Modern Revamp --}}
<section class="news-section py-5" id="newsSection">
    <div class="container">
        {{-- Section Header (matching About section style) --}}
        <div class="text-center mb-5 news-header-animate">
            <div class="news-badge">
                <span class="news-badge__emoji">📰</span>
                <span>Berita</span>
                <span class="news-badge__pulse"></span>
            </div>
            <h2 class="news-heading">
                Berita <span class="news-heading__highlight">Terbaru</span>
            </h2>
            <p class="news-subtitle">
                Info terkini seputar kegiatan dan perkembangan LDK Syahid
            </p>
        </div>

        {{-- Desktop Layout (hidden on mobile) --}}
        <div class="d-none d-md-block">
            <div class="news-grid">
                @forelse($postnews as $key => $news)
                <div class="news-card {{ $key === 0 ? 'news-card--featured' : '' }} news-card-animate" style="--anim-delay: {{ $key * 0.1 }}s">
                    <div class="news-card__img-wrap">
                        <img src="https://lh3.googleusercontent.com/d/{{ $news->gdrive_id }}"
                             alt="{{ $news->title }}"
                             class="news-card__img"
                             loading="lazy">
                        @if($key === 0)
                        <div class="news-card__featured-tag">
                            <i class="fas fa-star"></i> Terbaru
                        </div>
                        @endif
                        <div class="news-card__date-badge">
                            <span class="news-card__date-day">{{ \Carbon\Carbon::parse($news->datepublish)->format('d') }}</span>
                            <span class="news-card__date-month">{{ \Carbon\Carbon::parse($news->datepublish)->isoFormat('MMM') }}</span>
                        </div>
                    </div>
                    <div class="news-card__body">
                        <h4 class="news-card__title">
                            <a href="{{ $news->getNewsUrl() }}">{{ $news->title }}</a>
                        </h4>
                        <div class="news-card__meta-wrap">
                            <div class="news-card__meta">
                                <i class="fas fa-user"></i>
                                <span>{{ $news->reporter }}</span>
                            </div>
                            <div class="news-card__meta">
                                <i class="fas fa-edit"></i>
                                <span>{{ $news->editor }}</span>
                            </div>
                        </div>
                        @if($key === 0)
                        <p class="news-card__excerpt">
                            {!! substr(strip_tags($news->body), 0, 365) !!}...
                        </p>
                        @endif
                        <a href="{{ $news->getNewsUrl() }}" class="news-card__read">
                            <span>Baca Selengkapnya</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="news-empty">
                    <div class="news-empty__icon">📭</div>
                    <h4>Belum Ada Berita</h4>
                    <p>Berita terbaru akan segera hadir. Stay tuned!</p>
                </div>
                @endforelse
            </div>

            {{-- View All Button --}}
            @if(count($postnews) > 0)
            <div class="text-center mt-4 news-card-animate" style="--anim-delay: 0.5s">
                <a href="/news" class="news-btn-all">
                    <span>Lihat Semua Berita</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>

        {{-- Mobile Carousel (hidden on desktop) --}}
        <div class="d-md-none">
            <div class="owl-carousel news-carousel">
                @forelse($postnews as $key => $news)
                <div class="news-card news-card--mobile"
                     data-news-id="{{ $news->id }}"
                     data-news-title="{{ $news->title }}"
                     data-news-reporter="{{ $news->reporter }}"
                     data-news-editor="{{ $news->editor }}"
                     data-news-date="{{ \Carbon\Carbon::parse($news->datepublish)->isoFormat('D MMMM YYYY') }}"
                     data-news-img="https://lh3.googleusercontent.com/d/{{ $news->gdrive_id }}"
                     data-news-excerpt="{!! substr(strip_tags($news->body), 0, 200) !!}..."
                     data-news-url="{{ $news->getNewsUrl() }}">
                    <div class="news-card__img-wrap">
                        <img src="https://lh3.googleusercontent.com/d/{{ $news->gdrive_id }}"
                             alt="{{ $news->title }}"
                             class="news-card__img"
                             loading="lazy">
                        @if($key === 0)
                        <div class="news-card__featured-tag">
                            <i class="fas fa-star"></i> Terbaru
                        </div>
                        @endif
                        <div class="news-card__date-badge">
                            <span class="news-card__date-day">{{ \Carbon\Carbon::parse($news->datepublish)->format('d') }}</span>
                            <span class="news-card__date-month">{{ \Carbon\Carbon::parse($news->datepublish)->isoFormat('MMM') }}</span>
                        </div>
                        <div class="news-card__tap-hint">
                            Ketuk untuk baca <i class="fas fa-hand-pointer"></i>
                        </div>
                    </div>
                    <div class="news-card__body">
                        <h5 class="news-card__title">{{ $news->title }}</h5>
                        <div class="news-card__meta-wrap">
                            <div class="news-card__meta">
                                <i class="fas fa-user"></i>
                                <span>{{ $news->reporter }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="news-empty">
                    <div class="news-empty__icon">📭</div>
                    <h4>Belum Ada Berita</h4>
                    <p>Berita terbaru akan segera hadir. Stay tuned!</p>
                </div>
                @endforelse
            </div>
            {{-- Carousel Indicators --}}
            @if(count($postnews) > 1)
            <div class="news-carousel-dots"></div>
            @endif

            {{-- View All Button Mobile --}}
            @if(count($postnews) > 0)
            <div class="text-center mt-3">
                <a href="/news" class="news-btn-all news-btn-all--mobile">
                    <span>Semua Berita</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- Mobile Bottom Sheet --}}
<div class="news-sheet-overlay" id="newsSheetOverlay"></div>
<div class="news-sheet" id="newsSheet">
    <div class="news-sheet__header">
        <div class="news-sheet__handle"></div>
        <button class="news-sheet__close" id="newsSheetClose" aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="news-sheet__content">
        <div class="news-sheet__img-wrap">
            <img src="" alt="" class="news-sheet__img" id="newsSheetImg">
            <div class="news-sheet__img-gradient"></div>
        </div>
        <div class="news-sheet__info">
            <h3 class="news-sheet__title" id="newsSheetTitle"></h3>
            <div class="news-sheet__meta">
                <div class="news-sheet__meta-item">
                    <div class="news-sheet__meta-icon"><i class="fas fa-user"></i></div>
                    <div class="news-sheet__meta-text">
                        <span class="news-sheet__meta-label">Reporter</span>
                        <span id="newsSheetReporter"></span>
                    </div>
                </div>
                <div class="news-sheet__meta-item">
                    <div class="news-sheet__meta-icon"><i class="fas fa-edit"></i></div>
                    <div class="news-sheet__meta-text">
                        <span class="news-sheet__meta-label">Editor</span>
                        <span id="newsSheetEditor"></span>
                    </div>
                </div>
                <div class="news-sheet__meta-item">
                    <div class="news-sheet__meta-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div class="news-sheet__meta-text">
                        <span class="news-sheet__meta-label">Tanggal</span>
                        <span id="newsSheetDate"></span>
                    </div>
                </div>
            </div>
            <p class="news-sheet__excerpt" id="newsSheetExcerpt"></p>
            <a href="#" class="news-sheet__btn" id="newsSheetBtn">
                <span>Baca Berita Lengkap</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

@include('landing-page.home.partials.news.components._index-styles')
@include('landing-page.home.partials.news.components._index-scripts')
