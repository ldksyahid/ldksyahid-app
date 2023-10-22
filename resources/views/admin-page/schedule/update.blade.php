@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Edit Schedule</h5>
                <form role="form" action='/admin/schedule/{{ $postschedule->id }}/update' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="formFile" class="form-label required">Picture <span class="small">(1080 x 1350 Pixel)</span></label>
                            <br>
                            <img id="frame" src="{{ asset($postschedule->picture) }}" width="150px" height="200px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="picture" name = 'picture' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview()">
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputTitleSchedule" class="form-label required">Title</label>
                            <input type="text" class="form-control" id="inputTitleSchedule" name='title' value="{{old('title', $postschedule->title)}}" required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputMonth" class="form-label required">Month</label>
                            <input type="text" class="form-control" id="inputMonth" name='month' value="{{old('month', $postschedule->month)}}" required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputYear" class="form-label required">Year</label>
                            <input type="text" class="form-control" id="inputYear" name='year' value="{{old('year', $postschedule->year)}}" required>
                            <div class="invalid-feedback">
                                This is a required question
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a type="submit" class="btn btn-primary" href="/admin/schedule">Cancel</a>
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
</script>
@endsection
