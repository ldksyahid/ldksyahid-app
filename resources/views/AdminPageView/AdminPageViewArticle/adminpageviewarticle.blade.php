@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Article Database</h5>
                <a class='btn btn-primary' href="/admin/article/create"><i class="fa fa-plus"></i> Create Article</a>
                {{-- START Data table Article --}}
                <div class="mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr align='center'>
                                <th scope="col" style="width: 10px">No</th>
                                <th scope="col">Title</th>
                                <th scope="col">Theme</th>
                                <th scope="col">Publish Date</th>
                                <th scope="col">Writer</th>
                                <th scope="col">Editor</th>
                                <th scope="col">Poster</th>
                                <th scope="col">Embed anyflip</th>
                                <th scope="col" style="width: 10px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($postarticle as $key => $postarticle)
                            <tr>
                                <td scope="row" align='center'>{{$key + 1}}</td>
                                <td>{{ $postarticle->title }}</td>
                                <td align='center'>{{ $postarticle->theme }}</td>
                                <td align='center'>{{ $postarticle->dateevent }}</td>
                                <td align='center'>{{ $postarticle->writer }}</td>
                                <td align='center'>{{ $postarticle->editor }}</td>
                                <td align='center'>
                                    <img style="width: 100px;" src="{{ asset($postarticle->poster) }}" alt="{{$postarticle->title}}" class="card-img-top"/>
                                </td>
                                <td align='center'><a href="{{ $postarticle->embedpdf }}" target="_blank">{{substr($postarticle->embedpdf, 0, 10)}}</a></td>
                                <td align="center">
                                        <a href="/admin/article/{{ $postarticle->id }}/edit" class="btn btn-sm btn-primary mb-1"><i class="fa fa-edit"></i></a>
                                        <button type="submit" onclick="deleteConfirmationArticle({{ $postarticle->id }})" id="delete-article" class="btn btn-sm btn-primary mb-1"><i class="fa fa-trash"></i></button>
                                        <a class="btn btn-sm btn-primary" href="/article/{{ $postarticle->id }}/show" target="_blank"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan='9', align='center'>No Article Data</td>
                            </tr>
                            @endforelse
                        </tbody>
                        {{-- <tbody>
                            @forelse($postjumbotron as $key => $postjumbotron)
                            <tr>
                                <td scope="row" align='center'>{{$key + 1}}</td>
                                <td>{{ $postjumbotron->title }}</td>
                                <td>
                                    <img style="width: 100px;" src="{{asset('Images/uploads/jumbotrons')}}/{{$postjumbotron->picture}}" alt="{{$postjumbotron->title}}" class="card-img-top"/>
                                </td>
                                <td>{{ $postjumbotron->subtitle }}</td>
                                <td>{{substr($postjumbotron->sentence, 0, 10)}}...</td>
                                <td align='center'>{{$postjumbotron->btnname}}</td>
                                <td align='center'><a href="{{$postjumbotron->btnlink}}" target="_blank">Link</a></td>
                                <td align='center'>{{$postjumbotron->textalign}}</td>
                                <td align="center">
                                        <a href="/admin/jumbotron/{{$postjumbotron->id}}/edit" class="btn btn-sm btn-primary mb-1"><i class="fa fa-edit"></i></a>
                                        <button type="submit" onclick="deleteConfirmation({{$postjumbotron->id}})" id="delete-jumbotron" class="btn btn-sm btn-primary mb-1"><i class="fa fa-trash"></i></button>
                                        <a class="btn btn-sm btn-primary" href="/admin/jumbotron/{{$postjumbotron->id}}/preview"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan='9', align='center'>No Jumbotron Data</td>
                            </tr>
                        @endforelse
                        </tbody> --}}
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
// ===== START CRUD ARTICLE =====
// ini untuk konfirmasi delete
function deleteConfirmationArticle(id) {
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
                    url: `{{ url('/admin/article/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'Article has been deleted !'
                            });
                        }
                    });

                }
            })
        }
// ===== END CRUD ARTICLE =====
</script>
@endsection
