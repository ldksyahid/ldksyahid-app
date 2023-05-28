@extends('admin-page.template.body')

@section('content')
<!-- Form Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Edit Jumbotron</h5>
                <form role="form" action='/admin/jumbotron/{{$postjumbotron->id}}/update' method='post' enctype="multipart/form-data">
                @csrf
                @method('PUT')
                    <div class="row">
                        <div class="mb-3 col col-4">
                            <label for="formFile" class="form-label required">Picture (1440 x 560 Pixel)</label>
                            <br>
                            <img id="frame" src="{{ asset($postjumbotron->picture) }}" width="250px" height="150px" class="rounded mb-3 border"/>
                            <input class="form-control" type="file" id="picture" name ='picture' title="Choose a video please" accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG" onchange="preview()">
                        </div>
                        <div class="mb-3 col col-lg-12">
                            <label class="form-check-label" for="cekBtn">Add Button ?</label>
                            @if ($postjumbotron->btnname != null || $postjumbotron->btnlink != null)
                                <input type="checkbox" class="form-check-input" id="cekButton" onclick="cekBtn()" checked>
                            @else
                                <input type="checkbox" class="form-check-input" id="cekButton" onclick="cekBtn()">
                            @endif
                        </div>
                        <div id="formButton" @if ($postjumbotron->btnname != null || $postjumbotron->btnlink != null)
                            style="display: ;"
                        @else
                            style="display: none;"
                        @endif>
                            <div class="row">
                                <div class="mb-3 col col-lg-6">
                                    <label for="inputButtonName1" class="form-label">Button Name</label>
                                    <input type="text" class="form-control" id="inputButtonName1" name='buttonname' value="{{old('buttonname', $postjumbotron->btnname)}}">
                                </div>
                                <div class="mb-3 col col-lg-6">
                                    <label for="inputButtonLink1" class="form-label">Button Link</label>
                                    <input type="text" class="form-control" id="inputButtonLink1" name='buttonlink' value="{{old('buttonlink', $postjumbotron->btnlink)}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a type="submit" class="btn btn-primary" href="/admin/jumbotron">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Form End -->
@endsection

@section('scripts')
<script>
function cekBtn() {
    var checkBoxBtn = document.getElementById("cekButton");
    var elementFormBtn = document.getElementById("formButton");
    console.log(checkBoxBtn.checked);
    if (checkBoxBtn.checked == true){
        elementFormBtn.style.display = "block";
    } else {
        elementFormBtn.style.display = "none";
    }
}
</script>

<script>
function preview() {
    frame.src=URL.createObjectURL(event.target.files[0]);
}
</script>
@endsection
