@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- About Start -->
<div class="container-xxl py-5">
    <div id="space1" style="display:none;">
        <br><br><br><br>
    </div>
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                <div class="position-relative overflow-hidden ps-5 pt-5 h-100" style="min-height: 400px">
                        @if (Auth::User()->profile->profilepicture == null)
                            <img class="position-sticky img-fluid" src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setShape('square')->setDimension(500)->setFontSize(250)->toBase64() }}" alt="" style="object-fit: cover;" width= "500px" height= "700px"/>
                        @else
                            <img class="position-sticky img-fluid" src="{{Auth::User()->profile->profilepicture}}" alt="" style="object-fit: cover"  width= "500px" height= "700px"/>
                        @endif
                    <div class="position-absolute top-0 start-0 bg-white pe-3 pb-3" style="width: 250px; height: 150px">
                        <div class="d-flex flex-column justify-content-center text-center bg-primary h-100 p-3">
                            <h5 class="text-white">Sipaling {{Auth::User()->profile->sifat}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="h-100">
                    <div class="border-start border-5 border-primary ps-4 mb-5">
                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-body mb-2">{{ Auth::user()->name }}</h6>
                                <h1 class="display-4 mb-0">{{Auth::User()->profile->namapanggilan}}</h1>
                            </div>
                            <div class="col-6 text-end">
                                <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="LDK Syahid" width="100px" height="100px">
                            </div>
                        </div>
                    </div>
                    <p class="" style="text-align: justify">{{Auth::User()->profile->tentangdiri}}</p>
                    <div class="border-top mt-4 pt-4">
                        <div class="row g-4">
                            <div class="col-sm-6 d-flex wow fadeIn" data-wow-delay="0.1s">
                                <i class="fa fa-university fa-2x text-primary flex-shrink-0 me-3"></i>
                                <div class="row">
                                    <h6 class="mb-0">Universitas</h6><br>
                                    <p class="mb-0">{{Auth::User()->profile->universitas}}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 d-flex wow fadeIn" data-wow-delay="0.3s">
                                <i class="fa fa-address-card fa-2x text-primary flex-shrink-0 me-3"></i>
                                <div class="row">
                                    <h6 class="mb-0">NIM</h6><br>
                                    <p class="mb-0">{{Auth::User()->profile->nim}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4">
                        <div class="row g-4">
                            <div class="col-sm-6 d-flex wow fadeIn" data-wow-delay="0.1s">
                                <i class="fa fa-building fa-2x text-primary flex-shrink-0 me-3"></i>
                                <div class="row">
                                    <h6 class="mb-0">Fakultas</h6><br>
                                    <p class="mb-0">{{Auth::User()->profile->fakultas}}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 d-flex wow fadeIn" data-wow-delay="0.3s">
                                <i class="fas fa-book-reader fa-2x text-primary flex-shrink-0 me-3"></i>
                                <div class="row">
                                    <h6 class="mb-0">Program Studi</h6><br>
                                    <p class="mb-0">{{Auth::User()->profile->programstudi}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4">
                        <div class="row g-4">
                            <div class="col-sm-6 d-flex wow fadeIn" data-wow-delay="0.1s">
                                <i class="fas fa-chess-pawn fa-2x text-primary flex-shrink-0 me-3"></i>
                                <div class="row">
                                    <h6 class="mb-0">Forum Angkatan</h6><br>
                                    <p class="mb-0">{{Auth::User()->profile->forkat}}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 d-flex wow fadeIn" data-wow-delay="0.3s">
                                <i class="fas fa-id-card-alt fa-2x text-primary flex-shrink-0 me-3"></i>
                                <div class="row">
                                    <h6 class="mb-0">Nomor Anggota</h6><br>
                                    <p class="mb-0">{{Auth::User()->profile->nomoranggota}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4">
                        <div class="row g-4">
                            <div class="col-sm-6 d-flex wow fadeIn" data-wow-delay="0.1s">
                                <i class="fab fa-instagram fa-2x text-primary flex-shrink-0 me-3"></i>
                                <div class="row">
                                    <h6 class="mb-0">Akun Instagram</h6><br>
                                    <p class="mb-0">{{Auth::User()->profile->akuninstagram}}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 d-flex wow fadeIn" data-wow-delay="0.3s">
                                <i class="fab fa-linkedin fa-2x text-primary flex-shrink-0 me-3"></i>
                                <div class="row">
                                    <h6 class="mb-0">Akun LinkedIn</h6><br>
                                    <p class="mb-0">{{Auth::User()->profile->akunlinkedin}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4">
                        <div class="row g-4">
                            <div class="col-sm-6 d-flex wow fadeIn" data-wow-delay="0.1s">
                                <i class="fa fa-envelope fa-2x text-primary flex-shrink-0 me-3"></i>
                                <div class="row">
                                    <h6 class="mb-0">Email</h6><br>
                                    <p class="mb-0">{{Auth::User()->email}}</p>
                                </div>
                            </div>
                            <div class="col-sm-6 d-flex wow fadeIn" data-wow-delay="0.3s">
                                <i class="fa fa-puzzle-piece fa-2x text-primary flex-shrink-0 me-3"></i>
                                <div class="row">
                                    <h6 class="mb-0">Motto Hidup</h6><br>
                                    <p class="mb-0">{{Auth::User()->profile->mottohidup}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 d-flex wow fadeInUp" data-wow-delay="0.5s">
                <a class="btn btn-primary w-100 py-3 fadeIn mr-1" href="/" type="submit">Kembali</a>
                <a class="btn btn-primary w-100 py-3 fadeIn hideIfMobile" id="download">Export PNG</a>
                <a class="btn btn-primary w-100 py-3 fadeIn mx-auto" href="/profile/{{ Auth::user()->id }}/edit" type="submit">Ubah Profil</a>
            </div>
        </div>
    </div>
    <div id="space2" style="display:none;">
        <br><br><br><br><br>
    </div>
</div>
<!-- About End -->
@endsection

@section('scripts')
<script type="text/javascript">

    jQuery(document).ready(function(){
        jQuery("#download").click(function(){
            document.getElementById('space1').style.display = "block";
            document.getElementById('space2').style.display = "block";
            document.getElementById('navbar').classList.remove("sticky-top");
            screenshot();
            setTimeout(function () { location.reload(1); }, 1000);
        });
    });

    function screenshot(){
        html2canvas(document.getElementById("photo"),{
        }).then(function(canvas){
           downloadImage(canvas.toDataURL(),"Profilku.png");
        });
    }

    function downloadImage(uri, filename){
      var link = document.createElement('a');
      if(typeof link.download !== 'string'){
         window.open(uri);
      }
      else{
          link.href = uri;
          link.download = filename;
          accountForFirefox(clickLink, link);
      }
    }

    function clickLink(link){
        link.click();
    }

    function accountForFirefox(click){
        var link = arguments[1];
        document.body.appendChild(link);
        click(link);
        document.body.removeChild(link);
    }


 </script>
@endsection
