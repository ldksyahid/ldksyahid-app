@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Preview Article</h5>
                <form role="form" action='#' method='post' enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col-4">
                            <label for="inputTitleEvent" class="form-label required">Title</label>
                            <input type="text" class="form-control" id="inputTitleArticle" name='title' value="{{old('title', $postarticle->title)}}" disabled>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="inputTheme" class="form-label required">Theme</label>
                            <input type="text" class="form-control" id="inputTheme" name='theme' value="{{old('theme', $postarticle->theme)}}" disabled>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="inputDateArticle" class="form-label required">Date Article Created</label>
                            <input type="date" class="form-control" id="inputDateArticle" name='datearticle' value="{{old('dateevent', $postarticle->dateevent)}}" disabled>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="inputWriter" class="form-label required">Writer</label>
                            <input type="text" class="form-control" id="inputWriter" name='writer' value="{{old('writer', $postarticle->writer)}}" disabled>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="inputEditor" class="form-label required">Editor</label>
                            <input type="text" class="form-control" id="inputWriter" name='editor' value="{{old('editor', $postarticle->editor)}}" disabled>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="formFile" class="form-label required">Poster (550 x 400 Pixel)</label>
                            <br>
                            <img id="frame" src="{{ asset($postarticle->poster) }}" width="150px" height="200px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="poster" name = 'poster' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="inputLinkEmbedPDF" class="form-label required">Link Embed (Platform : <a href="https://anyflip.com/" target="_blank">anyflip.com</a> )</label>
                            <input type="text" class="form-control" id="inputLinkEmbedPDF" name='embedpdf' value="{{old('embedpdf', $postarticle->embedpdf)}}" disabled>
                        </div>
                        <div class="mb-3 col-12">
                            <a class="btn btn-primary" href="/admin/article"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
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
function preview() {
    frame.src=URL.createObjectURL(event.target.files[0]);
}
</script>
@endsection
