@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Create Gallery</h5>
                <form role="form" action='/admin/about/gallery/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="row">
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputEventName" class="form-label required">Event Name</label>
                            <input type="text" class="form-control" id="inputEventName" name='eventName' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputEventTheme" class="form-label required">Event Theme</label>
                            <input type="text" class="form-control" id="inputEventTheme" name='eventTheme' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputEventDescription" class="form-label required">Event Description</label>
                            <textarea class="form-control" name="eventDescription" id="inputEventDescription" required></textarea>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-5 col-12 col-lg-6">
                            <label for="inputLinkEmbedYoutube" class="form-label">Embed Youtube Link</label>
                            <input type="text" class="form-control" id="inputLinkEmbedYoutube" name='linkEmbedYoutube'>
                        </div>
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="groupPhoto" class="form-label required">Group Photo</label>
                            <br>
                            <div class="text-center">
                                <img id="frame" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="50%" class="rounded mb-3 border"/>
                            </div>
                            <input class="form-control" type="file" id="groupPhoto" name = 'groupPhoto' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" required onchange="preview()">
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo1" class="form-label">Photo 1</label>
                            <br>
                            <img id="frame1" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="80%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photo1" name ='photo1' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview1()">
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo2" class="form-label">Photo 2</label>
                            <br>
                            <img id="frame2" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="80%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photo2" name ='photo2' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview2()">
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo3" class="form-label">Photo 3</label>
                            <br>
                            <img id="frame3" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="80%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photo3" name ='photo3' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview3()">
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo4" class="form-label">Photo 4</label>
                            <br>
                            <img id="frame4" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="80%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photo4" name ='photo4' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview4()">
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo5" class="form-label">Photo 5</label>
                            <br>
                            <img id="frame5" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="80%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photo5" name ='photo5' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview5()">
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo6" class="form-label">Photo 6</label>
                            <br>
                            <img id="frame6" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="80%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photo6" name ='photo6' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview6()">
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo7" class="form-label">Photo 7</label>
                            <br>
                            <img id="frame7" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="80%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photo7" name ='photo7' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview7()">
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo8" class="form-label">Photo 8</label>
                            <br>
                            <img id="frame8" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="80%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photo8" name ='photo8' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview8()">
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo9" class="form-label">Photo 9</label>
                            <br>
                            <img id="frame9" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="80%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photo9" name ='photo9' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview9()">
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo10" class="form-label">Photo 10</label>
                            <br>
                            <img id="frame10" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="80%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photo10" name ='photo10' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview10()">
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo11" class="form-label">Photo 11</label>
                            <br>
                            <img id="frame11" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="80%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photo11" name ='photo11' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview11()">
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo12" class="form-label">Photo 12</label>
                            <br>
                            <img id="frame12" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="80%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photo12" name ='photo12' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview12()">
                        </div>
                        <div class="mb-3 row">
                           <div class="col-12 col-lg-6">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <a type="submit" class="btn btn-primary" href="/admin/about/gallery">Cancel</a>
                           </div>
                            <div class="col-12 col-lg-6 small text-end">
                                <i class="small">Insert Photos gradually (maximum 4 Photos), then update to re-insert.</i>
                            </div>
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
function preview1() {
    frame1.src=URL.createObjectURL(event.target.files[0]);
}
function preview2() {
    frame2.src=URL.createObjectURL(event.target.files[0]);
}
function preview3() {
    frame3.src=URL.createObjectURL(event.target.files[0]);
}
function preview4() {
    frame4.src=URL.createObjectURL(event.target.files[0]);
}
function preview5() {
    frame5.src=URL.createObjectURL(event.target.files[0]);
}
function preview6() {
    frame6.src=URL.createObjectURL(event.target.files[0]);
}
function preview7() {
    frame7.src=URL.createObjectURL(event.target.files[0]);
}
function preview8() {
    frame8.src=URL.createObjectURL(event.target.files[0]);
}
function preview9() {
    frame9.src=URL.createObjectURL(event.target.files[0]);
}
function preview10() {
    frame10.src=URL.createObjectURL(event.target.files[0]);
}
function preview11() {
    frame11.src=URL.createObjectURL(event.target.files[0]);
}
function preview12() {
    frame12.src=URL.createObjectURL(event.target.files[0]);
}
</script>
@endsection
