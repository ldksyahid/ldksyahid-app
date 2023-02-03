@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

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
                                <option value="pendidikan">Pendidikan</option>
                                <option value="kemanusiaan">Kemanusiaan</option>
                                <option value="kesehatan">Kesehatan</option>
                                <option value="ekonomi">Ekonomi</option>
                                <option value="sosial_dakwah">Sosial Dakwah</option>
                                <option value="lingkungan">Lingkungan</option>
                            </select>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="inputKotaCampaign" class="form-label">Kota Lokasi</label>
                            <input type="text" class="form-control" id="inputKotaCampaign" name='lokasi' placeholder="Jawaban Anda" required>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="inputTargetBiaya" class="form-label">Target Biaya</label>
                            <input type="text" class="form-control" id="inputTargetBiaya" name='target_biaya' placeholder="Rp0" required >
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="inputDeadlineCampaign" class="form-label">Deadline</label>
                            <input type="date" class="form-control" id="inputDeadlineCampaign" name='deadline' required>
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
                        <div class="mb-3 col col-lg-6">
                            <label for="formFile" class="form-label">Poster (1920 x 1080 Pixel)</label>
                            <input class="form-control" type="file" id="poster" name ='poster'accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" required>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="inputLink" class="form-label">Link</label>
                            <input type="text" class="form-control" id="inputLink" name='link' required placeholder="Jawaban Anda">
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Buat</button>
                        <a type="submit" class="btn btn-primary" href="/admin/event">Batalkan</a>
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
@endsection