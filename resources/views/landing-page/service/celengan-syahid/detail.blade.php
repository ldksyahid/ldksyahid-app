@extends('landing-page.template.body')

@section('head')
<link href="{{ asset('css/multiselectcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/navcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/cardcelengan.css') }}" rel="stylesheet" />
@endsection

@section('openGraph')
<meta property="og:title" content="{{ $data->judul }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{url()->current()}}" />
<meta property="og:image" content="{{ asset($data->poster) }}" />
<meta property="og:description" content="{!!  substr(strip_tags($data->cerita), 0, 80) !!}" />
<meta property="og:image:alt" content="{{ $data->link }}" />
@endsection


@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
@php
$donatur = 0;
$donation_total = 0 ;
@endphp
@foreach ( $data->donation as $donation)
@if ($donation->payment_status == 'PAID')
@php $donation_total += (int)$donation->jumlah_donasi @endphp
@php $donatur += 1 @endphp
@endif
@endforeach
<div class="container-fluid website-responsive" style="background-color: #f5f6fa;">
    <div class="row g-5">
        <div class="col col-lg-8">
            <div class="p-5" style="margin-right: -20px">
                <img class="w-100 " src="{{ asset($data->poster) }}" alt="Image" style="border-radius: 15px;"/>
            </div>
        </div>
        <div class="col col-lg-4 d-flex flex-row align-items-center">
            <div class="p-5" style="margin-left:-80px ">
                <div class="badge mb-3" style="margin-left:-8px;"> <span>{{ $data->kategori }}</span> </div>
                <div class="d-flex flex-row align-items-center">
                    <h3 class="text-body mb-0">{{ $data->judul }}</h3>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    @if ($data->nama_pj != null && $data->link_pj != null)
                        <div class="d-flex flex-row align-items-center" style="height: 2em;">
                            <img src="{{ asset($data->logo_pj) }}" alt="logo" width="30" height="30">
                            <div class="ms-2 c-details">
                                <h6 style="font-size: 18px" class="mb-0 text-body"><a href="{{ $data->link_pj }}" target="_blank">{{ $data->nama_pj }}</a></h6>
                            </div>
                        </div>
                    @else
                        <div class="d-flex flex-row align-items-center" style="height: 2em;">
                            <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="30" height="30">
                            <div class="ms-2 c-details">
                                <h6 style="font-size: 18px" class="mb-0 text-body"><a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a></h6>
                            </div>
                        </div>
                    @endif
                </div>
                <hr>
                <div class="mb-0">
                    <div class="row d-flex flex-row align-items-end">
                        <div class="col-lg-8 text-start">
                            <h5 style=" color:#00a79d;"><strong>{{ LFC::formatRupiah($donation_total) }}</strong></h5>
                        </div>
                        <div class="col-lg-4 text-end" style="margin-bottom: -20px;">
                            <p style="font-size:12px;"><i class="fas fa-users fa-1x text-body me-1 my-3"></i>{{ $donatur }} Donatur</p>
                        </div>
                    </div>
                </div>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ number_format(LFC::persentaseBiayaTerkumpul($donation_total,$data->target_biaya),1,'.','') }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><strong>{{ number_format(LFC::persentaseBiayaTerkumpul($donation_total,$data->target_biaya),1,'.','') }}%</strong></div>
                </div>
                <div class="mb-0">
                    <div class="row d-flex flex-row align-items-center">
                        <div class="col-lg-8 text-start my-2">
                            <p style="font-size: 12px;">
                                Target {{ LFC::formatRupiah($data->target_biaya) }}
                            </p>
                        </div>
                        <div class="col-lg-4 text-end">
                            @if (strtotime($data->deadline) > time())
                            <p style="font-size:12px;"><i class="far fa-clock fa-1x text-body me-1 my-2"></i>{{ LFC::countdownHari($data->deadline) }} hari lagi</p>
                            @else
                            <p style="font-size:12px;"><i class="far fa-clock fa-1x text-body me-1 my-2"></i>{{ LFC::countdownHari($data->deadline) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mb-0">
                    <div class="row align-items-center">
                        <div class="col-lg-8 text-start">
                            <a class="btn btn-primary py-2 px-5" style="border-radius: 5px;" href="/celengansyahid/yuk-donasi/{{ $data->link }}">Donasi Sekarang</a>
                        </div>
                       <div class="col-lg-4 text-end  align-items-center">
                           <div class="row justify-content-center align-items-center">
                                <div class="col-md-6">
                                    <div class="fs-6">
                                        Bagikan
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a href="https://api.whatsapp.com/send?&text=%F0%9F%9A%A8%20*%5BCELENGAN%20SYAHID%5D*%20%F0%9F%9A%A8%0A%0A_*{{ $data->judul }}*_%0A%0A_https%3A%2F%2Fldksyah.id%2Fcelengansyahid%2F{{ $data->link }}_%0A%0AYuk%20teman-teman%20kita%20bantu%20saudara%20kita%20%F0%9F%98%87%0A%0A_%22Dan%20berbuat-baiklah%20kepada%20kedua%20orang%20tua%2C%20karib-kerabat%2C%20anak-anak%20yatim%2C%20orang-orang%20miskin%2C%20tetangga%20dekat%20dan%20tetangga%20jauh%2C%20teman%20sejawat%2C%20ibnu%20sabil%20dan%20hamba%20sahaya%20yang%20kamu%20miliki.%20Sungguh%2C%20Allah%20tidak%20menyukai%20orang%20yang%20sombong%20dan%20membanggakan%20diri%2C%22%20%E2%97%8F%20(QS.%20An-Nisa%204%3A%20Ayat%2036)_%0A%0A%23CelenganSyahid%0A%23{{ $data->link }}%0A%23UKMLDKSyahid%0A%23KitaAdalahSaudara%0A%23Bismillah" target="_blank"><i class="fa fa-whatsapp fa-2x"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid website-responsive">
    <div class="row g-5">
        <div class="col-md-12">
            <div class="tab" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="px-5 nav nav-tabs" role="tablist" id="navbar-camp">
                    <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">Detail</a></li>
                    <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab">Kabar Terbaru</a></li>
                    <li role="presentation"><a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab">Donatur ({{ $donatur }})</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabs pt-3 p-5 col col-lg-8" style="padding-top: -40px;">
                    <div role="tabpanel" class="tab-pane active" id="Section1" style="color:#000;">
                        {!! $data->cerita !!}
                    </div>
                    <div role="tabpanel" class="tab-pane" id="Section2">
                        @if ($data->kabar_terbaru != null)
                            {!! $data->kabar_terbaru !!}
                        @else
                            <div class="col col-lg-12 text-center m-3 text-body">
                                <img src="{{asset('Images/Icons/empty_file.png')}}" alt="logo" width="150" height="150" >
                                <p>Campaign ini belum memiliki kabar terbaru</p>
                            </div>
                        @endif
                    </div>
                    <div role="tabpanel" class="tab-pane" id="Section3">
                        <div style="margin: 30px 0px 30px 0px ; ">
                            @if ($donatur > 0)
                            @foreach ( $data->donation as $donation)
                            @if ($donation->payment_status == 'PAID')
                            <div class="row d-flex flex-row align-items-center p-4 my-3" style="background-color: #f5f6fa; border-radius:15px;">
                                <div class="col-lg-2 text-center">
                                    <img src="{{asset('Images/Icons/guesticon.png')}}" alt="user-anonim" style="border-radius:100%;" width="100" height="100">
                                </div>
                                <div class="col-lg-10 text-start">
                                    <div class="row d-flex flex-row align-items-center">
                                        <div class="col-lg-9">
                                            <h6 class="text-body">{{ $donation->nama_donatur }}</h6>
                                        </div>
                                        <div class="col-lg-3 text-end">
                                            <span style="font-size: 11px;" class="text-body">{{ $donation->created_at->diffForHumans()  }}</span>
                                        </div>
                                    </div>
                                    <p class="text-body" style="">
                                    Berdonasi Sebesar <strong>{{ LFC::formatRupiah($donation->jumlah_donasi) }}</strong>
                                    <br>
                                    {{ $donation->pesan_donatur }}
                                    </p>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            @else
                            <div class="col col-lg-12 text-center m-3 text-body">
                                <img src="{{asset('Images/Icons/empty_box.png')}}" alt="logo" width="150" height="150" >
                                <p>Campaign ini belum memiliki Donatur</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0 wow fadeIn mobile-responsive" data-wow-delay="0.2s" style="background-color: #f5f6fa;">
    <div class="p-4">
        <div>
            <img class="w-100 " src="{{ asset($data->poster) }}" alt="Image" style="border-radius: 15px;"/>
            <div class="badge-mobile mt-3"> <span style="font-size:10px;"><b>{{ $data->kategori }}</b></span> </div>
            <div class="d-flex flex-row align-items-center">
                <h5 class="text-body mb-0">{{ $data->judul }}</h5>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                @if ($data->nama_pj != null && $data->link_pj != null)
                <div class="d-flex flex-row align-items-center" style="height: 2em;">
                    <img src="{{ asset($data->logo_pj) }}" alt="logo" width="25" height="25">
                    <div class="ms-2 c-details my-0">
                        <h6 style="font-size: 14px" class="mb-0 text-body"><a href="{{ $data->link_pj }}" target="_blank">{{ $data->nama_pj }}</a></h6>
                    </div>
                </div>
                @else
                <div class="d-flex flex-row align-items-center" style="height: 2em;">
                    <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="25" height="25">
                    <div class="ms-2 c-details my-0">
                        <h6 style="font-size: 14px" class="mb-0 text-body"><a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a></h6>
                    </div>
                </div>
                @endif
            </div>
            <hr>
            <div class="mb-0">
                <div class="row d-flex flex-row align-items-end">
                    <div class="col-lg-8 text-start" style="margin-bottom: -39px;">
                        <h5 style=" color:#00a79d; font-size:16px;"><strong>{{ LFC::formatRupiah($donation_total) }}</strong></h5>
                    </div>
                    <div class="col-lg-4 text-end" style="margin-bottom: -20px;">
                        <p style="font-size:10px;"><i class="fas fa-users fa-1x text-body me-1 my-3"></i>{{ $donatur }} Donatur</p>
                    </div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{ number_format(LFC::persentaseBiayaTerkumpul($donation_total,$data->target_biaya),1,'.','') }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><strong>{{ number_format(LFC::persentaseBiayaTerkumpul($donation_total,$data->target_biaya),1,'.','') }}%</strong></div>
            </div>
            <div class="mb-0">
                <div class="row d-flex flex-row align-items-center">
                    <div class="col-lg-8 text-start my-2">
                        <p style="font-size: 10px;">
                            Target {{ LFC::formatRupiah($data->target_biaya) }}
                        </p>
                    </div>
                    <div class="col-lg-4 text-end" style="margin-top: -50px;">
                        @if (strtotime($data->deadline) > time())
                        <p style="font-size:12px;"><i class="far fa-clock fa-1x text-body me-1 my-2"></i>{{ LFC::countdownHari($data->deadline) }} hari lagi</p>
                        @else
                        <p style="font-size:12px;"><i class="far fa-clock fa-1x text-body me-1 my-2"></i>{{ LFC::countdownHari($data->deadline) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-center small">
                <p>Bagikan</p>
                <a href="https://api.whatsapp.com/send?&text=%F0%9F%9A%A8%20*%5BCELENGAN%20SYAHID%5D*%20%F0%9F%9A%A8%0A%0A_*{{ $data->judul }}*_%0A%0A_https%3A%2F%2Fldksyah.id%2Fcelengansyahid%2F{{ $data->link }}_%0A%0AYuk%20teman-teman%20kita%20bantu%20saudara%20kita%20%F0%9F%98%87%0A%0A_%22Dan%20berbuat-baiklah%20kepada%20kedua%20orang%20tua%2C%20karib-kerabat%2C%20anak-anak%20yatim%2C%20orang-orang%20miskin%2C%20tetangga%20dekat%20dan%20tetangga%20jauh%2C%20teman%20sejawat%2C%20ibnu%20sabil%20dan%20hamba%20sahaya%20yang%20kamu%20miliki.%20Sungguh%2C%20Allah%20tidak%20menyukai%20orang%20yang%20sombong%20dan%20membanggakan%20diri%2C%22%20%E2%97%8F%20(QS.%20An-Nisa%204%3A%20Ayat%2036)_%0A%0A%23CelenganSyahid%0A%23{{ $data->link }}%0A%23UKMLDKSyahid%0A%23KitaAdalahSaudara%0A%23Bismillah" target="_blank"><i class="fa fa-whatsapp fa-2x"></i></a>
            </div>
        </div>
    </div>
    <div class="p-4 my-3 mx-3 shadow-sm" style="background-color: #fff; border-radius:10px;">
        <div>
            <h6 class="text-body">Detail</h6>
            {{-- <p>
                {!!  substr('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas vitae scelerisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar nibh tempor porta.', 0, 150) !!}<span id="dotsDetail"></span><span id="moreDetail" style="display: none;">{!!  substr('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas vitae scelerisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar nibh tempor porta.', 151) !!}</span>
            </p> --}}
            {{-- <p>
                {!!  substr(strip_tags($data->cerita), 0, 150) !!}<span id="dotsDetail"></span><span id="moreDetail" style="display: none;">{!!  $data->cerita !!}}</span>
            </p> --}}
            <p>
                {!! $data->cerita !!}
            </p>
            {{-- <div class="text-center">
                <button type="button" class="btn btn-outline-primary w-100" onclick="readMoreLessDetail()" id="readMoreLessDetail">Baca Selengkapnya</button>
            </div> --}}
        </div>
    </div>
    <div class="p-4 my-3 mx-3 shadow-sm" style="background-color: #fff; border-radius:10px;">
        <div>
            <h6 class="text-body">Kabar Terbaru</h6>
            {{-- <p>
                {!!  substr('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas vitae scelerisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar nibh tempor porta.', 0, 150) !!}<span id="dotsUpdate"></span><span id="moreUpdate" style="display: none;">{!!  substr('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas vitae scelerisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar nibh tempor porta.', 151) !!}</span>
            </p>
            <div class="text-center">
                <button type="button" class="btn btn-outline-primary w-100" onclick="readMoreLessUpdate()" id="readMoreLessUpdate">Baca Selengkapnya</button>
            </div> --}}
            @if ($data->kabar_terbaru != null)
            <p>
                {!! $data->kabar_terbaru !!}
            </p>
            @else
            <div class="col col-lg-12 text-center m-3 text-body small">
                <img src="{{asset('Images/Icons/empty_file.png')}}" alt="logo" width="100" height="100" >
                <p>Campaign ini belum memiliki kabar terbaru</p>
            </div>
            @endif
        </div>
    </div>
    <div class="p-4 my-3 mx-3 shadow-sm" style="background-color: #fff; border-radius:10px;">
        <div>
            <h6 class="text-body" style="margin-bottom: 15px;">Donatur ({{ $donatur }})</h6>
            @if ($donatur > 0)
            @foreach ( $data->donation as $donation)
            @if ($donation->payment_status == 'PAID')
            <div class="row p-2 my-2" style="background-color: #f5f6fa; border-radius:10px;">
                <div class="col col-lg-2 text-start w-100" >
                    <img src="{{asset('Images/Icons/guesticon.png')}}" alt="user-anonim" style="border-radius:100%; margin-top:0px;" width="35" height="35">
                </div>
                <div class="col col-lg-10 text-start" style="margin-left: -200px;">
                    <h6 class="text-body" style="font-size:12px;">{{ $donation->nama_donatur }}</h6>
                    <p class="text-body" style="font-size:10px;">
                    Berdonasi Sebesar <strong>{{ LFC::formatRupiah($donation->jumlah_donasi) }}</strong>
                    <br>
                    {{ $donation->pesan_donatur }}
                    </p>
                    <p style="font-size: 8px;" class="text-body text-end">{{ $donation->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @endif
            @endforeach
            @else
            <div class="col col-lg-12 text-center m-3 text-body">
                <img src="{{asset('Images/Icons/empty_box.png')}}" alt="logo" width="100" height="100" >
                <br><br>
                <p>Campaign ini belum memiliki Donatur</p>
            </div>
            @endif

        </div>
    </div>
</div>
<div class="conteiner-fluid mobile-responsive p-3 shadow wow fadeInUp" style="position: fixed; left: 0; bottom: 0; width: 100%; background-color: #f5f6fa; text-align: center; z-index:3;" data-wow-delay="0.2s">
    <div class="col-lg-12 text-center">
        <a class="btn btn-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/celengansyahid/yuk-donasi/{{ $data->link }}">Donasi Sekarang</a>
        <hr>
    </div>
</div>
@endsection


@section('scripts')
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script>
var arrowup = document.getElementById("arrow-up");

arrowup.style.display = "none";

function bgc(x) {
  if (x.matches) { // If media query matches
    document.body.style.backgroundColor = "#f5f6fa";
  } else {
   document.body.style.backgroundColor = "#fff";
  }
}

var x = window.matchMedia("(max-width: 700px)")
bgc(x);

x.addListener(bgc)
</script>
<script>
function readMoreLessDetail() {
    var dots = document.getElementById("dotsDetail");
    var moreText = document.getElementById("moreDetail");
    var btnText = document.getElementById("readMoreLessDetail");

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btnText.innerHTML = "Baca Selengkapnya";
        moreText.style.display = "none";
    } else {
        dots.style.display = "none";
        btnText.innerHTML = "Baca Lebih Sedikit";
        moreText.style.display = "inline";
    }
}
function readMoreLessUpdate() {
    var dots = document.getElementById("dotsUpdate");
    var moreText = document.getElementById("moreUpdate");
    var btnText = document.getElementById("readMoreLessUpdate");

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btnText.innerHTML = "Baca Selengkapnya";
        moreText.style.display = "none";
    } else {
        dots.style.display = "none";
        btnText.innerHTML = "Baca Lebih Sedikit";
        moreText.style.display = "inline";
    }
}
</script>
@endsection
