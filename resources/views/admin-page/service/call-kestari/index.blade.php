@extends('admin-page.template.body')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
@endsection

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-lg-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Call Kestari Management System</h5>
                <button class='btn btn-primary' onClick="create()"><i class="fa fa-plus"></i> Create Call Kestari</button>
                {{-- START Data table Call Kestari --}}
                <div id="read" class="mt-3"></div>
                {{-- END Data table Call Kestari --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
<!-- Modal -->
<div class="modal fade" id="modalCrudCallKestari" tabindex="-1" aria-labelledby="modalLabelCrudCallKestari" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content bg-light rounded h-100 p-4">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelCrudCallKestari">Modal title</h5>
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
<script>
    // ===== START CRUD Call Kestari =====
    // untuk load database
    $(document).ready(function(){
        read();
    });


    //untuk read database
    function read() {
        $.get("{{ url('/admin/service/callkestari/read') }}", {}, function(data, status){
            $('#read').html(data);
        });
    }

    // untuk modal create
    function create() {
        $.get("{{ url('/admin/service/callkestari/create') }}", {}, function(data, status){
            $("#modalLabelCrudCallKestari").html('Create Call Kestari')
            $("#page").html(data);
            $("#modalCrudCallKestari").modal('show');
        });
    }

    // untuk menyimpan database
    function store() {
        var buttonName = $("#buttonName").val();
        var link = $("#link").val();
        var appear = $("#appear").val();
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            width: '350px',
        })
        $.ajax({
            type: "get",
            url: "{{ url('/admin/service/callkestari/store') }}",
            data: {
                buttonName: buttonName,
                link: link,
                appear: appear,
            },
            success: function(data) {
                if($.isEmptyObject(data.error)){
                    $(".btn-close").click();
                    read();
                    Toast.fire({
                        icon: 'success',
                        title: 'Call Kestari has been created !'
                    });
                }else{
                    printErrorMsg(data.error);
                }
            }
        });
    }

    // Untuk modal halaman edit show
    function edit(id) {
        $.get("{{ url('/admin/service/callkestari/edit') }}/" + id, {}, function(data, status) {
            $("#modalLabelCrudCallKestari").html('Edit CallKestari')
            $("#page").html(data);
            $("#modalCrudCallKestari").modal('show');
        });
    }

    // untuk update database
    function update(id) {
        var buttonName = $("#buttonName").val();
        var link = $("#link").val();
        var appear = $("#appear").val();
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            width: '350px',
        })
        $.ajax({
            type: "get",
            url: "{{ url('/admin/service/callkestari/update') }}/"+id,
            data: {
                buttonName: buttonName,
                link: link,
                appear: appear, },
            success: function(data) {
                if($.isEmptyObject(data.error)){
                    $(".btn-close").click();
                    read();
                    Toast.fire({
                        icon: 'success',
                        title: 'Call Kestari has been updated !'
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

    //untuk destroy database
    function destroycallkestari(id) {
        var buttonName = $("#buttonName").val();
        var link = $("#link").val();
        var appear = $("#appear").val();

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
                url: "{{ url('/admin/service/callkestari/destroy') }}/"+id,
                data: {
                    buttonName: buttonName,
                    link: link,
                    appear: appear, },
                    success: function(data) {
                        $(".btn-close").click();
                        read();
                        Toast.fire({
                            icon: 'success',
                            title: 'Call Kestari has been deleted!'
                        });
                    },
                    error: function(xhr, status, error) {
                        alert(err.Message);
                    }
                });
            }
        })
    }

    function preview(id) {
        $.get("{{ url('/admin/service/callkestari/preview') }}/" + id, {}, function(data, status) {
            $("#modalLabelCrudCallKestari").html('Preview Call Kestari')
            $("#page").html(data);
            $("#modalCrudCallKestari").modal('show');
        });
    }
    // ===== END CRUD Call Kestari =====
</script>
@endsection
