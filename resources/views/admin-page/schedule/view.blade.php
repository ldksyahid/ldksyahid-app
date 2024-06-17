@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Preview Schedule</h5>
                <form role="form" action='#' method='post' enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="formFile" class="form-label required">Picture <span class="small">(1080 x 1350 Pixel)</span></label>
                            <br>
                            <img id="frame" src="https://lh3.google.com/u/0/d/{{ $postschedule->gdrive_id }}" width="150px" height="200px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="picture" name = 'picture' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputTitleSchedule" class="form-label required">Title</label>
                            <input type="text" class="form-control" id="inputTitleSchedule" name='title' value="{{old('title', $postschedule->title)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputMonth" class="form-label required">Month</label>
                            <input type="text" class="form-control" id="inputMonth" name='month' value="{{old('month', $postschedule->month)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputYear" class="form-label required">Year</label>
                            <input type="text" class="form-control" id="inputYear" name='year' value="{{old('year', $postschedule->year)}}" disabled>
                        </div>
                        <div class="mb-3">
                            <a class="btn btn-primary" href="/admin/schedule"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
@endsection
