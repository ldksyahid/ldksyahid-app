@extends('landing-page.template.body')
@section('openGraph')
<meta property="og:title" content="{{ $postnews->title }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:image" content="https://drive.google.com/thumbnail?id={{ $postnews->gdrive_id }}" />
<meta property="og:image:width" content="400" />
<meta property="og:image:height" content="300" />
<meta property="og:description" content="{!!  substr(strip_tags($postnews->body), 0, 80) !!}" />
<meta property="og:image:alt" content="{{ $postnews->descpicture }}" />
@endsection
@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="ps-4 text-center">
                    <h5 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('Y') }}</h5>
                    <h6 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('MMMM') }}</h6>
                    <h1 class="display-6 mb-0">{{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('DD') }}</h1>
                    <p class="mb-0">{{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('dddd') }}</p>
                </div>
            </div>
            <div class="col-lg-10 col-md-6 wow fadeInDown" data-wow-delay="0.5s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                    <h6 class="text-body mb-2">Dipublikasikan oleh {{ $postnews->publisher }}</h6>
                    <h1 class="display-6 mb-0" style="text-align: left">{{ $postnews->title }}</h1>
                </div>
            </div>
            <div class="wow fadeInUp " data-wow-delay="1.0s">
                <div class="col-lg-10 col-md-6 text-start">
                    <p class="mb-2 text-start"><i>Reporter</i> {{ $postnews->reporter }}; <i>Editor</i> {{ $postnews->editor }}</p>
                    <img src="https://drive.google.com/thumbnail?id={{ $postnews->gdrive_id }}" alt="{{$postnews->title}}" class="img-fluid rounded">
                    <p class="mt-1 small text-center"><i>{{ $postnews->descpicture }}</i></p>
                </div>
                <div class="mb-1 col-lg-10 col-md-6" style="">
                    <p data-wow-delay="0.5s">{!! $postnews->body !!}</p>
                </div>
                <div class="text-start">
                    <a class="small text-uppercase" href="/news"><i class="fa fa-arrow-left mr-3"></i> Berita Lainnya</a>
                </div>
                <div class="col-lg-10 col-md-6 text-start">
                    <hr>
                </div>
                <div class="col-lg-10 col-md-6 wow fadeInUp text-start">
                    <div id="disqus_thread"></div>
                </div>
            </div>
        </div>
    </div>
</div>

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
