@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Preview Jumbotron</h5>
                <form role="form" action='#' method='post' enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <label for="formFile" class="form-label required">Picture <span class="small">(1440 x 560 Pixel)</span></label>
                            <br>
                            <img id="frame" src="https://drive.google.com/thumbnail?id={{ $postjumbotron->gdrive_id }}" width="250px" height="150px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="picture" name ='picture' title="Choose a video please" accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="my-3 col-12 col-lg-12">
                            <label class="form-check-label" for="cekBtn">Add Button ?</label>
                            @if ($postjumbotron->btnname != null || $postjumbotron->btnlink != null)
                                <input type="checkbox" class="form-check-input" id="cekButton" onclick="cekBtn()" checked disabled>
                            @else
                                <input type="checkbox" class="form-check-input" id="cekButton" onclick="cekBtn()" disabled>
                            @endif
                        </div>
                        <div id="formButton" @if ($postjumbotron->btnname != null || $postjumbotron->btnlink != null)
                            style="display: ;"
                        @else
                            style="display: none;"
                        @endif>
                            <div class="row">
                                <div class="mb-3 col-12 col-lg-6">
                                    <label for="inputButtonName1" class="form-label">Button Name</label>
                                    <input type="text" class="form-control" id="inputButtonName1" name='buttonname' value="{{old('buttonname', $postjumbotron->btnname)}}" disabled>
                                </div>
                                <div class="mb-3 col-12 col-lg-6">
                                    <label for="inputButtonLink1" class="form-label">Button Link</label>
                                    <input type="text" class="form-control" id="inputButtonLink1" name='buttonlink' value="{{old('buttonlink', $postjumbotron->btnlink)}}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a type="submit" class="btn btn-primary" href="/admin/jumbotron"><i class="fa fa-arrow-left"></i> Back</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
@endsection
