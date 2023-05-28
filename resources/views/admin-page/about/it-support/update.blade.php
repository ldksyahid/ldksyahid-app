@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Edit IT Support</h5>
                <form role="form" action='/admin/about/itsupport/{{ $postitsupport->id }}/update' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-4">
                            <label for="inputName" class="form-label required">Name</label>
                            <input type="text" class="form-control" id="inputName" name='name' value="{{old('name', $postitsupport->name)}}" required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="inputForkat" class="form-label required">Forkat</label>
                            <input type="text" class="form-control" id="inputForkat" name='forkat' value="{{old('forkat', $postitsupport->forkat)}}" required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="inputPosition" class="form-label required">Position</label>
                            <input type="text" class="form-control" id="inputPosition" name='position' value="{{old('position', $postitsupport->position)}}" required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="photoProfile" class="form-label required">Photo Profile (300 x 350 Pixel)</label>
                            <br>
                            <img id="frame" src="{{ asset($postitsupport->photoProfile) }}" width="200px" height="250px"  class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photoProfile" name = 'photoProfile' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG, image/webp" onchange="preview()">
                        </div>
                        <div class="mb-3 col-4">
                            <label for="inputLinkInstagram" class="form-label required">Instagram Link</label>
                            <input type="text" class="form-control" id="inputLinkInstagram" name='linkInstagram' value="{{old('linkInstagram', $postitsupport->linkInstagram)}}" required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="inputLinkInstagram" class="form-label required">Linkedin Link</label>
                            <input type="text" class="form-control" id="inputLinkInstagram" name='linkLinkedin' value="{{old('linkLinkedin', $postitsupport->linkLinkedin)}}" required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a type="submit" class="btn btn-primary" href="/admin/about/itsupport">Cancel</a>
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
