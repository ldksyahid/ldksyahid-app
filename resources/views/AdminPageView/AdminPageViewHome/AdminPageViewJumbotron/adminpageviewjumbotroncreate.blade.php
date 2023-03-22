@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Create Jumbotron</h5>
                <form role="form" action='/admin/jumbotron/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="row">
                        <div class="mb-3 col col-lg-12">
                            <label for="formFile" class="form-label">Picture (1440 x 560 Pixel)</label>
                            <input class="form-control" type="file" id="picture" name ='picture' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" required>
                            <div class="invalid-feedback">
                                Please insert a picture here.
                            </div>
                            <div class="valid-feedback">
                                Nice Picture!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-12">
                            <label class="form-check-label" for="cekBtn">Add Button ?</label>
                            <input type="checkbox" class="form-check-input" id="cekButton" onclick="cekBtn()">
                        </div>
                        <div id="formButton" style="display: none;">
                            <div class="row">
                                <div class="mb-3 col col-lg-6">
                                    <label for="inputButtonName1" class="form-label">Button Name</label>
                                    <input type="text" class="form-control" id="inputButtonName1" name='buttonname' placeholder="Enter the Button Name like 'More', 'Go', etc">
                                </div>
                                <div class="mb-3 col col-lg-6">
                                    <label for="inputButtonLink1" class="form-label">Button Link</label>
                                    <input type="text" class="form-control" id="inputButtonLink1" name='buttonlink' placeholder="Enter the Button Link like 'https://www.instagram.com/ldksyahid/'">
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
    console.log(checkBoxBtn.checked);
    if (checkBoxBtn.checked == true){
        elementFormBtn.style.display = "block";
    } else {
        elementFormBtn.style.display = "none";
    }
}
</script>
@endsection
