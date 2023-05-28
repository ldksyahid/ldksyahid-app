@extends('admin-page.template.body')

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Contact Message Database</h5>
                <div  class="mt-3">
                    <table class="table table-bordered small">
                        <thead>
                            <tr align='center'>
                                <th scope="col" style="width: 10px">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $key => $item)
                            <tr>
                                <td scope="row" align='center'>{{$key + 1}}</td>
                                <td align='center'>{{$item->name}}</td>
                                <td align='center'>{{$item->subject}}</td>
                                <td align='center'>{{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $item->created_at )->format('Y') }}</td>
                                <td align="center">
                                    <button class="btn btn-sm btn-primary" onClick="destroycontactmessage({{ $item->id }})"><i class="fa fa-trash"></i></button>
                                    <button class="btn btn-sm btn-primary" onClick="preview({{ $item->id }})"><i class="fa fa-eye"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan='9', align='center'>No Contact Message Data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
<!-- Modal -->
<div class="modal fade" id="modalCrudContactMessage" tabindex="-1" aria-labelledby="modalLabelContactMessage" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content bg-light rounded h-100 p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelContactMessage">Modal title</h5>
                <button type="button" class="btn btn-close btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="pagecontactmessage"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // ===== START CRUD CONTACT MESSAGE =====
    // untuk destroy database
    function destroycontactmessage(id) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            width: '350px',
        })

        Swal.fire({
            title: 'Are you sure ?',
            text: "You won't be able to revert this !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                type: "get",
                url: `{{ url('/admin/about/contact/message/${id}/destroy') }}`,
                data: {},
                    success: function(data) {
                        $(".btn-close").click();
                        setTimeout(function () { location.reload(1); }, 300);
                        Toast.fire({
                            icon: 'success',
                            title: 'Message has been deleted !'
                        });
                    }
                });
            }
        })
    }

    // untuk modal preview
    function preview(id) {
        $.get(`{{ url('/admin/about/contact/message/${id}/preview') }}`, {}, function(data, status) {
            $("#modalLabelContactMessage").html('Preview Message')
            $("#pagecontactmessage").html(data);
            $("#modalCrudContactMessage").modal('show');
        });
    }
    // ===== END CRUD CONTACT MESSAGE =====
</script>
@endsection
