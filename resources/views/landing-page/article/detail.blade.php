@extends('landing-page.template.body')

@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
    $date = \Carbon\Carbon::parse($postarticle->dateevent);
@endphp

@section('openGraph')
<meta property="og:title" content="{{ $postarticle->title }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ asset($postarticle->poster) }}" />
<meta property="og:description" content="{{ $postarticle->theme }}" />
@endsection

@section('styles')
@include('landing-page.article.components._detail-styles')
@endsection

@section('content')

{{-- ── HERO ─────────────────────────────────────────────────────── --}}
<div class="ad-hero">
    <div class="ad-hero-blob ad-hero-blob-1"></div>
    <div class="ad-hero-blob ad-hero-blob-2"></div>
    <div class="ad-hero-blob ad-hero-blob-3"></div>

    <div class="container">
        <div class="ad-hero-inner">

            {{-- Date Card (desktop) --}}
            <div class="ad-date-card wow fadeInLeft d-none d-md-flex" data-wow-delay="0.1s">
                <div class="ad-date-day">{{ $date->isoFormat('dddd') }}</div>
                <div class="ad-date-num">{{ $date->format('d') }}</div>
                <div class="ad-date-month">{{ $date->isoFormat('MMMM') }}</div>
                <div class="ad-date-year">{{ $date->format('Y') }}</div>
                <div class="ad-date-deco"></div>
            </div>

            {{-- Info --}}
            <div class="ad-hero-info wow fadeInUp" data-wow-delay="0.15s">

                {{-- Mobile date chip --}}
                <div class="ad-date-chip d-md-none">
                    <i class="far fa-calendar-alt"></i>
                    {{ $date->isoFormat('dddd, D MMMM Y') }}
                </div>

                <span class="ad-theme-badge">
                    <span class="ad-theme-dot"></span>
                    {{ $postarticle->theme }}
                </span>

                <h1 class="ad-title">{{ $postarticle->title }}</h1>

                <div class="ad-authors">
                    <div class="ad-author-chip">
                        <div class="ad-author-icon"><i class="fas fa-pen-fancy"></i></div>
                        <div class="ad-author-text">
                            <span class="ad-author-label">Penulis</span>
                            <span class="ad-author-name">{{ $postarticle->writer }}</span>
                        </div>
                    </div>
                    @if($postarticle->editor)
                    <div class="ad-author-divider"></div>
                    <div class="ad-author-chip">
                        <div class="ad-author-icon"><i class="fas fa-edit"></i></div>
                        <div class="ad-author-text">
                            <span class="ad-author-label">Editor</span>
                            <span class="ad-author-name">{{ $postarticle->editor }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="ad-share-wrap">
                    <span class="ad-share-label">Bagikan</span>
                    <div class="ad-share-row">
                        <button class="ad-share-btn ad-share-copy" onclick="adCopyUrl(event)">
                            <i class="fas fa-link"></i><span>Salin URL</span>
                        </button>
                        <button class="ad-share-btn ad-share-wa"
                                data-title="{{ e($postarticle->title) }}"
                                onclick="adShareWa(this, event)">
                            <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                        </button>
                        <button class="ad-share-btn ad-share-tw"
                                data-title="{{ e($postarticle->title) }}"
                                onclick="adShareTw(this, event)">
                            <span style="font-weight:900; font-size:.9rem; line-height:1; letter-spacing:-1px;">X</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Smooth fade into main section --}}
    <div class="ad-hero-fade"></div>
</div>


{{-- ── MAIN ─────────────────────────────────────────────────────── --}}
<div class="container ad-main">
    <div class="row g-4">

        {{-- Reader --}}
        <div class="ad-page col-lg-8 wow fadeInUp" data-wow-delay="0.2s">
            <div class="ad-reader-card">
                <div class="ad-reader-bar">
                    <div class="ad-reader-dots">
                        <span class="ad-rd ad-rd-r"></span>
                        <span class="ad-rd ad-rd-y"></span>
                        <span class="ad-rd ad-rd-g"></span>
                    </div>
                    <div class="ad-reader-url-pill">
                        <i class="fas fa-lock"></i>
                        <span>anyflip.com</span>
                    </div>
                    <a href="{{ $postarticle->embedpdf }}" target="_blank" class="ad-reader-open" title="Buka di tab baru">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
                <div class="ad-reader-body">
                    <iframe src="{{ $postarticle->embedpdf }}" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>
        </div>

        {{-- Sidebar: desktop only --}}
        <div class="col-lg-4 wow fadeInUp d-none d-lg-block" data-wow-delay="0.3s">
            <div class="ad-sidebar">
                <div class="ad-sidebar-header">
                    <div class="ad-sidebar-icon-wrap">
                        <i class="fas fa-fire-flame-curved"></i>
                    </div>
                    <div>
                        <h5 class="ad-sidebar-title">Baca Juga</h5>
                        <p class="ad-sidebar-sub">Artikel pilihan untukmu</p>
                    </div>
                </div>
                <div class="ad-related-list">
                    @foreach($relatedArticles as $i => $article)
                    <a href="{{ $article->getArticleUrl() }}" class="ad-related-card">
                        <div class="ad-related-img-wrap">
                            <img src="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                                 alt="{{ $article->title }}" loading="lazy">
                            <div class="ad-related-overlay"></div>
                        </div>
                        <div class="ad-related-body">
                            <span class="ad-related-title">{{ $article->title }}</span>
                            <span class="ad-related-date">
                                <i class="far fa-calendar-alt"></i>
                                {{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('D MMM Y') }}
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- Bottom: Artikel Lainnya only --}}
    <div class="ad-actions wow fadeInUp" data-wow-delay="0.2s">
        <a href="/articles" class="ad-back-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Artikel Lainnya</span>
        </a>
    </div>

    {{-- Section divider --}}
    <div class="ad-section-divider wow fadeInUp" data-wow-delay="0.1s">
        <span class="ad-section-divider-icon"><i class="fas fa-comments"></i></span>
    </div>

    {{-- Disqus --}}
    <div class="ad-disqus-wrap wow fadeInUp" data-wow-delay="0.15s">
        <div id="disqus_thread"></div>
    </div>

</div>


{{-- ── MOBILE: Floating Baca Juga button ───────────────────────── --}}
<div class="ad-rj-float d-lg-none">
    <button class="ad-rj-float-btn" onclick="adOpenRjSheet()">
        <span class="ad-rj-float-icon"><i class="fas fa-fire-flame-curved"></i></span>
        <span>Baca Juga</span>
        <span class="ad-rj-badge">{{ count($relatedArticles) }}</span>
    </button>
</div>

{{-- ── MOBILE: Baca Juga Bottom Sheet ─────────────────────────── --}}
<div class="ad-rj-backdrop" id="ad-rj-backdrop"></div>
<div class="ad-rj-sheet" id="ad-rj-sheet">
    <div class="ad-rj-header">
        <div class="ad-rj-header-row">
            <div class="ad-rj-header-icon"><i class="fas fa-fire-flame-curved"></i></div>
            <div>
                <h5 class="ad-rj-header-title">Baca Juga</h5>
                <p class="ad-rj-header-sub">{{ count($relatedArticles) }} artikel pilihan</p>
            </div>
            <button class="ad-rj-close" onclick="adCloseRjSheet()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="ad-rj-grid">
        @foreach($relatedArticles as $i => $article)
        <a href="{{ $article->getArticleUrl() }}" class="ad-rj-item">
            <div class="ad-rj-item-img">
                <img src="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                     alt="{{ $article->title }}" loading="lazy">
                <div class="ad-rj-item-overlay"></div>
            </div>
            <div class="ad-rj-item-body">
                <span class="ad-rj-item-title">{{ $article->title }}</span>
                <span class="ad-rj-item-date">
                    <i class="far fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('D MMM Y') }}
                </span>
            </div>
        </a>
        @endforeach
    </div>
</div>

@endsection

@section('scripts')
@include('landing-page.article.components._detail-scripts')
@endsection
