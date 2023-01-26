@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('style')
<link href="{{ asset('css/multiselectcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/navcelengan.css') }}" rel="stylesheet" />
@endsection


@section('content')
<div class="container-xxl websiteResponsive" style="background-color: #f5f6fa;">
    <div class="row g-5">
        <div class="col col-lg-8">
            <div class="p-5" style="margin-right: -20px">
                <img class="w-100 " src="{{ asset('Images/fixImage/dummy/excamp.png') }}" alt="Image" style="border-radius: 15px;"/>
            </div>
        </div>
        <div class="col col-lg-4 d-flex flex-row align-items-center">
            <div class="p-5" style="margin-left:-80px ">
                <div class="badge mb-3" style="margin-left:-8px;"> <span>Sosial Dakwah</span> </div>
                <div class="d-flex flex-row align-items-center">
                    <h3 class="text-body mb-0">Pojok Baca Pelosok Negeri : Membangun Bangsa Dengan Literasi</h3>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center" style="height: 2em;">
                        <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="30" height="30">
                        <div class="ms-2 c-details">
                            <h6 style="font-size: 18px" class="mb-0 text-body"><a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a></h6>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mb-0">
                    <div class="row d-flex flex-row align-items-end">
                        <div class="col-lg-8 text-start">
                            <h5 style=" color:#00a79d;"><strong>Rp. 23.000,-</strong></h5>
                        </div>
                        <div class="col-lg-4 text-end" style="margin-bottom: -20px;">
                            <p style="font-size:12px;"><i class="fas fa-users fa-1x text-body me-1 my-3"></i>5 Donatur</p>
                        </div>
                    </div>
                </div>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><strong>75%</strong></div>
                </div>
                <div class="mb-0">
                    <div class="row d-flex flex-row align-items-center">
                        <div class="col-lg-8 text-start my-2">
                            <p style="font-size: 12px;">
                                0.63% dari target Rp. 100.000.000,-
                            </p>
                        </div>
                        <div class="col-lg-4 text-end">
                            <p style="font-size:12px;"><i class="far fa-clock fa-1x text-body me-1 my-2"></i>341 hari lagi</p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mb-0">
                    <div class="row align-items-center">
                        <div class="col-lg-8 text-start">
                            <a class="btn btn-primary py-2 px-5" style="border-radius: 5px;" href="/service/celengansyahid/yuk-donasi/{{ 'pojok-baca-pelosok-negeri' }}">Donasi Sekarang</a>
                        </div>
                       <div class="col-lg-4 text-end  align-items-center">
                           <div class="row justify-content-center align-items-center">
                                <div class="col-md-6">
                                    <div class="fs-6">
                                        Bagikan
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <a href=""><i class="fa fa-whatsapp fa-2x"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-xxl websiteResponsive">
    <div class="row g-5">
        <div class="col-md-12">
            <div class="tab" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="px-5 nav nav-tabs" role="tablist" id="navbar-camp">
                    <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">Detail</a></li>
                    <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab">Kabar Terbaru</a></li>
                    <li role="presentation"><a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab">Donatur <span style="color: #fff; background-color:#00a79d; border-radius:100%; padding:5px; font-size:10px;" class="text-center">1</span></a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabs pt-3 p-5 col col-lg-8" style="padding-top: -40px;">
                    <div role="tabpanel" class="tab-pane active" id="Section1" style="color:#000;">
                        <p>Di tengah maraknya penggunaan sosial media, faktanya minat baca orang Indonesia menurut data UNESCO hanya 0,001%. Artinya, dari 1.000 orang Indonesia, hanya 1 orang yang rajin membaca. Sementara survei Program for International Student Assessment (PISA) menyebutkan tingkat literasi Indonesia berada di urutan ke-62 dari 70 negara di dunia.</p>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="Section2">
                        <p>Sejak didirikan lebih dari 10 tahun lalu dari hasil uang swadaya masyarakrat, sekolah ini tak pernah memiliki perpustakaan yang layak. Jangankan perpustakaan, buku-buku yang digunakanpun tidak sesuai dengan kurikulum yang berlaku. Tidak seperti sekolah lain yang memiliki perpustakaan, semua buku-buku hasil sumbangan tersebut hanya bisa diletakkan di atas meja pojok kelas. Berbaur menjadi satu tanpa dibedakan berdasarkan urutan kelas. Bahkan, tak jarang sudah usang.</p>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="Section3">
                        <div style="margin: 30px 0px 30px 0px ; ">
                            <div class="row d-flex flex-row align-items-center p-4" style="background-color: #f5f6fa; border-radius:15px;">
                                <div class="col-lg-2 text-center">
                                    <img src="{{asset('Images/Icons/guesticon.png')}}" alt="user-anonim" style="border-radius:100%;" width="100" height="100">
                                </div>
                                <div class="col-lg-10 text-start">
                                    <div class="row d-flex flex-row align-items-center">
                                        <div class="col-lg-9">
                                            <h6 class="text-body">Manusia Baik</h6>
                                        </div>
                                        <div class="col-lg-3 text-end">
                                            <span style="font-size: 11px;" class="text-body">30 menit yang lalu</span>
                                        </div>
                                    </div>
                                    <p class="text-body" style="">
                                    Berdonasi Sebesar <strong>Rp. 250.000,-</strong>
                                    <br>
                                    <i>ya Allah terimakasih atas rezeki yg tak pernah putus ini sehingga aku bisa terus bersedekah</i>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0 wow fadeIn mobileResponsive" data-wow-delay="0.2s" style="background-color: #f5f6fa;">
    <div class="p-4">
        <div>
            <img class="w-100 " src="{{ asset('Images/fixImage/dummy/excamp.png') }}" alt="Image" style="border-radius: 15px;"/>
            <div class="badge-mobile mt-3"> <span style="font-size:10px;"><b>Sosial Dakwah</b></span> </div>
            <div class="d-flex flex-row align-items-center">
                <h5 class="text-body mb-0">Pojok Baca Pelosok Negeri : Membangun Bangsa Dengan Literasi</h5>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-row align-items-center" style="height: 2em;">
                    <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="25" height="25">
                    <div class="ms-2 c-details my-0">
                        <h6 style="font-size: 14px" class="mb-0 text-body"><a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a></h6>
                    </div>
                </div>
            </div>
            <hr>
            <div class="mb-0">
                <div class="row d-flex flex-row align-items-end">
                    <div class="col-lg-8 text-start" style="margin-bottom: -39px;">
                        <h5 style=" color:#00a79d; font-size:16px;"><strong>Rp. 23.000,-</strong></h5>
                    </div>
                    <div class="col-lg-4 text-end" style="margin-bottom: -20px;">
                        <p style="font-size:10px;"><i class="fas fa-users fa-1x text-body me-1 my-3"></i>5 Donatur</p>
                    </div>
                </div>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><strong>75%</strong></div>
            </div>
            <div class="mb-0">
                <div class="row d-flex flex-row align-items-center">
                    <div class="col-lg-8 text-start my-2">
                        <p style="font-size: 10px;">
                            0.63% dari target Rp. 100.000.000,-
                        </p>
                    </div>
                    <div class="col-lg-4 text-end" style="margin-top: -50px;">
                        <p style="font-size:10px;"><i class="far fa-clock fa-1x text-body me-1 my-2"></i>341 hari lagi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4 my-3 mx-3 shadow-sm" style="background-color: #fff; border-radius:10px;">
        <div>
            <h6 class="text-body">Detail</h6>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas vitae scel<span id="dotsDetail"></span><span id="moreDetail" style="display: none;">erisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar nibh tempor porta.</span></p>
            <div class="text-center">
                <button type="button" class="btn btn-outline-primary w-100" onclick="readMoreLessDetail()" id="readMoreLessDetail">Baca Selengkapnya</button>
            </div>
        </div>
    </div>
    <div class="p-4 my-3 mx-3 shadow-sm" style="background-color: #fff; border-radius:10px;">
        <div>
            <h6 class="text-body">Kabar Terbaru</h6>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas vitae scel<span id="dotsUpdate"></span><span id="moreUpdate" style="display: none;">erisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus vestibulum augue ut aliquet. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar nibh tempor porta.</span></p>
            <div class="text-center">
                <button type="button" class="btn btn-outline-primary w-100" onclick="readMoreLessUpdate()" id="readMoreLessUpdate">Baca Selengkapnya</button>
            </div>
        </div>
    </div>
    <div class="p-4 my-3 mx-3 shadow-sm" style="background-color: #fff; border-radius:10px;">
        <div>
            <h6 class="text-body" style="margin-bottom: 15px;">Donatur <span style="color: #fff; background-color:#00a79d; border-radius:100%; padding:5px; font-size:10px;" class="text-center">213</span></h6>
            <div class="row p-2 my-2" style="background-color: #f5f6fa; border-radius:10px;">
                <div class="col col-lg-2 text-start w-100" >
                    <img src="{{asset('Images/Icons/guesticon.png')}}" alt="user-anonim" style="border-radius:100%; margin-top:0px;" width="35" height="35">
                </div>
                <div class="col col-lg-10 text-start" style="margin-left: -200px;">
                    <h6 class="text-body" style="font-size:12px;">Manusia Baik</h6>
                    <p class="text-body" style="font-size:10px;">
                    Berdonasi Sebesar <strong>Rp. 250.000,-</strong>
                    <br>
                    <i>ya Allah terimakasih atas rezeki yg tak pernah putus ini sehingga aku bisa terus bersedekah</i>
                    </p>
                    <p style="font-size: 8px;" class="text-body text-end">30 menit yang lalu</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="conteiner-fluid mobileResponsive p-3 shadow wow fadeInUp" style="position: fixed; left: 0; bottom: 0; width: 100%; background-color: #f5f6fa; text-align: center; z-index:3;" data-wow-delay="0.2s">
    <div class="col-lg-12 text-center">
        <a class="btn btn-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/yuk-donasi/{{ 'pojok-baca-pelosok-negeri' }}">Donasi Sekarang</a>
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
