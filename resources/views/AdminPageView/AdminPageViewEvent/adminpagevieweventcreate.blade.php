@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

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
                    <div class="mb-3">
                        <label for="inputTitleEvent" class="form-label">Title</label>
                        <input type="text" class="form-control" id="inputTitleEvent" name='title' placeholder="Enter the Event Title..." required>
                        <div class="invalid-feedback">
                            Please fill in the title.
                        </div>
                        <div class="valid-feedback">
                            Great Event Title!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputEventOrganizer" class="form-label">Event Organizer</label>
                        <input type="text" class="form-control" id="inputEventOrganizer" name='division' placeholder="This event is hosted by..." required>
                        <div class="invalid-feedback">
                            Please fill in the Event Organizer.
                        </div>
                        <div class="valid-feedback">
                            Cool Event Organizer!
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="inputBroadcast" class="form-label">Broadcast Event</label>
                        <textarea class="form-control summernote" name="broadcast" id="inputBroadcast" required></textarea>
                        <div class="invalid-feedback">
                            Please fill in the Event Organizer.
                        </div>
                        <div class="valid-feedback">
                            Cool Event Organizer!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputLinkEmbedGform" class="form-label">Link Embed GForm</label>
                        <input type="text" class="form-control" id="inputLinkEmbedGform" name='linkembedgform' placeholder="Only insert Embedded GForms Link ending with viewform?embedded=true">
                        <div class="invalid-feedback">
                            Please fill in the Link Embed GForm.
                        </div>
                        <div class="valid-feedback">
                            Good Job!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputDateEvent" class="form-label">Date Event</label>
                        <input type="date" class="form-control" id="inputDateEvent" name='dateevent' placeholder="Enter the event start date..." required>
                        <div class="invalid-feedback">
                            Please fill in the Date Event.
                        </div>
                        <div class="valid-feedback">
                            Nice Date !
                        </div>
                    </div>
                    <div class="mb-3 col-xl-4">
                        <label for="formFile" class="form-label">Poster (1080 x 1350 Pixel)</label>
                        <input class="form-control" type="file" id="poster" name ='poster'accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" required>
                        <div class="invalid-feedback">
                            Please insert a Poster Event here.
                        </div>
                        <div class="valid-feedback">
                            Nice Poster!
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
