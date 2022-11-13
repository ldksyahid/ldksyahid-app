@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">User Database</h5>
                <button class='btn btn-primary' onClick="create()"><i class="fa fa-plus"></i> Create User</button>
                {{-- START Data table User --}}
                <table class="mt-3 table table-bordered data-table">
                    <thead>
                        <tr align='center'>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Password</th>
                            <th scope="col">Email Verified</th>
                            <th scope="col">Admin?</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>


                {{-- <div id="read" class="mt-3 data-table"></div> --}}
                {{-- END Data table User --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
<!-- Modal -->
<div class="modal fade" id="modalCrudUser" tabindex="-1" aria-labelledby="modalLabelCrudUser" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content bg-light rounded h-100 p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelCrudUser">Modal title</h5>
                <button type="button" class="btn btn-close btn-primary" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="page"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    // ===== START DATATABLE =====
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.user.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'password', name: 'password'},
                {data: 'is_admin', name: 'is_admin'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
    // ===== END DATATABLE =====

    // ===== START CRUD USER =====
    // untuk load database
    $(document).ready(function(){
        read();
    });


    //untuk read database
    function read() {
        $.get("{{ url('admin/user/read') }}", {}, function(data, status){
            $('#read').html(data);
        });
    }

    // untuk modal create
    function create() {
        $.get("{{ url('admin/user/create') }}", {}, function(data, status){
            $("#modalLabelCrudUser").html('Create User')
            $("#page").html(data);
            $("#modalCrudUser").modal('show');
        });
    }

    // untuk menyimpan database
    function store() {
        var name = $("#inputName1").val();
        var email = $("#inputEmail1").val();
        var password = $("#inputPassword1").val();
        var is_admin = $('#is_admin').is(':checked');
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            width: '350px',
        })
        $.ajax({
            type: "get",
            url: "{{ url('admin/user/store') }}",
            data: {
                name: name,
                email: email,
                password: password,
                is_admin:is_admin
            },
            success: function(data) {
                $(".btn-close").click();
                read();
                Toast.fire({
                    icon: 'success',
                    title: 'User has been created !'
                });
            }
        });
    }

    // Untuk modal halaman edit show
    function edit(id) {
        $.get("{{ url('admin/user/edit') }}/" + id, {}, function(data, status) {
            $("#modalLabelCrudUser").html('Edit User')
            $("#page").html(data);
            $("#modalCrudUser").modal('show');
        });
    }

    // untuk update database
    function update(id) {
        var name = $("#inputName1").val();
        var email = $("#inputEmail1").val();
        var password = $("#inputPassword1").val();
        var is_admin = $('#is_admin').is(':checked');
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            width: '350px',
        })
        $.ajax({
            type: "get",
            url: "{{ url('admin/user/update') }}/"+id,
            data: {
                name: name,
                email: email,
                password: password,
                is_admin:is_admin },
            success: function(data) {
                $(".btn-close").click();
                read();
                Toast.fire({
                    icon: 'success',
                    title: 'User has been updated !'
                });

            }
        });
    }

    //untuk destroy database
    function destroyuser(id) {
        var name = $("#inputName1").val();
        var email = $("#inputEmail1").val();
        var password = $("#inputPassword1").val();
        var is_admin = $('#is_admin').is(':checked');

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
                url: "{{ url('admin/user/destroy') }}/"+id,
                data: {
                    name: name,
                    email: email,
                    password: password,
                    is_admin:is_admin },
                    success: function(data) {
                        $(".btn-close").click();
                        read();
                        Toast.fire({
                            icon: 'success',
                            title: 'User has been deleted !'
                        });
                    },
                    error: function(xhr, status, error) {
                        alert(err.Message);
                    }
                });
            }
        })
    }

    // function destroyuser(id) {
    //     var name = $("#inputName1").val();
    //     var email = $("#inputEmail1").val();
    //     var password = $("#inputPassword1").val();
    //     var is_admin = $('#is_admin').is(':checked');

    //     const Toast = Swal.mixin({
    //         toast: true,
    //         position: 'top-end',
    //         showConfirmButton: false,
    //         timer: 1500,
    //         width: '350px',
    //     })

    //     if (id == 12) {
    //         Toast.fire({
    //             icon: 'error',
    //             title: "Can't delete this user!"
    //         });
    //     }else {
    //         Swal.fire({
    //         title: 'Are you sure ?',
    //         text: "You won't be able to revert this !",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, delete it!'
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 $.ajax({
    //                 type: "get",
    //                 url: "{{ url('admin/user/destroy') }}/"+id,
    //                 data: {
    //                     name: name,
    //                     email: email,
    //                     password: password,
    //                     is_admin:is_admin },
    //                     success: function(data) {
    //                         $(".btn-close").click();
    //                         read();
    //                         Toast.fire({
    //                             icon: 'success',
    //                             title: 'User has been deleted !'
    //                         });
    //                     }
    //                 });
    //             }
    //         })
    //     }
    // }

    // untuk modal preview
    function preview(id) {
        $.get("{{ url('admin/user/preview') }}/" + id, {}, function(data, status) {
            $("#modalLabelCrudUser").html('Preview User')
            $("#page").html(data);
            $("#modalCrudUser").modal('show');
        });
    }
    // ===== END CRUD USER =====
</script>
@endsection
