@extends('admin-page.template.body')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
@endsection

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">News Management System</h5>
                <a class='btn btn-primary' href="/admin/news/create"><i class="fa fa-plus"></i> Create News</a>
                {{-- START Data table News --}}
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-nowrap small" id="dataNews">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Date Publish</th>
                                    <th scope="col" class="text-center">Publisher</th>
                                    <th scope="col" class="text-center">Title</th>
                                    <th scope="col" class="text-center">Reporter</th>
                                    <th scope="col" class="text-center">Editor</th>
                                    <th scope="col" class="text-center">Picture</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($postnews as $key => $postnews)
                                <tr class="small">
                                    <td scope="row" align='center'>{{$key + 1}}</td>
                                    <td align='center'>{{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('dddd') }} {{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postnews->datepublish )->format('Y') }}</td>
                                    <td align='center'>{{ $postnews->publisher }}</td>
                                    <td align='center'>{{ $postnews->title }}</td>
                                    <td align='center'>{{ $postnews->reporter }}</td>
                                    <td align='center'>{{ $postnews->editor }}</td>
                                    <td align='center'><img style="width: 100px;" src="https://drive.google.com/thumbnail?id={{ $postnews->gdrive_id }}" alt="{{ $postnews->title }}" class="card-img"/></td>
                                    <td align="center">
                                            <a href="/admin/news/{{ $postnews->id }}/edit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                            <button type="submit" onclick="deleteConfirmationNews({{ $postnews->id }})" id="delete-event" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                                            <a class="btn btn-sm btn-primary" href="/admin/news/{{ $postnews->id }}/preview"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan='9', align='center'>No News Data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- END Data table News --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script>
// ===== START CRUD EVENT =====
// ini untuk konfirmasi delete
function deleteConfirmationNews(id) {
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
                    url: `{{ url('/admin/news/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'News has been deleted !'
                            });
                        }
                    });

                }
            })
        }
// ===== END CRUD EVENT =====
</script>
<script>
    $('#dataNews').DataTable({
        responsive: true,
        fixedHeader: true,
    });
</script>
@endsection

