@extends('admin-page.template.body')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Create Jumbotron</h5>
                <form role="form" action='/admin/jumbotron/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <label for="formFile" class="form-label required">Picture <span class="small">(1440 x 560 Pixel)</span></label>
                            <br>
                            <img id="frame" src="{{ asset('Images/Icons/add_image.svg') }}" width="250px" height="150px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="picture" name ='picture' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview()" required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 my-3">
                            <label class="form-check-label" for="cekBtn">Add Button ?</label>
                            <input type="checkbox" class="form-check-input" id="cekButton" onclick="cekBtn()">
                        </div>
                        <div id="formButton" style="display: none;">
                            <div class="row">
                                <div class="mb-3 col-12 col-lg-6">
                                    <label for="inputButtonName1" class="form-label">Button Name</label>
                                    <input type="text" class="form-control" id="inputButtonName1" name='buttonname'>
                                </div>
                                <div class="mb-3 col-12 col-lg-6">
                                    <label for="inputButtonLink1" class="form-label">Button Link</label>
                                    <input type="text" class="form-control" id="inputButtonLink1" name='buttonlink'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a type="submit" class="btn btn-primary" href="/admin/jumbotron">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
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
function cekBtn() {
    var checkBoxBtn = document.getElementById("cekButton");
    var elementFormBtn = document.getElementById("formButton");
    if (checkBoxBtn.checked == true){
        elementFormBtn.style.display = "block";
    } else {
        elementFormBtn.style.display = "none";
    }
}
</script>

<script>
function preview() {
    frame.src=URL.createObjectURL(event.target.files[0]);
}
</script>
@endsection
