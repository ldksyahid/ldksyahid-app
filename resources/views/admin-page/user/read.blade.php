@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
<div class="table-responsive">
    <table class="table table-hover table-striped text-nowrap small" id="dataUser">
        <thead>
            <tr>
                <th scope="col" class="text-center">No</th>
                <th scope="col" class="text-center">Name</th>
                <th scope="col" class="text-center">Created</th>
                <th scope="col" class="text-center">Email</th>
                <th scope="col" class="text-center">Verification</th>
                <th scope="col" class="text-center">Role</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $pointer = 0;
            @endphp
            @foreach($data as $item)
            <tr class="small">
                <td scope="row" align='center'>{{ $pointer += 1 }}</td>
                <td align="center">{{$item->name}}</td>
                <td align="center">{{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('dddd') }} {{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $item->created_at )->format('Y') }} ({{ \Carbon\Carbon::parse( $item->created_at )->format('H:i T') }})</td>
                <td align="center">{{$item->email}}</td>
                @if ($item->email_verified_at == null)
                    <td align='center'>Not yet</td>
                @else
                    <td align='center'>Yes</td>
                @endif
                @if (LFC::getRoleName($item->getRoleNames()) != null)
                    <td align='center' style="font-size: 16px;">
                        @if (LFC::getRoleName($item->getRoleNames()) == 'Superadmin')
                            <i class="badge badge-pill bg-danger">{{ LFC::getRoleName($item->getRoleNames()) }}</i>
                        @elseif (LFC::getRoleName($item->getRoleNames()) == 'HelperAdmin')
                            <i class="badge badge-pill bg-warning">{{ LFC::getRoleName($item->getRoleNames()) }}</i>
                        @elseif (LFC::getRoleName($item->getRoleNames()) == 'HelperCelsyahid')
                            <i class="badge badge-pill bg-success">{{ LFC::getRoleName($item->getRoleNames()) }}</i>
                        @elseif (LFC::getRoleName($item->getRoleNames()) == 'HelperEventMart')
                            <i class="badge badge-pill" style="background-color: #5352ed;">{{ LFC::getRoleName($item->getRoleNames()) }}</i>
                        @elseif (LFC::getRoleName($item->getRoleNames()) == 'HelperSPAM')
                            <i class="badge badge-pill bg-info">{{ LFC::getRoleName($item->getRoleNames()) }}</i>
                        @elseif (LFC::getRoleName($item->getRoleNames()) == 'HelperMedia')
                            <i class="badge badge-pill bg-dark">{{ LFC::getRoleName($item->getRoleNames()) }}</i>
                        @elseif (LFC::getRoleName($item->getRoleNames()) == 'HelperLetter')
                            <i class="badge badge-pill bg-secondary">{{ LFC::getRoleName($item->getRoleNames()) }}</i>
                        @elseif (LFC::getRoleName($item->getRoleNames()) == 'User')
                            <i class="badge badge-pill bg-primary">{{ LFC::getRoleName($item->getRoleNames()) }}</i>
                        @endif
                    </td>
                @else
                    <td align='center' style="font-size: 16px;"><i class="badge badge-pill bg-primary">User</i></td>
                @endif
                <td align="center">
                    <button class="btn btn-sm btn-primary" onClick="edit({{ $item->id }})"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-primary" onClick="destroyuser({{ $item->id }})"><i class="fa fa-trash"></i></button>
                    <button class="btn btn-sm btn-primary" onClick="preview({{ $item->id }})"><i class="fa fa-eye"></i></button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    $('#dataUser').DataTable({
        responsive: true,
        fixedHeader: true,
    });
</script>

