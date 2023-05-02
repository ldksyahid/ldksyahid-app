@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Create IT Support LDK Syahid</h5>
                <form role="form" action='/admin/about/itsupport/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="inputName" name='name' required>
                        <div class="invalid-feedback">
                            Please fill in the Name.
                        </div>
                        <div class="valid-feedback">
                            Great!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputForkat" class="form-label">Forkat</label>
                        <input type="text" class="form-control" id="inputForkat" name='forkat' placeholder="Ex. Al-Qomar" required>
                        <div class="invalid-feedback">
                            Please fill in the Forkat.
                        </div>
                        <div class="valid-feedback">
                            Cool!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputPosition" class="form-label">Position</label>
                        <input type="text" class="form-control" id="inputPosition" name='position' placeholder="Ex. Machine Learning Developer" required>
                        <div class="invalid-feedback">
                            Please fill in the Position.
                        </div>
                        <div class="valid-feedback">
                            Okay!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputLinkInstagram" class="form-label">Link Instagram</label>
                        <input type="text" class="form-control" id="inputLinkInstagram" name='linkInstagram' placeholder="Ex. https://www.instagram.com/username/" required>
                        <div class="invalid-feedback">
                            Please fill in the Link Instagram.
                        </div>
                        <div class="valid-feedback">
                            Good!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputLinkInstagram" class="form-label">Link Linkedin</label>
                        <input type="text" class="form-control" id="inputLinkInstagram" name='linkLinkedin' placeholder="Ex. https://www.linkedin.com/in/username/" required>
                        <div class="invalid-feedback">
                            Please fill in the Link Linkedin.
                        </div>
                        <div class="valid-feedback">
                            Cool!
                        </div>
                    </div>
                    <div class="mb-3 col-xl-4">
                        <label for="photoProfile" class="form-label">Photo Profile (300 x 350 Pixel)</label>
                        <input class="form-control" type="file" id="photoProfile" name = 'photoProfile' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG, image/webp" required>
                        <div class="invalid-feedback">
                            Please insert a Photo Profile here.
                        </div>
                        <div class="valid-feedback">
                            Nice!
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a type="submit" class="btn btn-primary" href="/admin/about/itsupport">Cancel</a>
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
@endsection
