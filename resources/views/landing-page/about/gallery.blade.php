@extends('landing-page.template.body')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="https://lh3.googleusercontent.com/d/1Y4z7FlfDyACvm6jyaWvCQHNB_-1NgnVz" alt="Image" />
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Gallery Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            @forelse($postgallery as $key => $post)
            <div class="col-lg-12 col-md-6 wow fadeInUp mb-5" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                    <h6 class="text-body mb-2">{{ $post->eventName }}</h6>
                    <h2 class="mb-0">{{ $post->eventTheme }}</h2>
                    <p class="mb-0 mt-1" style="text-align: justify">
                        {{ $post->eventDescription }}
                    </p>
                </div>
                @if (!empty($post->linkDoc))
                <div class="mb-3">
                    <p>Link Dokumentasi : <a href="{{ $post->linkDoc }}" target="_blank" rel="noopener noreferrer">{{ \Illuminate\Support\Str::limit($post->linkDoc, 80, '...') }}</a></p>
                </div>
                @endif

                <div class="row g-0">
                    <div class="col-lg-12 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1">
                            <img class="img-fluid w-100" src="https://lh3.googleusercontent.com/d/{{ $post->gdrive_id }}" alt="Group Photo" width="700" height="500" />
                        </div>
                    </div>

                    @for($i = 1; $i <= 12; $i++)
                        @php $gdriveKey = 'gdrive_id_' . $i; @endphp
                        @if ($post->$gdriveKey)
                        <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                            <div class="position-relative m-1 img-hover-zoom">
                                <img class="img-fluid w-100" src="https://lh3.googleusercontent.com/d/{{ $post->$gdriveKey }}" alt="Photo {{ $i }}" />
                            </div>
                        </div>
                        @endif
                    @endfor

                    @if ($post->linkEmbedYoutube)
                    <div class="col-lg-12 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="m-1">
                            <iframe width="100%" height="600" src="{{ $post->linkEmbedYoutube }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-lg-12 col-md-6 wow fadeInUp mb-5" data-wow-delay="0.1s" style="text-align: center">
                <h1>Dokumentasi Kegiatan Belum Tersedia</h1>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Gallery End -->
@endsection
