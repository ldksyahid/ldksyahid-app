@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">News Database</h5>
                <a class='btn btn-primary' href="/admin/news/create"><i class="fa fa-plus"></i>Create News</a>
                {{-- START Data table News --}}
                <div class="mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr align='center'>
                                <th scope="col" style="width: 10px">No</th>
                                <th scope="col" style="width: 170px">Date Publish</th>
                                <th scope="col">Publisher</th>
                                <th scope="col">Title</th>
                                <th scope="col" style="width: 170px">Reporter</th>
                                <th scope="col">Editor</th>
                                <th scope="col" style="width: 180px">Picture</th>
                                <th scope="col" style="width: 180px">Picture Description</th>
                                <th scope="col" style="width: 180px">Content</th>
                                <th scope="col" style="width: 40px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($postnews as $key => $postnews)
                            <tr>
                                <td scope="row" align='center'>{{$key + 1}}</td>
                                <td>{{ $postnews->datepublish }}</td>
                                <td>{{ $postnews->publisher }}</td>
                                <td>{{ substr($postnews->title, 0, 10) }}</td>
                                <td>{{ $postnews->reporter }}</td>
                                <td align='center'>{{ $postnews->editor }}</td>
                                <td align='center'><img style="width: 100px;" src="{{ asset($postnews->picture) }}" alt="{{ $postnews->title }}" class="card-img-top"/></td>
                                <td align='center'>{{ substr($postnews->descpicture, 0, 10) }}</td>
                                <td align='center'>{!!  substr(strip_tags($postnews->body), 0, 10) !!}</td>
                                <td align="center">
                                        <a href="/admin/news/{{ $postnews->id }}/edit" class="btn btn-sm btn-primary mb-1"><i class="fa fa-edit"></i></a>
                                        <button type="submit" onclick="deleteConfirmationNews({{ $postnews->id }})" id="delete-event" class="btn btn-sm btn-primary mb-1"><i class="fa fa-trash"></i></button>
                                        <a class="btn btn-sm btn-primary" href="/news/{{ $postnews->id }}/show" target="_blank"><i class="fa fa-eye"></i></a>
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
                {{-- END Data table News --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
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
@endsection

