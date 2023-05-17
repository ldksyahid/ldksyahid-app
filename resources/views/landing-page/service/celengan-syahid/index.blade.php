@extends('landing-page.template.body')

@section('head')
<link href="{{ asset('css/multiselectcelengan.css') }}" rel="stylesheet" />
@endsection

@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
<div class="container-fluid p-0 mb-4 wow fadeIn" data-wow-delay="0.2s">
  <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="w-100 " src="{{ asset('Images/fixImage/billboardimage/celengan_syahid.png') }}" alt="Image" />
        </div>
        @forelse($postcampaign as $key => $data)
        <div class="carousel-item">
            <img class="w-100 " src="{{ asset($data->poster) }}" alt="Image" />
        </div>
        @empty
        @endforelse
      </div>
  </div>
</div>
<div class="container-xl">
    <div class="row g-3">
        {{-- website --}}
        <div class="col-lg-12 col-md-6 wow fadeInUp website-responsive" data-wow-delay="0.1s">
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
        <div class="col-lg-12 col-md-6 wow fadeInUp mobile-responsive" data-wow-delay="0.1s">
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
        {{-- <div class="col-lg-12 col-md-6 wow fadeInUp py-1" data-wow-delay="0.5s" style="margin-bottom: 0px;">
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
                                    <div class="col text-center">
                                        <a class="btn btn-danger w-100 py-3 fadeIn boder-r d-flex align-items-center h-25" style="margin-bottom: -25px;" id="hapusPilihan" onchange="hapusPilihan()">Hapus&nbsp;&nbsp;</a>
                                    </div>
                                    <div class="col text-center">
                                        <a class="btn btn-primary w-100 py-3 fadeIn boder-r d-flex align-items-center h-25 " href="#" type="submit" style="margin-bottom: -25px;" onchange="simpanPilihan()">Simpan</a>
                                    </div>
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
        </div> --}}
        <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
            {{-- <h6 class="text-body">Menampilkan 12 dari 62 <i>campaign</i></h6> --}}
            {{-- website --}}
            <div class="row g-4 mt-1 website-responsive">
                @forelse($postcampaign as $key => $data)
                @php $donation_total = 0 @endphp
                @foreach ( $data->donation as $donation)
                @if ($donation->payment_status == 'PAID')
                @php $donation_total += (int)$donation->jumlah_donasi @endphp
                @endif
                @endforeach

                <div class="col-lg-4 col-md-6 mt-3">
                    <div class="card shadow-c mb-2">
                        <div style="height: 12em;">
                            <a href="/service/celengansyahid/{{ $data->link }}"><img src="{{ asset($data->poster) }}" alt="poster-{{ $data->link }}" class="card-img w-100"></a>
                        </div>
                        <div class="mt-1 p-3">
                            <div class="badge" style="margin-left:-8px;"> <span>{{ $data->kategori }}</span> </div>
                            <div style="height: 5em;" class="d-flex flex-row align-items-center">
                                <h5 class="text-body mb-0"><a href="/service/celengansyahid/{{ $data->link }}">{{ $data->judul }}</a></h5>
                            </div>
                            <div style="height: 2em;">
                                <p style="font-size: 14px;">
                                    {!!  substr(strip_tags($data->cerita), 0, 80) !!}...
                                </p>
                            </div>
                            <div class="mt-3">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    @if ($data->nama_pj != null && $data->link_pj != null)
                                    <div class="d-flex flex-row align-items-center" style="height: 2em;">
                                        <img src="{{ asset($data->logo_pj) }}" alt="logo" width="25" height="25">
                                        <div class="ms-2 c-details">
                                            <h6 style="font-size: 16px" class="mb-0 text-body"><a href="{{ $data->link_pj }}" target="_blank">{{ $data->nama_pj }}</a></h6>
                                        </div>
                                    </div>
                                    @else
                                    <div class="d-flex flex-row align-items-center" style="height: 2em;">
                                        <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="25" height="25">
                                        <div class="ms-2 c-details">
                                            <h6 style="font-size: 16px" class="mb-0 text-body"><a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a></h6>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="progress mt-3">
                                    <div class="progress-bar" role="progressbar" style="width: {{ number_format(LFC::persentaseBiayaTerkumpul($donation_total,$data->target_biaya),1,'.','') }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><strong>{{ number_format(LFC::persentaseBiayaTerkumpul($donation_total,$data->target_biaya),1,'.','') }}%</strong></div>
                                </div>
                                <div class="mt-0">
                                    <div class="row">
                                        <div class="col text-start">
                                            <p>
                                                <span style="font-size: 12px;">Terkumpul</span>
                                                <br>
                                                <span style=" color:#00a79d;">
                                                    <strong>{{ LFC::FormatRupiah($donation_total) }}</strong>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="col text-end">
                                            <p>
                                                <span style="font-size: 12px;">Sisa Hari</span>
                                                <br>
                                                <span>
                                                    <strong>{{ LFC::countdownHari($data->deadline) }}</strong>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-lg-12 m-5 text-body text-center">
                    <img src="{{asset('Images/Icons/empty_inbox.png')}}" alt="logo" width="150" height="150" >
                    <br><br>
                    <p>Campaign Belum Tersedia</p>
                </div>
                @endforelse
            </div>
            {{-- mobile --}}
            <div class="row mt-1 mobile-responsive">
                @forelse($postcampaign as $key => $data)
                @php $donation_total = 0 @endphp
                @foreach ( $data->donation as $donation)
                @if ($donation->payment_status == 'PAID')
                @php $donation_total += (int)$donation->jumlah_donasi @endphp
                @endif
                @endforeach
                <div class="col-lg-4 col-md-6 mt-1">
                    <div class="row d-flex flex-row align-items-center">
                        <div class="col" style="margin-right:-20px;">
                            <div  class="p-3">
                                <div class="badge-mobile-all pb-1" style="margin-top: -20px"> <span style="font-size:6px; font-weight:575;"><p>{{$data->kategori}}</p></span> </div>
                                <a href="/service/celengansyahid/{{ $data->link }}"><img src="{{ asset($data->poster) }}" alt="{{ $data->link }}" class="card-img w-100" style="border-radius: 5px;"></a>
                            </div>
                        </div>
                        <div class="col" style="margin-left:-20px;">
                            <div class="p-3">
                                <div style="line-height: 1.1em">
                                    <a href="/service/celengansyahid/{{ $data->link }}" style="font-size: 12px ; font-weight:600;">{!!  strip_tags( $data->judul ) !!}</a>
                                </div>
                            </div>
                            <div class="col p-3" style="margin-top:-30px;">
                                <div class="d-flex justify-content-between">
                                    @if ($data->nama_pj != null && $data->link_pj != null)
                                    <div class="d-flex flex-row align-items-center">
                                        <img src="{{ asset($data->logo_pj) }}" alt="logo" width="15" height="15">
                                        <div class="ms-2 c-details">
                                            <h6 style="font-size: 10px" class="mb-0 text-body"><a href="{{ $data->link_pj }}" target="_blank" style="font-size: 8px">{{ $data->nama_pj }}</a></h6>
                                        </div>
                                    </div>
                                    @else
                                    <div class="d-flex flex-row align-items-center">
                                        <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="15" height="15">
                                        <div class="ms-2 c-details">
                                            <h6 style="font-size: 10px" class="mb-0 text-body"><a href="https://www.ldksyah.id/" target="_blank" style="font-size: 8px">UKM LDK Syahid</a></h6>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="progress  my-1" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ number_format(LFC::persentaseBiayaTerkumpul($donation_total,$data->target_biaya),1,'.','') }}%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><strong style="font-size: 6px; margin-bottom:0px;">{{ number_format(LFC::persentaseBiayaTerkumpul($donation_total,$data->target_biaya),1,'.','') }}%</strong></div>
                                </div>
                                <div class="mt-0">
                                    <div class="row">
                                        <div class="col text-start" style="line-height: -50px;">
                                            <p style="font-size: 8px;">Terkumpul</p>
                                            <p style=" color:#00a79d; font-size:9px; margin-top:-18px;"><strong>{{ LFC::formatRupiah($donation_total) }}</strong></p>
                                        </div>
                                        <div class="col text-end">
                                            <p style="font-size: 8px;">Sisa Hari</p>
                                            <p style="font-size:9px; margin-top:-18px;"><strong>{{ LFC::countdownHari($data->deadline) }}</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="margin:-25px -20px 0px -20px;" class="px-3">
                        <hr>
                    </div>
                </div>
                @empty
                <div class="col-lg-12 m-2 text-body text-center">
                    <img src="{{asset('Images/Icons/empty_inbox.png')}}" alt="logo" width="90" height="90" >
                    <br><br>
                    <p>Campaign Belum Tersedia</p>
                </div>
                @endforelse
            </div>
        </div>
        {{-- <div class="col-lg-12 col-md-6 wow fadeInUp text-center" data-wow-delay="0.5s">
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
        </div> --}}
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
