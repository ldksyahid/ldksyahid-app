<table class="table table-bordered">
    <thead>
        <tr align='center'>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Password</th>
            <th scope="col">Admin?</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td scope="row" align='center'>{{ $item->id }}</td>
            <td>{{substr($item->name, 0, 20)}}</td>
            <td >{{ $item->email }}</td>
            <td>{{substr($item->password, 0, 10)}}...</td>
            <td align='center'>{{ $item->is_admin }}</td>
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
