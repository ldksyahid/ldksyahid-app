@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('style')
<link href="{{ asset('css/multiselectcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/navcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/cardcelengan.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="websiteResponsive">
    <div class="container-fluid" style="background-color: #f5f6fa;">
        <div class="container w-75">
            <div class="row g-5">
                <div class="col col-lg-6">
                    <div class="py-5">
                        <img class="w-100 " src="{{ asset('Images/fixImage/dummy/excamp.png') }}" alt="Image" style="border-radius: 15px;"/>
                    </div>
                </div>
                <div class="col col-lg-6 d-flex flex-row align-items-center">
                    <div class="py-5">
                        <div class="d-flex flex-row align-items-center">
                            <div style="line-height: 0.1;">
                                <p style="color: #00a79d">Kamu akan berdonasi untuk membantu :</p>
                                <h4 class="text-body mb-0">Pojok Baca Pelosok Negeri : Membangun Bangsa Dengan Literasi</h4>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row align-items-center" style="height: 2em;">
                                        <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="30" height="30">
                                        <div class="ms-2 c-details">
                                            <h6 style="font-size: 18px" class="mb-0 text-body"><a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="container w-75">
            <div class="g-5">
                <form action="">
                    <div class="col col-lg-12 my-5">
                        <div class="text-center">
                            <h3 class="text-body mb-3">Masukan Nominal Donasi</h3>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend" style="border-radius:5px;">
                                    <div class="input-group-text" style="border-radius:5px 0px 0px 5px; background:none; border-right:none;" id="input-group-text-1">Rp.</div>
                                </div>
                                <input type="text" class="form-control" id="inputBiayaDonasi" style="border-radius:0px 5px 5px 0px; border-left:none; padding-left:0px; margin-left:-5px;" onKeyUp="rupiahrp(this)" onKeyPress="return isNumber(event)">
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-12 my-5">
                        <div class="text-center">
                            <a class="btn btn-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/yuk-donasi/{{ 'pojok-baca-pelosok-negeri' }}">LANJUTKAN PEMBAYARAN DONASI</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if( charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=46 ) {
        return false;
    }
    return true;
}

function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}

function rupiahrp(objek, separator) {
	var nilai_1 = objek.value;
	var nilai_2 = nilai_1.replace(/,/g,"");
	var nilai_3 = formatNumber(nilai_2);
	objek.value = nilai_3;
}
</script>
<script>
var click = false
var input_group_text_1 = document.getElementById("input-group-text-1");
var input_biaya_donasi = document.getElementById("inputBiayaDonasi");
input_biaya_donasi.addEventListener('click', function(e) {
    input_group_text_1.style.borderColor = "#00a79d";
    click = true;
    e.stopPropagation();
}, true)
document.addEventListener('click', function(e){
    input_group_text_1.style.borderColor = "#ced4da";
    click = false;
}, false)
</script>
@endsection
