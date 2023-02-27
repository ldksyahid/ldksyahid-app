@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('style')
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>


@endsection


@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Buat Campaign Celengan Syahid</h5>
                <form role="form" action='/admin/service/celengansyahid/campaign/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="mb-3 col col-lg-12">
                            <label for="inputJudulCampaign" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="inputJudulCampaign" name='judul' placeholder="Jawaban Anda" required>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="chooseKategoriCampaign" class="form-label">Kategori</label>
                            <select class="form-select mb-3" aria-label="Default select" required name="kategori">
                                <option disabled selected hidden>-- Pilih Kategori --</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Kemanusiaan">Kemanusiaan</option>
                                <option value="Kesehatan">Kesehatan</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Sosial Dakwah">Sosial Dakwah</option>
                                <option value="Lingkungan">Lingkungan</option>
                            </select>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="inputLink" class="form-label">Link</label>
                            <input type="text" class="form-control" id="inputLink" name='link' required placeholder="Jawaban Anda" style="text-transform: lowercase;">
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="inputProvinsiCampaign" class="form-label">Provinsi</label>
                            <select class="form-group mb-3 textSearch" aria-label="" required name="provinsi" placeholder="Jawaban Anda" type='text' id="inputProvinsiCampaign" onchange="storeProvince()">
                                <option disabled selected hidden>-- Pilih Provinsi --</option>
                                @foreach ($provinces as $id => $name)
                                    <option value="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="kota" class="form-label">Kabupaten/Kota</label>
                            <select class="mb-3 textSearch" aria-label="" required name="kota" placeholder="Jawaban Anda" type='text' id="kota">
                                <option disabled selected hidden>-- Pilih Kabupaten/Kota --</option>
                                @foreach ($cities as $id => $name)
                                    <option value="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-12">
                            <label for="inputTargetBiaya" class="form-label">Target Biaya</label>
                            <input type="text" class="form-control" id="inputTargetBiaya" name='target_biaya' placeholder="Rp0" required >
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-12">
                            <label for="inputCerita" class="form-label">Detail Cerita</label>
                            <textarea class="form-control summernote" name="cerita" id="inputCerita" required></textarea>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-4">
                            <label for="formFile" class="form-label">Poster (1920 x 1080 Pixel)</label>
                            <input class="form-control" type="file" id="poster" name ='poster'accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" required>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-4">
                            <label for="inputDeadlineCampaign" class="form-label">Deadline</label>
                            <input type="date" class="form-control" id="inputDeadlineCampaign" name='deadline' required>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-4">
                            <label for="inputTelpPJ" class="form-label">Kontak Penanggung Jawab</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputTelpPJ">+62</span>
                                <input type="text" class="form-control" id="inputTelpPJ" name='telp_pj' placeholder="Jawaban Anda" aria-describedby="inputTelpPJ">
                            </div>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-12">
                            <label for="inputTujuan" class="form-label">Tujuan</label>
                            <textarea class="form-control" name="tujuan" id="inputTujuan" style="height: 100px;"></textarea>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-12">
                            <label for="inputKabarTerbaru" class="form-label">Kabar Terbaru</label>
                            <textarea class="form-control summernote" name="kabar_terbaru" id="inputKabarTerbaru"></textarea>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-12">
                            <label class="form-check-label" for="cekOrganisasi">Organisasi Selain UKM LDK Syahid ?</label>
                            <input type="checkbox" class="form-check-input" id="cekOrganisasi" onclick="cekOrg()">
                        </div>
                        <div id="formOrganisasi" style="display: none;">
                            <div class="row">
                                <div class="mb-3 col col-lg-4" >
                                    <label for="inputNamaPJ" class="form-label">Nama Organisasi</label>
                                    <input type="text" class="form-control" id="inputNamaPJ" name='nama_pj' placeholder="Jawaban Anda">
                                    <div class="invalid-feedback">
                                        Pertanyaan ini wajib diisi
                                    </div>
                                    <div class="valid-feedback">
                                        Okke!
                                    </div>
                                </div>
                                <div class="mb-3 col col-lg-4"  >
                                    <label for="inputLinkPJ" class="form-label">Link Profil Organisasi</label>
                                    <input type="text" class="form-control" id="inputLinkPJ" name='link_pj' placeholder="Jawaban Anda">
                                    <div class="invalid-feedback">
                                        Pertanyaan ini wajib diisi
                                    </div>
                                    <div class="valid-feedback">
                                        Okke!
                                    </div>
                                </div>
                                <div class="mb-3 col col-lg-4"  >
                                    <label for="formFile" class="form-label">Logo Organisasi</label>
                                    <input class="form-control" type="file" id="poster" name ='logo_pj'accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG">
                                    <div class="invalid-feedback">
                                        Pertanyaan ini wajib diisi
                                    </div>
                                    <div class="valid-feedback">
                                        Okke!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Buat</button>
                        <a type="submit" class="btn btn-primary" href="/admin/service/celengansyahid/campaigns">Batalkan</a>
                    </div>
                </form>
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

{{-- <script>
    function storeProvince() {
        var provinsi_id = $("#inputProvinsiCampaign").val();
        $("#inputKotaCampaign").append($('<option>', {
                    value: 1,
                    text: 'One'
                }));
        console.log(provinsi_id);
        var CSRF_TOKEN = '{{csrf_token()}}';
        console.log(CSRF_TOKEN);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            type: "post",
            url: "{{ url('/admin/service/celengansyahid/campaign/get-city') }}",
            data: {
                id: provinsi_id,
            },
            success: function(data) {
                console.log(data);

                $('#city').empty();
                // $('#city').append($('<option>', {
                //     value: 1,
                //     text: 'One'
                // }));
                $.each(data, function (id, name) {
                    $('#city').append(new Option(name, id))
                })
            },
            error: function(data){
                var errors = data.responseJSON;
                console.log('apa ini error nnyaaaa ' + errors);
            }
        });
    }
</script> --}}
@endsection
