<!-- Form Start -->
<div class="col-sm-12 col-xl-12">
    <div>
        <div class="mb-3">
            <label for="name" class="form-label"><b>Full Name</b></label>
            <br>
            <label for="name" class="form-label">{{ $data->name }}</label>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label"><b>Email</b></label>
            <br>
            <label for="email" class="form-label">{{ $data->email }}</label>
        </div>
        <div class="mb-3">
            <label for="whatsapp" class="form-label"><b>Whatsapp Contact</b></label>
            <br>
            <label for="whatsapp" class="form-label">{{ $data->whatsapp }}</label>
        </div>
        <div class="mb-3">
            <label for="defaultLink" class="form-label"><b>Default Link</b></label>
            <br>
            <a href="{{ $data->defaultLink }}" for="defaultLink" target="_blank" class="form-label">{{ $data->defaultLink }}</a>
        </div>
        <div class="mb-3">
            <label for="customLink" class="form-label"><b>Custom Link</b></label>
            <br>
            <label for="customLink" class="form-label">{{ $data->customLink }}</label>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label"><b>Note</b></label>
            <br>
            <label for="note" class="form-label">{{ $data->note }}</label>
        </div>
        <div class="mb-3">
            <label for="fixCustomLink" class="form-label"><b>Fix Custom Link</b></label>
            <br>
            @if ($data->fixCustomLink == null)
                <p>Belum Ada</p>
            @else
                <a href="{{ $data->fixCustomLink }}" target="_blank">{{ $data->fixCustomLink }}</a>
            @endif
            {{-- <label for="fixCustomLink" class="form-label"><b>{{ $data->fixCustomLink }}</b></label> --}}
        </div>
    </div>

</div>
<!-- Form End -->
