@extends('admin-page.template.body')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
@endsection

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">User Management System</h5>
                <button class='btn btn-primary' onClick="create()"><i class="fa fa-plus"></i> Create User</button>
                {{-- START Data table User --}}
                <div class="mt-3" id="read">
                </div>
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
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script type="text/javascript">

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
        var roleName = $('.roleName:checked').val();
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
                roleName:roleName
            },
            success: function(data) {
                if($.isEmptyObject(data.error)){
                    $(".btn-close").click();
                    read();
                    Toast.fire({
                        icon: 'success',
                        title: 'User has been created !'
                    });
                }else{
                    printErrorMsg(data.error);
                }
            }
        });
    }

    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }

    // Untuk modal halaman edit show
    function edit(id) {
        if (id == 2) {
            Swal.fire({
                icon: 'error',
                title: 'Edit Failed',
                text: "^_^ Sory You Can't Edit this Account ^_^",
                confirmButtonText: 'Shap',
                confirmButtonColor : '#00d2c5'
            })
        } else {
            $.get("{{ url('admin/user/edit') }}/" + id, {}, function(data, status) {
                $("#modalLabelCrudUser").html('Edit User')
                $("#page").html(data);
                $("#modalCrudUser").modal('show');
            });
        }
    }

    // untuk update database
    function update(id) {
        var name = $("#inputName1").val();
        var email = $("#inputEmail1").val();
        var password = $("#inputPassword1").val();
        var roleName = $('.roleName:checked').val();
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
                roleName:roleName },
            success: function(data) {
                if($.isEmptyObject(data.error)){
                    $(".btn-close").click();
                    read();
                    Toast.fire({
                        icon: 'success',
                        title: 'User has been updated !'
                    });
                }else{
                    printErrorMsg(data.error);
                }
            }
        });
    }

    //untuk destroy database
    function destroyuser(id) {
        var name = $("#inputName1").val();
        var email = $("#inputEmail1").val();
        var password = $("#inputPassword1").val();
        if (id == 2) {
            Swal.fire({
                icon: 'error',
                title: 'Delete Failed',
                text: "^_^ Sory You Can't Delete this Account ^_^",
                confirmButtonText: 'Shap',
                confirmButtonColor : '#00d2c5'
            })
        } else {
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
                        password: password},
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
    }

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
