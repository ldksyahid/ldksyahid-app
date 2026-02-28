{{-- resources/views/landing-page/news/detail.blade.php --}}
@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     OPEN GRAPH
     ══════════════════════════════════════════════════ --}}
@section('openGraph')
<meta property="og:title"       content="{{ $postnews->title }}" />
<meta property="og:type"        content="article" />
<meta property="og:url"         content="{{ url()->current() }}" />
<meta property="og:image"       content="{{ $postnews->getPictureUrl() }}" />
<meta property="og:image:width" content="400" />
<meta property="og:image:height" content="300" />
<meta property="og:description" content="{{ substr(strip_tags($postnews->body), 0, 160) }}" />
<meta property="og:image:alt"   content="{{ $postnews->descpicture }}" />
@endsection


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.news.components._detail-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

{{-- Reading Progress Bar --}}
<div class="nd-progress" id="nd-progress"></div>

{{-- ══════════════════════════════════════════════════
     HERO — Full-width featured image
     ══════════════════════════════════════════════════ --}}
<div class="nd-hero">

    {{-- Background image --}}
    <div class="nd-hero-bg"
         style="background-image: url('{{ $postnews->getPictureUrl() }}')">
    </div>

    {{-- Dark gradient overlay --}}
    <div class="nd-hero-overlay"></div>

    {{-- Hero content --}}
    <div class="nd-hero-content">
        <div class="container">

            {{-- Publisher badge --}}
            <div class="nd-hero-badge">
                <span class="nd-hero-badge-dot"></span>
                {{ $postnews->publisher }}
            </div>

            {{-- Title --}}
            <h1 class="nd-hero-title">{{ $postnews->title }}</h1>

            {{-- Meta chips --}}
            <div class="nd-hero-metas">
                <span class="nd-hero-meta">
                    <i class="far fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($postnews->datepublish)->isoFormat('dddd, D MMMM Y') }}
                </span>
                <span class="nd-hero-meta">
                    <i class="fas fa-user-edit"></i>
                    Reporter: {{ $postnews->reporter }}
                </span>
                @if($postnews->editor)
                <span class="nd-hero-meta">
                    <i class="fas fa-pen"></i>
                    Editor: {{ $postnews->editor }}
                </span>
                @endif
            </div>

        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════
     MAIN CONTENT
     ══════════════════════════════════════════════════ --}}
<div class="nd-content-wrap">
    <div class="container">

        {{-- Back button --}}
        <a href="{{ route('news.index') }}" class="nd-back-btn nd-enter">
            <i class="fas fa-arrow-left"></i>
            <span>Berita Lainnya</span>
        </a>

        {{-- Flexbox layout: main + sidebar (no Bootstrap row on mobile) --}}
        <div class="nd-layout">

            {{-- ── MAIN COLUMN ─────────────────────────────────────── --}}
            <div class="nd-main">

                {{-- Featured image + caption --}}
                <div class="nd-enter" style="transition-delay:.05s">
                    <img src="{{ $postnews->getPictureUrl() }}"
                         alt="{{ $postnews->title }}"
                         style="width:100%;border-radius:20px;object-fit:cover;max-height:420px;box-shadow:0 8px 32px rgba(0,0,0,.1);display:block;margin-bottom:.5rem;"
                         loading="eager">
                    @if($postnews->descpicture)
                    <p class="nd-img-caption">{{ $postnews->descpicture }}</p>
                    @endif
                </div>

                {{-- Article body --}}
                <div class="nd-body-card nd-enter" style="transition-delay:.1s">
                    <div class="nd-body">
                        {!! $postnews->body !!}
                    </div>
                </div>

                {{-- Divider --}}
                <div class="nd-divider nd-enter" style="transition-delay:.15s"></div>

                {{-- Share section --}}
                <div class="nd-share-section nd-enter" style="transition-delay:.2s">
                    <span class="nd-share-section-label">Bagikan Berita</span>
                    <div class="nd-share-btns">
                        <button class="nd-share-full-btn nd-share-copy">
                            <i class="fas fa-link"></i>
                            <span>Salin URL</span>
                        </button>
                        <button class="nd-share-full-btn nd-share-wa"
                                data-title="{{ e($postnews->title) }}">
                            <i class="fab fa-whatsapp"></i>
                            <span>Bagikan ke WhatsApp</span>
                        </button>
                    </div>
                </div>

                {{-- Comments --}}
                <div class="nd-comments-section nd-enter" style="transition-delay:.25s">
                    <h3 class="nd-comments-title">
                        <i class="far fa-comments" style="color:var(--nd-primary)"></i>
                        Komentar
                    </h3>
                    <div id="disqus_thread"></div>
                </div>

            </div>{{-- /nd-main --}}


            {{-- ── SIDEBAR ──────────────────────────────────────────── --}}
            <aside class="nd-aside nd-enter" style="transition-delay:.08s">
                <div class="nd-sidebar">

                    {{-- Meta info card --}}
                    <div class="nd-card-box">
                        <div class="nd-card-box-title">
                            <i class="fas fa-info-circle"></i>
                            Informasi Berita
                        </div>

                        <div class="nd-meta-item">
                            <div class="nd-meta-icon"><i class="far fa-calendar-alt"></i></div>
                            <div class="nd-meta-text">
                                <span class="nd-meta-label">Tanggal Terbit</span>
                                <span class="nd-meta-value">
                                    {{ \Carbon\Carbon::parse($postnews->datepublish)->isoFormat('D MMMM Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="nd-meta-item">
                            <div class="nd-meta-icon"><i class="fas fa-building"></i></div>
                            <div class="nd-meta-text">
                                <span class="nd-meta-label">Penerbit</span>
                                <span class="nd-meta-value">{{ $postnews->publisher }}</span>
                            </div>
                        </div>

                        <div class="nd-meta-item">
                            <div class="nd-meta-icon"><i class="fas fa-user-edit"></i></div>
                            <div class="nd-meta-text">
                                <span class="nd-meta-label">Reporter</span>
                                <span class="nd-meta-value">{{ $postnews->reporter }}</span>
                            </div>
                        </div>

                        @if($postnews->editor)
                        <div class="nd-meta-item">
                            <div class="nd-meta-icon"><i class="fas fa-pen"></i></div>
                            <div class="nd-meta-text">
                                <span class="nd-meta-label">Editor</span>
                                <span class="nd-meta-value">{{ $postnews->editor }}</span>
                            </div>
                        </div>
                        @endif

                    </div>{{-- /nd-card-box --}}


                    {{-- Share card --}}
                    <div class="nd-card-box">
                        <div class="nd-card-box-title">
                            <i class="fas fa-share-alt"></i>
                            Bagikan
                        </div>
                        <div class="nd-share-row">
                            <button class="nd-share-btn nd-share-copy">
                                <i class="fas fa-link"></i>
                                <span>Salin</span>
                            </button>
                            <button class="nd-share-btn nd-share-wa"
                                    data-title="{{ e($postnews->title) }}">
                                <i class="fab fa-whatsapp"></i>
                                <span>WhatsApp</span>
                            </button>
                        </div>
                    </div>


                    {{-- Related news card --}}
                    <div class="nd-card-box">
                        <div class="nd-card-box-title">
                            <i class="fas fa-newspaper"></i>
                            Berita Lainnya
                        </div>

                        @if($relatedNews->isEmpty())
                            <p class="nd-related-empty">Belum ada berita lainnya.</p>
                        @else
                            <div class="nd-related-list">
                                @foreach($relatedNews as $rel)
                                <a href="{{ route('news.show', $rel->id) }}" class="nd-related-item">
                                    <img src="{{ $rel->getPictureUrl() }}"
                                         alt="{{ $rel->title }}"
                                         class="nd-related-thumb" loading="lazy">
                                    <div class="nd-related-info">
                                        <div class="nd-related-title">{{ $rel->title }}</div>
                                        <div class="nd-related-date">
                                            <i class="far fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($rel->datepublish)->isoFormat('D MMM Y') }}
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        @endif

                    </div>{{-- /nd-card-box related --}}

                </div>{{-- /nd-sidebar --}}
            </aside>{{-- /nd-aside --}}

        </div>{{-- /nd-layout --}}

    </div>{{-- /container --}}
</div>{{-- /nd-content-wrap --}}

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.news.components._detail-scripts')
@endsection
