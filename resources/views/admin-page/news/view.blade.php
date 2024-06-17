@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Preview News</h5>
                <form role="form" action='#' method='post' enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputDatePublish" class="form-label required">Date Publish</label>
                            <input type="date" class="form-control" id="inputDatePublish" name='datepublish' value="{{old('datepublish', $postnews->datepublish)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputPublisher" class="form-label required">Publisher</label>
                            <input type="text" class="form-control" id="inputPublisher" name='publisher' value="{{old('publisher', $postnews->publisher)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputTitle" class="form-label required">Title</label>
                            <input type="text" class="form-control" id="inputTitle" name='title' value="{{old('title', $postnews->title)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputReporter" class="form-label required">Reporter</label>
                            <input type="text" class="form-control" id="inputReporter" name='reporter' value="{{old('reporter', $postnews->reporter)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputEditor" class="form-label required">Editor</label>
                            <input type="text" class="form-control" id="inputEditor" name='editor' value="{{old('editor', $postnews->editor)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="picture" class="form-label required">Picture <span class="small">(1366 x 768 Pixel)</span></label>
                            <br>
                            <img id="frame" src="https://lh3.google.com/u/0/d/{{ $postnews->gdrive_id }}" width="250px" height="150px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="picture" name = 'picture' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG, image/webp" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputDescPicture" class="form-label required">Picture Description</label>
                            <input type="text" class="form-control" id="inputDescPicture" name='descpicture' value="{{old('descpicture', $postnews->descpicture)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-12">
                            <label for="inputBody" class="form-label required">Content News</label>
                            <div class="border p-5 rounded">
                                {!! $postnews->body !!}
                            </div>
                        </div>
                        <div class="mb-3">
                            <a class="btn btn-primary" href="/admin/news"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
@endsection
