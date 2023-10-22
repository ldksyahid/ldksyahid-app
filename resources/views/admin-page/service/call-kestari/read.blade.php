<div class="table-responsive">
    <table class="table table-hover table-striped text-nowrap small" id="dataCallKestari">
        <thead>
            <tr>
                <th scope="col" class="text-center">No</th>
                <th scope="col" class="text-center">Button Name</th>
                <th scope="col" class="text-center">Link</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $key => $item)
            <tr>
                <td scope="row" align='center'>{{ $key+1 }}</td>
                <td align='center'>{{ $item->buttonName }}</td>
                <td align='center'>
                    <a href="{{ $item->link }}" target="_blank">{{ $item->link }}</a>
                </td>
                <td align="center">
                    <button class="btn btn-sm btn-primary" onClick="edit({{ $item->id }})"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-sm btn-primary" onClick="destroycallkestari({{ $item->id }})"><i class="fa fa-trash"></i></button>
                    <button class="btn btn-sm btn-primary" onClick="preview({{ $item->id }})"><i class="fa fa-eye"></i></button>
                </td>
            </tr>
        @empty
        <tr>
            <td colspan='9', align='center'>No Call Kestari Data</td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>

<script>
    $('#dataCallKestari').DataTable({
        responsive: true,
        fixedHeader: true,
    });
</script>
