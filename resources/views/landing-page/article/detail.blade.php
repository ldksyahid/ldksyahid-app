@extends('landing-page.template.body')

@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp

@section('openGraph')
<meta property="og:title" content="{{ $postarticle->title }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ asset($postarticle->poster) }}" />
<meta property="og:description" content="{{ $postarticle->theme }}" />
@endsection

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-5 wow fadeInDown" data-wow-delay="0.2s">
                <div class="dateevent-box text-center bg-white border shadow-sm rounded-4 px-3 py-4">
                    <div class="text-primary fw-bold" style="font-size: 1.25rem;">
                        {{ \Carbon\Carbon::parse($postarticle->dateevent)->isoFormat('dddd') }}
                    </div>
                    <div class="display-4 fw-bold text-dark my-2" style="line-height: 1;">
                        {{ \Carbon\Carbon::parse($postarticle->dateevent)->isoFormat('DD') }}
                    </div>
                    <div class="text-uppercase text-secondary small mb-1">
                        {{ \Carbon\Carbon::parse($postarticle->dateevent)->isoFormat('MMMM') }}
                    </div>
                    <div class="text-muted fw-medium">
                        {{ \Carbon\Carbon::parse($postarticle->dateevent)->format('Y') }}
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-md-7 wow fadeInUp" data-wow-delay="0.2s">
                <div class="border-start border-4 border-primary ps-4 mb-4">
                    <span class="badge bg-primary rounded-pill px-3 py-1 text-uppercase">{{ $postarticle->theme }}</span>
                    <h1 class="display-6 fw-bold mt-3">{{ $postarticle->title }}</h1>
                    <div class="row g-2 text-secondary small">
                        <div class="col-12 col-sm-6">
                            <strong class="text-muted">Penulis:</strong>
                            <span class="d-block" style="color: #8d9297;">{{ $postarticle->writer }}</span>
                        </div>
                        <div class="col-12 col-sm-6">
                            <strong class="text-muted">Editor:</strong>
                            <span class="d-block" style="color: #8d9297;">{{ $postarticle->editor }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 wow fadeInUp" data-wow-delay="0.2s">
                <div class="rounded-4 overflow-hidden shadow-sm border">
                    <iframe src="{{ $postarticle->embedpdf }}" class="w-100" style="min-height: 600px; border: none;" allowfullscreen></iframe>
                </div>
            </div>

            <div class="col-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                <div class="bg-light p-4 shadow-sm rounded-4">
                    <h5 class="fw-bold mb-4">Baca Juga</h5>
                    @foreach($relatedArticles as $article)
                        <a href="{{ url('/articles/' . $article->id) }}" class="text-decoration-none">
                            <div class="related-article-box text-dark mb-3 px-3 py-3">
                                <div class="fw-semibold mb-1">{{ $article->title }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('D MMM Y') }}</small>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-12">
                <a class="btn btn-outline-primary rounded-pill px-4" href="/articles">
                    <i class="fa fa-arrow-left me-2"></i> Artikel Lainnya
                </a>
            </div>

            <div class="col-12">
                <hr class="rounded-pill border-primary opacity-50">
            </div>

            <div class="col-12">
                <div class="bg-light p-4 rounded-4 shadow-sm">
                    <div id="disqus_thread"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .rounded-4 {
        border-radius: 1.5rem !important;
    }

    hr.rounded-pill {
        height: 4px;
        border: none;
        background-color: #00a79d;
        border-radius: 2rem;
        margin: 2rem 0;
    }

    iframe {
        border-radius: 1.25rem;
    }

    .dateevent-box {
        background-color: #f9f9f9;
        border-left: 6px solid #00a79d;
        transition: all 0.3s ease;
    }

    .dateevent-box:hover {
        background-color: #e4f9f7;
        box-shadow: 0 4px 12px rgba(0, 167, 157, 0.15);
    }

    .related-article-box {
        background-color: white;
        border: 1px solid #e5e5e5;
        border-radius: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    }

    .related-article-box:hover {
        background-color: #f0fdfd;
        border-color: #00a79d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 167, 157, 0.2);
    }

    .related-article-box .fw-semibold {
        font-size: 0.95rem;
        color: #333;
    }

    .related-article-box small {
        color: #8d9297;
        font-size: 0.8rem;
    }

    .badge.bg-primary,
    .btn-outline-primary,
    .border-primary {
        border-color: #00a79d !important;
        color: #00a79d !important;
    }

    .btn-outline-primary:hover {
        background-color: #00a79d !important;
        color: white !important;
        border-color: #00a79d !important;
    }

    .badge.bg-primary {
        background-color: #00a79d !important;
        color: white !important;
    }

    .wow {
        animation-duration: 0.8s;
        animation-fill-mode: both;
    }
</style>
@endsection

@section('scripts')
<script>
    (function() {
        var d = document, s = d.createElement('script');
        s.src = 'https://https-ldksyah-id-1.disqus.com/embed.js';
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>
    Please enable JavaScript to view the
    <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
</noscript>
@endsection
