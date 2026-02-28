{{-- ===========================================================
     ARTICLE CARDS PARTIAL
     Rendered both on initial load and via AJAX.
     Variables required: $postarticle (LengthAwarePaginator)
     =========================================================== --}}

@php
    $cardColors = ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#0ea5e9'];
@endphp

{{-- ── Desktop Grid (d-none d-lg-block) ───────────────────────── --}}
<div class="d-none d-lg-block">
    @if($postarticle->isEmpty())
        <div class="ar-empty-state">
            <div class="ar-empty-visual">
                <div class="ar-empty-deco ar-empty-deco-1"></div>
                <div class="ar-empty-deco ar-empty-deco-2"></div>
                <div class="ar-empty-deco ar-empty-deco-3"></div>
                <div class="ar-empty-ring ar-empty-ring-1"></div>
                <div class="ar-empty-ring ar-empty-ring-2"></div>
                <div class="ar-empty-icon-wrap">
                    <i class="fas fa-search"></i>
                    <span class="ar-empty-sparkle ar-empty-sparkle-1">✨</span>
                    <span class="ar-empty-sparkle ar-empty-sparkle-2">📝</span>
                    <span class="ar-empty-sparkle ar-empty-sparkle-3">🔍</span>
                </div>
            </div>
            <h4 class="ar-empty-title">Artikel Tidak Ditemukan</h4>
            <p class="ar-empty-sub">Coba ubah kata kunci atau hapus beberapa filter yang aktif</p>
            <div class="ar-empty-tips">
                <span class="ar-empty-tip">💡 Coba kata kunci lebih umum</span>
                <span class="ar-empty-tip">🗑️ Hapus beberapa filter</span>
                <span class="ar-empty-tip">📅 Coba tahun berbeda</span>
            </div>
        </div>
    @else
        <div class="ar-grid">
            @foreach($postarticle as $article)
            @php $accent = $cardColors[$loop->index % count($cardColors)]; @endphp
            <div class="ar-card wow fadeInUp" style="--ar-accent: {{ $accent }}" data-wow-delay="0.{{ ($loop->index % 3 + 1) }}s">

                {{-- Full-width Image --}}
                <a href="/articles/{{ $article->id }}" class="ar-card-img-wrap">
                    <img src="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                         alt="{{ $article->title }}"
                         class="ar-card-img" loading="lazy">
                    <div class="ar-card-date">
                        <span class="ar-card-date-num">{{ \Carbon\Carbon::parse($article->dateevent)->format('d') }}</span>
                        <span class="ar-card-date-month">{{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('MMM') }}</span>
                    </div>
                </a>

                {{-- Card Body --}}
                <div class="ar-card-body">
                    <span class="ar-card-theme">{{ $article->theme }}</span>
                    <h3 class="ar-card-title">
                        <a href="/articles/{{ $article->id }}">{{ $article->title }}</a>
                    </h3>

                    {{-- People Card --}}
                    <div class="ar-card-people">
                        <div class="ar-card-meta-row">
                            <div class="ar-card-avatar">
                                <i class="fas fa-pen-fancy"></i>
                            </div>
                            <div class="ar-card-meta-info">
                                <span class="ar-card-meta-label">Penulis</span>
                                <span class="ar-card-meta-name">{{ $article->writer }}</span>
                            </div>
                        </div>
                        @if($article->editor)
                        <div class="ar-card-people-divider"></div>
                        <div class="ar-card-meta-row">
                            <div class="ar-card-avatar">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="ar-card-meta-info">
                                <span class="ar-card-meta-label">Editor</span>
                                <span class="ar-card-meta-name">{{ $article->editor }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <a href="/articles/{{ $article->id }}" class="ar-read-btn">
                        <span>Baca Artikel</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <div class="ar-share-wrap">
                        <span class="ar-share-label">Bagikan</span>
                        <div class="ar-share-row">
                            <button class="ar-share-btn ar-share-copy"
                                    data-url="/articles/{{ $article->id }}"
                                    onclick="arCopyUrl(this.dataset.url, event)">
                                <i class="fas fa-link"></i><span>Salin URL</span>
                            </button>
                            <button class="ar-share-btn ar-share-wa"
                                    data-url="/articles/{{ $article->id }}"
                                    data-title="{{ e($article->title) }}"
                                    onclick="arShareWa(this.dataset.url, this.dataset.title, event)">
                                <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                            </button>
                        </div>
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
            <div class="ar-empty-visual">
                <div class="ar-empty-deco ar-empty-deco-1"></div>
                <div class="ar-empty-deco ar-empty-deco-2"></div>
                <div class="ar-empty-deco ar-empty-deco-3"></div>
                <div class="ar-empty-ring ar-empty-ring-1"></div>
                <div class="ar-empty-ring ar-empty-ring-2"></div>
                <div class="ar-empty-icon-wrap">
                    <i class="fas fa-search"></i>
                    <span class="ar-empty-sparkle ar-empty-sparkle-1">✨</span>
                    <span class="ar-empty-sparkle ar-empty-sparkle-2">📝</span>
                    <span class="ar-empty-sparkle ar-empty-sparkle-3">🔍</span>
                </div>
            </div>
            <h4 class="ar-empty-title">Artikel Tidak Ditemukan</h4>
            <p class="ar-empty-sub">Coba ubah kata kunci atau hapus filter yang aktif</p>
            <div class="ar-empty-tips">
                <span class="ar-empty-tip">💡 Kata kunci lebih umum</span>
                <span class="ar-empty-tip">🗑️ Hapus filter</span>
            </div>
        </div>
    @else
        <div class="ar-mobile-carousel" id="ar-mobile-carousel">
            @foreach($postarticle as $article)
            @php $accent = $cardColors[$loop->index % count($cardColors)]; @endphp
            <div class="ar-mobile-card"
                 style="--ar-accent: {{ $accent }}"
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
                    <div class="ar-card-date">
                        <span class="ar-card-date-num">{{ \Carbon\Carbon::parse($article->dateevent)->format('d') }}</span>
                        <span class="ar-card-date-month">{{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('MMM') }}</span>
                    </div>
                    <div class="ar-m-tap-hint">Baca selengkapnya 👆</div>
                </div>

                <div class="ar-m-body">
                    <span class="ar-m-theme">{{ $article->theme }}</span>
                    <h4 class="ar-m-title">{{ $article->title }}</h4>
                    <div class="ar-card-people ar-card-people--sm">
                        <div class="ar-card-meta-row">
                            <div class="ar-card-avatar">
                                <i class="fas fa-pen-fancy"></i>
                            </div>
                            <div class="ar-card-meta-info">
                                <span class="ar-card-meta-label">Penulis</span>
                                <span class="ar-card-meta-name">{{ $article->writer }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="ar-share-wrap ar-share-wrap--sm">
                        <span class="ar-share-label">Bagikan</span>
                        <div class="ar-share-row ar-share-row--sm">
                            <button class="ar-share-btn ar-share-copy"
                                    data-url="/articles/{{ $article->id }}"
                                    onclick="arCopyUrl(this.dataset.url, event)">
                                <i class="fas fa-link"></i><span>Salin URL</span>
                            </button>
                            <button class="ar-share-btn ar-share-wa"
                                    data-url="/articles/{{ $article->id }}"
                                    data-title="{{ e($article->title) }}"
                                    onclick="arShareWa(this.dataset.url, this.dataset.title, event)">
                                <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                            </button>
                        </div>
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
