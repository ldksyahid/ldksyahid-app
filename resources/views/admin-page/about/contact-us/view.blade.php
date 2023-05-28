<!-- Form Start -->
<div class="col-12">
    <form>
        <div class="row">
            <div class="mb-3 col-6">
                <label for="inputName1" class="form-label"><b>Name</b></label>
                <br>
                <label for="inputName1" class="form-label">{{ $data->name }}</label>
            </div>
            <div class="mb-3 col-6">
                <label for="inputEmail1" class="form-label"><b>Email Address</b></label>
                <br>
                <label for="inputEmail" class="form-label">{{ $data->email }}</label>
            </div>
            <div class="mb-3 col-6">
                <label for="inputEmail1" class="form-label"><b>Date</b></label>
                <br>
                <label for="inputEmail" class="form-label">{{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $data->created_at )->format('Y') }} ({{ \Carbon\Carbon::parse( $data->created_at )->format('H:i T') }})</label>
            </div>
            <div class="mb-3 col-6">
                <label for="inputPassword1" class="form-label"><b>Subject</b></label>
                <br>
                <label for="inputPassword1" class="form-label">{{ ($data->subject) }}</label>
            </div>
            <div class="mb-3 col-12">
                <label for="inputPosition1" class="form-label"><b>Message</b></label>
                <br>
                <div class="border rounded p-3">
                    {{ $data->message }}
                </div>
            </div>
        </div>
    </form>
</div>
<!-- Form End -->
