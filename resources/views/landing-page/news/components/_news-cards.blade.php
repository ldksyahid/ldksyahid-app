{{-- ===========================================================
     NEWS CARDS PARTIAL
     Rendered both on initial load and via AJAX.
     Variables required: $postnews (LengthAwarePaginator)
     =========================================================== --}}

@php
    $cardColors = ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#0ea5e9'];
@endphp

{{-- ── Desktop Grid (d-none d-lg-block) ───────────────────────── --}}
<div class="d-none d-lg-block">
    @if($postnews->isEmpty())
        <div class="nw-empty-state">
            <div class="nw-empty-visual">
                <div class="nw-empty-deco nw-empty-deco-1"></div>
                <div class="nw-empty-deco nw-empty-deco-2"></div>
                <div class="nw-empty-deco nw-empty-deco-3"></div>
                <div class="nw-empty-ring nw-empty-ring-1"></div>
                <div class="nw-empty-ring nw-empty-ring-2"></div>
                <div class="nw-empty-icon-wrap">
                    <i class="fas fa-newspaper"></i>
                    <span class="nw-empty-sparkle nw-empty-sparkle-1">✨</span>
                    <span class="nw-empty-sparkle nw-empty-sparkle-2">📰</span>
                    <span class="nw-empty-sparkle nw-empty-sparkle-3">🔍</span>
                </div>
            </div>
            <h4 class="nw-empty-title">Berita Tidak Ditemukan</h4>
            <p class="nw-empty-sub">Coba ubah kata kunci atau hapus beberapa filter yang aktif</p>
            <div class="nw-empty-tips">
                <span class="nw-empty-tip">💡 Coba kata kunci lebih umum</span>
                <span class="nw-empty-tip">🗑️ Hapus beberapa filter</span>
                <span class="nw-empty-tip">📅 Coba tahun berbeda</span>
            </div>
        </div>
    @else
        <div class="nw-grid">
            @foreach($postnews as $news)
            @php
                $accent  = $cardColors[$loop->index % count($cardColors)];
                $excerpt = substr(strip_tags($news->body), 0, 115);
                if (strlen(strip_tags($news->body)) > 115) $excerpt .= '…';
            @endphp
            <div class="nw-card wow fadeInUp"
                 style="--nw-accent: {{ $accent }}"
                 data-wow-delay="0.{{ ($loop->index % 3 + 1) }}s">

                {{-- Featured Image --}}
                <a href="/news/{{ $news->id }}" class="nw-card-img-wrap">
                    <img src="{{ $news->getPictureUrl() }}"
                         alt="{{ $news->title }}"
                         class="nw-card-img" loading="lazy">

                    {{-- Date badge overlay --}}
                    <div class="nw-card-date">
                        <span class="nw-card-date-num">{{ \Carbon\Carbon::parse($news->datepublish)->format('d') }}</span>
                        <span class="nw-card-date-month">{{ \Carbon\Carbon::parse($news->datepublish)->isoFormat('MMM') }}</span>
                    </div>
                </a>

                {{-- Card Body --}}
                <div class="nw-card-body">
                    {{-- Publisher badge --}}
                    <span class="nw-card-publisher">{{ $news->publisher }}</span>

                    {{-- Title --}}
                    <h3 class="nw-card-title">
                        <a href="/news/{{ $news->id }}">{{ $news->title }}</a>
                    </h3>

                    {{-- Excerpt --}}
                    @if($excerpt)
                    <p class="nw-card-excerpt">{{ $excerpt }}</p>
                    @endif

                    {{-- Reporter / Editor --}}
                    <div class="nw-card-people">
                        <div class="nw-card-meta-row">
                            <div class="nw-card-avatar"><i class="fas fa-user-edit"></i></div>
                            <div class="nw-card-meta-info">
                                <span class="nw-card-meta-label">Reporter</span>
                                <span class="nw-card-meta-name">{{ $news->reporter }}</span>
                            </div>
                        </div>
                        @if($news->editor)
                        <div class="nw-card-people-divider"></div>
                        <div class="nw-card-meta-row">
                            <div class="nw-card-avatar"><i class="fas fa-pen"></i></div>
                            <div class="nw-card-meta-info">
                                <span class="nw-card-meta-label">Editor</span>
                                <span class="nw-card-meta-name">{{ $news->editor }}</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Read CTA --}}
                    <a href="/news/{{ $news->id }}" class="nw-read-btn">
                        <span>Baca Selengkapnya</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>

                    {{-- Share --}}
                    <div class="nw-card-share">
                        <span class="nw-card-share-label">Bagikan</span>
                        <div class="nw-card-share-btns">
                            <button class="nw-card-share-btn nw-card-share-btn--copy"
                                    title="Salin URL"
                                    data-url="/news/{{ $news->id }}"
                                    onclick="nwCopyUrl(this.dataset.url, event)">
                                <i class="fas fa-link"></i>
                            </button>
                            <button class="nw-card-share-btn nw-card-share-btn--wa"
                                    title="WhatsApp"
                                    data-url="/news/{{ $news->id }}"
                                    data-title="{{ e($news->title) }}"
                                    onclick="nwShareWa(this.dataset.url, this.dataset.title, event)">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                            <button class="nw-card-share-btn nw-card-share-btn--tw"
                                    title="Twitter / X"
                                    data-url="/news/{{ $news->id }}"
                                    data-title="{{ e($news->title) }}"
                                    onclick="nwShareTw(this.dataset.url, this.dataset.title, event)">
                                <i class="fab fa-twitter"></i>
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
    @if($postnews->isEmpty())
        <div class="nw-empty-state">
            <div class="nw-empty-visual">
                <div class="nw-empty-deco nw-empty-deco-1"></div>
                <div class="nw-empty-deco nw-empty-deco-2"></div>
                <div class="nw-empty-ring nw-empty-ring-1"></div>
                <div class="nw-empty-ring nw-empty-ring-2"></div>
                <div class="nw-empty-icon-wrap">
                    <i class="fas fa-newspaper"></i>
                    <span class="nw-empty-sparkle nw-empty-sparkle-1">✨</span>
                    <span class="nw-empty-sparkle nw-empty-sparkle-2">📰</span>
                </div>
            </div>
            <h4 class="nw-empty-title">Berita Tidak Ditemukan</h4>
            <p class="nw-empty-sub">Coba ubah kata kunci atau hapus filter yang aktif</p>
            <div class="nw-empty-tips">
                <span class="nw-empty-tip">💡 Kata kunci lebih umum</span>
                <span class="nw-empty-tip">🗑️ Hapus filter</span>
            </div>
        </div>
    @else
        <div class="nw-mobile-carousel" id="nw-mobile-carousel">
            @foreach($postnews as $news)
            @php
                $accent  = $cardColors[$loop->index % count($cardColors)];
                $excerpt = substr(strip_tags($news->body), 0, 120);
                if (strlen(strip_tags($news->body)) > 120) $excerpt .= '…';
            @endphp
            <div class="nw-mobile-card"
                 style="--nw-accent: {{ $accent }}"
                 data-id="{{ $news->id }}"
                 data-title="{{ e($news->title) }}"
                 data-publisher="{{ e($news->publisher) }}"
                 data-date="{{ \Carbon\Carbon::parse($news->datepublish)->isoFormat('dddd, D MMMM Y') }}"
                 data-reporter="{{ e($news->reporter) }}"
                 data-editor="{{ e($news->editor ?? '') }}"
                 data-image="{{ $news->gdrive_id }}"
                 data-url="/news/{{ $news->id }}"
                 data-excerpt="{{ e($excerpt) }}"
                 onclick="nwOpenBottomSheet(this)">

                {{-- Thumbnail --}}
                <div class="nw-m-thumb">
                    <img src="{{ $news->getPictureUrl() }}"
                         alt="{{ $news->title }}" loading="lazy">
                    <div class="nw-card-date">
                        <span class="nw-card-date-num">{{ \Carbon\Carbon::parse($news->datepublish)->format('d') }}</span>
                        <span class="nw-card-date-month">{{ \Carbon\Carbon::parse($news->datepublish)->isoFormat('MMM') }}</span>
                    </div>
                    <div class="nw-m-tap-hint">Baca selengkapnya 👆</div>
                </div>

                {{-- Card body --}}
                <div class="nw-m-body">
                    <span class="nw-m-publisher">{{ $news->publisher }}</span>
                    <h4 class="nw-m-title">{{ $news->title }}</h4>
                    <div class="nw-card-people nw-card-people--sm">
                        <div class="nw-card-meta-row">
                            <div class="nw-card-avatar"><i class="fas fa-user-edit"></i></div>
                            <div class="nw-card-meta-info">
                                <span class="nw-card-meta-label">Reporter</span>
                                <span class="nw-card-meta-name">{{ $news->reporter }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="nw-card-share" style="margin-top:.5rem; padding-top:.6rem;">
                        <span class="nw-card-share-label">Bagikan</span>
                        <div class="nw-card-share-btns">
                            <button class="nw-card-share-btn nw-card-share-btn--copy"
                                    title="Salin URL"
                                    data-url="/news/{{ $news->id }}"
                                    onclick="nwCopyUrl(this.dataset.url, event)">
                                <i class="fas fa-link"></i>
                            </button>
                            <button class="nw-card-share-btn nw-card-share-btn--wa"
                                    title="WhatsApp"
                                    data-url="/news/{{ $news->id }}"
                                    data-title="{{ e($news->title) }}"
                                    onclick="nwShareWa(this.dataset.url, this.dataset.title, event)">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                            <button class="nw-card-share-btn nw-card-share-btn--tw"
                                    title="Twitter / X"
                                    data-url="/news/{{ $news->id }}"
                                    data-title="{{ e($news->title) }}"
                                    onclick="nwShareTw(this.dataset.url, this.dataset.title, event)">
                                <i class="fab fa-twitter"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Scroll indicator dots --}}
        <div class="nw-carousel-dots" id="nw-carousel-dots"></div>
    @endif
</div>

{{-- ── Pagination ─────────────────────────────────────────────── --}}
<div class="nw-pagination-wrap mt-4">
    @include('components.pagination-custom.index', [
        'paginator'  => $postnews,
        'itemLabel'  => 'berita',
    ])
</div>
