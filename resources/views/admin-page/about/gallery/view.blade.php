@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Preview Gallery</h5>
                <form role="form" action='#' method='post' enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputEventName" class="form-label required">Event Name</label>
                            <input type="text" class="form-control" id="inputEventName" name='eventName' value="{{old('eventName', $postgallery->eventName)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputEventTheme" class="form-label required">Event Theme</label>
                            <input type="text" class="form-control" id="inputEventTheme" name='eventTheme' value="{{old('eventTheme', $postgallery->eventTheme)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputEventDescription" class="form-label required">Event Description</label>
                            <textarea class="form-control" name="eventDescription" id="inputEventDescription" disabled>{{$postgallery->eventDescription}}</textarea>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputLinkEmbedYoutube" class="form-label">Embed Youtube Link</label>
                            <input type="text" class="form-control" id="inputLinkEmbedYoutube" name='linkEmbedYoutube' value="{{old('linkEmbedYoutube', $postgallery->linkEmbedYoutube)}}" disabled>
                        </div>
                        <div class="mb-5 col-12 col-lg-4">
                            <label for="inputLinkDocinputLinkDoc" class="form-label">Documentation Link</label>
                            <input type="text" class="form-control" id="inputLinkDoc" name='linkDoc' value="{{old('linkDoc', $postgallery->linkDoc)}}" disabled>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="groupPhoto" class="form-label required">Group Photo</label>
                            <br>
                            <div class="text-center">
                                @if ($postgallery->gdrive_id == !null)
                                <img id="frame" src="https://lh3.googleusercontent.com/d/{{ $postgallery->gdrive_id }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="groupPhoto" name = 'groupPhoto' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        @for($i = 1; $i <= 12; $i++)
                            <div class="mb-3 col-12 col-lg-4">
                                <label for="photo{{ $i }}" class="form-label">Photo {{ $i }}</label>
                                <br>
                                <div>
                                    @if ($postgallery->{'gdrive_id_'.$i} != null)
                                    <img id="frame{{ $i }}" src="https://lh3.googleusercontent.com/d/{{ $postgallery->{'gdrive_id_'.$i} }}" width="50%" class="rounded mb-3 border"/>
                                    @else
                                    <img id="frame{{ $i }}" src="https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm" width="50%" class="rounded mb-3 border"/>
                                    @endif
                                </div>
                                <input class="form-control" type="file" id="photo{{ $i }}" name ='photo{{ $i }}' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                            </div>
                        @endfor
                        <div class="mb-3 row">
                            <div class="col-12 col-lg-6">
                                <a class="btn btn-primary" href="/admin/about/gallery"><i class="fa fa-arrow-left"></i> Back</a>
                            </div>
                            <div class="col-12 col-lg-6 small text-end">
                                 <i class="small">Insert Photos gradually (maximum 4 Photos), then update to re-insert.</i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
@endsection