<!-- Form Start -->
<div class="col-sm-12 col-xl-12">
    <div>
        <div class="mb-3">
            <label for="name" class="form-label"><b>Full Name</b></label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter the Name..." value="{{ $data->name }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label"><b>Email</b></label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter the Email..." value="{{ $data->email }}">
        </div>
        <div class="mb-3">
            <label for="whatsapp" class="form-label"><b>Whatsapp Contact</b></label>
            <input type="text" class="form-control" id="whatsapp" name="whatsapp" placeholder="Enter the Whatsapp..." value="{{ $data->whatsapp }}">
        </div>
        <div class="mb-3">
            <label for="customLink" class="form-label"><b>Custom Link</b></label>
            <input type="text" class="form-control" id="customLink" name="customLink" placeholder="Enter the Custom Link..." value="{{ $data->customLink }}">
        </div>
        <div class="mb-3">
            <label for="defaultLink" class="form-label"><b>Default Link</b></label>
            <input type="text" class="form-control" id="defaultLink" name="defaultLink" placeholder="Enter the Default Link..." value="{{ $data->defaultLink }}">
        </div>
        <div class="mb-3">
            <label for="note" class="form-label"><b>Note</b></label>
            <textarea class="form-control" placeholder="Leave a note here" id="note" name="note" style="height: 150px;">{{ $data->note }}</textarea>
        </div>
        <div class="mb-3">
            <label for="fixCustomLink" class="form-label"><b>Fix Custom Link</b></label>
            <input type="text" class="form-control" id="fixCustomLink" name="fixCustomLink" placeholder="Enter the Fix Custom Link..." value="{{ $data->fixCustomLink }}">
        </div>
        <button type="submit" class="btn btn-primary" onClick="updateFixCustomLink({{ $data->id }})">Save Change</button>
    </div>

</div>
<!-- Form End -->
