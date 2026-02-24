{{-- ===========================================================
     ARTICLE CARDS PARTIAL
     Rendered both on initial load and via AJAX.
     Variables required: $postarticle (LengthAwarePaginator)
     =========================================================== --}}

{{-- ── Desktop Grid (d-none d-lg-block) ───────────────────────── --}}
<div class="d-none d-lg-block">
    @if($postarticle->isEmpty())
        <div class="ar-empty-state">
            <div class="ar-empty-icon">📄</div>
            <h4>Belum Ada Artikel</h4>
            <p>Tidak ada artikel yang sesuai dengan pencarian atau filter Anda.</p>
        </div>
    @else
        <div class="ar-grid">
            @foreach($postarticle as $article)
            <div class="ar-card wow fadeInUp" data-wow-delay="0.{{ ($loop->index % 3 + 1) }}s">

                {{-- Card Image --}}
                <a href="/articles/{{ $article->id }}" class="ar-card-img-link">
                    <div class="ar-card-img-wrap">
                        <img src="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                             alt="{{ $article->title }}"
                             class="ar-card-img" loading="lazy">
                        @if($loop->first && $postarticle->currentPage() == 1)
                            <span class="ar-card-badge-new">✦ Terbaru</span>
                        @endif
                        <div class="ar-card-img-overlay"></div>
                    </div>
                </a>

                {{-- Card Body --}}
                <div class="ar-card-body">
                    <div class="ar-card-meta">
                        <span class="ar-card-date">
                            <i class="far fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('D MMM Y') }}
                        </span>
                    </div>

                    <span class="ar-card-theme">{{ $article->theme }}</span>

                    <h3 class="ar-card-title">
                        <a href="/articles/{{ $article->id }}">{{ $article->title }}</a>
                    </h3>

                    <div class="ar-card-info">
                        <div class="ar-card-info-item">
                            <span class="ar-bullet"></span>
                            <span><strong>Penulis:</strong> {{ $article->writer }}</span>
                        </div>
                        <div class="ar-card-info-item">
                            <span class="ar-bullet"></span>
                            <span><strong>Editor:</strong> {{ $article->editor }}</span>
                        </div>
                    </div>

                    <div class="ar-card-cta">
                        <a href="/articles/{{ $article->id }}" class="ar-read-btn">
                            <span>Baca Artikel</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ── Mobile Carousel (d-lg-none) ─────────────────────────────── --}}
<div class="d-lg-none">
    @if($postarticle->isEmpty())
        <div class="ar-empty-state">
            <div class="ar-empty-icon">📄</div>
            <h4>Belum Ada Artikel</h4>
            <p>Tidak ada artikel yang sesuai.</p>
        </div>
    @else
        <div class="ar-mobile-carousel" id="ar-mobile-carousel">
            @foreach($postarticle as $article)
            <div class="ar-mobile-card"
                 data-id="{{ $article->id }}"
                 data-title="{{ e($article->title) }}"
                 data-theme="{{ e($article->theme) }}"
                 data-date="{{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('dddd, D MMMM Y') }}"
                 data-writer="{{ e($article->writer) }}"
                 data-editor="{{ e($article->editor) }}"
                 data-image="{{ $article->gdrive_id }}"
                 data-url="/articles/{{ $article->id }}"
                 onclick="arOpenBottomSheet(this)">

                <div class="ar-m-thumb">
                    <img src="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                         alt="{{ $article->title }}" loading="lazy">
                    @if($loop->first && $postarticle->currentPage() == 1)
                        <span class="ar-m-badge-new">✦ Terbaru</span>
                    @endif
                    <div class="ar-m-thumb-overlay"></div>
                </div>

                <div class="ar-m-body">
                    <span class="ar-m-theme">{{ $article->theme }}</span>
                    <h4 class="ar-m-title">{{ $article->title }}</h4>
                    <p class="ar-m-meta">
                        <i class="far fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('D MMM Y') }}
                    </p>
                    <div class="ar-m-tap-hint">
                        <i class="fas fa-book-open"></i>
                        <span>Lihat Detail</span>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Carousel scroll indicator dots --}}
        <div class="ar-carousel-dots" id="ar-carousel-dots"></div>
    @endif
</div>

{{-- ── Pagination ─────────────────────────────────────────────── --}}
<div class="ar-pagination-wrap mt-4">
    @include('components.pagination-custom', [
        'paginator'  => $postarticle,
        'itemLabel'  => 'artikel',
    ])
</div>
