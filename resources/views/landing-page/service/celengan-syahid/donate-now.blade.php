@extends('landing-page.template.body')

@section('style')
<link href="{{ asset('css/multiselectcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/navcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/cardcelengan.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="website-responsive">
    <div class="container-fluid" style="background-color: #f5f6fa;">
        <div class="container w-75">
            <div class="row g-5">
                <div class="col col-lg-6">
                    <div class="py-5">
                        <img class="w-100 " src="{{ asset($data->poster) }}" alt="Image" style="border-radius: 15px;"/>
                    </div>
                </div>
                <div class="col col-lg-6 d-flex flex-row align-items-center">
                    <div class="py-5">
                        <div class="d-flex flex-row align-items-center">
                            <div style="line-height: 0.1;">
                                <p style="color: #00a79d">Kamu akan berdonasi untuk membantu :</p>
                                <h4 class="text-body mb-0">{{ $data->judul }}</h4>
                                <hr>
                                <div class="d-flex justify-content-between">
                                   @if ($data->nama_pj != null || $data->link_pj != null)
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
                <form role="form" action='/service/celengansyahid/donation/store' method='post' enctype="multipart/form-data" class="needs-validation form" novalidate>
                @csrf
                @method('POST')
                    <input type="hidden" name="postdonation" value="{{$data->id}}" />
                    <input type="hidden" name="linkcampaign" value="{{$data->link}}" />
                    <div class="col col-lg-12 my-5">
                        <div class="text-center">
                            <h3 class="text-body mb-3">Masukan Nominal Donasi</h3>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control inputBiayaDonasi" id="inputBiayaDonasiWeb"  name="jumlah_donasi" style="border-radius: 5px" placeholder="Rp0" required />
                                <div class="invalid-feedback">
                                    Pertanyaan ini wajib diisi
                                </div>
                                <div class="valid-feedback">
                                    Okke!
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h4 class="text-body mb-3">Atau pilih nominal Donasi</h4>
                        </div>
                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100" onclick="donaterp(1)" style="border-radius: 5px;">Rp10.000</button>
                                </div>
                                <div class="col col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100"  onclick="donaterp(2)" style="border-radius: 5px;">Rp20.000</button>
                                </div>
                                <div class="col col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100"  onclick="donaterp(3)"  style="border-radius: 5px;">Rp50.0000</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100"  onclick="donaterp(4)" style="border-radius: 5px;">Rp100.000</button>
                                </div>
                                <div class="col col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100"  onclick="donaterp(5)" style="border-radius: 5px;">Rp200.000</button>
                                </div>
                                <div class="col col-lg-4">
                                    <button type="button" class="btn btn-outline-primary w-100"  onclick="donaterp(6)" style="border-radius: 5px;">Rp500.000</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-12 my-5">
                        <div class="text-center">
                            <h3 class="text-body mb-3">Profil Donatur</h3>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control namaDonatur" id="namaDonaturWeb" placeholder="Nama Donatur" style="border-radius: 5px;" name="nama_donatur" required>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="form-group my-3">
                            <input type="email" class="form-control" id="emailDonatur" placeholder="Email" style="border-radius: 5px;" name="email_donatur" required>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="telponDonatur" placeholder="No. Telpon" style="border-radius: 5px;" name="no_telp_donatur" required onkeypress="return isNumber(event)">
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div class="form-check">
                              <input class="form-check-input anonimCheck" type="checkbox" id="anonimCheckWeb">
                              <label class="form-check-label" for="anonimCheckWeb">
                                Tampilkan sebagai donatur anonim
                              </label>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-12 my-5">
                        <div class="text-center">
                            <h3 class="text-body mb-3">Dukungan atau Doamu (Optional)</h3>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" id="doamu" rows="5" style="border-radius:5px;" name="pesan_donatur"></textarea>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-12 my-5 text-end">
                        <div class="form-group">
                            <div class="input-group mb-2">
                                <div class="input-group-prepend" style="border-radius:5px;">
                                    <div class="input-group-text" style="border-radius:5px 0px 0px 5px;; border-right:none;"><strong style="font-size:22px;">TOTAL</strong></div>
                                </div>
                                <input type="text" class="form-control text-end totalDonasi" name="totalDonasi" id="totalDonasiWeb"  style="border-radius:0px 5px 5px 0px; border-left:none; padding-left:0px; margin-left:-5px; font-weight:700; font-size:22px; color:#00a79d;" disabled value='Rp0'>
                            </div>
                        </div>
                    </div>
                    <div class="col col-lg-12 my-5">
                        <div class="col-md-6 mb-3">{!! htmlFormSnippet() !!} </div>
                    </div>
                    <div class="col col-lg-12 my-5">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary py-2 px-5 w-100" style="border-radius: 5px;">LANJUTKAN PEMBAYARAN DONASI</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="mobile-responsive">
    <div class="container-fluid p-0" style="background-color: #f5f6fa;">
        <div>
            <img class="w-100 " src="{{ asset($data->poster) }}" alt="Image"/>
        </div>
        <div class="px-4 py-4">
            <div style="line-height: 0.1;">
                <p style="color: #00a79d; font-size:14px;">Kamu akan berdonasi untuk membantu :</p>
                <h6 class="text-body mb-0" style="font-size: 16px">{{ $data->judul }}</h6>
                <hr>
                <div class="d-flex justify-content-between">
                    @if ($data->nama_pj != null || $data->link_pj != null)
                    <div class="d-flex flex-row align-items-center" style="height: 0.7em;">
                        <img src="{{ asset($data->logo_pj) }}" alt="logo" width="20" height="20">
                        <div class="ms-2 c-details my-0">
                            <h6 style="font-size: 12px" class="mb-0 text-body"><a href="{{ $data->link_pj }}" target="_blank">{{ $data->nama_pj }}</a></h6>
                        </div>
                    </div>
                    @else
                    <div class="d-flex flex-row align-items-center" style="height: 0.7em;">
                        <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="20" height="20">
                        <div class="ms-2 c-details my-0">
                            <h6 style="font-size: 12px" class="mb-0 text-body"><a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a></h6>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container px-4 py-3">
        <div>
            <form role="form" action='/service/celengansyahid/donation/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf
            @method('POST')
                <input type="hidden" name="linkcampaign" value="{{$data->link}}" />
                <input type="hidden" name="postdonation" value="{{$data->id}}" />
                <div class="col col-md-12 my-4">
                    <div class="text-center">
                        <h6 class="text-body mb-2" style="font-size: 18px">Masukan Nominal Donasi</h6>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control inputBiayaDonasi" id="inputBiayaDonasiMobile" name='jumlah_donasi' style="border-radius:5px; font-size: 16px" placeholder="Rp0" required>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h6 class="text-body mb-3" style="font-size: 16px">Atau pilih nominal Donasi</h6>
                    </div>
                    <div class="form-group">
                        <div class="row mb-2">
                            <div class="col col-md-6">
                                <button type="button" class="btn btn-outline-primary w-100" onclick="donaterp(1)" style="border-radius: 5px; font-size: 16px">Rp10.000</button>
                            </div>
                            <div class="col col-md-6">
                                <button type="button" class="btn btn-outline-primary w-100"  onclick="donaterp(2)" style="border-radius: 5px; font-size: 16px">Rp20.000</button>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col col-md-6">
                                <button type="button" class="btn btn-outline-primary w-100" onclick="donaterp(3)" style="border-radius: 5px; font-size: 16px">Rp50.000</button>
                            </div>
                            <div class="col col-md-6">
                                <button type="button" class="btn btn-outline-primary w-100"  onclick="donaterp(4)" style="border-radius: 5px; font-size: 16px">Rp100.000</button>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col col-md-6">
                                <button type="button" class="btn btn-outline-primary w-100" onclick="donaterp(5)" style="border-radius: 5px; font-size: 16px">Rp200.000</button>
                            </div>
                            <div class="col col-md-6">
                                <button type="button" class="btn btn-outline-primary w-100"  onclick="donaterp(6)" style="border-radius: 5px; font-size: 16px">Rp500.000</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-md-12 my-4">
                    <div class="text-center">
                        <h6 class="text-body mb-3" style="font-size: 18px;">Profil Donatur</h6>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control namaDonatur" id="namaDonaturWeb" placeholder="Nama Donatur" style="border-radius: 5px; font-size: 16px" required name="nama_donatur">
                        <div class="invalid-feedback small">
                            Pertanyaan ini wajib diisi
                        </div>
                        <div class="valid-feedback small">
                            Okke!
                        </div>
                    </div>
                    <div class="form-group my-2">
                        <input type="email" class="form-control" id="emailDonatur" placeholder="Email" style="border-radius: 5px; font-size: 16px" required name="email_donatur">
                        <div class="invalid-feedback small">
                            Pertanyaan ini wajib diisi
                        </div>
                        <div class="valid-feedback small">
                            Okke!
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="telponDonatur" placeholder="No. Telpon" style="border-radius: 5px; font-size: 16px" required name="no_telp_donatur" onkeypress="return isNumber(event)">
                        <div class="invalid-feedback small">
                            Pertanyaan ini wajib diisi
                        </div>
                        <div class="valid-feedback small">
                            Okke!
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <div class="form-check">
                          <input class="form-check-input anonimCheck" type="checkbox" id="anonimCheckMobile" style="font-size: 16px;">
                          <label class="form-check-label" for="anonimCheckMobile" style="font-size: 16px;">
                            Tampilkan sebagai donatur anonim
                          </label>
                        </div>
                    </div>
                </div>
                <div class="col col-md-12 my-4">
                    <div class="text-center">
                        <h6 class="text-body mb-3" style="font-size: 18px;">Dukungan atau Doamu (Optional)</h6>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="doamu" rows="5" style="border-radius:5px; font-size: 16px" name="pesan_donatur"></textarea>
                        <div class="valid-feedback small">
                            Okke!
                        </div>
                    </div>
                </div>
                <div class="col col-md-12 my-4 text-end">
                    <div class="form-group">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend" style="border-radius:5px;">
                                <div class="input-group-text" style="border-radius:5px 0px 0px 5px;; border-right:none;"><strong style="font-size:16px;">TOTAL</strong></div>
                            </div>
                            <input type="text" class="form-control text-end totalDonasi" name="totalDonasi" id="totalDonasiWeb"  style="border-radius:0px 5px 5px 0px; border-left:none; padding-left:0px; margin-left:-5px; font-weight:700; font-size:16px; color:#00a79d;" disabled value='Rp0'>
                        </div>
                    </div>
                </div>
                <div class="col col-md-12 my-4">
                    <div class="col-md-6 mb-3" style="font-size: 10px;">{!! htmlFormSnippet() !!} </div>
                </div>
                <div class="col col-md-12 my-4">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary py-2 px-5 w-100" style="border-radius: 5px; font-size:14px;">LANJUTKAN PEMBAYARAN DONASI</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const dengan_rupiah = document.querySelectorAll('.inputBiayaDonasi');
for (let i = 0; i < dengan_rupiah.length; i++) {
    dengan_rupiah[i].addEventListener('keyup', function(e)
    {
        dengan_rupiah[i].value = formatRupiah(this.value, 'Rp');
    });
}
function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^\d]/g, '').toString(),
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
const anonimCheck = document.querySelectorAll('.anonimCheck');
const namaDonatur = document.querySelectorAll('.namaDonatur');
for (let i = 0; i < anonimCheck.length; i++) {
    anonimCheck[i].addEventListener('change', function(e)
    {
        namaDonatur[i].readOnly = this.checked;
        namaDonatur[i].value = 'Manusia Baik';
    });
}
</script>

<script>
    const inputBiayaDonasi = document.querySelectorAll(".inputBiayaDonasi");
    const tagihanDonasi = document.querySelectorAll(".totalDonasi");
    function donaterp(num) {
        if (num == 1) {
            for (let i = 0; i < inputBiayaDonasi.length; i++) {
                inputBiayaDonasi[i].value = formatRupiah('10000', 'Rp');
                tagihanDonasi[i].value = formatRupiah('10000', 'Rp');
            }
        } else if (num == 2) {
            for (let i = 0; i < inputBiayaDonasi.length; i++) {
                inputBiayaDonasi[i].value = formatRupiah('20000', 'Rp');
                tagihanDonasi[i].value = formatRupiah('20000', 'Rp');
            }
        } else if (num == 3) {
            for (let i = 0; i < inputBiayaDonasi.length; i++) {
                inputBiayaDonasi[i].value = formatRupiah('50000', 'Rp');
                tagihanDonasi[i].value = formatRupiah('50000', 'Rp');
            }
        } else if (num == 4) {
            for (let i = 0; i < inputBiayaDonasi.length; i++) {
                inputBiayaDonasi[i].value = formatRupiah('100000', 'Rp');
                tagihanDonasi[i].value = formatRupiah('100000', 'Rp');
            }
        } else if (num == 5) {
            for (let i = 0; i < inputBiayaDonasi.length; i++) {
                inputBiayaDonasi[i].value = formatRupiah('200000', 'Rp');
                tagihanDonasi[i].value = formatRupiah('200000', 'Rp');
            }
        } else if (num == 6) {
            for (let i = 0; i < inputBiayaDonasi.length; i++) {
                inputBiayaDonasi[i].value = formatRupiah('500000', 'Rp');
                tagihanDonasi[i].value = formatRupiah('500000', 'Rp');
            }
        }
    }
</script>

<script>
var firstInput = document.getElementsByName("jumlah_donasi");
var secondInput = document.getElementsByName("totalDonasi");
for (let i = 0; i < firstInput.length; i++) {
    function process(e) {
    secondInput[i].value = formatRupiah(e.target.value.toString().replace('.', ''), 'Rp');
    }
    firstInput[i].addEventListener("input", process);
}
</script>

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

<script>
function isNumber(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

     return true;
  }
</script>
@endsection
