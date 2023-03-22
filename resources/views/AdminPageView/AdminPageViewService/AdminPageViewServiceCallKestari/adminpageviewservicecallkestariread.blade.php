<table class="table table-bordered">
    <thead>
        <tr align='center'>
            <th scope="col">No</th>
            <th scope="col">Button Name</th>
            <th scope="col">Link</th>
            <th scope="col">Appear</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $key => $item)
        <tr>
            <td scope="row" align='center'>{{ $key+1 }}</td>
            <td scope="row" align='center'>{{ $item->buttonName }}</td>
            <td align='center'>
                <a href="{{ $item->link }}" target="_blank">Click Here</a>
            </td>
            <td align="center">{{ $item->appear }}</td>
            <td align="center">
                <button class="btn btn-sm btn-primary" onClick="edit({{ $item->id }})"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-primary" onClick="destroycallkestari({{ $item->id }})"><i class="fa fa-trash"></i></button>
                <a class="btn btn-sm btn-primary" href="/service/callkestari" target="_blank"><i class="fa fa-eye"></i></a>
            </td>
        </tr>
    @empty
    <tr>
        <td colspan='9', align='center'>No Call Kestari Data</td>
    </tr>
    @endforelse
    </tbody>
</table>
