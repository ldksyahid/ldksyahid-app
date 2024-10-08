@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Preview Testimony</h5>
                <form role="form" action='#' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputName1" class="form-label required">Name</label>
                            <input type="text" class="form-control" id="inputName1" name='name' value="{{old('name', $posttestimony->name)}}" required disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputProfession1" class="form-label required">Profession</label>
                            <input type="text" class="form-control" id="inputProfession" name='profession' value="{{old('profession', $posttestimony->profession)}}" required disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="inputTestimony" class="form-label required">Testimony <span class="small">(Max 250 Letters)</span></label>
                            <textarea class="form-control" name="testimony" id="inputTestimony" maxlength="250" required disabled>{{ $posttestimony->testimony }}</textarea>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="formFile" class="form-label required">Photo Profile <span class="small">(100 x 100 Pixel)</span></label>
                            <br>
                            <img id="frame" src="https://lh3.googleusercontent.com/d/{{ $posttestimony->gdrive_id }}" width="150px" height="150px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="picture" name ='picture' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG"  required disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-12">
                            <a type="submit" class="btn btn-primary" href="/admin/testimony"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
@endsection
