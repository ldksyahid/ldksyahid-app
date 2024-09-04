@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Preview IT Support</h5>
                <form role="form" action='#' method='post' enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputName" class="form-label required">Name</label>
                            <input type="text" class="form-control" id="inputName" name='name' value="{{old('name', $postitsupport->name)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputForkat" class="form-label required">Forkat</label>
                            <input type="text" class="form-control" id="inputForkat" name='forkat' value="{{old('forkat', $postitsupport->forkat)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputPosition" class="form-label required">Position</label>
                            <input type="text" class="form-control" id="inputPosition" name='position' value="{{old('position', $postitsupport->position)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photoProfile" class="form-label required">Photo Profile <span class="small">(300 x 350 Pixel)</span></label>
                            <br>
                            <img id="frame" src="https://lh3.googleusercontent.com/d/{{ $postitsupport->gdrive_id }}" width="200px" height="250px"  class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="photoProfile" name = 'photoProfile' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG, image/webp" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputLinkInstagram" class="form-label required">Instagram Link</label>
                            <input type="text" class="form-control" id="inputLinkInstagram" name='linkInstagram' value="{{old('linkInstagram', $postitsupport->linkInstagram)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputLinkInstagram" class="form-label required">Linkedin Link</label>
                            <input type="text" class="form-control" id="inputLinkInstagram" name='linkLinkedin' value="{{old('linkLinkedin', $postitsupport->linkLinkedin)}}" disabled>
                        </div>
                        <div class="mb-3 col-12">
                            <a class="btn btn-primary" href="/admin/about/itsupport"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
@endsection
