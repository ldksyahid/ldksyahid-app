@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Edit Article {{ $postarticle->title }} LDK Syahid</h5>
                <form role="form" action='/admin/article/{{ $postarticle->id }}/update' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                    <div class="mb-3">
                        <label for="inputTitleEvent" class="form-label">Title</label>
                        <input type="text" class="form-control" id="inputTitleArticle" name='title' placeholder="Enter the Article Title..." value="{{old('title', $postarticle->title)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the title.
                        </div>
                        <div class="valid-feedback">
                            Great Article Title!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputTheme" class="form-label">Theme</label>
                        <input type="text" class="form-control" id="inputTheme" name='theme' placeholder="Enter the Article Theme..." value="{{old('theme', $postarticle->theme)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Theme.
                        </div>
                        <div class="valid-feedback">
                            Great Article Theme!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputDateArticle" class="form-label">Date Article Created</label>
                        <input type="date" class="form-control" id="inputDateArticle" name='datearticle' placeholder="Enter the article created date..." value="{{old('dateevent', $postarticle->dateevent)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Date Article Created.
                        </div>
                        <div class="valid-feedback">
                            Nice Date !
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputWriter" class="form-label">Writer</label>
                        <input type="text" class="form-control" id="inputWriter" name='writer' placeholder="Enter the Writer Name..." value="{{old('writer', $postarticle->writer)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Writer.
                        </div>
                        <div class="valid-feedback">
                            Cool Writer!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputEditor" class="form-label">Editor</label>
                        <input type="text" class="form-control" id="inputWriter" name='editor' placeholder="Enter the Editor Name..." value="{{old('editor', $postarticle->editor)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Writer.
                        </div>
                        <div class="valid-feedback">
                            Cool Famous Editor!
                        </div>
                    </div>
                    <div class="mb-3 col-xl-4">
                        <label for="formFile" class="form-label">Poster (550 x 400 Pixel)</label>
                        <input class="form-control" type="file" id="poster" name = 'poster' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG">
                        <div class="invalid-feedback">
                            Please insert a Poster Article here.
                        </div>
                        <div class="valid-feedback">
                            Nice Poster!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputLinkEmbedPDF" class="form-label">Link Embed PDF</label>
                        <input type="text" class="form-control" id="inputLinkEmbedPDF" name='embedpdf' placeholder="Only insert Embedded PDF Link" value="{{old('embedpdf', $postarticle->embedpdf)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Link Embed PDF.
                        </div>
                        <div class="valid-feedback">
                            Good Job!
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a type="submit" class="btn btn-primary" href="/admin/article">Cancel</a>
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
