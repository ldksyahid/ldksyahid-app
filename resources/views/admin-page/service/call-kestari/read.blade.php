<table class="table table-bordered small">
    <thead>
        <tr align='center'>
            <th scope="col" style="width: 10px">No</th>
            <th scope="col">Button Name</th>
            <th scope="col">Link</th>
            <th scope="col" style="width: 15%">Action</th>
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
            <td align="center">
                <button class="btn btn-sm btn-primary" onClick="edit({{ $item->id }})"><i class="fa fa-edit"></i></button>
                <button class="btn btn-sm btn-primary" onClick="destroycallkestari({{ $item->id }})"><i class="fa fa-trash"></i></button>
                <button class="btn btn-sm btn-primary m-1" onClick="preview({{ $item->id }})"><i class="fa fa-eye"></i></button>
            </td>
        </tr>
    @empty
    <tr>
        <td colspan='9', align='center'>No Call Kestari Data</td>
    </tr>
    @endforelse
    </tbody>
</table>
