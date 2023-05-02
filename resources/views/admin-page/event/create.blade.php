@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Create Event LDK Syahid</h5>
                <form role="form" action='/admin/event/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="row">
                        <div class="mb-3 col col-6">
                            <label for="inputTitleEvent" class="form-label">Title</label>
                            <input type="text" class="form-control" id="inputTitleEvent" name='title' placeholder="Enter the Event Title..." required>
                            <div class="invalid-feedback">
                                Please fill in the title.
                            </div>
                            <div class="valid-feedback">
                                Great Event Title!
                            </div>
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputEventOrganizer" class="form-label">Event Organizer</label>
                            <input type="text" class="form-control" id="inputEventOrganizer" name='division' placeholder="This event is hosted by..." required>
                            <div class="invalid-feedback">
                                Please fill in the Event Organizer.
                            </div>
                            <div class="valid-feedback">
                                Cool Event Organizer!
                            </div>
                        </div>
                        <div class="mb-3 col col-lg-3">
                            <label for="inputTag" class="form-label">Tag</label>
                            <select class="form-select mb-3" aria-label="Default select" required name="tag">
                                <option disabled selected hidden>-- Choose Tag --</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Pelatihan">Pelatihan</option>
                            </select>
                            <div class="invalid-feedback">
                                Please fill in the Tag.
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-4">
                            <label for="inputLocation" class="form-label">Location</label>
                            <input type="text" class="form-control" id="inputLocation" name='location' required placeholder="Enter the Location...">
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-4">
                            <label for="inputLinkLocation" class="form-label">Link Location</label>
                            <input type="text" class="form-control" id="inputLinkLocation" name='linkLocation' placeholder="https://...">
                        </div>
                        <div class="mb-3 col col-lg-4">
                            <label for="inputPlace" class="form-label">Place</label>
                            <select class="form-select mb-3" aria-label="Default select" required name="place">
                                <option disabled selected hidden>-- Choose Place --</option>
                                <option value="Online">Online</option>
                                <option value="Offline">Offline</option>
                                <option value="Hybrid">Hybrid</option>
                            </select>
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-12">
                            <label for="inputBroadcast" class="form-label">Broadcast Event</label>
                            <textarea class="form-control summernote" name="broadcast" id="inputBroadcast" required></textarea>
                            <div class="invalid-feedback">
                                Please fill in the Event Organizer.
                            </div>
                            <div class="valid-feedback">
                                Cool Event Organizer!
                            </div>
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputLinkRegistration" class="form-label">Link Registration</label>
                            <input type="text" class="form-control" id="inputLinkRegistration" name='linkRegist' placeholder="Enter Link Registration...">
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputStart" class="form-label">Start Event</label>
                            <input type="datetime-local" class="form-control" id="inputStart" name='start' placeholder="Enter the event start..." required>
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputStart" class="form-label">Event Finished</label>
                            <input type="datetime-local" class="form-control" id="inputFinish" name='finished' placeholder="Enter the event finished..." required>
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputCloseRegist" class="form-label">Close Registration</label>
                            <input type="datetime-local" class="form-control" id="inputCloseRegist" name='closeRegist' placeholder="Enter the Close Regist Date..." required>
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-4">
                            <label for="formFile" class="form-label">Poster (1080 x 1350 Pixel)</label>
                            <input class="form-control" type="file" id="poster" name ='poster'accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" required>
                            <div class="invalid-feedback">
                                Please insert a Poster Event here.
                            </div>
                            <div class="valid-feedback">
                                Nice Poster!
                            </div>
                        </div>
                        <div class="mb-4 col col-4">
                            <label for="inputLinkDoc" class="form-label">Link Documentation</label>
                            <input type="text" class="form-control" id="inputLinkDoc" name='linkDoc' placeholder="https://...">
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-4 col col-4">
                            <label for="inputLinkPresent" class="form-label">Link Presentation</label>
                            <input type="text" class="form-control" id="inputLinkPresent" name='linkPresent' placeholder="https://...">
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputContactPerson1" class="form-label">Contact Person 1</label>
                            <input type="text" class="form-control" id="inputContactPerson1" name='cntctPrsn1' placeholder="+62...">
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputNameCntctPrsn1" class="form-label">Name Contact Person 1</label>
                            <input type="text" class="form-control" id="inputNameCntctPrsn1" name='nameCntctPrsn1' placeholder="Enter Name...">
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputContactPerson2" class="form-label">Contact Person 2</label>
                            <input type="text" class="form-control" id="inputContactPerson2" name='cntctPrsn2' placeholder="+62...">
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputNameCntctPrsn2" class="form-label">Name Contact Person 2</label>
                            <input type="text" class="form-control" id="inputNameCntctPrsn2" name='nameCntctPrsn2' placeholder="Enter Name...">
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
@endsection
