@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Jumbotron Database</h5>
                <a class='btn btn-primary' href="/admin/jumbotron/create"><i class="fa fa-plus"></i> Create Jumbotron</a>

                <div class="mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr align='center'>
                                <th scope="col" style="width: 10px">No</th>
                                <th scope="col">Picture</th>
                                <th scope="col">Button Name</th>
                                <th scope="col">Button Link</th>
                                <th scope="col" style="width: 40px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($postjumbotron as $key => $postjumbotron)
                            <tr>
                                <td scope="row" align='center'>{{$key + 1}}</td>
                                <td align='center'>
                                    <img style="width: 300px;" src="{{ asset($postjumbotron->picture) }}" alt="{{$postjumbotron->title}}" class="card-img"/>
                                </td>
                                @if ($postjumbotron->btnname != null || $postjumbotron->btnlink != null)
                                    <td align='center'>{{$postjumbotron->btnname}}</td>
                                    <td align='center'><a href="{{$postjumbotron->btnlink}}" target="_blank">Click Here</a></td>
                                @else
                                    <td align='center'>None</td>
                                    <td align='center'>None</td>
                                @endif
                                <td align="center">
                                    <a href="/admin/jumbotron/{{$postjumbotron->id}}/edit" class="btn btn-sm btn-primary mb-1"><i class="fa fa-edit"></i></a>
                                    <button type="submit" onclick="deleteConfirmationJumbotron({{$postjumbotron->id}})" id="delete-jumbotron" class="btn btn-sm btn-primary mb-1"><i class="fa fa-trash"></i></button>
                                    <a class="btn btn-sm btn-primary" href="/admin/jumbotron/{{$postjumbotron->id}}/preview"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan='9', align='center'>No Jumbotron Data</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// ===== START CRUD JUMBOTRON =====
// ini untuk konfirmasi delete
        function deleteConfirmationJumbotron(id) {
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
                    url: `{{ url('/admin/jumbotron/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'Jumbotron has been deleted !'
                            });
                        }
                    });

                }
            })
        }
// ===== END CRUD JUMBOTRON =====
</script>
@endsection
