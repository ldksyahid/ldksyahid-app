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
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputEventDescription" class="form-label required">Event Description</label>
                            <textarea class="form-control" name="eventDescription" id="inputEventDescription" disabled>{{$postgallery->eventDescription}}</textarea>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputLinkEmbedYoutube" class="form-label">Embed Youtube Link</label>
                            <input type="text" class="form-control" id="inputLinkEmbedYoutube" name='linkEmbedYoutube' value="{{old('linkEmbedYoutube', $postgallery->linkEmbedYoutube)}}" disabled>
                        </div>
                        <div class="mb-3 col-12">
                            <label for="groupPhoto" class="form-label required">Group Photo</label>
                            <br>
                            <div class="text-center">
                                @if ($postgallery->groupPhoto == !null)
                                <img id="frame" src="{{ asset($postgallery->groupPhoto) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="groupPhoto" name = 'groupPhoto' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo1" class="form-label">Photo 1</label>
                            <br>
                            <div>
                                @if ($postgallery->photo1 == !null)
                                <img id="frame1" src="{{ asset($postgallery->photo1) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame1" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="photo1" name ='photo1' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo2" class="form-label">Photo 2</label>
                            <br>
                            <div>
                                @if ($postgallery->photo2 == !null)
                                <img id="frame2" src="{{ asset($postgallery->photo2) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame2" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="photo2" name ='photo2' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo3" class="form-label">Photo 3</label>
                            <br>
                            <div>
                                @if ($postgallery->photo3 == !null)
                                <img id="frame3" src="{{ asset($postgallery->photo3) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame3" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="photo3" name ='photo3' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo4" class="form-label">Photo 4</label>
                            <br>
                            <div>
                                @if ($postgallery->photo4 == !null)
                                <img id="frame4" src="{{ asset($postgallery->photo4) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame4" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="photo4" name ='photo4' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo5" class="form-label">Photo 5</label>
                            <br>
                            <div>
                                @if ($postgallery->photo5 == !null)
                                <img id="frame5" src="{{ asset($postgallery->photo5) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame5" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="photo5" name ='photo5' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo6" class="form-label">Photo 6</label>
                            <br>
                            <div>
                                @if ($postgallery->photo6 == !null)
                                <img id="frame6" src="{{ asset($postgallery->photo6) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame6" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="photo6" name ='photo6' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo7" class="form-label">Photo 7</label>
                            <br>
                            <div>
                                @if ($postgallery->photo7 == !null)
                                <img id="frame7" src="{{ asset($postgallery->photo7) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame7" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="photo7" name ='photo7' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo8" class="form-label">Photo 8</label>
                            <br>
                            <div>
                                @if ($postgallery->photo8 == !null)
                                <img id="frame8" src="{{ asset($postgallery->photo8) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame8" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="photo8" name ='photo8' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo9" class="form-label">Photo 9</label>
                            <br>
                            <div>
                                @if ($postgallery->photo9 == !null)
                                <img id="frame9" src="{{ asset($postgallery->photo9) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame9" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="photo9" name ='photo9' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo10" class="form-label">Photo 10</label>
                            <br>
                            <div>
                                @if ($postgallery->photo10 == !null)
                                <img id="frame10" src="{{ asset($postgallery->photo10) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame10" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="photo10" name ='photo10' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo11" class="form-label">Photo 11</label>
                            <br>
                            <div>
                                @if ($postgallery->photo11 == !null)
                                <img id="frame11" src="{{ asset($postgallery->photo11) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame11" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="photo11" name ='photo11' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="photo12" class="form-label">Photo 12</label>
                            <br>
                            <div>
                                @if ($postgallery->photo12 == !null)
                                <img id="frame12" src="{{ asset($postgallery->photo12) }}" width="50%" class="rounded mb-3 border"/>
                                @else
                                <img id="frame12" src="{{ asset('Images/Icons/add_image.svg') }}" width="50%" class="rounded mb-3 border"/>
                                @endif
                            </div>
                            <input class="form-control" type="file" id="photo12" name ='photo12' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" disabled>
                        </div>
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


