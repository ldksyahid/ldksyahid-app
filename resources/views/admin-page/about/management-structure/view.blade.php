@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Preview Structure</h5>
                <form role="form" action='#' method='post' enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col-4">
                            <label for="inputBatch required" class="form-label">Batch</label>
                            <input type="text" class="form-control" id="inputBatch" name='batch' value="{{old('bacth', $poststructure->batch)}}" disabled>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="inputPeriod" class="form-label required">Period</label>
                            <input type="text" class="form-control" id="inputPeriod" name='period' value="{{old('period', $poststructure->period)}}" disabled>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="inputStructureName" class="form-label required">Structure Name</label>
                            <input type="text" class="form-control" id="inputStructureName" name='structureName' value="{{old('structureName', $poststructure->structureName)}}" disabled>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="inputStructureDescription" class="form-label required">Structure Description</label>
                            <textarea class="form-control" name="structureDescription" id="inputStructureDescription" disabled>{{ $poststructure->structureDescription }}</textarea>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="formFile" class="form-label required">Structure Logo (No Background 1080 x 1080)</label>
                            <br>
                            <img id="frame" src="{{ asset($poststructure->structureLogo) }}" width="300px" height="300px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="structureLogo" name = 'structureLogo' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-6">
                            <label for="formFile" class="form-label required">Structure Image (1515 x >=2560)</label>
                            <br>
                            <img id="frame2" src="{{ asset($poststructure->structureImage) }}" width="27.5%" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="structureImage" name = 'structureImage' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3">
                            <a class="btn btn-primary" href="/admin/about/structure"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
@endsection
