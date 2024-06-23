@extends('admin-page.template.body')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>
@endsection

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Preview KTA LDK Syahid</h5>
                <form role="form" action='#' method='post' enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputFullName" class="form-label required">Full Name</label>
                            <input type="text" class="form-control" id="inputFullName" name='fullName' value="{{old('fullName', $ktaData->fullName)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4 text-center">
                            <label for="photo" class="form-label">Photo Profile</label>
                            <br>
                            @if (!empty($ktaData->photo))
                                <img id="frame" src="{{ asset($ktaData->photo) }}" width="150px" height="200px" class="rounded mb-3 border"/>
                            @else
                                @if ($ktaData->gender != "Male")
                                    <img id="frame" src="https://lh3.googleusercontent.com/d/1wssPqERqsehbQIrUsp9ntd9RHe8m77OQ" width="150px" height="200px" class="rounded mb-3 border"/>
                                @else
                                    <img id="frame" src="https://lh3.googleusercontent.com/d/1dpTivBD1VPetcmHj3psiz75si_n1PwTo" width="150px" height="200px" class="rounded mb-3 border"/>
                                @endif
                            @endif
                            <input class="form-control" type="file" id="photo" name='photo' accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG, image/webp">
                        </div>
                        <div class="col-12 col-lg-4">
                            <fieldset class="row mb-3">
                                <legend class="col-form-label pt-0 required">Gender</legend>
                                    <div class="form-check col-6 col-lg-12">
                                        <input class="form-check-input gender" type="radio" name="gender" id="genderMale" value='Male' @if ($ktaData->gender == 'Male') checked @endif disabled>
                                        <label class="form-check-label" for="male">
                                            <i class="badge badge-pill bg-dark">Male</i>
                                        </label>
                                    </div>
                                    <div class="form-check col-6 col-lg-12">
                                        <input class="form-check-input gender" type="radio" name="gender" id="genderFemale" value='Female' @if ($ktaData->gender == 'Female') checked @endif disabled>
                                        <label class="form-check-label" for="female">
                                            <i class="badge badge-pill bg-warning">Female</i>
                                        </label>
                                    </div>
                            </fieldset>
                        </div>
                        <div class="mb-3 col-12 col-lg-5">
                            <label for="inputNim" class="form-label required">NIM</label>
                            <input type="text" class="form-control" id="inputNim" name='nim' value="{{old('nim', $ktaData->nim)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputFaculty" class="form-label required">Faculty</label>
                            <select class="form-group mb-3 textSearch" name="faculty" type='text' id="inputFaculty" disabled>
                                <option selected hidden value="{{old('faculty', $ktaData->getFaculty->id)}}">{{$ktaData->getFaculty->facultyName}}</option>
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="inputMajor" class="form-label required">Major</label>
                            <select class="mb-3 textSearch" aria-label="" name="major" type='text' id="inputMajor" disabled>
                                <option selected hidden value="{{old('faculty', $ktaData->getMajor->id)}}">{{$ktaData->getMajor->majorName}}</option>
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-lg-3">
                            <label for="inputGeneration" class="form-label required">Generation</label>
                            <select class="form-group mb-3 textSearch" aria-label=""  name="generation" type='text' id="inputGeneration" disabled>
                                <option selected hidden value="{{old('faculty', $ktaData->getGeneration->id)}}">{{$ktaData->getGeneration->generationName}}</option>
                            </select>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputMemberNumber" class="form-label required">Member Number</label>
                            <input type="text" class= "form-control" id="inputMemberNumber" name='memberNumber' value="{{old('nim', $ktaData->memberNumber)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-5">
                            <label for="inputLinkProfile" class="form-label required">Link Profile</label>
                            <input type="text" class="form-control" id="inputLinkProfile" name='linkProfile' value="{{old('nim', $ktaData->linkProfile)}}" disabled style="text-transform: lowercase;">
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputSlogan" class="form-label">Slogan</label>
                            <textarea class="form-control" name="slogan" id="inputSlogan" disabled>{{ $ktaData->slogan }}</textarea>
                        </div>
                        <div class="mb-3 col-12 col-lg-6">
                            <label for="inputBackground" class="form-label">Background</label>
                            <textarea class="form-control" name="background" id="inputBackground" disabled>{{ $ktaData->background }}</textarea>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="text" class="form-control" id="inputEmail" name='email' value="{{old('email', $ktaData->email)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputLinkedIn" class="form-label">LinkedIn</label>
                            <input type="text" class="form-control" id="inputLinkedIn" name='linkedIn' value="{{old('linkedIn', $ktaData->linkedIn)}}" disabled>
                        </div>
                        <div class="mb-3 col-12 col-lg-4">
                            <label for="inputInstagram" class="form-label">Instagram</label>
                            <input type="text" class="form-control" id="inputInstagram" name='instagram' value="{{old('instagram', $ktaData->instagram)}}" disabled>
                        </div>
                        <div class="mb-3 col-12">
                            <a type="submit" class="btn btn-primary" href="/admin/ktaldksyahid"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
@endsection

@section('scripts')
<script>
function preview() {
    frame.src=URL.createObjectURL(event.target.files[0]);
}
</script>
<script>
const textSearch = document.querySelectorAll('.textSearch');
let tomSelects = [];

for (let i = 0; i < textSearch.length; i++) {
    tomSelects[i] = new TomSelect(textSearch[i], {
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
}
</script>
@endsection
