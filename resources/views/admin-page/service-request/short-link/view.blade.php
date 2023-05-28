<!-- Form Start -->
<div class="col-12">
    <div class="row">
        <div class="mb-3 col-4">
            <label for="name" class="form-label required"><b>Full Name</b></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}" disabled>
        </div>
        <div class="mb-3 col-4">
            <label for="email" class="form-label required"><b>Email</b></label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $data->email }}" disabled>
        </div>
        <div class="mb-3 col-4">
            <label for="whatsapp" class="form-label required"><b>Whatsapp Contact</b></label>
            <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ $data->whatsapp }}" disabled>
        </div>
        <div class="mb-3 col-6">
            <label for="customLink" class="form-label required"><b>Custom Link</b></label>
            <input type="text" class="form-control" id="customLink" name="customLink" value="{{ $data->customLink }}" disabled>
        </div>
        <div class="mb-3 col-6">
            <label for="defaultLink" class="form-label required"><b>Default Link</b></label>
            <input type="text" class="form-control" id="defaultLink" name="defaultLink" value="{{ $data->defaultLink }}" disabled>
        </div>
        <div class="mb-3 col-12">
            <label for="note" class="form-label required"><b>Note</b></label>
            <textarea class="form-control" placeholder="Leave a note here" id="note" name="note" style="height: 150px;" disabled>{{ $data->note }}</textarea>
        </div>
        <div class="mb-3 col-12">
            <label for="fixCustomLink" class="form-label required"><b>Fix Custom Link</b></label>
            <input type="text" class="form-control" id="fixCustomLink" name="fixCustomLink" value="{{ $data->fixCustomLink }}" disabled>
        </div>
    </div>
</div>
<!-- Form End -->
