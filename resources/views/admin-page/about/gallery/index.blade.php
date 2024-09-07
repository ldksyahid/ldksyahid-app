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
                <h5 class="mb-4">Gallery Management System</h5>
                <a class='btn btn-primary' href="/admin/about/gallery/create"><i class="fa fa-plus"></i> Create Gallery</a>
                {{-- START Data table Gallery --}}
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-nowrap small" id="dataGallery">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Event Name</th>
                                    <th scope="col" class="text-center">Event Theme</th>
                                    <th scope="col" class="text-center">Group Photo</th>
                                    <th scope="col" class="text-center">Embed Youtube Link</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($postgallery as $key => $postgallery)
                                <tr>
                                    <td scope="row" align='center'>{{ $key+1 }}</td>
                                    <td align='center'>{{ $postgallery->eventName }}</td>
                                    <td align='center'>{{ $postgallery->eventTheme }}</td>
                                    <td align='center'>
                                        <img style="width: 100px;" src="https://lh3.googleusercontent.com/d/{{ $postgallery->gdrive_id }}" alt="" class="card-img"/>
                                    </td>
                                    @if ($postgallery->linkEmbedYoutube == null)
                                        <td align='center'>Nothing</td>
                                    @else
                                        <td align='center'><a href="{{ $postgallery->linkEmbedYoutube }}" target="_blank" rel="noopener noreferrer">{{ $postgallery->linkEmbedYoutube }}</a></td>
                                    @endif
                                    <td align="center">
                                        <a href="/admin/about/gallery/{{ $postgallery->id }}/edit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <button type="submit" onclick="deleteConfirmationGallery({{ $postgallery->id }})" id="delete-gallery" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                                        <a class="btn btn-sm btn-primary" href="/admin/about/gallery/{{ $postgallery->id }}/preview"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan='9', align='center'>No Gallery Data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- END Data table Gallery --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script>
// ===== START CRUD GALLERY =====
// ini untuk konfirmasi delete
function deleteConfirmationGallery(id) {
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
                    url: `{{ url('/admin/about/gallery/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'Gallery has been deleted !'
                            });
                        }
                    });

                }
            })
        }
// ===== END CRUD GALLERY =====
</script>
<script>
    $('#dataGallery').DataTable({
        responsive: true,
        fixedHeader: true,
    });
</script>
@endsection
