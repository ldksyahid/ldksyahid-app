@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Gallery Database</h5>
                <a class='btn btn-primary' href="/admin/about/gallery/create"><i class="fa fa-plus"></i> Create Gallery</a>
                {{-- START Data table Article --}}
                <div class="mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr align='center' class="small">
                                <th scope="col" style="width: 10px">No</th>
                                <th scope="col">Event Name</th>
                                <th scope="col">Event Theme</th>
                                <th scope="col">Big Photo</th>
                                <th scope="col">Other Photo</th>
                                <th scope="col">Link Embed</th>
                                <th scope="col" style="width: 10px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($postgallery as $key => $postgallery)
                            <tr>
                                <td scope="row" align='center'>{{ $key+1 }}</td>
                                <td align='center'>{{ $postgallery->eventName }}</td>
                                <td align='center'>{{ $postgallery->eventTheme }}</td>
                                <td align='center'>
                                    <img style="width: 150px;" src="{{ asset($postgallery->groupPhoto) }}" alt="" class="card-img"/>
                                </td>
                                <td align='center'>
                                    <img style="width: 100px;" src="{{ asset($postgallery->photo1) }}" alt="" class="card-img"/>
                                    <img style="width: 100px;" src="{{ asset($postgallery->photo2) }}" alt="" class="card-img"/>
                                    <img style="width: 100px;" src="{{ asset($postgallery->photo3) }}" alt="" class="card-img"/>
                                    <img style="width: 100px;" src="{{ asset($postgallery->photo4) }}" alt="" class="card-img"/>
                                    <img style="width: 100px;" src="{{ asset($postgallery->photo5) }}" alt="" class="card-img"/>
                                    <img style="width: 100px;" src="{{ asset($postgallery->photo6) }}" alt="" class="card-img"/>
                                    <img style="width: 100px;" src="{{ asset($postgallery->photo7) }}" alt="" class="card-img"/>
                                    <img style="width: 100px;" src="{{ asset($postgallery->photo8) }}" alt="" class="card-img"/>
                                    <img style="width: 100px;" src="{{ asset($postgallery->photo9) }}" alt="" class="card-img"/>
                                    <img style="width: 100px;" src="{{ asset($postgallery->photo10) }}" alt="" class="card-img"/>
                                    <img style="width: 100px;" src="{{ asset($postgallery->photo11) }}" alt="" class="card-img"/>
                                    <img style="width: 100px;" src="{{ asset($postgallery->photo12) }}" alt="" class="card-img"/>
                                </td>
                                @if ($postgallery->linkEmbedYoutube == null)
                                    <td align='center'>Nothing</td>
                                @else
                                    <td align='center'>{{ $postgallery->linkEmbedYoutube }}</td>
                                @endif
                                <td align="center">
                                    <a href="/admin/about/gallery/{{ $postgallery->id }}/edit" class="btn btn-sm btn-primary mb-1"><i class="fa fa-edit"></i></a>
                                    <button type="submit" onclick="deleteConfirmationGallery({{ $postgallery->id }})" id="delete-gallery" class="btn btn-sm btn-primary mb-1"><i class="fa fa-trash"></i></button>
                                    <a class="btn btn-sm btn-primary" href="/about/gallery" target="_blank"><i class="fa fa-eye"></i></a>
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
                {{-- END Data table Jumbotron --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
<script>
// ===== START CRUD SCHEDULE =====
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
// ===== END CRUD SCHEDULE =====
</script>
@endsection
