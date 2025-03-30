@extends('landing-page.template.body')

@section('openGraph')
<meta property="og:title" content="{{ $postevent->title }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:image" content="https://lh3.googleusercontent.com/d/{{ $postevent->gdrive_id }}" />
<meta property="og:description" content="{!!  substr(strip_tags($postevent->broadcast), 0, 100) !!}" />
@endsection

@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
@if((new \Jenssegers\Agent\Agent())->isDesktop())
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-3">
                <img src="https://lh3.googleusercontent.com/d/{{ $postevent->gdrive_id }}" alt="{{ $postevent->title }}" style="border-radius: 5px;" class="img-fluid shadow">
            </div>
            <div class="col-6">
                @if ($postevent->tag != null)
                <button type="button" class="btn btn-outline-secondary" style="border-radius: 5px; padding:2px 10px; font-size:13px;" disabled>{{ $postevent->tag }}</button>
                @else
                <button type="button" class="btn btn-outline-secondary" style="border-radius: 5px; padding:2px 10px; font-size:13px;" disabled>Seminar</button>
                @endif
                <h2 class="my-2" style="text-align: left; font-size :28px;">{{ $postevent->title }}</h2>
                <p>Diselenggarakan oleh: {{ $postevent->division }}</p>
            </div>
            <div class="col-3 text-center">
                @if (time() <= strtotime($postevent->start))
                <div>
                    <p class="mt-4 mb-0">Terbuka Hingga:</p>
                    <h1 class="display-6" style="font-size :16px; margin-top:2px;">{{ \Carbon\Carbon::parse( $postevent->closeRegist )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $postevent->closeRegist )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $postevent->closeRegist )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postevent->closeRegist )->format('Y') }}</h1>
                </div>
                <div>
                    <p class="mt-4 mb-0">Countdown:</p>
                    <h1 class="display-6" style="font-size :16px; margin-top:2px;">{{ LFC::countdownHari($postevent->start) }} Hari Lagi</h1>
                </div>
                @elseif (time() > strtotime($postevent->start) && time() <= strtotime($postevent->finished))
                <div>
                    <h1 class="display-6 mt-5 mb-0" style="font-size :16px; margin-top:2px;">Event Sedang Berlangsung</h1>
                </div>
                @else
                <div>
                    <h1 class="display-6 mt-5 mb-0" style="font-size :16px; margin-top:2px;">Event Telah Selesai</h1>
                </div>
                @endif
            </div>
            <div class="col-lg-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-desc-tab" data-bs-toggle="tab" data-bs-target="#nav-desc" type="button" role="tab" aria-controls="nav-desc" aria-selected="true" style="color: #8d9297; border-radius: 5px 5px 0px 0px;">Deskripsi</button>
                        <button class="nav-link" id="nav-doc-tab" data-bs-toggle="tab" data-bs-target="#nav-doc" type="button" role="tab" aria-controls="nav-doc" aria-selected="false" style="color: #8d9297; border-radius: 5px 5px 0px 0px;">Dokumentasi</button>
                        <button class="nav-link" id="nav-disc-tab" data-bs-toggle="tab" data-bs-target="#nav-disc" type="button" role="tab" aria-controls="nav-disc" aria-selected="false" style="color: #8d9297; border-radius: 5px 5px 0px 0px;">Pembahasan</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active py-5" id="nav-desc" role="tabpanel" aria-labelledby="nav-desc-tab">
                        <div class="row">
                            <div class="col-9">
                                {!! $postevent->broadcast !!}
                            </div>
                            <div class="col-3">
                                <div class="mb-5">
                                    <p style="font-size: 24px; margin-bottom:3px;">Keikutsertaan</p>
                                    @if (time() <= strtotime($postevent->start))
                                    <div class="alert alert-warning" role="alert" style="border-radius: 5px;">
                                        <p class="mb-0">Silahkan daftar terlebih dahulu untuk mengikuti event ini.</p>
                                    </div>
                                    <a class="btn btn-primary shadow w-100" href="{{ $postevent->linkRegist }}" target="_blank" style="border-radius: 5px;">Daftar</a>
                                    @elseif (time() > strtotime($postevent->start) && time() <= strtotime($postevent->finished))
                                    <div class="alert alert-info" role="alert" style="border-radius: 5px;">
                                        <p class="mb-0">Event sedang berlangsung, Silahkan daftar terlebih dahulu untuk mengikuti event ini.</p>
                                    </div>
                                    <a class="btn btn-primary shadow w-100" href="{{ $postevent->linkRegist }}" target="_blank" style="border-radius: 5px;">Daftar</a>
                                    @else
                                    <div class="alert alert-danger" role="alert" style="border-radius: 5px;">
                                        <p class="mb-0">Maaf, event ini telah selesai</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-5">
                                    <p style="font-size: 24px; margin-bottom:3px;">Jadwal <br> Pelaksanaan</p>
                                    <div class="row">
                                        @if ($postevent->start != null)
                                        <div class="col-3">
                                            <p>Mulai</p>
                                        </div>
                                        <div class="col-9">
                                            <p>: {{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postevent->start )->format('Y') }} <br> &nbsp; ({{ \Carbon\Carbon::parse( $postevent->start )->format('H:i A') }})</p>
                                        </div>
                                        <div class="col-3">
                                            <p>Selesai</p>
                                        </div>
                                        <div class="col-9">
                                            <p>: {{ \Carbon\Carbon::parse( $postevent->finished )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $postevent->finished )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postevent->finished )->format('Y') }} <br> &nbsp; ({{ \Carbon\Carbon::parse( $postevent->finished )->format('H:i A') }})</p>
                                        </div>
                                        @else
                                        <div class="col-12">
                                            <div class="alert alert-danger" role="alert" style="border-radius: 5px;">
                                                <p class="mb-0">Tidak ada jadwal pelaksanaan</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <p style="font-size: 24px; margin-bottom:3px;">Lokasi</p>
                                    <div class="row">
                                        @if ($postevent->location != null)
                                        <div class="col-2">
                                            <i class="fa fa-map-marker fa-2x text-secondary"></i>
                                        </div>
                                        <div class="col-10">
                                            <p>{{ $postevent->location }} <br><a href="{{ $postevent->linkLocation }}" target="_blank">Link Lokasi</a></p>
                                            <h1 class="display-6" style="font-size: 14px">{{ $postevent->place }}</h1>
                                        </div>
                                        @else
                                        <div class="col-12">
                                            <div class="alert alert-danger" role="alert" style="border-radius: 5px;">
                                                <p class="mb-0">Tidak ada lokasi</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <p style="font-size: 24px; margin-bottom:3px;">Contact Person</p>
                                    <div class="row">
                                        @if ($postevent->cntctPrsn1 == null && $postevent->cntctPrsn2 == null)
                                        <div class="col-12">
                                        <div class="col-12">
                                            <div class="alert alert-danger" role="alert" style="border-radius: 5px;">
                                                <p class="mb-0">Tidak ada Contact Person</p>
                                            </div>
                                        </div>
                                        </div>
                                        @else
                                        <div class="col-2">
                                            <i class="fa fa-whatsapp fa-2x text-secondary"></i>
                                        </div>
                                        <div class="col-10">
                                            @if ($postevent->cntctPrsn1 != null && $postevent->cntctPrsn2 != null)
                                            <a href="https://wa.me/+62{{ $postevent->cntctPrsn1 }}" target="_blank" rel="noopener noreferrer">0{{ $postevent->cntctPrsn1 }} ({{ $postevent->nameCntctPrsn1 }})</a>
                                            <br>
                                            <a href="https://wa.me/+62{{ $postevent->cntctPrsn2 }}" target="_blank" rel="noopener noreferrer">0{{ $postevent->cntctPrsn2 }} ({{ $postevent->nameCntctPrsn2 }})</a>
                                            @elseif ($postevent->cntctPrsn1 == null)
                                            <a href="https://wa.me/+62{{ $postevent->cntctPrsn2 }}" target="_blank" rel="noopener noreferrer">0{{ $postevent->cntctPrsn2 }} ({{ $postevent->nameCntctPrsn2 }})</a>
                                            @elseif ($postevent->cntctPrsn2 == null)
                                            <a href="https://wa.me/+62{{ $postevent->cntctPrsn1 }}" target="_blank" rel="noopener noreferrer">0{{ $postevent->cntctPrsn1 }} ({{ $postevent->nameCntctPrsn1 }})</a>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade py-5" id="nav-doc" role="tabpanel" aria-labelledby="nav-doc-tab">
                        <div>
                            <p style="font-size: 24px;" class="mb-0">Foto dan Video</p>
                            @if ($postevent->linkDoc != null)
                            <a href="{{ $postevent->linkDoc }}" target="_blank" rel="noopener noreferrer">{{ $postevent->linkDoc }}</a>
                            @else
                            <div class="alert alert-info" role="alert" style="border-radius: 5px;">
                                Belum ada foto dan video yang diunggah oleh pengelola Event.
                            </div>
                            @endif
                        </div>
                        <br>
                        <div>
                            <p style="font-size: 24px;" class="mb-0">Presentasi</p>
                            @if ($postevent->linkPresent)
                            <a href="{{ $postevent->linkPresent }}" target="_blank" rel="noopener noreferrer">{{ $postevent->linkPresent }}</a>
                            @else
                            <div class="alert alert-info" role="alert" style="border-radius: 5px;">
                                Belum ada presentasi yang diunggah oleh pengelola Event.
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade py-5" id="nav-disc" role="tabpanel" aria-labelledby="nav-disc-tab">
                        <p style="text-align: justify;">Kamu dapat berdiskusi dan bertanya mengenai Event {{ $postevent->title }} pada halaman ini.</p>
                        <div id="disqus_thread"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if((new \Jenssegers\Agent\Agent())->isMobile())
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mb-4">
            <img src="https://lh3.googleusercontent.com/d/{{ $postevent->gdrive_id }}" alt="{{ $postevent->title }}" style="border-radius: 5px;" class="img-fluid shadow" width="65%">
        </div>
        <div class="mb-4">
            @if ($postevent->tag != null)
            <button type="button" class="btn btn-outline-secondary" style="border-radius: 5px; padding:2px 10px; font-size:12px;" disabled>{{ $postevent->tag }}</button>
            @else
            <button type="button" class="btn btn-outline-secondary" style="border-radius: 5px; padding:2px 10px; font-size:12px;" disabled>Seminar</button>
            @endif
            <h2 class="my-2" style="text-align: left; font-size :20px;">{{ $postevent->title }}</h2>
            <p style="font-size: 14px;">Diselenggarakan oleh: {{ $postevent->division }}</p>
        </div>
        <div class="my-5 text-center" style="font-size: 16px;">
            @if (time() <= strtotime($postevent->start))
                <div>
                    <p class="mt-4 mb-0">Terbuka Hingga:</p>
                    <h1 class="display-6" style="font-size :16px; margin-top:2px;">{{ \Carbon\Carbon::parse( $postevent->closeRegist )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $postevent->closeRegist )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $postevent->closeRegist )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postevent->closeRegist )->format('Y') }}</h1>
                </div>
                <div>
                    <p class="mt-4 mb-0">Countdown:</p>
                    <h1 class="display-6" style="font-size :16px; margin-top:2px;">{{ LFC::countdownHari($postevent->start) }} Hari Lagi</h1>
                </div>
                @elseif (time() > strtotime($postevent->start) && time() <= strtotime($postevent->finished))
                <div>
                    <h1 class="display-6 mt-5 mb-0" style="font-size :16px; margin-top:2px;">Event Sedang Berlangsung</h1>
                </div>
                @else
                <div>
                    <h1 class="display-6 mt-5 mb-0" style="font-size :16px; margin-top:2px;">Event Telah Selesai</h1>
                </div>
            @endif
        </div>
        <div>
            <hr>
            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist" style="font-size: 14px; border-radius: 20px;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-desc-tab" data-bs-toggle="pill" data-bs-target="#pills-desc" type="button" role="tab" aria-controls="pills-desc" aria-selected="true" style="border-radius :5px;">Deskripsi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-doc-tab" data-bs-toggle="pill" data-bs-target="#pills-doc" type="button" role="tab" aria-controls="pills-doc" aria-selected="false" style="border-radius :5px;">Dokumentasi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-disc-tab" data-bs-toggle="pill" data-bs-target="#pills-disc" type="button" role="tab" aria-controls="pills-disc" aria-selected="false" style="border-radius :5px;">Pembahasan</button>
                </li>
            </ul>
            <hr>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-desc" role="tabpanel" aria-labelledby="pills-desc-tab">
                    <div class="mb-5">
                        <p style="font-size: 20px; margin-bottom:3px;" class="mb-2">Keikutsertaan</p>
                        @if (time() <= strtotime($postevent->start))
                        <div class="alert alert-warning" role="alert" style="border-radius: 5px; font-size: 12px;">
                            <p class="mb-0">Silahkan daftar terlebih dahulu untuk mengikuti event ini.</p>
                        </div>
                        <a class="btn btn-primary shadow w-100 mt-0" href="{{ $postevent->linkRegist }}" style="border-radius: 5px; font-size: 14px;" target="_blank">Daftar</a>
                        @elseif (time() > strtotime($postevent->start) && time() <= strtotime($postevent->finished))
                        <div class="alert alert-info" role="alert" style="border-radius: 5px; font-size: 12px;">
                            <p class="mb-0">Event sedang berlangsung, Silahkan daftar terlebih dahulu untuk mengikuti event ini.</p>
                        </div>
                        <a class="btn btn-primary shadow w-100 mt-0" href="{{ $postevent->linkRegist }}" style="border-radius: 5px; font-size: 14px;" target="_blank">Daftar</a>
                        @else
                        <div class="alert alert-danger" role="alert" style="border-radius: 5px; font-size: 12px;">
                            <p class="mb-0">Maaf, event ini telah selesai</p>
                        </div>
                        @endif
                    </div>
                    <div class="mb-5">
                        <p style="font-size: 20px; margin-bottom:3px;" class="mb-2">Jadwal <br> Pelaksanaan</p>
                        <div class="row" style="font-size: 16px;">
                            @if ($postevent->start != null)
                            <div class="col-3">
                                <p>Mulai</p>
                            </div>
                            <div class="col-9">
                                <p>: {{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postevent->start )->format('Y') }} <br> &nbsp; ({{ \Carbon\Carbon::parse( $postevent->start )->format('H:i A') }})</p>
                            </div>
                            <div class="col-3">
                                <p>Selesai</p>
                            </div>
                            <div class="col-9">
                                <p>: {{ \Carbon\Carbon::parse( $postevent->finished )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $postevent->finished )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postevent->finished )->format('Y') }} <br> &nbsp; ({{ \Carbon\Carbon::parse( $postevent->finished )->format('H:i A') }})</p>
                            </div>
                            @else
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert" style="border-radius: 5px; font-size: 12px;">
                                    <p class="mb-0">Tidak ada jadwal pelaksanaan</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="mb-5">
                        <p style="font-size: 20px" class="mb-2">Lokasi</p>
                        <div class="row">
                            @if ($postevent->location != null)
                            <div class="col-1">
                                <i class="fa fa-map-marker fa-2x text-secondary"></i>
                            </div>
                            <div class="col-10">
                                <p style="font-size: 16px;">{{ $postevent->location }} <br><a href="{{ $postevent->linkLocation }}" target="_blank">Link Lokasi</a></p>
                                <h1 class="display-6" style="font-size: 14px">{{ $postevent->place }}</h1>
                            </div>
                            @else
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert" style="border-radius: 5px; font-size: 12px;">
                                    <p class="mb-0">Tidak ada lokasi</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p style="font-size: 20px" class="mb-2">Contact Person</p>
                        <div class="row">
                            @if ($postevent->cntctPrsn1 == null && $postevent->cntctPrsn2 == null)
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert" style="border-radius: 5px; font-size: 12px;">
                                    <p class="mb-0">Tidak ada Contact Person</p>
                                </div>
                            </div>
                            @else
                            <div class="col-1 m-1">
                                <i class="fa fa-whatsapp fa-2x text-secondary"></i>
                            </div>
                            <div class="col-10">
                                <div class="col-10">
                                    @if ($postevent->cntctPrsn1 != null && $postevent->cntctPrsn2 != null)
                                    <a href="https://wa.me/+62{{ $postevent->cntctPrsn1 }}" target="_blank" rel="noopener noreferrer">0{{ $postevent->cntctPrsn1 }} ({{ $postevent->nameCntctPrsn1 }})</a>
                                    <br>
                                    <a href="https://wa.me/+62{{ $postevent->cntctPrsn2 }}" target="_blank" rel="noopener noreferrer">0{{ $postevent->cntctPrsn2 }} ({{ $postevent->nameCntctPrsn2 }})</a>
                                    @elseif ($postevent->cntctPrsn1 == null)
                                    <a href="https://wa.me/+62{{ $postevent->cntctPrsn2 }}" target="_blank" rel="noopener noreferrer">0{{ $postevent->cntctPrsn2 }} ({{ $postevent->nameCntctPrsn2 }})</a>
                                    @elseif ($postevent->cntctPrsn2 == null)
                                    <a href="https://wa.me/+62{{ $postevent->cntctPrsn1 }}" target="_blank" rel="noopener noreferrer">0{{ $postevent->cntctPrsn1 }} ({{ $postevent->nameCntctPrsn1 }})</a>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <hr class="my-5">
                    <div>
                        {!! $postevent->broadcast !!}
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-doc" role="tabpanel" aria-labelledby="pills-doc-tab">
                    <div>
                        <p style="font-size: 18px;" class="mb-0">Foto dan Video</p>
                        @if ($postevent->linkDoc != null)
                        <a href="{{ $postevent->linkDoc }}" target="_blank" rel="noopener noreferrer" style="font-size: 16px;">klik disini</a>
                        @else
                        <div class="alert alert-info" role="alert" style="border-radius: 5px; font-size: 12px;">
                            Belum ada foto dan video yang diunggah oleh pengelola Event.
                        </div>
                        @endif
                    </div>
                    <br>
                    <div>
                        <p style="font-size: 18px;" class="mb-0">Presentasi</p>
                        @if ($postevent->linkPresent)
                        <a href="{{ $postevent->linkPresent }}" target="_blank" rel="noopener noreferrer" style="font-size: 16px;">klik disini</a>
                        @else
                        <div class="alert alert-info" role="alert" style="border-radius: 5px; font-size: 12px;">
                            Belum ada presentasi yang diunggah oleh pengelola Event.
                        </div>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-disc" role="tabpanel" aria-labelledby="pills-disc-tab">
                    <p style="text-align: justify; font-size: 16px;">Kamu dapat berdiskusi dan bertanya mengenai Event {{ $postevent->title }} pada halaman ini.</p>
                    <div id="disqus_thread"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
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
