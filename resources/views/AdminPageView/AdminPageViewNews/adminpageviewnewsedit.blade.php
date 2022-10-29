@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Edit {{ $postnews->title }} News LDK Syahid</h5>
                <form role="form" action='/admin/news/{{ $postnews->id }}/update' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                    <div class="mb-3">
                        <label for="inputDatePublish" class="form-label">Date Publish</label>
                        <input type="date" class="form-control" id="inputDatePublish" name='datepublish' value="{{old('datepublish', $postnews->datepublish)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Date Publish.
                        </div>
                        <div class="valid-feedback">
                            Great Date!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputPublisher" class="form-label">Publisher</label>
                        <input type="text" class="form-control" id="inputPublisher" name='publisher' placeholder="Fill the Publisher Ex. LDK Syahid UIN Jakarta" value="{{old('publisher', $postnews->publisher)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Publisher.
                        </div>
                        <div class="valid-feedback">
                            Cool Publisher!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="inputTitle" name='title' placeholder="Fill the Title..." value="{{old('title', $postnews->title)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Title.
                        </div>
                        <div class="valid-feedback">
                            Awesome Title!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputReporter" class="form-label">Reporter</label>
                        <input type="text" class="form-control" id="inputReporter" name='reporter' placeholder="Fill the Name of Reporter..." value="{{old('reporter', $postnews->reporter)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Reporter.
                        </div>
                        <div class="valid-feedback">
                            Cheerful Reporter!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputEditor" class="form-label">Editor</label>
                        <input type="text" class="form-control" id="inputEditor" name='editor' placeholder="Fill the Name of Editor..." value="{{old('editor', $postnews->editor)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Editor.
                        </div>
                        <div class="valid-feedback">
                            Cheerful Editor!
                        </div>
                    </div>
                    <div class="mb-3 col-xl-4">
                        <label for="picture" class="form-label">Picture (1366 x 768 Pixel)</label>
                        <input class="form-control" type="file" id="picture" name = 'picture' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG, image/webp" src="{{ asset($postnews->picture) }}">
                        <div class="invalid-feedback">
                            Please insert a Picture News here.
                        </div>
                        <div class="valid-feedback">
                            Nice Picture!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputDescPicture" class="form-label">Picture Description</label>
                        <input type="text" class="form-control" id="inputDescPicture" name='descpicture' placeholder="Fill the Picture Description..." value="{{old('descpicture', $postnews->descpicture)}}" required>
                        <div class="invalid-feedback">
                            Please fill Picture Description.
                        </div>
                        <div class="valid-feedback">
                            Cool Picture Description!
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="inputBody" class="form-label">Content News</label>
                        <textarea class="form-control summernote" name="body" id="inputBody" required>{{ $postnews->body }}</textarea>
                        <div class="invalid-feedback">
                            Please fill in the Content News.
                        </div>
                        <div class="valid-feedback">
                            Awesome Content News!
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Change</button>
                    <a type="submit" class="btn btn-primary" href="/admin/news">Cancel</a>
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
              height: 800,
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
