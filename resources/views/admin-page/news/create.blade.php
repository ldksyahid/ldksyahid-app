@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Create News</h5>
                <form role="form" action='/admin/news/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="row">
                        <div class="mb-3 col-4">
                            <label for="inputDatePublish" class="form-label required">Date Publish</label>
                            <input type="date" class="form-control" id="inputDatePublish" name='datepublish' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="inputPublisher" class="form-label required">Publisher</label>
                            <input type="text" class="form-control" id="inputPublisher" name='publisher' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="inputTitle" class="form-label required">Title</label>
                            <input type="text" class="form-control" id="inputTitle" name='title' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="inputReporter" class="form-label required">Reporter</label>
                            <input type="text" class="form-control" id="inputReporter" name='reporter' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="inputEditor" class="form-label required">Editor</label>
                            <input type="text" class="form-control" id="inputEditor" name='editor' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="picture" class="form-label required">Picture (1366 x 768 Pixel)</label>
                            <br>
                            <img id="frame" src="{{ asset('Images/Icons/add_image.svg') }}" width="250px" height="150px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="picture" name = 'picture' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG, image/webp" required onchange="preview()">
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="inputDescPicture" class="form-label required">Picture Description</label>
                            <input type="text" class="form-control" id="inputDescPicture" name='descpicture' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="inputBody" class="form-label required">Content News</label>
                            <textarea class="form-control summernote" name="body" id="inputBody" required></textarea>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a type="submit" class="btn btn-primary" href="/admin/news">Cancel</a>
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
        height: 800,
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
