@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Edit Schedule {{ $postschedule->title }} LDK Syahid</h5>
                <form role="form" action='/admin/schedule/{{ $postschedule->id }}/update' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                    <div class="mb-3">
                        <label for="inputTitleSchedule" class="form-label">Title</label>
                        <input type="text" class="form-control" id="inputTitleSchedule" name='title' placeholder="Enter the Schedule Title..." value="{{old('title', $postschedule->title)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the title.
                        </div>
                        <div class="valid-feedback">
                            Great Schedule Title!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputMonth" class="form-label">Month</label>
                        <input type="text" class="form-control" id="inputMonth" name='month' placeholder="Fill Must like Ex. September" value="{{old('month', $postschedule->month)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Month.
                        </div>
                        <div class="valid-feedback">
                            Cool Month!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputYear" class="form-label">Year</label>
                        <input type="text" class="form-control" id="inputYear" name='year' placeholder="Fill Must like Ex. 2022" value="{{old('year', $postschedule->year)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Year.
                        </div>
                        <div class="valid-feedback">
                            Cool Year!
                        </div>
                    </div>
                    <div class="mb-3 col-xl-4">
                        <label for="formFile" class="form-label">Picture (1080 x 1350 Pixel)</label>
                        <input class="form-control" type="file" id="picture" name = 'picture' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG">
                        <div class="invalid-feedback">
                            Please insert a Picture Schedule here.
                        </div>
                        <div class="valid-feedback">
                            Nice Picture!
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Change</button>
                    <a type="submit" class="btn btn-primary" href="/admin/schedule">Cancel</a>
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
@endsection
