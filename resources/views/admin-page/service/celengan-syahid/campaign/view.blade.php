@extends('admin-page.template.body')

@section('head')
<link href="{{ asset('css/multiselectcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/navcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/cardcelengan.css') }}" rel="stylesheet" />
@endsection


@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
@php $donation_total = 0 ; $donatur=0 @endphp
@foreach ( $data->donation as $donation)
@if ($donation->payment_status == 'PAID')
@php $donation_total += (int)$donation->jumlah_donasi ; $donatur +=1 @endphp
@endif
@endforeach
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <div>
                    <div class="mb-2 mr-0">
                        <a href="/admin/service/celengansyahid/campaigns"><i class="fa fa-arrow-circle-left fa-2x" aria-hidden="true"></i></a>
                    </div>
                    <div class="row">
                        <div class="col col-lg-8 p-1" >
                            <img class="w-100 " src="{{ asset($data->poster) }}" alt="Image" style="border-radius: 15px;"/>
                            <div class="d-flex justify-content-between m-2 text-body small">
                                <div class="col col-lg-6">
                                    <p><i class="fas fa-globe fa-1x text-body" aria-hidden="true"></i> {{ $data->kota }}, {{ $data->provinsi }}</p>
                                </div>
                                <div class="col col-lg-6 text-end">
                                    <P>{{ \Carbon\Carbon::parse( $data->deadline )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $data->deadline )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $data->deadline )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $data->deadline )->format('Y') }} <i class="fas fa-bullseye fa-1x text-body"></i></P>
                                </div>
                            </div>
                        </div>
                        <div class="col col-lg-4 d-flex flex-row align-items-center">
                            <div class="p-1">
                                <div class="badge mb-3" style="margin-left:-8px;"> <span>{{ $data->kategori }}</span> </div>
                                <div class="d-flex flex-row align-items-center">
                                    <h3 class="text-body mb-0">{{ $data->judul }}</h3>
                                </div>
                                <p class="small">#{{ $data->link }}</p>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    @if ($data->nama_pj != null || $data->link_pj != null)
                                    <div class="d-flex flex-row align-items-center" style="height: 2em;">
                                        <img src="{{ asset($data->logo_pj) }}" alt="logo" width="30" height="30">
                                        <div class="ms-2 c-details">
                                            <h6 style="font-size: 18px" class="mb-0 text-body"><a href="{{ $data->link_pj }}" target="_blank">{{ $data->nama_pj }}</a></h6>
                                            <a class="small" href="https://wa.me/62{{ $data->telp_pj }}" target="_blank">0{{ $data->telp_pj }} (PJ)</a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="d-flex flex-row align-items-center" style="height: 2em;">
                                        <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="30" height="30">
                                        <div class="ms-2 c-details">
                                            <h6 style="font-size: 18px" class="mb-0 text-body"><a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a></h6>
                                            <a class="small" href="https://api.whatsapp.com/send?phone=62{{ $data->telp_pj }}" target="_blank">0{{ $data->telp_pj }} (PJ)</a>
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
                            </div>
                        </div>
                        <div class="col col-lg-12 my-3">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-detail-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-detail" type="button" role="tab" aria-controls="nav-detail"
                                        aria-selected="true">Detail</button>
                                    <button class="nav-link" id="nav-tujuan-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-tujuan" type="button" role="tab"
                                        aria-controls="nav-tujuan" aria-selected="false">Tujuan</button>
                                    <button class="nav-link" id="nav-newInfo-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-newInfo" type="button" role="tab"
                                        aria-controls="nav-newInfo" aria-selected="false">Kabar Terbaru</button>
                                    <button class="nav-link" id="nav-donatur-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-donatur" type="button" role="tab"
                                        aria-controls="nav-donatur" aria-selected="false">Donatur ({{ $donatur }})</button>
                                </div>
                            </nav>
                            <div class="tab-content pt-3" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                                    {!! $data->cerita !!}
                                </div>
                                <div class="tab-pane fade" id="nav-newInfo" role="tabpanel" aria-labelledby="nav-newInfo-tab">
                                    @if ($data->kabar_terbaru != null)
                                        {!! $data->kabar_terbaru !!}
                                    @else
                                        <div class="col col-lg-12 text-center m-3">
                                            <img src="{{asset('Images/Icons/empty_file.png')}}" alt="logo" width="150" height="150" >
                                            <p>Campaign ini belum memiliki kabar terbaru</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="tab-pane fade" id="nav-tujuan" role="tabpanel" aria-labelledby="nav-tujuan-tab">
                                    {{ $data->tujuan }}
                                </div>
                                <div class="tab-pane fade" id="nav-donatur" role="tabpanel" aria-labelledby="nav-donatur-tab">
                                    @if ($donatur > 0)
                                    @foreach ( $data->donation as $donation)
                                    <div class="row d-flex flex-row align-items-center p-4 col-lg-10" style="background-color: #f5f6fa; border-radius:15px;">
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
                                            @if ($donation->pesan_donatur != null)
                                                <i>{{ $donation->pesan_donatur }}</i>
                                            @else
                                                <i>Bismillah Semoga Berkah yaaa ! tetap Semangat Semuanya !!</i>
                                            @endif
                                            </p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="col col-lg-12 text-center m-3">
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
    </div>
</div>
<!-- Form End -->
@endsection
@section('scripts')
<script>
    // Pemanggilan Validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
             $('.summernote').summernote({
              height: 500,
              dialogsInBody: true,
              callbacks:{
                  onInit:function(){
                  $('body > .note-popover').hide();
                  }
               },
           });
        });
</script>
<script>
    const dengan_rupiah = document.querySelectorAll('#inputTargetBiaya');
    for (let i = 0; i < dengan_rupiah.length; i++) {
        dengan_rupiah[i].addEventListener('keyup', function(e)
        {
            dengan_rupiah[i].value = formatRupiah(this.value, 'Rp');
        });
    }
    function formatRupiah(angka, prefix)
        {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split    = number_string.split(','),
                sisa     = split[0].length % 3,
                rupiah     = split[0].substr(0, sisa),
                ribuan     = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
        }
</script>
<script>
    document.querySelector('#inputLink').addEventListener('keydown', (e) => {
    if (e.which === 188 || e.which === 32 || e.which === 188 || e.which === 186 || e.which === 187 || e.which === 190 || e.which === 191 || e.which === 192 || e.which === 219 || e.which === 220 || e.which === 221 || e.which === 222) {
        e.preventDefault();
    }
    });

    const textSearch = document.querySelectorAll('.textSearch');
    for (let i = 0; i < textSearch.length; i++) {
        new TomSelect(textSearch[i],{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    }

</script>

<script>
function cekOrg() {
  var checkBox = document.getElementById("cekOrganisasi");
  var element = document.getElementById("formOrganisasi");
  if (checkBox.checked == true){
    element.style.display = "block";
  } else {
    element.style.display = "none";
  }
}
</script>
@endsection

