<!-- Form Start -->
<div class="col-sm-12 col-xl-12">
    <form>
        <div class="mb-3">
            <label for="inputName1" class="form-label"><b>Name</b></label>
            <br>
            <label for="inputName1" class="form-label">{{ $data->name }}</label>
        </div>
        <div class="mb-3">
            <label for="inputEmail1" class="form-label"><b>Email Address</b></label>
            <br>
            <label for="inputEmail" class="form-label">{{ $data->email }}</label>
        </div>
        <div class="mb-3">
            <label for="inputEmail1" class="form-label"><b>Email Verified</b></label>
            <br>
            @if ($data->email_verified_at == null)
                <label for="inputEmail" class="form-label">Not yet</label>
            @else
                <label for="inputEmail" class="form-label">{{ \Carbon\Carbon::parse( $data->email_verified_at )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $data->email_verified_at )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $data->email_verified_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $data->email_verified_at )->format('Y') }} ({{ \Carbon\Carbon::parse( $data->email_verified_at )->format('H:i T') }})</label>
            @endif
        </div>
        <div class="mb-3">
            <label for="inputPosition1" class="form-label"><b>Role</b></label>
            <br>
            @if ($data->is_admin == 1)
                <label for="inputPosition" class="form-label">Helper</label>
            @elseif ($data->is_admin == 2)
                <label for="inputPosition" class="form-label">Superadmin</label>
            @else
                <label for="inputPosition" class="form-label">User</label>
            @endif

        </div>
    </form>

</div>
<!-- Form End -->
