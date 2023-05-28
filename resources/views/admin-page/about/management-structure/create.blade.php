@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Create Structure</h5>
                <form role="form" action='/admin/about/structure/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="row">
                        <div class="mb-3 col-4">
                            <label for="inputBatch" class="form-label required">Batch</label>
                            <input type="text" class="form-control" id="inputBatch" name='batch' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="inputPeriod" class="form-label required">Period</label>
                            <input type="text" class="form-control" id="inputPeriod" name='period' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="inputStructureName" class="form-label required">Structure Name</label>
                            <input type="text" class="form-control" id="inputStructureName" name='structureName' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="inputStructureDescription" class="form-label required">Structure Description</label>
                            <textarea class="form-control" name="structureDescription" id="inputStructureDescription" required></textarea>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="formFile" class="form-label required">Structure Logo (No Background 1080 x 1080)</label>
                            <br>
                            <img id="frame" src="{{ asset('Images/Icons/add_image.svg') }}" width="300px" height="300px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="structureLogo" name = 'structureLogo' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" required onchange="preview()">
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="formFile" class="form-label required">Structure Image (1515 x >=2560)</label>
                            <br>
                            <img id="frame2" src="{{ asset('Images/Icons/add_image.svg') }}" width="27.5%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="structureImage" name = 'structureImage' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" required onchange="preview2()">
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a type="submit" class="btn btn-primary" href="/admin/about/structure">Cancel</a>
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
function preview2() {
    frame2.src=URL.createObjectURL(event.target.files[0]);
}
</script>
@endsection
