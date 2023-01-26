@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('style')
<link href="{{ asset('css/multiselectcelengan.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
  <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
          <div class="carousel-item active">
              <img class="w-100 " src="{{ asset('Images/fixImage/dummy/excamp.png') }}" alt="Image" />
          </div>
          <div class="carousel-item">
              <img class="w-100 " src="{{ asset('Images/fixImage/dummy/excamp2.png') }}" alt="Image" />
          </div>
      </div>
  </div>
</div>
<div class="container-xl">
    <div class="row g-3">
        {{-- website --}}
        <div class="col-lg-12 col-md-6 wow fadeInUp websiteResponsive" data-wow-delay="0.1s">
            <div class="border-start border-5 border-primary ps-4 mb-3">
                <h6 class="text-body text-uppercase mb-2">Celengan Syahid</h6>
                <h1 class="display-6 mb-0">
                    Mari Bantu Mereka yang Membutuhkan
                </h1>
            </div>
            <p class="mb-0" style="text-align: justify">
                "Dan sembahlah Allah dan janganlah kamu mempersekutukan-Nya dengan sesuatu apa pun. Dan berbuat-baiklah kepada kedua orang tua, karib-kerabat, anak-anak yatim, orang-orang miskin, tetangga dekat dan tetangga jauh, teman sejawat, ibnu sabil dan hamba sahaya yang kamu miliki. Sungguh, Allah tidak menyukai orang yang sombong dan membanggakan diri,"
                ● (QS. An-Nisa 4: Ayat 36)
            </p>
        </div>
        {{-- mobile --}}
        <div class="col-lg-12 col-md-6 wow fadeInUp mobileResponsive" data-wow-delay="0.1s">
            <div class="border-start border-5 border-primary ps-4 mb-3">
                <h6 class="text-body text-uppercase mb-2" style="font-size: 18px;">Celengan Syahid</h6>
                <h1 class="display-6 mb-0" style="font-size: 24px;">
                    Mari Bantu Mereka yang Membutuhkan
                </h1>
            </div>
            <p class="mb-0" style="text-align: justify ;font-size: 10px;">
                "Dan sembahlah Allah dan janganlah kamu mempersekutukan-Nya dengan sesuatu apa pun. Dan berbuat-baiklah kepada kedua orang tua, karib-kerabat, anak-anak yatim, orang-orang miskin, tetangga dekat dan tetangga jauh, teman sejawat, ibnu sabil dan hamba sahaya yang kamu miliki. Sungguh, Allah tidak menyukai orang yang sombong dan membanggakan diri,"
                ● (QS. An-Nisa 4: Ayat 36)
            </p>
        </div>
        <div class="col-lg-12 col-md-6 wow fadeInUp py-1" data-wow-delay="0.5s" style="margin-bottom: 0px;">
            <div class="row">
                <div class="col">
                    <h6 class="text-body" style="display: inline-block; margin-right:10px;">Filter</h6>
                    <form style="display: inline-block">
                        <div class="multiselect" id="multiselect-kategori">
                            <div class="selectBox" id="selectBox-kategori">
                                <select class="rounded-pill child">
                                    <option>Kategori</option>
                                </select>
                                <div class="overSelect"></div>
                            </div>
                            <div class="checkboxes card mt-2 w-15 p-3" id="checkboxes-kategori">
                                <label for="pendidikan" class="p-1">
                                <input type="checkbox" id="pendidikan" value="pendidikan" onchange="checkboxStatusChange()">Pendidikan</label>
                                <label for="kemanusiaan" class="p-1">
                                <input type="checkbox" id="kemanusiaan" value="kemanusiaan" onchange="checkboxStatusChange()">Kemanusiaan</label>
                                <label for="kesehatan" class="p-1">
                                <input type="checkbox" id="kesehatan" value="kesehatan" onchange="checkboxStatusChange()">Kesehatan</label>
                                <label for="ekonomi" class="p-1">
                                <input type="checkbox" id="ekonomi" value="ekonomi" onchange="checkboxStatusChange()">Ekonomi</label>
                                <label for="sosial-dakwah" class="p-1">
                                <input type="checkbox" id="sosial-dakwah" value="sosial-dakwah" onchange="checkboxStatusChange()">Sosial Dakwah</label>
                                <label for="lingkungan" class="p-1">
                                <input type="checkbox" id="lingkungan" value="lingkungan" onchange="checkboxStatusChange()">Lingkungan</label>
                                <hr>
                                <div class="row mb-0">
                                    {{-- <div class="col text-center">
                                        <a class="btn btn-danger w-100 py-3 fadeIn boder-r d-flex align-items-center h-25" style="margin-bottom: -25px;" id="hapusPilihan" onchange="hapusPilihan()">Hapus&nbsp;&nbsp;</a>
                                    </div>
                                    <div class="col text-center">
                                        <a class="btn btn-primary w-100 py-3 fadeIn boder-r d-flex align-items-center h-25 " href="#" type="submit" style="margin-bottom: -25px;" onchange="simpanPilihan()">Simpan</a>
                                    </div> --}}
                                    <div class="col text-center">
                                        <label for="hapus" class="p-3 btn btn-danger w-100 py-3 fadeIn boder-r d-flex align-items-center h-25 btn-simpan" style="margin-bottom: -25px;" id="btn-hapus">
                                            <input type="checkbox"  id="hapus" onchange="hapusPilihan()">Hapus
                                        </label>
                                    </div>
                                    <div class="col text-center">
                                        <label for="simpan" class="p-3 btn btn-primary w-100 py-3 fadeIn boder-r d-flex align-items-center h-25 btn-simpan" style="margin-bottom: -25px;" id="btn-simpan">
                                            <input type="checkbox" id="simpan" onchange="simpanPilihan()">Simpan
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
            <h6 class="text-body">Menampilkan 12 dari 62 <i>campaign</i></h6>
            {{-- website --}}
            <div class="row g-4 mt-1 websiteResponsive">
                <div class="col-lg-4 col-md-6 mt-3">
                    <div class="card shadow-c mb-2">
                        <div style="height: 13em;">
                            <a href="/service/celengansyahid/{{ 1 }}/show"><img src="{{ asset('Images/fixImage/dummy/excamp.png') }}" alt="" class="card-img w-100"></a>
                        </div>
                        <div class="mt-1 p-3">
                            <div class="badge" style="margin-left:-8px;"> <span>Sosial Dakwah</span> </div>
                            <div style="height: 5em;" class="d-flex flex-row align-items-center">
                                <h5 class="text-body mb-0"><a href="/service/celengansyahid/{{ 1 }}/show">Pojok Baca Pelosok Negeri : Membangun Bangsa Dengan Literasi</a></h5>
                            </div>
                            <div style="height: 2em;">
                                <p style="font-size: 14px;">
                                    {!!  substr(strip_tags('Miris, literasi Indonesia posisi ke-62 dari 70 negara di dunia. Mari bangun bangsa dengan tingkatkan literasi melalui Pojok'), 0, 100) !!}
                                </p>
                            </div>
                            <div class="mt-3">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex flex-row align-items-center" style="height: 2em;">
                                        <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="25" height="25">
                                        <div class="ms-2 c-details">
                                            <h6 style="font-size: 16px" class="mb-0 text-body"><a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress mt-3">
                                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><strong>50%</strong></div>
                                </div>
                                <div class="mt-0">
                                    <div class="row">
                                        <div class="col text-start">
                                            <p>
                                                <span style="font-size: 12px;">Terkumpul</span>
                                                <br>
                                                <span style=" color:#00a79d;">
                                                    <strong>Rp. 23.000,-</strong>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col text-end">
                                            <p>
                                                <span style="font-size: 12px;">Sisa Hari</span>
                                                <br>
                                                <span>
                                                    <strong>365</strong>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- mobile --}}
            <div class="row mt-1 mobileResponsive">
                <div class="col-lg-4 col-md-6 mt-3">
                    <div class="card shadow">
                        <div class="row d-flex flex-row align-items-start">
                            <div class="col" style="margin-right:-20px;">
                                <div  class="p-3">
                                    <a href="/service/celengansyahid/{{ 1 }}/show"><img src="{{ asset('Images/fixImage/dummy/excamp.png') }}" alt="" class="card-img w-100" style="border-radius: 5px;"></a>
                                </div>
                            </div>
                            <div class="col" style="margin-left:-20px;">
                                <div class="p-3">
                                    <div class="badge-mobile "> <span style="font-size:10px;"><b>Sosial Dakwah</b></span> </div>
                                    <div style="line-height: 1.1em">
                                        <h5 class=""><a href="/service/celengansyahid/{{ 1 }}/show" style="font-size: 12px ;">{!!  substr(strip_tags('Pojok Baca Pelosok Negeri : Membangun Bangsa Dengan Literasi'), 0, 25) !!}</a></h5>
                                        <p style="font-size: 10px;">
                                            {!!  substr(strip_tags('Miris, literasi Indonesia posisi ke-62 dari 70 negara di dunia. Mari bangun bangsa dengan tingkatkan literasi melalui Pojok'), 0, 100) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col p-3" style="margin-top:-30px;">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex flex-row align-items-center">
                                    <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="20" height="20">
                                    <div class="ms-2 c-details">
                                        <h6 style="font-size: 10px" class="mb-0 text-body"><a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="progress  my-1" style="height: 13px;">
                                <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><strong style="font-size: 9px;">50%</strong></div>
                            </div>
                            <div class="mt-0">
                                <div class="row">
                                    <div class="col text-start" style="line-height: -50px;">
                                        <p style="font-size: 9px;">Terkumpul</p>
                                        <p style=" color:#00a79d; font-size:10px; margin-top:-18px;"><strong>Rp. 23.000,-</strong></p>
                                    </div>
                                    <div class="col text-end">
                                        <p style="font-size: 9px;">Sisa Hari</p>
                                        <p style="font-size:10px; margin-top:-18px;"><strong>365</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-6 wow fadeInUp text-center" data-wow-delay="0.5s">
            <div class="pagination">
                <a href="#">&laquo;</a>
                <a href="#">1</a>
                <a href="#" class="active">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">&raquo;</a>
                </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let expanded = false;
const multiSelect_kategori = document.getElementById('multiselect-kategori');
const selectBox_kategori = document.getElementById('selectBox-kategori');
const checkboxes_kategori = document.getElementById('checkboxes-kategori');


multiSelect_kategori.addEventListener('click', function(e) {
    if (!expanded) {
    checkboxes_kategori.style.display = "block";
    expanded = true;
  }
  else{
    checkboxes_kategori.style.display = "none";
    expanded = false;
  }
  e.stopPropagation();
}, true)

document.addEventListener('click', function(e){
  if (expanded) {
    checkboxes_kategori.style.display = "none";
    expanded = false;
  }
}, false)


function checkboxStatusChange() {
  var multiselect = document.getElementById("multiselect-kategori");
  var multiselectOption = multiselect.getElementsByTagName('option')[0];

  var values = [];
  var checkboxes = document.getElementById("checkboxes-kategori");
  var checkedCheckboxes = checkboxes.querySelectorAll('input[type=checkbox]:checked');

  for (const item of checkedCheckboxes) {
    var checkboxValue = item.getAttribute('value');
    values.push(checkboxValue);
  }

  var dropdownValue = '';
  if (values.length > 0) {
    dropdownValue = ' ('+values.length+') ';
  }
  multiselectOption.innerHTML = 'Kategori' + dropdownValue;
}

function hapusPilihan() {
    console.log('iya hapus');
}

function simpanPilihan() {
    console.log('iya simpan');
}

</script>
@endsection
