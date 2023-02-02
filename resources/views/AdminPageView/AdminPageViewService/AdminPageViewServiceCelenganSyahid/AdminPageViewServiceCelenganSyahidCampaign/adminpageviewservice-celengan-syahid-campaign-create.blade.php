@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Buat Campaign untuk Celengan Syahid</h5>
                <form role="form" action='/admin/service/celengansyahid/campaign/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="row">
                        <div class="mb-3 col col-lg-6">
                            <label for="inputJudulCampaign" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="inputJudulCampaign" name='judul' placeholder="Jawaban Anda" required>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                        <div class="col-auto my-1">
                            <label class="mr-sm-2" for="inlineFormCustomSelect">Preference</label>
                            <select class="custom-select  form-control" id="inlineFormCustomSelect">
                                <option selected>Choose...</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="mb-3 col col-lg-6">
                            <label for="inputKategoriCampaign" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="inputKategoriCampaign" name='kategori' placeholder="Jawaban Anda" required>
                            <div class="invalid-feedback">
                                Pertanyaan ini wajib diisi
                            </div>
                            <div class="valid-feedback">
                                Okke!
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                    <a type="submit" class="btn btn-primary" href="/admin/event">Batalkan</a>
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
@endsection
