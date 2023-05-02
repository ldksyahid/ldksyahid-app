@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Edit {{ $postevent->title }} Event LDK Syahid</h5>
                <form role="form" action='/admin/event/{{ $postevent->id }}/update' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                    <div class="row">
                        <div class="mb-3 col col-6">
                            <label for="inputTitleEvent" class="form-label">Title</label>
                            <input type="text" class="form-control" id="inputTitleEvent" name='title' placeholder="Enter the Event Title..." value="{{old('title', $postevent->title)}}" required>
                            <div class="invalid-feedback">
                                Please fill in the title.
                            </div>
                            <div class="valid-feedback">
                                Great Event Title!
                            </div>
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputEventOrganizer" class="form-label">Event Organizer</label>
                            <input type="text" class="form-control" id="inputEventOrganizer" name='division' placeholder="This event is hosted by..." value="{{old('division', $postevent->division)}}" required>
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
                                <option selected hidden value="{{old('tag', $postevent->tag)}}">{{ $postevent->tag }}</option>
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
                            <input type="text" class="form-control" id="inputLocation" name='location' value="{{old('location', $postevent->location)}}" required placeholder="Enter the Location...">
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-4">
                            <label for="inputLinkLocation" class="form-label">Link Location</label>
                            <input type="text" class="form-control" id="inputLinkLocation" name='linkLocation' value="{{old('linkLocation', $postevent->linkLocation)}}" placeholder="https://...">
                        </div>
                        <div class="mb-3 col col-lg-4">
                            <label for="inputPlace" class="form-label">Place</label>
                            <select class="form-select mb-3" aria-label="Default select" required name="place">
                                <option selected hidden value="{{old('place', $postevent->place)}}">{{ $postevent->place }}</option>
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
                            <textarea class="form-control summernote" name="broadcast" id="inputBroadcast" required>{{ $postevent->broadcast }}</textarea>
                            <div class="invalid-feedback">
                                Please fill in the Event Organizer.
                            </div>
                            <div class="valid-feedback">
                                Cool Event Organizer!
                            </div>
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputLinkRegistration" class="form-label">Link Registration</label>
                            <input type="text" class="form-control" id="inputLinkRegistration" name='linkRegist' placeholder="Enter Link Registration..." value="{{old('linkRegist', $postevent->linkRegist)}}">
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputStart" class="form-label">Start Event</label>
                            <input type="datetime-local" class="form-control" id="inputStart" name='start' placeholder="Enter the event start..." required value="{{old('start', $postevent->start)}}">
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputStart" class="form-label">Event Finished</label>
                            <input type="datetime-local" class="form-control" id="inputFinish" name='finished' placeholder="Enter the event finished..." value="{{old('finished', $postevent->finished)}}" required>
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputCloseRegist" class="form-label">Close Registration</label>
                            <input type="datetime-local" class="form-control" id="inputCloseRegist" name='closeRegist' placeholder="Enter the Close Regist Date..." required value="{{old('closeRegist', $postevent->closeRegist)}}">
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-4">
                            <label for="formFile" class="form-label">Poster (1080 x 1350 Pixel)</label>
                            <input class="form-control" type="file" id="poster" name ='poster'accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG">
                        </div>
                        <div class="mb-3 col col-4">
                            <label for="inputLinkDoc" class="form-label">Link Documentation</label>
                            <input type="text" class="form-control" id="inputLinkDoc" name='linkDoc' placeholder="https://..." value="{{old('linkDoc', $postevent->linkDoc)}}">
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-4">
                            <label for="inputLinkPresent" class="form-label">Link Presentation</label>
                            <input type="text" class="form-control" id="inputLinkPresent" name='linkPresent' placeholder="https://..." value="{{old('linkPresent', $postevent->linkPresent)}}">
                            <div class="invalid-feedback">
                                This question is mandatory!
                            </div>
                            <div class="valid-feedback">
                                Great!
                            </div>
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputContactPerson1" class="form-label">Contact Person 1</label>
                            <input type="text" class="form-control" id="inputContactPerson1" name='cntctPrsn1' placeholder="+62..." value="{{old('cntctPrsn1', $postevent->cntctPrsn1)}}">
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputNameCntctPrsn1" class="form-label">Name Contact Person 1</label>
                            <input type="text" class="form-control" id="inputNameCntctPrsn1" name='nameCntctPrsn1' placeholder="Enter Name..." value="{{old('nameCntctPrsn1', $postevent->nameCntctPrsn1)}}">
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputContactPerson2" class="form-label">Contact Person 2</label>
                            <input type="text" class="form-control" id="inputContactPerson2" name='cntctPrsn2' placeholder="+62..." value="{{old('cntctPrsn2', $postevent->cntctPrsn2)}}">
                        </div>
                        <div class="mb-3 col col-3">
                            <label for="inputNameCntctPrsn2" class="form-label">Name Contact Person 2</label>
                            <input type="text" class="form-control" id="inputNameCntctPrsn2" name='nameCntctPrsn2' placeholder="Enter Name..." value="{{old('nameCntctPrsn2', $postevent->nameCntctPrsn2)}}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Change</button>
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
