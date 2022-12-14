<table class=" table table-bordered" id="data_users_reguler">
    <thead>
        <tr align='center'>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Password</th>
            <th scope="col">Email Verified</th>
            <th scope="col">Privilage</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td scope="row" align='center'>{{ $item->id }}</td>
            <td>{{substr($item->name, 0, 20)}}</td>
            <td >{{substr($item->email, 0, 20)}}</td>
            <td>{{substr($item->password, 0, 5)}}...</td>
            @if ($item->email_verified_at == null)
                <td align='center'>Not yet</td>
            @else
                <td align='center'>Yes</td>
            @endif
            @if ($item->is_admin == 1)
                <td align='center'>Helper</td>
            @elseif ($item->is_admin == 2)
                <td align='center'>Superadmin</td>
            @else
                <td align='center'>User</td>
            @endif
            <td align="center">
                @if ($item->email == "ldk@uinjkt.ac.id")
                    <button class="btn btn-sm btn-primary" onClick="preview({{ $item->id }})"><i class="fa fa-eye"></i></button>
                @elseif ($item->email== "yusufwijaya3@gmail.com")
                    <button class="btn btn-sm btn-primary" onClick="preview({{ $item->id }})"><i class="fa fa-eye"></i></button>
                @else
                    <button class="btn btn-sm btn-primary" onClick="edit({{ $item->id }})"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-primary" onClick="destroyuser({{ $item->id }})"><i class="fa fa-trash"></i></button>
                    <button class="btn btn-sm btn-primary" onClick="preview({{ $item->id }})"><i class="fa fa-eye"></i></button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
    $('#data_users_reguler').DataTable();
} );
</script>

