@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Create Structure {{ $poststructure->structureName }} LDK Syahid {{ $poststructure->batch }}</h5>
                <form role="form" action='/admin/about/structure/{{ $poststructure->id }}/update' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                    <div class="mb-3">
                        <label for="inputBatch" class="form-label">Batch</label>
                        <input type="text" class="form-control" id="inputBatch" name='batch' placeholder="Ex. 26" value="{{old('bacth', $poststructure->batch)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Batch.
                        </div>
                        <div class="valid-feedback">
                            Good!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputPeriod" class="form-label">Period</label>
                        <input type="text" class="form-control" id="inputPeriod" name='period' placeholder="Ex. 2021/2022" value="{{old('period', $poststructure->period)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Period.
                        </div>
                        <div class="valid-feedback">
                            Cool!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputStructureName" class="form-label">Structure Name</label>
                        <input type="text" class="form-control" id="inputStructureName" name='structureName' placeholder="Ex. Pendar Cakrawala" value="{{old('structureName', $poststructure->structureName)}}" required>
                        <div class="invalid-feedback">
                            Please fill in the Structure Name.
                        </div>
                        <div class="valid-feedback">
                            Cool!
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="inputStructureDescription" class="form-label">Structure Description</label>
                        <textarea class="form-control" name="structureDescription" id="inputStructureDescription" required>{{ $poststructure->structureDescription }}</textarea>
                        <div class="invalid-feedback">
                            Please fill in the Structure Description.
                        </div>
                        <div class="valid-feedback">
                            Good!
                        </div>
                    </div>
                    <div class="mb-3 col-xl-4">
                        <label for="formFile" class="form-label">Structure Logo (No Background 1080 x 1080)</label>
                        <input class="form-control" type="file" id="structureLogo" name = 'structureLogo' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG">
                        <div class="invalid-feedback">
                            Please insert a Structure Logo here.
                        </div>
                        <div class="valid-feedback">
                            Nice Structure Logo!
                        </div>
                    </div>
                    <div class="mb-3 col-xl-4">
                        <label for="formFile" class="form-label">Structure Image (1515 x >=2560)</label>
                        <input class="form-control" type="file" id="structureImage" name = 'structureImage' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG">
                        <div class="invalid-feedback">
                            Please insert a Structure Logo here.
                        </div>
                        <div class="valid-feedback">
                            Nice Structure Logo!
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Change</button>
                    <a type="submit" class="btn btn-primary" href="/admin/about/structure">Cancel</a>
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
