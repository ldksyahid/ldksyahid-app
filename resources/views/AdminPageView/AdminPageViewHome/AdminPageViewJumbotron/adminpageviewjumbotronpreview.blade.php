@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h5 class="mb-4">Preview</h5>
                    <div class="text-center">
                        <img style="width: 650px;" src="{{asset('Images/uploads/jumbotrons')}}/{{$postjumbotron->picture}}" alt="{{$postjumbotron->title}}" class="card-img-top mb-3 rounded shadow"/>
                        <h5 class="mb-1">"{{$postjumbotron->title}}" Jumbotron</h5>
                        <h6>{{ $postjumbotron->subtitle }}</h6>
                        <p class="mb-0">{{$postjumbotron->sentence}}</p>
                    </div>
                    <hr>
                    <div class="text-start">
                        <h6>Link : </h6><a href="{{ $postjumbotron->btnlink }}" target="_blank" class="">{{ $postjumbotron->btnlink }}</a>
                        <h6 class="mt-5">Button Name : </h6><a type="submit" class="btn btn-primary" href="{{ $postjumbotron->btnlink }}" target="_blank">{{$postjumbotron->btnname}}</a>
                        <h6 class="mt-5">Alignment Item : </h6><p>{{ $postjumbotron->textalign }}</p>
                        <h6 class="mt-5">Image Name : </h6><p>{{ $postjumbotron->picture }}</p>
                    </div>
                    <div class="text-end">
                        <a type="submit" class="btn btn-primary" href="/admin/jumbotron">Done</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
@endsection
