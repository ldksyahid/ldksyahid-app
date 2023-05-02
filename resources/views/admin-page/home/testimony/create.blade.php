@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Create Testimony</h5>
                <form role="form" action='/admin/testimony/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="mb-3">
                        <label for="inputName1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="inputName1" name='name' placeholder="Enter the Full Name..." required>
                        <div class="invalid-feedback">
                            Please fill in the Name.
                        </div>
                        <div class="valid-feedback">
                            Great!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputProfession1" class="form-label">Profession</label>
                        <input type="text" class="form-control" id="inputProfession" name='profession' placeholder="Enter the Profession..." required>
                        <div class="invalid-feedback">
                            Please fill in the Profession.
                        </div>
                        <div class="valid-feedback">
                            Great!
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="inputTestimony" class="form-label">Testimony (Max 250 Letters)</label>
                        <textarea class="form-control" name="testimony" id="inputTestimony" maxlength="250" required></textarea>
                        <div class="invalid-feedback">
                            Please fill in the Testimony.
                        </div>
                        <div class="valid-feedback">
                            Awesome!
                        </div>
                    </div>
                    <div class="mb-3 col-xl-4">
                        <label for="formFile" class="form-label">Photo Profile (100 x 100 Pixel)</label>
                        <input class="form-control" type="file" id="picture" name ='picture' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" required>
                        <div class="invalid-feedback">
                            Please insert a Photo Profile.
                        </div>
                        <div class="valid-feedback">
                            Nice!
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a type="submit" class="btn btn-primary" href="/admin/testimony">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
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
@endsection
