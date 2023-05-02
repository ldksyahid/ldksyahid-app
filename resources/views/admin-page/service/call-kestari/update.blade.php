<!-- Form Start -->
<div class="col-sm-12 col-xl-12">
    <div>
        <div class="mb-3">
            <label for="buttonName" class="form-label"><b>Button Name</b></label>
            <input type="text" class="form-control" id="buttonName" placeholder="Ex. Peminjaman Barang" value="{{ $data->buttonName }}">
        </div>
        <div class="mb-3">
            <label for="link" class="form-label"><b>Link</b></label>
            <textarea class="form-control" name="link" id="link">{{ $data->link }}</textarea>
        </div>
        <div class="mb-3">
            <label for="appear" class="form-label"><b>Appear</b></label>
            <input type="text" class="form-control" id="appear" placeholder="Right or Left" value="{{ $data->appear }}">
        </div>
        <button type="submit" class="btn btn-primary" onClick="update({{ $data->id }})">Update</button>
    </div>

</div>
<!-- Form End -->
