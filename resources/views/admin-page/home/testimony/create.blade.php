@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Create Testimony</h5>
                <form role="form" action='/admin/testimony/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="row">
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputName1" class="form-label required">Name</label>
                            <input type="text" class="form-control" id="inputName1" name='name' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputProfession1" class="form-label required">Profession</label>
                            <input type="text" class="form-control" id="inputProfession" name='profession' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="inputTestimony" class="form-label required">Testimony <span class="small">(Max 250 Letters)</span></label>
                            <textarea class="form-control" name="testimony" id="inputTestimony" maxlength="250" required></textarea>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="formFile" class="form-label required">Photo Profile <span class="small">(100 x 100 Pixel)</span></label>
                            <br>
                            <img id="frame" src="{{ asset('Images/Icons/add_image.svg') }}" width="150px" height="150px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="picture" name ='picture' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview()" required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="col-12 col-lg-12">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a type="submit" class="btn btn-primary" href="/admin/testimony">Cancel</a>
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

<script>
function preview() {
    frame.src=URL.createObjectURL(event.target.files[0]);
}
</script>
@endsection
