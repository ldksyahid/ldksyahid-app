<!-- Form Start -->
<div class="col-12">
    <div class="row">
        <div class="mb-3 col-12 col-lg-8">
            <label for="link" class="form-label required"><b>Link</b></label>
            <textarea class="form-control" name="link" id="link" disabled>{{ $data->link }}</textarea>
        </div>
        <div class="mb-3 col-12 col-lg-4">
            <label for="buttonName" class="form-label required"><b>Button Name</b></label>
            <input type="text" class="form-control" id="buttonName" value="{{ $data->buttonName }}" disabled>
        </div>
    </div>
</div>
<!-- Form End -->
