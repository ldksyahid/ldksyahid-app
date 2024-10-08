@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Create Event</h5>
                <form role="form" action='/admin/event/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="row">
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputTitleEvent" class="form-label required">Title</label>
                            <input type="text" class="form-control" id="inputTitleEvent" name='title' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="inputEventOrganizer" class="form-label required">Event Organizer</label>
                            <input type="text" class="form-control" id="inputEventOrganizer" name='division' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="inputTag" class="form-label required">Tag</label>
                            <select class="form-select mb-3" aria-label="Default select" required name="tag">
                                <option value="Seminar">Seminar</option>
                                <option value="Pelatihan">Pelatihan</option>
                            </select>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputLocation" class="form-label required">Location</label>
                            <input type="text" class="form-control" id="inputLocation" name='location' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputLinkLocation" class="form-label">Link Location</label>
                            <input type="text" class="form-control" id="inputLinkLocation" name='linkLocation'>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputPlace" class="form-label required">Place</label>
                            <select class="form-select mb-3" aria-label="Default select" required name="place">
                                <option value="Online">Online</option>
                                <option value="Offline">Offline</option>
                                <option value="Hybrid">Hybrid</option>
                            </select>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="inputBroadcast" class="form-label required">Broadcast Event</label>
                            <textarea class="form-control summernote" name="broadcast" id="inputBroadcast" required></textarea>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="inputLinkRegistration" class="form-label required">Link Registration</label>
                            <input type="text" class="form-control" id="inputLinkRegistration" name='linkRegist' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="inputStart" class="form-label required">Start Event</label>
                            <input type="datetime-local" class="form-control" id="inputStart" name='start' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="inputStart" class="form-label required">Event Finished</label>
                            <input type="datetime-local" class="form-control" id="inputFinish" name='finished' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="inputCloseRegist" class="form-label required">Close Registration</label>
                            <input type="datetime-local" class="form-control" id="inputCloseRegist" name='closeRegist' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="formFile" class="form-label required">Poster <span class="small">(1080 x 1350 Pixel)</span></label>
                            <br>
                            <img id="frame" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="150px" height="200px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="poster" name ='poster'accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" required onchange="preview()">
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-4 col-12 col-lg-3">
                            <label for="inputLinkDoc" class="form-label">Link Documentation</label>
                            <input type="text" class="form-control" id="inputLinkDoc" name='linkDoc'>
                        </div>
                        <div class="mb-4 col-12 col-lg-3">
                            <label for="inputLinkPresent" class="form-label">Link Presentation</label>
                            <input type="text" class="form-control" id="inputLinkPresent" name='linkPresent'>
                        </div>
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="inputContactPerson1" class="form-label required">Contact Person 1</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputContactPerson1">+62</span>
                                <input type="text" class="form-control" id="inputContactPerson1" name='cntctPrsn1' required aria-describedby="inputContactPerson1">
                            </div>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="inputNameCntctPrsn1" class="form-label required">Name Contact Person 1</label>
                            <input type="text" class="form-control" id="inputNameCntctPrsn1" name='nameCntctPrsn1' required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="inputContactPerson2" class="form-label">Contact Person 2</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputContactPerson2">+62</span>
                                <input type="text" class="form-control" id="inputContactPerson2" name='cntctPrsn2' required aria-describedby="inputContactPerson2">
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="inputNameCntctPrsn2" class="form-label">Name Contact Person 2</label>
                            <input type="text" class="form-control" id="inputNameCntctPrsn2" name='nameCntctPrsn2'>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a type="submit" class="btn btn-primary" href="/admin/event">Cancel</a>
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
