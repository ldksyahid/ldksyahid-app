@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Edit "{{$postjumbotron->title}}" Jumbotron</h5>
                <form role="form" action='/admin/jumbotron/{{$postjumbotron->id}}/update' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                    <div class="mb-3">
                        <label for="inputTitle1" class="form-label">Title</label>
                        <input type="text" class="form-control" id="inputTitle1" name='title' placeholder="Enter the Title..." value="{{old('title', $postjumbotron->title)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the title.
                        </div>
                        <div class="valid-feedback">
                            Great Title!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputSubtitle1" class="form-label">Subtitle</label>
                        <input type="text" class="form-control" id="inputSubtitle1" name='subtitle' placeholder="Enter the Subtitle..."  value="{{old('subtitle', $postjumbotron->subtitle)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the subtitle.
                        </div>
                        <div class="valid-feedback">
                            Great Subtitle!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputSentence1" class="form-label">Sentence</label>
                        <input type="text" class="form-control" id="inputSentence1" name='sentence' placeholder="Fill the Sentence for Thumbnail..." value="{{old('sentence', $postjumbotron->sentence)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Sentence.
                        </div>
                        <div class="valid-feedback">
                            Interesting Sentence!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputButtonName1" class="form-label">Button Name</label>
                        <input type="text" class="form-control" id="inputButtonName1" name='buttonname' placeholder="Enter the Button Name like 'More', 'Go', 'Contact Us' etc OR ignore it if you don't want to fill it..." value="{{old('buttonname', $postjumbotron->btnname)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the button name.
                        </div>
                        <div class="valid-feedback">
                            Interesting Button Name!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputButtonLink1" class="form-label">Button Link</label>
                        <input type="text" class="form-control" id="inputButtonLink1" name='buttonlink' placeholder="Enter the Button Link like 'https://www.instagram.com/ldksyahid/' etc OR ignore it if you don't want to fill it..." value="{{old('buttonlink', $postjumbotron->btnlink)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the button link to go to the link page.
                        </div>
                        <div class="valid-feedback">
                            Good Link!
                        </div>
                    </div>
                    <div class="mb-3 col-xl-4">
                        <label for="formFile" class="form-label">Picture (1366 x 768 Pixel)</label>
                        <input class="form-control" type="file" id="picture" name ='picture' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG">
                        <div class="invalid-feedback">
                            Please insert a picture here.
                        </div>
                        <div class="valid-feedback">
                            Nice Picture!
                        </div>
                    </div>
                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0">Alignment Item</legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="textalign" id="left" value="start" required>
                                <label class="form-check-label" for="left">
                                    Left
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="textalign" id="center" value="center" required>
                                <label class="form-check-label" for="center">
                                    Center
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="textalign" id="right" value="end" required>
                                <label class="form-check-label" for="right">
                                    Right
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <button type="submit" class="btn btn-primary">Save Change</button>
                    <a type="submit" class="btn btn-primary" href="/admin/jumbotron">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
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
@endsection
