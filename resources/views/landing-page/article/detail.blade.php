@extends('landing-page.template.body')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
@section('openGraph')
<meta property="og:title" content="{{ $postarticle->title }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:image" content="{{ asset($postarticle->poster) }}" />
<meta property="og:description" content="{{ $postarticle->theme }}" />
@endsection
@section('content')
<!-- Article Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-2 col-md-6 wow fadeInDown" data-wow-delay="0.5s">
                <div class="ps-4 mb-5 text-center">
                    <h5 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postarticle->dateevent )->format('Y') }}</h5>
                    <h6 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('MMMM') }}</h6>
                    <h1 class="display-6 mb-0">{{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('DD') }}</h1>
                    <p class="mb-0">{{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('dddd') }}</p>
                </div>
            </div>
            <div class="col-lg-10 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                <h6 class="text-body text-uppercase mb-2">{{ $postarticle->theme }}</h6>
                <h1 class="display-6 mb-4" style="text-align: left">{{ $postarticle->title }}</h1>
                <h6 class="text-body mb-0">Penulis : {{ $postarticle->writer }}</h6>
                <h6 class="text-body mb-0">Editor  : {{ $postarticle->editor }}</h6>
                </div>
            </div>
            <iframe style="width:1080px;height:600px" src="{{ $postarticle->embedpdf }}"  seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" ></iframe>
            <div class="text-start">
                <a class="small text-uppercase" href="/articles"><i class="fa fa-arrow-left ms-3"></i> Artikel Lainnya</a>
            </div>
            <div class="col-lg-12 col-md-6 text-start">
                <hr>
            </div>
            <div class="col-lg-12 col-md-6 wow fadeInUp text-start">
                <div id="disqus_thread"></div>
            </div>
        </div>
    </div>
</div>
<!-- Article End -->
@endsection

@section('scripts')
<script>
    /**
    *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
    *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
    /*
    var disqus_config = function () {
    this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
    this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
    };
    */
    (function() { // DON'T EDIT BELOW THIS LINE
    var d = document, s = d.createElement('script');
    s.src = 'https://https-ldksyah-id-1.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
@endsection
