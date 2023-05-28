<!-- Form Start -->
<div class="col-12">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger print-error-msg small pb-0 error-field fade-in shadow-sm">
                <span><i class="fa fa-exclamation-circle fa-1x me-2"></i>Error Message :</span>
                <br>
                <ul></ul>
            </div>
        </div>
        <div class="mb-3 col-8">
            <label for="link" class="form-label required"><b>Link</b></label>
            <textarea class="form-control" name="link" id="link">{{ $data->link }}</textarea>
        </div>
        <div class="mb-3 col-4">
            <label for="buttonName" class="form-label required"><b>Button Name</b></label>
            <input type="text" class="form-control" id="buttonName" value="{{ $data->buttonName }}">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary" onClick="update({{ $data->id }})">Update</button>
        </div>
    </div>
</div>
<!-- Form End -->
