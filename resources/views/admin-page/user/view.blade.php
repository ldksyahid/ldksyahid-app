<!-- Form Start -->
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
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
            @if (LFC::getRoleName($data->getRoleNames()) != null)
                <label for="inputPosition" class="form-label" style="font-size: 18px;">
                    @if (LFC::getRoleName($data->getRoleNames()) == 'Superadmin')
                        <i class="badge badge-pill bg-danger">{{ LFC::getRoleName($data->getRoleNames()) }}</i>
                    @elseif (LFC::getRoleName($data->getRoleNames()) == 'HelperAdmin')
                        <i class="badge badge-pill bg-warning">{{ LFC::getRoleName($data->getRoleNames()) }}</i>
                    @elseif (LFC::getRoleName($data->getRoleNames()) == 'HelperCelsyahid')
                        <i class="badge badge-pill bg-success">{{ LFC::getRoleName($data->getRoleNames()) }}</i>
                    @elseif (LFC::getRoleName($data->getRoleNames()) == 'HelperEventMart')
                        <i class="badge badge-pill" style="background-color: #5352ed;">{{ LFC::getRoleName($data->getRoleNames()) }}</i>
                    @elseif (LFC::getRoleName($data->getRoleNames()) == 'HelperSPAM')
                        <i class="badge badge-pill bg-info">{{ LFC::getRoleName($data->getRoleNames()) }}</i>
                    @elseif (LFC::getRoleName($data->getRoleNames()) == 'HelperMedia')
                        <i class="badge badge-pill bg-dark">{{ LFC::getRoleName($data->getRoleNames()) }}</i>
                    @elseif (LFC::getRoleName($data->getRoleNames()) == 'HelperLetter')
                        <i class="badge badge-pill bg-secondary">{{ LFC::getRoleName($data->getRoleNames()) }}</i>
                    @elseif (LFC::getRoleName($data->getRoleNames()) == 'User')
                        <i class="badge badge-pill bg-primary">{{ LFC::getRoleName($data->getRoleNames()) }}</i>
                    @endif
                </label>
            @else
                <label for="inputPosition" class="form-label" style="font-size: 18px;"><i class="badge badge-pill bg-primary">User</i></label>
            @endif

        </div>
    </form>

</div>
<!-- Form End -->
